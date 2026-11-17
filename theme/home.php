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
</head>
<body class="monify-home">
<div class="stcode--menu-mnfy">
    <div class="stcode-align-container">
        <div class="rwnx">
            <div class="c-12">   
                <div class="mnx--pRNX-main">
                    <a href="<?php echo get_home_url(); ?>" class="logo--tpx">
                        <img src="<?php echo STCODE_URI; ?>/assets/imgs/logo.svg" class="image--mnfy" alt="<?php echo get_bloginfo('name'); ?>" title="<?php echo get_bloginfo('name'); ?>">
                        <h1 class="screen-reader-text">Monify</h1>
                    </a>
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
                </div>
            </div>
        </div>
    </div>
</div>
<div class="hjxs">
    <div class="stcode-align-container">
        <div class="colum colum--hx2">
            <div class="a-bloc-text">
                <h2 class="mJnx">Conecte-se e entenda sobre o melhor <br><span>banco</span> para você.</h2>
                <p class="mJnx--txt">As <strong>melhores recomendações</strong> para o que você<br> precisa, <strong>em um só lugar!</strong></p>
                <p class="kJz--txt">Veja qual o melhor <br> <small>Match para você!</small></p>
            </div>
            <div class="a-bloc-hero">
                <picture class="u-m-0">
                    <source type="image/webp" media="(min-width: 998px)" srcset="<?php echo STCODE_URI; ?>/assets/vetors/mpaec.webp 1x">
                    <source media="(min-width: 768px)" srcset="<?php echo STCODE_URI; ?>/assets/vetors/mpaec.png 1x">
                    <img alt="<?php echo get_bloginfo('name'); ?> Ache seu cartão" width="460" height="auto" data-loader="creditcard" src="<?php echo STCODE_URI; ?>/assets/vetors/mpaec.png" srcset="<?php echo STCODE_URI; ?>/assets/vetors/mpaec.png">
                </picture>
                <picture class="u-m-0">
                    <source type="image/webp" media="(min-width: 998px)" srcset="<?php echo STCODE_URI; ?>/assets/vetors/wmn-loan.webp 1x">
                    <source media="(min-width: 768px)" srcset="<?php echo STCODE_URI; ?>/assets/vetors/wmn-loan.png 1x">
                    <img alt="<?php echo get_bloginfo('name'); ?> Ache seu cartão" width="460" height="auto" data-loader="notload" src="<?php echo STCODE_URI; ?>/assets/vetors/wmn-loan.png" srcset="<?php echo STCODE_URI; ?>/assets/vetors/wmn-loan.png">
                </picture>
                <picture class="u-m-0">
                    <source type="image/webp" media="(min-width: 998px)" srcset="<?php echo STCODE_URI; ?>/assets/vetors/men-bank.webp 1x">
                    <source media="(min-width: 768px)" srcset="<?php echo STCODE_URI; ?>/assets/vetors/men-bank.png 1x">
                    <img alt="<?php echo get_bloginfo('name'); ?> Ache seu cartão" width="510" height="auto" data-loader="notload" src="<?php echo STCODE_URI; ?>/assets/vetors/men-bank.png" srcset="<?php echo STCODE_URI; ?>/assets/vetors/men-bank.png">
                </picture>
            </div>
        </div>
    </div>
