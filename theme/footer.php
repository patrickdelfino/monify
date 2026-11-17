<?php $locations = get_nav_menu_locations();
if (is_stcode_template_single()) { ?>
<div id="compare" class="text-center">
    <div id="wrap-compare">
        <span id="label-compare">Comparar os cartões</span>
        <div class="fix-compare">
            <div id="card1" class="cards"></div>
            <i class="bx bx-x"></i>
            <div id="card2" class="cards"></div>
            <span data-open="comparacao" class="button blue" aria-controls="comparacao" aria-haspopup="true" tabindex="0" onclick="compareCards()">Comparar agora</span>
            <span id="btn-clear" class="button hollow" onclick="clearComparison()">Cancelar</span>
        </div>
    </div>
</div>
<div id="reveal-mod" class="reveal-overlay">
    <div class="reveal reveal-comparador" id="comparacao">
        <div class="reveal-column">
            <div id="comparar__card__left" class="comparar comparar-card">
            </div>
            <div id="comparar__card__right" class="comparar comparar-card">
            </div>
        </div>
        <a id="url_compare" class="fix-close button blue expanded" href="">Ver comparação detalhada</a>
        <span id="back-article" class="small-link close-compare" title="Clique para fechar">(x) voltar para o artigo</span>
        <span id="close-card" title="Clique para fechar" class="fix-close close-button close-compare"><span aria-hidden="true">×</span></span>
    </div>
</div>
<?php } elseif (is_stcode_archive_list()) { ?>
<div class="monify-compare-bar" data-monify-catalog-compare hidden>
    <div class="monify-compare-bar-inner">
        <p data-monify-selected aria-live="polite"></p>
        <form action="<?php echo esc_url(home_url('/comparador-de-cartao-de-credito/comparar/')); ?>" method="get">
            <input type="hidden" name="primeiro">
            <input type="hidden" name="segundo">
            <button class="button blue" type="submit" disabled>Comparar agora</button>
            <button class="button hollow" type="button" data-monify-clear>Limpar</button>
        </form>
    </div>
</div>
<?php } ?>
<div class="Whsxal">
    <?php if (!is_stcode_template()) { ?>
    <div class="footer_FXAS">
        <div class="footer--siteInfo">
            <a href="/" class="siteLogo"><img src="<?php echo STCODE_URI; ?>/assets/imgs/slogan.svg" height="auto" width="174" src="" alt="Credit Cards"></a>
            <p class="followText">Siga nossas redes</p>
            <div class="footer__social">
                <a class="social__socialIcon" href="#" title="Twitter" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M19.633 7.997c.013.175.013.349.013.523 0 5.325-4.053 11.461-11.46 11.461-2.282 0-4.402-.661-6.186-1.809.324.037.636.05.973.05a8.07 8.07 0 0 0 5.001-1.721 4.036 4.036 0 0 1-3.767-2.793c.249.037.499.062.761.062.361 0 .724-.05 1.061-.137a4.027 4.027 0 0 1-3.23-3.953v-.05c.537.299 1.16.486 1.82.511a4.022 4.022 0 0 1-1.796-3.354c0-.748.199-1.434.548-2.032a11.457 11.457 0 0 0 8.306 4.215c-.062-.3-.1-.611-.1-.923a4.026 4.026 0 0 1 4.028-4.028c1.16 0 2.207.486 2.943 1.272a7.957 7.957 0 0 0 2.556-.973 4.02 4.02 0 0 1-1.771 2.22 8.073 8.073 0 0 0 2.319-.624 8.645 8.645 0 0 1-2.019 2.083z"></path></svg></a>
                <a class="social__socialIcon" href="#" title="Facebook" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M13.397 20.997v-8.196h2.765l.411-3.209h-3.176V7.548c0-.926.258-1.56 1.587-1.56h1.684V3.127A22.336 22.336 0 0 0 14.201 3c-2.444 0-4.122 1.492-4.122 4.231v2.355H7.332v3.209h2.753v8.202h3.312z"></path></svg></a>
                <a class="social__socialIcon" href="#" title="Instagram" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M11.999 7.377a4.623 4.623 0 1 0 0 9.248 4.623 4.623 0 0 0 0-9.248zm0 7.627a3.004 3.004 0 1 1 0-6.008 3.004 3.004 0 0 1 0 6.008z"></path><circle cx="16.806" cy="7.207" r="1.078"></circle><path d="M20.533 6.111A4.605 4.605 0 0 0 17.9 3.479a6.606 6.606 0 0 0-2.186-.42c-.963-.042-1.268-.054-3.71-.054s-2.755 0-3.71.054a6.554 6.554 0 0 0-2.184.42 4.6 4.6 0 0 0-2.633 2.632 6.585 6.585 0 0 0-.419 2.186c-.043.962-.056 1.267-.056 3.71 0 2.442 0 2.753.056 3.71.015.748.156 1.486.419 2.187a4.61 4.61 0 0 0 2.634 2.632 6.584 6.584 0 0 0 2.185.45c.963.042 1.268.055 3.71.055s2.755 0 3.71-.055a6.615 6.615 0 0 0 2.186-.419 4.613 4.613 0 0 0 2.633-2.633c.263-.7.404-1.438.419-2.186.043-.962.056-1.267.056-3.71s0-2.753-.056-3.71a6.581 6.581 0 0 0-.421-2.217zm-1.218 9.532a5.043 5.043 0 0 1-.311 1.688 2.987 2.987 0 0 1-1.712 1.711 4.985 4.985 0 0 1-1.67.311c-.95.044-1.218.055-3.654.055-2.438 0-2.687 0-3.655-.055a4.96 4.96 0 0 1-1.669-.311 2.985 2.985 0 0 1-1.719-1.711 5.08 5.08 0 0 1-.311-1.669c-.043-.95-.053-1.218-.053-3.654 0-2.437 0-2.686.053-3.655a5.038 5.038 0 0 1 .311-1.687c.305-.789.93-1.41 1.719-1.712a5.01 5.01 0 0 1 1.669-.311c.951-.043 1.218-.055 3.655-.055s2.687 0 3.654.055a4.96 4.96 0 0 1 1.67.311 2.991 2.991 0 0 1 1.712 1.712 5.08 5.08 0 0 1 .311 1.669c.043.951.054 1.218.054 3.655 0 2.436 0 2.698-.043 3.654h-.011z"></path></svg></a>
                <a class="social__socialIcon" href="#" title="Youtube" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21.593 7.203a2.506 2.506 0 0 0-1.762-1.766C18.265 5.007 12 5 12 5s-6.264-.007-7.831.404a2.56 2.56 0 0 0-1.766 1.778c-.413 1.566-.417 4.814-.417 4.814s-.004 3.264.406 4.814c.23.857.905 1.534 1.763 1.765 1.582.43 7.83.437 7.83.437s6.265.007 7.831-.403a2.515 2.515 0 0 0 1.767-1.763c.414-1.565.417-4.812.417-4.812s.02-3.265-.407-4.831zM9.996 15.005l.005-6 5.207 3.005-5.212 2.995z"></path></svg></a>
            </div>
        </div>
        <div class="llnk--Mnft">
            <?php if ( has_nav_menu('footer-1') ) { 
                $menu = wp_get_nav_menu_object($locations['footer-1']); ?>
                <div class="llnk--linkList">
                    <h6 class="llnk--heading" id="footer-0"><?php echo isset($menu->name) ? $menu->name : false; ?></h6>
                    <ul class="llnk--list">
                        <?php
                        if ( has_nav_menu('footer-1') ) {
                            wp_nav_menu(array(
                                'theme_location'    => 'footer-1',
                                'menu'              => 'footer-1',
                                'container'         => false,
                                'items_wrap'        => '%3$s',
                                'walker'            => new monify_footer_walker
                            )); 
                        }
                        ?>
                    </ul>
                </div>
            <?php } ?>
            <?php if ( has_nav_menu('footer-2') ) { 
                $menu = wp_get_nav_menu_object($locations['footer-2']); ?>
                <div class="llnk--linkList">
                    <h6 class="llnk--heading" id="footer-1"><?php echo isset($menu->name) ? $menu->name : false; ?></h6>
                    <ul class="llnk--list">
                        <?php
                        if ( has_nav_menu('footer-2') ) {
                            wp_nav_menu(array(
                                'theme_location'    => 'footer-2',
                                'menu'              => 'footer-2',
                                'container'         => false,
                                'items_wrap'        => '%3$s',
                                'walker'            => new monify_footer_walker
                            )); 
                        }
                        ?>
                    </ul>
                </div>
            <?php } ?>
            <?php if ( has_nav_menu('footer-3') ) { 
                $menu = wp_get_nav_menu_object($locations['footer-3']); ?>
                <div class="llnk--linkList">
                    <h6 class="llnk--heading" id="footer-2"><?php echo isset($menu->name) ? $menu->name : false; ?></h6>
                    <ul class="llnk--list">
                        <?php
                        if ( has_nav_menu('footer-3') ) {
                            wp_nav_menu(array(
                                'theme_location'    => 'footer-3',
                                'menu'              => 'footer-3',
                                'container'         => false,
                                'items_wrap'        => '%3$s',
                                'walker'            => new monify_footer_walker
                            )); 
                        }
                        ?>
                    </ul>
                </div>
            <?php } ?>
            <?php if ( has_nav_menu('footer-4') ) { 
                $menu = wp_get_nav_menu_object($locations['footer-4']); ?>
                <div class="llnk--linkList">
                    <h6 class="llnk--heading" id="footer-3"><?php echo isset($menu->name) ? $menu->name : false; ?></h6>
                    <ul class="llnk--list">
                        <?php
                        if ( has_nav_menu('footer-4') ) {
                            wp_nav_menu(array(
                                'theme_location'    => 'footer-4',
                                'menu'              => 'footer-4',
                                'container'         => false,
                                'items_wrap'        => '%3$s',
                                'walker'            => new monify_footer_walker
                            )); 
                        }
                        ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php } ?>
    <div class="bdmx">
        <div class="telx">
            <span class="c-s"><i class='bx bxs-phone' ></i> xxxx xxx xxxx</span>
            <span class="s-c">Segunda à sexta, das 8h às 18h</span>
        </div>
        <div class="i-d-footer">
            <span class="d-v">Tem uma dúvida ou sugestão? Envie um e-mail para:<br><span class="c-v">faleconosco@monify.com</span></span>
            <ul>
                <?php
                if ( has_nav_menu('footer-5') ) {
                    wp_nav_menu(array(
                        'theme_location'    => 'footer-5',
                        'menu'              => 'footer-5',
                        'container'         => false,
                        'items_wrap'        => '%3$s'
                    )); 
                }
                ?>
            </ul>
            <span class="f-d">© Monify. Todos os direitos reservados.</span>
            <span class="copyright">Desenvolvido por: <a href="https://sarthemes.com/" target="_blank">Sarthemes</a></span>
        </div>
    </div>
</div>
<?php wp_footer(); ?>