<?php
/*
Plugin Name: Shortcode athlete
Description: Allow to use [athlete id=""] in all WYSWYG
Author: Nicolas PALLAS
Text Domain: shortcode-athlete
Version: 1.0
*/

define('SHORTCODE_ATHLETE_PATH', plugin_dir_path(__FILE__));
define('SHORTCODE_ATHLETE_URL', plugin_dir_url(__FILE__));

function sa_enqueue_scripts()  {
    $plugin_data = get_file_data(__FILE__, ['Version' => 'Version'], false);

    wp_register_style('sa-front', SHORTCODE_ATHLETE_URL.'assets/css/front.css', [], $plugin_data['Version']);
    wp_register_style('poppins-900', '//fonts.cdnfonts.com/css/poppins?styles=20381');
    wp_register_style('futura-pt-700', '//fonts.cdnfonts.com/css/futura-pt?styles=117663,117662');
}
add_action('wp_enqueue_scripts', 'sa_enqueue_scripts');

/**
 * @param $attributes
 * @return false|string
 */
function sa_shortcode_athlete($attributes)  {
    wp_enqueue_style('sa-front');
    wp_enqueue_style('poppins-900');
    wp_enqueue_style('futura-pt-700');

    if(empty($attributes['id'])) {
        return '<div class="athlete-card athlete-card--error">'.
            __('ID is missing: Get the athlete ID from "https://www.thesportsdb.com/" and add it to the shortcode', 'shortcode-athlete').
        '</div>';
    }

    $transient_name = 'athlete_'.$attributes['id'];
    $athlete = get_transient($transient_name);

    if (empty($athlete)) {
        $curl_response_athlete = wp_remote_get('https://www.thesportsdb.com/api/v1/json/3/lookupplayer.php?id='.$attributes['id']);

        if ($curl_response_athlete['response']['code'] === 200) {
            $athletes = json_decode($curl_response_athlete['body']);
            $athlete = $athletes->players[0];

            $athlete->country_flag_url = sa_get_flag_by_country_name($athlete->strNationality);
            $athlete->dateBorn = strtotime($athlete->dateBorn);
            $athlete->age = floor((strtotime('now') - $athlete->dateBorn)/365/24/60/60);

            set_transient($transient_name, $athlete, WEEK_IN_SECONDS);
        }
    }

    ob_start();
    load_template(SHORTCODE_ATHLETE_PATH.'template-parts/shortcode-athlete.php', false, $athlete);
    return ob_get_clean();
}
add_shortcode('athlete', 'sa_shortcode_athlete');

/**
 * @param string $name
 * @return false|string
 */
function sa_get_icon_markup(string $name) {
    return file_get_contents(SHORTCODE_ATHLETE_PATH.'assets/images/'.$name.'.svg');
}

/**
 * @param string $country_name
 * @return string
 */
function sa_get_flag_by_country_name(string $country_name): string {
    $countries_code = get_transient('countries_code');

    if (empty($countries_code)) {
        $curl_response_countries_code = wp_remote_get('https://flagcdn.com/en/codes.json');
        if ($curl_response_countries_code['response']['code'] === 200) {
            $countries_code = json_decode($curl_response_countries_code['body']);
            set_transient('countries_code', $countries_code, YEAR_IN_SECONDS);
        }
    }

    $country_code = array_search($country_name, (array) $countries_code);

    return $country_code ? "https://flagcdn.com/$country_code.svg" : '';
}