</div>
<div class="Whsxa">
    <div class="stcode-align-container">
        <ul class="c-tabs">
            <li class="active" data-tab="cart-tab">Cartão de Crédito</li>
            <li data-tab="loan-tab">Empréstimo</li>
            <li data-tab="acount-tab">Conta Digital</li>
        </ul>
        <div id="cart-tab" class="jhs-quizz c-tabs-l">
            <div class="colum colum--hx0">
                <div class="a-bloc-quiz">
                    <picture class="u-c-0">
                        <img alt="<?php echo get_bloginfo('name'); ?> busque seu cartão de crédito" width="85%" height="auto" src="<?php echo STCODE_URI; ?>/assets/vetors/wmn-credit.svg" srcset="<?php echo STCODE_URI; ?>/assets/vetors/wmn-credit.svg 1x" loading="eager">
                    </picture>
                </div>
                <div class="a-bloc-choice">
                    <div class="cadsx-item">
                        <label>Que tipo de cartão você procura?</label>
                        <div class="btt dropdown-btn filter-button" data-id="#dropdown-credit"><span>Sem Anuidade <i class='bx bx-chevron-down'></i></span></div>
                        <div class="dropdown" id="dropdown-credit">
                            <div class="dropdown-list-item item-credit">
                                <input type="radio" id="for_1" name="filter_credit_option" value="1">
                                <label for="for_1">Com Anuidade</label>
                            </div>
                        </div>
                    </div>
                    <div class="cadsx-item">
                        <label>Você já possui algum cartão de crédito ?</label>
                        <div class="boxes-content">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="filter_credit_have_0" name="filter_credit_have" value="no" checked="checked">
                                <label class="form-check-label" for="filter_credit_have_0">Não possuo</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="filter_credit_have_1" name="filter_credit_have" value="yes">
                                <label class="form-check-label" for="filter_credit_have_1">Tenho um ou mais</label>
                            </div>
                        </div>
                    </div>
                    <div class="cadsx-item">
                        <label>Onde você planeja usar?</label>
                        <div class="boxes-content">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="filter_credit_use_0" name="filter_credit_use" value="nacional" checked="checked">
                                <label class="form-check-label" for="filter_credit_use_0">Nacional</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="filter_credit_use_1" name="filter_credit_use" value="internacional">
                                <label class="form-check-label" for="filter_credit_use_1">Internacional</label>
                            </div>
                        </div>
                    </div>
                    <div class="cadsx-item-full">
                        <label for="volume">Quanto você precisa de limite?</label>
                        <input type="range" id="xcas-M" class="form-range" aria-valuenow="23500" min="0" aria-valuemin="0" max="80000" aria-valuemax="80000" step="500" value="15000" aria-orientation="horizontal" tabindex="0">
                        <div class="m-range" id="range-m">R$ 15.000,00</div>
                        <button class="btt go-to-quizz">Buscar Cartões</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="loan-tab" class="jhs-quizz c-tabs-l">
            <div class="colum colum--hx0">
                <div class="a-bloc-quiz">
                    <picture class="u-c-0">
                        <img alt="<?php echo get_bloginfo('name'); ?> busque seu empréstimo" width="80%" height="auto" src="<?php echo STCODE_URI; ?>/assets/vetors/loan-quizz.svg" srcset="<?php echo STCODE_URI; ?>/assets/vetors/loan-quizz.svg 1x" loading="eager">
                    </picture>
                </div>
                <div class="a-bloc-choice">
                    <div class="cadsx-item">
                        <label>Que tipo de empréstimo você procura?</label>
                        <div class="btt dropdown-btn filter-button" data-id="#dropdown-genres"><span>Consignado <i class='bx bx-chevron-down'></i></span></div>
                        <div class="dropdown" id="dropdown-loan">
                            <div class="dropdown-list-item item-loan">
                                <input type="radio" id="for_1" name="filter_loan" value="1">
                                <label for="for_1">Pessoal</label>
                            </div>
                            <div class="dropdown-list-item item-loan">
                                <input type="radio" id="for_1" name="filter_loan" value="1">
                                <label for="for_1">Sem garantia</label>
                            </div>
                            <div class="dropdown-list-item item-loan">
                                <input type="radio" id="for_1" name="filter_loan" value="1">
                                <label for="for_1">Menos taxas</label>
                            </div>
                            <div class="dropdown-list-item item-loan">
                                <input type="radio" id="for_1" name="filter_loan" value="1">
                                <label for="for_1">Para negativados</label>
                            </div>
                        </div>
                    </div>
                    <div class="cadsx-item">
                        <label>Você já pediu empréstimo antes?</label>
                        <div class="boxes-content">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="loan_after_confirm_0" name="loan_after_confirm" value="yes" checked="checked">
                                <label class="form-check-label" for="loan_after_confirm_0">Sim</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="loan_after_confirm_1" name="loan_after_confirm" value="no">
                                <label class="form-check-label" for="loan_after_confirm_1">Não</label>
                            </div>
                        </div>
                    </div>
                    <div class="cadsx-item">
                        <label>Em quantas vezes você pretende quitar?</label>
                        <div class="btt dropdown-btn filter-button" data-id="#dropdown-parcelas"><span>24x <i class='bx bx-chevron-down'></i></span></div>
                        <div class="dropdown" id="dropdown-parcelas">
                            <div class="dropdown-list-item item-parcelas">
                                <input type="radio" id="for_12" name="filter_loan_parcelas" value="12">
                                <label for="for_12">12x</label>
                            </div>
                            <div class="dropdown-list-item item-loan">
                                <input type="radio" id="for_24" name="filter_loan_parcelas" value="24">
                                <label for="for_24">24x</label>
                            </div>
                            <div class="dropdown-list-item item-loan">
                                <input type="radio" id="for_36" name="filter_loan_parcelas" value="36">
                                <label for="for_36">36x</label>
                            </div>
                            <div class="dropdown-list-item item-loan">
                                <input type="radio" id="for_48" name="filter_loan_parcelas" value="48">
                                <label for="for_48">48x</label>
                            </div>
                            <div class="dropdown-list-item item-loan">
                                <input type="radio" id="for_60" name="filter_loan_parcelas" value="60">
                                <label for="for_60">60x</label>
                            </div>
                        </div>
                    </div>
                    <div class="cadsx-item-full">
                        <label for="volume">Quanto você precisa?</label>
                        <input type="range" id="xcas-R" class="form-range" aria-valuenow="20000" min="0" aria-valuemin="0" max="150000" aria-valuemax="150000" step="500" value="20000" aria-orientation="horizontal" tabindex="0">
                        <div class="m-range" id="range-r">R$ 20.000,00</div>
                        <button class="btt go-to-quizz">Buscar empréstimos</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="acount-tab" class="jhs-quizz c-tabs-l">
            <div class="colum colum--hx0">
                <div class="a-bloc-quiz">
                    <picture class="u-c-0">
                        <img alt="<?php echo get_bloginfo('name'); ?> busque seu banco digital" width="80%" height="auto" src="<?php echo STCODE_URI; ?>/assets/vetors/bank-quizz.svg" srcset="<?php echo STCODE_URI; ?>/assets/vetors/bank-quizz.svg 1x" loading="eager">
                    </picture>
                </div>
                <div class="a-bloc-choice">
                    <div class="cadsx-item">
                        <label>Que tipo de conta digital você procura?</label>
                        <div class="btt dropdown-btn filter-button" data-id="#dropdown-digital"><span>Transferência grátis <i class='bx bx-chevron-down'></i></span></div>
                        <div class="dropdown" id="dropdown-digital">
                            <div class="dropdown-list-item item-digital">
                                <input type="radio" id="for_acount" name="filter_bank_account" value="acount">
                                <label for="for_acount">Mensalidade grátis</label>
                            </div>
                        </div>
                    </div>
                    <div class="cadsx-item">
                        <label>Você já possui alguma conta bancária?</label>
                        <div class="boxes-content">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="filter_bank_register_0" name="filter_bank_register" value="yes" checked="checked">
                                <label class="form-check-label" for="filter_bank_register_0">Não possuo</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="filter_bank_register_1" name="filter_bank_register" value="no">
                                <label class="form-check-label" for="filter_bank_register_1">Tenho um ou mais</label>
                            </div>
                        </div>
                    </div>
                    <div class="cadsx-item">
                        <label>Que tipo de conta digital você gostaria?</label>
                        <div class="boxes-content">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="filter_bank_wish_0" name="filter_bank_wish" value="yes" checked="checked">
                                <label class="form-check-label" for="filter_bank_wish_0">Conta Corrente</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="filter_bank_wish_1" name="filter_bank_wish" value="comtdi">
                                <label class="form-check-label" for="filter_bank_wish_1">Conta Poupança</label>
                            </div>
                        </div>
                    </div>
                    <div class="cadsx-item-full">
                        <label for="volume">Quanto você precisa de limite?</label>
                        <input type="range" id="xcas-L" class="form-range" aria-valuenow="15000" min="0" aria-valuemin="0" max="80000" aria-valuemax="80000" step="500" value="15000" aria-orientation="horizontal" tabindex="0">
                        <div class="m-range" id="range-l">R$ 15.000,00</div>
                        <button class="btt go-to-quizz">Buscar contas</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="about-us" class="cJnxza">
    <div class="stcode-align-container">
        <div class="colum colum--hx2">
            <div class="a-bloc-kMx">
                <h2 class="Thxa">Sobre - Nós</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer sed suscipit dui. Praesent sit amet aliquam elit, cursus accumsan sapien. Nullam rutrum sem et turpis pretium, eu pharetra dolor ornare. Nulla gravida quam sit amet sapien cursus hendrerit at nec diam. Proin vitae consectetur erat. Fusce accumsan dui id magna gravida, eu congue nulla gravida. Donec suscipit lectus vitae lectus blandit pellentesque. Cras tempus nulla et diam dignissim blandit. Nulla eu leo in odio euismod ornare et eu orci. In vitae purus erat.</p>
                <p>Quisque egestas libero ac lorem tincidunt lobortis. Curabitur aliquam accumsan tellus, vitae mollis neque fermentum non. Phasellus rutrum lectus id urna sodales auctor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In consequat enim quis lectus ornare varius. Vivamus vehicula at lorem quis finibus. Nullam ultrices aliquam fringilla. Etiam nec faucibus dui. Suspendisse fermentum id odio non auctor. Proin nec gravida neque, sit amet laoreet felis.</p>
                <p>Vestibulum sodales, justo nec accumsan blandit, dui sem congue dolor, ultricies tristique enim lacus nec sapien. Nulla facilisi. Donec nec justo imperdiet, molestie diam quis, luctus lectus. Suspendisse iaculis placerat libero tempus luctus.</p>
            </div>
            <div class="b-video">
                <iframe src="https://player.vimeo.com/video/857388024?h=5e72204020&loop=1" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>
