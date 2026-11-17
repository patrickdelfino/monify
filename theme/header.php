<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="language" content="pt-BR" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta content="index,follow,noodp,noydir" name="robots" />
    <meta content="index,follow" name="googlebot" />
    <link rel="icon" href="<?php echo stcode_get_option('config_favicon'); ?>" sizes="32x32">
    <link rel="shortcut icon" href="<?php echo stcode_get_option('config_touch_icon'); ?>" type="image/x-icon" />
    <!-- Codigos -->
    <?php wp_head(); ?>
    <?php if (is_stcode_template()) { ?>
    <style type="text/css">.stcode--menu-mnfy{ box-shadow: 0 0 0 0 }</style>
    <?php } ?>
</head>
<body<?php stcode_classbody(); ?>>
<div class="stcode--menu-mnfy">
    <div class="stcode-align-container">
        <div class="rwnx">
            <div class="c-12">   
                <div class="mnx--pRNX-main<?php if (is_stcode_ceb_single()) { ?> justify-content-center<?php } ?>">
                    <a href="<?php echo get_home_url(); ?>" class="logo--tpx">
                        <img src="<?php echo STCODE_URI; ?>/assets/imgs/slogan.svg" class="image--mnfy" alt="<?php echo get_bloginfo('name'); ?>" title="<?php echo get_bloginfo('name'); ?>">
                        <h1 class="screen-reader-text">Monify</h1>
                    </a>
                    <?php if (!is_singular('seguimento') AND !is_stcode_ceb_single()) { ?>
                    <nav>
                        <ul class="pRNX--lxs">
                            <?php
                            if ( has_nav_menu('menu-home') ) {
                                wp_nav_menu(array(
                                    'theme_location'    => 'menu-home',
                                    'menu'              => 'menu-home',
                                    'container'         => false,
                                    'items_wrap'        => '%3$s',
                                    'walker'            => new monify_home_walker
                                )); 
                            }
                            ?>
                        </ul>
                    </nav>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>