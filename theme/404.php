<?php get_header(); ?>
<div class="container">
	<div class="page-not-found">
		<div class="cm-result">
			<div class="cm-result-icon"><img src="<?php echo STCODE_URI; ?>/assets/imgs/404.svg"></div>
            <div class="cm-content">
    			<div class="cm-result-title">Página não encontrada</div>
    			<div class="cm-result-subtitle">Mas ainda temos muito para você descobrir ~</div>
    			<div class="cm-result-extra"><a href="/" class="button-primary">Página Inicial</a></div>
            </div>
		</div>
	</div>
</div>
<style type="text/css">
.page-not-found {
    border-radius: 8px;
    max-width: 1200px;
    min-width: 570px;
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background-color: #fff;
    margin: 140px auto;
}

.cm-result {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -webkit-justify-content: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-orient: vertical;
    gap: 120px;
}

.cm-result img {
    width: 400px;
}

.cm-result-icon {
    margin-bottom: 4px;
    text-align: center
}

.cm-result-title {
    font-weight: 700;
    font-size: 1.982rem;
    line-height: 30px;
}

.cm-result-subtitle {
    font-size: .887rem;
    line-height: 31px;
    color: #666;
}

.cm-result-extra {
    margin-top: 12px
}

.page-not-found .button-primary {
    display: inline-block;
    width: 100%;
    height: 44px;
    line-height: 44px;
    padding: 0 40px;
    font-weight: 400;
    font-size: 14px;
    text-align: center;
    vertical-align: middle;
    background-color: #1fddd5;
    border-radius: 5px;
    text-decoration: none;
    color: #fff;
}

.page-not-found .button-primary:hover {
    background-color: hsl(177.47deg 75.4% 49.41% / 55%);
}
</style>
<?php get_footer(); ?>