<div class="Whsxa cJnxza">
    <div class="stcode-align-container">
        <h2 class="Thxa hbs">Como a MONIFY <br>funciona?</h2>
        <p class="mxLa qaaxz">Ao finalizar o seu cadastro a tecnologia do nosso algoritmo cruza suas informações com o comportamento financeiro de outras centenas de pessoas em mais de 300 produtos.Só depois desse entendimento é que conseguimos identificar as opções recomendadas para o seu perfil.Nossa missão é permitir que você aproveite ao máximo todos os benefícios que um cartão de crédito, conta ou empréstimo podem oferecer!</p>
        <div class="colum colum--hx2">
            <div class="i-m-3">
                <img alt="<?php echo get_bloginfo('name'); ?> Cartão de crédito" width="420" height="auto" data-loader="creditcard" src="<?php echo STCODE_URI; ?>/assets/vetors/credit.svg" srcset="<?php echo STCODE_URI; ?>/assets/vetors/credit.svg" loading="eager">
                <h3>Cartão de crédito</h3>
                <p>Com base no seu SCORE juntamente com suas necessidades, nós encontramos qual cartão se encaixa melhor no seu perfil!</p>
                <button class="btt large-more">Saiba Mais</button>
            </div>
            <div class="i-m-3">
                <img alt="<?php echo get_bloginfo('name'); ?> Empréstimo" width="420" height="auto" data-loader="creditcard" src="<?php echo STCODE_URI; ?>/assets/vetors/loan.svg" srcset="<?php echo STCODE_URI; ?>/assets/vetors/loan.svg" loading="eager">
                <h3>Empréstimo</h3>
                <p>Hoje existem milhares de opções de empréstimo, mas como escolher a mais benéfica para você? Nosso algoritmo consegue!</p>
                <button class="btt large-more">Saiba Mais</button>
            </div>
            <div class="i-m-3">
                <img alt="<?php echo get_bloginfo('name'); ?> Conta Digital" width="420" height="auto" data-loader="creditcard" src="<?php echo STCODE_URI; ?>/assets/vetors/bank.svg" srcset="<?php echo STCODE_URI; ?>/assets/vetors/bank.svg" loading="eager">
                <h3>Conta Digital</h3>
                <p>Analizaremos qual a melhor proposta se encaixa no seu perfil para que você aproveite ao máximo cada benefício que uma conta digital pode oferecer!</p>
                <button class="btt large-more">Saiba Mais</button>
            </div>
        </div>
    </div>
