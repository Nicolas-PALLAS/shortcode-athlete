<div class="athlete-card <?php echo empty($args->strCutout) ? ' athlete-card--no-photo' : '' ?>">
    <?php if(!empty($args->strCutout)) { ?>
        <img class="athlete-card__photo" loading="lazy" width="300px" height="300px" src="<?php echo $args->strCutout ?>" alt="<?php echo $args->strPlayer ?>">
    <?php } ?>
    <div class="athlete-card__right-part">
        <div class="athlete-card__data-top">
            <?php if(!empty($args->strPlayer)) { ?>
                <span class="athlete-card__name"><?php echo $args->strPlayer ?></span>
            <?php } ?>
            <span class="athlete-card__social-network">
                <?php if(!empty($args->strFacebook)) { ?>
                    <a href="//<?php echo $args->strFacebook ?>" target="_blank"><?php echo sa_get_icon_markup('facebook-fill') ?></a>
                <?php } ?>
                <?php if(!empty($args->strTwitter)) { ?>
                    <a href="//<?php echo $args->strTwitter ?>" target="_blank"><?php echo sa_get_icon_markup('twitter') ?></a>
                <?php } ?>
                <?php if(!empty($args->strInstagram)) { ?>
                    <a href="//<?php echo $args->strFacebook ?>" target="_blank"><?php echo sa_get_icon_markup('instagram') ?></a>
                <?php } ?>
            </span>
        </div>
        <div class="athlete-card__data-middle">
            <?php if(!empty($args->strSport)) { ?>
                <span class="athlete-card__sport">
                    <?php if($args->strSport === 'Soccer') { ?>
                        <span class="drop-shadow">⚽</span>
                    <?php } ?>
                    <span class="<?php echo $args->strSport !== 'Soccer' ? 'my-auto' : '' ?>"><?php echo $args->strSport ?></span>
                </span>
            <?php } ?>
            <?php if(!empty($args->strNationality)) { ?>
                <span class="athlete-card__nationality">
                    <?php if(!empty($args->country_flag_url)) { ?>
                        <img class="drop-shadow" loading="lazy" width="16px" src="<?php echo $args->country_flag_url ?>" alt="<?php echo $args->strNationality ?>">
                    <?php } ?>
                    <span><?php echo $args->strNationality ?></span>
                </span>
            <?php } ?>
            <?php if(!empty($args->dateBorn)) { ?>
                <span class="athlete-card__date-born">
                    <span class="drop-shadow"><?php echo sa_get_icon_markup('birthday-cake') ?></span>
                    <span><?php echo $args->age.__(' years old', 'shortcode-athlete') ?></span>
                    <span>(<?php echo date('d/m/Y', $args->dateBorn) ?>)</span>
                </span>
            <?php } ?>
        </div>
        <div class="athlete-card__data-bottom">
            <?php if(!empty($args->strTeam)) { ?>
                <span class="athlete-card__team">
                    <?php echo sa_get_icon_markup('shield-halved') ?>
                    <div><?php echo str_replace('_', '', $args->strTeam) ?></div>
                </span>
            <?php } ?>
            <?php if(!empty($args->strHeight)) { ?>
                <span class="athlete-card__height">
                    <?php echo sa_get_icon_markup('ruler-fill') ?>
                    <div><?php echo $args->strHeight ?></div>
                </span>
            <?php } ?>
            <?php if(!empty($args->strWeight)) { ?>
                <span class="athlete-card__weight">
                    <?php echo sa_get_icon_markup('weight') ?>
                    <div><?php echo $args->strWeight ?></div>
                </span>
            <?php } ?>
        </div>
    </div>
</div>