</div>
<div class="cJnxza">
    <div class="stcode-align-container">
        <h2 class="Thxa cbx">VEJA O QUE DIZEM <br>SOBRE A <span>MONIFY</span>!</h2>
        <div class="articles d-1">
            <?php foreach (range(0, 3) as $key) { ?>
            <div class="avl-itens">
                <div class="tlk-abtus">
                    <div class="avatar"><img src="<?php echo STCODE_URI; ?>/assets/imgs/avatar.png" alt="" title=""></div>
                    <div class="stars"><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star-half'></i><i class='bx bx-star'></i></div>
                    <div class="tlt">Maria Helena</div>
                    <p class="abt">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod ligula a metus laoreet, a iaculis magna gravida. Mauris interdum pellentesque urna, a suscipit quam faucibus quis. Fusce vel purus a turpis convallis lobortis. Integer non nunc eget urna feugiat efficitur at eu dui. Maecenas dapibus volutpat mauris, id tincidunt ex mollis vel.</p>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="Whsxa cJnxza">
    <div class="stcode-align-container">
        <h2 class="Thxa Laz">Dúvidas <br>Frequentes</h2>
        <p class="mxLa dds">Entendemos que aja algumas <strong>dúvidas frequentes</strong> e por isso nós da <span>Monify</span> estamos aqui para ajudar a <strong>esclarecer</strong> algumas delas</p>
        <img alt="" width="600" height="auto" data-loader="creditcard" src="<?php echo STCODE_URI; ?>/assets/vetors/faq.svg" srcset="<?php echo STCODE_URI; ?>/assets/vetors/faq.svg" class="faq-Imx">
        <ul class="accordion">
            <li>
                <input id="asked_1" type="radio" name="accordion" checked>
                <label for="asked_1"><div class="count"></div><h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3><i class='bx bx-chevron-down-circle' ></i></label>
                <div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut ipsum nec risus sollicitudin sodales vel ut metus. Integer ac tortor ut tellus euismod vehicula. Vestibulum aliquet sem at augue elementum, in fermentum elit semper. Nulla in volutpat mi, id eleifend odio. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis auctor odio sed dolor tincidunt, quis feugiat nisi tincidunt. Nunc euismod lorem eu mi semper, in gravida dui interdum. Quisque euismod arcu eu quam laoreet, sit amet fringilla purus vestibulum. Nam id lectus at nibh fringilla consequat. Mauris pharetra varius metus, in venenatis nulla dignissim ut.</p>
                    <p>Nam a velit at mauris finibus hendrerit. Duis luctus purus nec felis feugiat fringilla. Nam facilisis tortor eu nunc tincidunt, non tincidunt ex tincidunt. Cras pharetra nisi sit amet ultrices lobortis. Fusce laoreet ut quam eu scelerisque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Vestibulum malesuada feugiat nulla, ut feugiat urna pulvinar eu. Phasellus accumsan justo nec turpis dignissim, a tristique purus euismod. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Phasellus interdum, ex nec feugiat cursus, neque justo luctus erat, eu ultrices sapien nunc eget purus. Ut dapibus vitae libero vitae euismod.</p>
                </div>
            </li>
            <li>
                <input id="asked_2" type="radio" name="accordion">
                <label for="asked_2"><div class="count"></div><h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3><i class='bx bx-chevron-down-circle' ></i></label>
                <div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut ipsum nec risus sollicitudin sodales vel ut metus. Integer ac tortor ut tellus euismod vehicula. Vestibulum aliquet sem at augue elementum, in fermentum elit semper. Nulla in volutpat mi, id eleifend odio. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis auctor odio sed dolor tincidunt, quis feugiat nisi tincidunt. Nunc euismod lorem eu mi semper, in gravida dui interdum. Quisque euismod arcu eu quam laoreet, sit amet fringilla purus vestibulum. Nam id lectus at nibh fringilla consequat. Mauris pharetra varius metus, in venenatis nulla dignissim ut.</p>
                    <p>Nam a velit at mauris finibus hendrerit. Duis luctus purus nec felis feugiat fringilla. Nam facilisis tortor eu nunc tincidunt, non tincidunt ex tincidunt. Cras pharetra nisi sit amet ultrices lobortis. Fusce laoreet ut quam eu scelerisque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Vestibulum malesuada feugiat nulla, ut feugiat urna pulvinar eu. Phasellus accumsan justo nec turpis dignissim, a tristique purus euismod. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Phasellus interdum, ex nec feugiat cursus, neque justo luctus erat, eu ultrices sapien nunc eget purus. Ut dapibus vitae libero vitae euismod.</p>
                </div>
            </li>
            <li>
                <input id="asked_3" type="radio" name="accordion">
                <label for="asked_3"><div class="count"></div><h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3><i class='bx bx-chevron-down-circle' ></i></label>
                <div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut ipsum nec risus sollicitudin sodales vel ut metus. Integer ac tortor ut tellus euismod vehicula. Vestibulum aliquet sem at augue elementum, in fermentum elit semper. Nulla in volutpat mi, id eleifend odio. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis auctor odio sed dolor tincidunt, quis feugiat nisi tincidunt. Nunc euismod lorem eu mi semper, in gravida dui interdum. Quisque euismod arcu eu quam laoreet, sit amet fringilla purus vestibulum. Nam id lectus at nibh fringilla consequat. Mauris pharetra varius metus, in venenatis nulla dignissim ut.</p>
                    <p>Nam a velit at mauris finibus hendrerit. Duis luctus purus nec felis feugiat fringilla. Nam facilisis tortor eu nunc tincidunt, non tincidunt ex tincidunt. Cras pharetra nisi sit amet ultrices lobortis. Fusce laoreet ut quam eu scelerisque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Vestibulum malesuada feugiat nulla, ut feugiat urna pulvinar eu. Phasellus accumsan justo nec turpis dignissim, a tristique purus euismod. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Phasellus interdum, ex nec feugiat cursus, neque justo luctus erat, eu ultrices sapien nunc eget purus. Ut dapibus vitae libero vitae euismod.</p>
                </div>
            </li>
            <li>
                <input id="asked_4" type="radio" name="accordion">
                <label for="asked_4"><div class="count"></div><h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3><i class='bx bx-chevron-down-circle' ></i></label>
                <div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut ipsum nec risus sollicitudin sodales vel ut metus. Integer ac tortor ut tellus euismod vehicula. Vestibulum aliquet sem at augue elementum, in fermentum elit semper. Nulla in volutpat mi, id eleifend odio. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis auctor odio sed dolor tincidunt, quis feugiat nisi tincidunt. Nunc euismod lorem eu mi semper, in gravida dui interdum. Quisque euismod arcu eu quam laoreet, sit amet fringilla purus vestibulum. Nam id lectus at nibh fringilla consequat. Mauris pharetra varius metus, in venenatis nulla dignissim ut.</p>
                    <p>Nam a velit at mauris finibus hendrerit. Duis luctus purus nec felis feugiat fringilla. Nam facilisis tortor eu nunc tincidunt, non tincidunt ex tincidunt. Cras pharetra nisi sit amet ultrices lobortis. Fusce laoreet ut quam eu scelerisque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Vestibulum malesuada feugiat nulla, ut feugiat urna pulvinar eu. Phasellus accumsan justo nec turpis dignissim, a tristique purus euismod. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Phasellus interdum, ex nec feugiat cursus, neque justo luctus erat, eu ultrices sapien nunc eget purus. Ut dapibus vitae libero vitae euismod.</p>
                </div>
            </li>
            <li>
                <input id="asked_5" type="radio" name="accordion">
                <label for="asked_5"><div class="count"></div><h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3><i class='bx bx-chevron-down-circle' ></i></label>
                <div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut ipsum nec risus sollicitudin sodales vel ut metus. Integer ac tortor ut tellus euismod vehicula. Vestibulum aliquet sem at augue elementum, in fermentum elit semper. Nulla in volutpat mi, id eleifend odio. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis auctor odio sed dolor tincidunt, quis feugiat nisi tincidunt. Nunc euismod lorem eu mi semper, in gravida dui interdum. Quisque euismod arcu eu quam laoreet, sit amet fringilla purus vestibulum. Nam id lectus at nibh fringilla consequat. Mauris pharetra varius metus, in venenatis nulla dignissim ut.</p>
                    <p>Nam a velit at mauris finibus hendrerit. Duis luctus purus nec felis feugiat fringilla. Nam facilisis tortor eu nunc tincidunt, non tincidunt ex tincidunt. Cras pharetra nisi sit amet ultrices lobortis. Fusce laoreet ut quam eu scelerisque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Vestibulum malesuada feugiat nulla, ut feugiat urna pulvinar eu. Phasellus accumsan justo nec turpis dignissim, a tristique purus euismod. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Phasellus interdum, ex nec feugiat cursus, neque justo luctus erat, eu ultrices sapien nunc eget purus. Ut dapibus vitae libero vitae euismod.</p>
                </div>
            </li>
        </div>
    </div>
</div>
<div class="cJnxza">
    <div class="stcode-align-container">
        <h2 class="Thxa Laz">Aprenda sobre <span>finanças</span> com <br>nossos conteúdos</h2>
        <div class="articles d-1">
            <?php 
            // Argumentos
            $args = array(
                'post_type'             => 'post',
                'order'                 => 'DESC',
                'posts_per_page'        => 4,
                'post_status'           => 'publish',
                'no_found_rows'         => 'true',
                'ignore_sticky_posts'   => 1
            );

            // A Query
            $loop = new WP_Query( $args );
            // O Loop
            if ( $loop->have_posts() ) { 
                while ( $loop->have_posts() ) {
                    $loop->the_post();
                    echo '<div class="news-block-2"><a href="'.get_the_permalink().'" rel="noopener noreferrer">'.stcodes_generate_picture(get_the_ID()).'</a><p class="news-tag">'.get_terms_list_attribute(get_the_ID(),'category', 'name',1).'</p><a href="'.get_the_permalink().'" rel="noopener noreferrer"><h5 class="news-title">'.get_the_title().'</h5></a></div>';
                }
                // Restaurar Post Data Original
                wp_reset_postdata();
            }
            ?>
        </div>
        <a href="<?php echo get_home_url(); ?>/blog" class="seemore">Ver mais Conteúdos <i class='bx bx-chevron-right'></i></a>
    </div>
    <div class="b-a"></div>
    <div class="Mxca">
        <div class="stcode-align-container alcd">
            <h2 class="Fnmx">Junte-se a mais de <span>239.950</span> pessoas</h2>
            <h3 class="mx">Entre para nossa lista e receba conteúdos exclusivos e com prioridade.</h3>
            <form action="newsletter" method="get" class="newsletter-kax">
                <div class="newsletter-form">
                    <input type="email" name="email" id="email" placeholder="Digite seu e-mail" required />
                </div>
                <input type="submit" value="Eu quero!" />
            </form>
        </div>
    </div>
</div>
<div class="Whsxal">
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
            <?php 
            $locations = get_nav_menu_locations();
            if ( has_nav_menu('footer-1') ) { 
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
<!-- Codigo Extra -->
<?php $codigo_rodape = stripslashes(stcode_get_option('php_footer_code'));
echo ($codigo_rodape ? $codigo_rodape : null); ?>