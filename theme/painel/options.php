<?php
/**
 * Opções das funçoes do painel
 *
 * @link              https://sarthemes.com/
 * @since             0.0.1
 * @package           monify/painel
 *
 */

$options = [
	/**
	 * Sessões
	 * 
	 **/
	[
        "type"     => "section",
        "icon"     => "bx-slider-alt",
        "title"    => "Configurações",
        "id"       => "c",
        "expanded" => true
    ],
    [
        "type"     => "section",
        "icon"     => "bx-objects-vertical-bottom",
        "title"    => "SEO",
        "id"       => "s",
        "expanded" => false
    ],
    /**
     * Sub Sessões
     * 
     **/
    [
        "section"  => "c",
        "type"     => "heading",
        "title"    => "Geral",
        "id"       => "configuracoes"
    ],
    [
        "section"  => "c",
        "type"     => "heading",
        "title"    => "Personalizar",
        "id"       => "configuracoes-custom"
    ],
    [
        "section"  => "c",
        "type"     => "heading",
        "title"    => "Wordpress",
        "id"       => "configuracoes-wp"
    ],
    [
        "section"  => "s",
        "type"     => "heading",
        "title"    => "Geral",
        "id"       => "seo"
    ],
    [
        "section"  => "s",
        "type"     => "heading",
        "title"    => "Pagina inicial",
        "id"       => "seo-home"
    ],
    [
        "section"  => "s",
        "type"     => "heading",
        "title"    => "Artigos",
        "id"       => "seo-articles"
    ],
    [
        "section"  => "s",
        "type"     => "heading",
        "title"    => "Cartões de Crédito",
        "id"       => "seo-cartao"
    ],
    [
        "section"  => "s",
        "type"     => "heading",
        "title"    => "Empréstimo",
        "id"       => "seo-emprestimo"
    ],
    [
        "section"  => "s",
        "type"     => "heading",
        "title"    => "Banco",
        "id"       => "seo-banco"
    ],
    [
        "section"  => "s",
        "type"     => "heading",
        "title"    => "Paginas",
        "id"       => "seo-pages"
    ],
    [
        "section"  => "s",
        "type"     => "heading",
        "title"    => "Seguimentos",
        "id"       => "seo-seguimento"
    ],
    [
        "section"  => "s",
        "type"     => "heading",
        "title"    => "Quiz",
        "id"       => "seo-quiz"
    ],
    [
        "section"  => "s",
        "type"     => "heading",
        "title"    => "Comparador de Cartões",
        "id"       => "seo-comparador"
    ],
	/**
     * Configuracoes
     * 
     **/
	[
        "under_section"       => "configuracoes",
        "type"                => "small_heading",
        "name"                => 'Google',
    ],
	[
        "under_section"       => "configuracoes",
        "type"                => "text",
        "name"                => 'Google Search Console Verificação',
        "id"                  => "google_console",
        "placeholder"         => 'UA-45132606-12',
        "desc"                => 'Inserir código de rastreamento para usar esta função',
    ],
    [
        "under_section"       => "configuracoes",
        "type"                => "text",
        "name"                => 'Google Analytics',
        "id"                  => "google_analytics",
        "placeholder"         => 'gkoxcwsdAV6PShwWqeHghbqKlPx',
        "desc"                => 'Inserir código de rastreamento para usar esta função',
    ],
    [
        "under_section"       => "configuracoes",
        "type"                => "checkbox",
        "name"                => 'Funçoes do tema',
        "id"                  => [
            "ativar_cookie",
            "ativar_seo",
            "ativar_views",
            "ativar_manutencao"
        ],
        "options"             => [
            'Sistema de alerta sobre cookies',
            'Sistema SEO',
            'Sistema Views',
            'Modo Manutenção',
        ],
        "desc"                => 'Clique para ativar ou desativar',
        "default"             => ["not","not","not","not"]
    ],
    [
        "under_section"       => "configuracoes",
        "type"                => "textarea",
        "name"                => 'Mensagem do Modo Manutenção',
        "rows"                => "3",
        "id"                  => "offline_message",
        "desc"                => "Adicione uma mensagem para exibir aos úsuarios"

    ],
    [
        "under_section"       => "configuracoes-wp",
        "type"                => "checkbox",
        "name"                => 'Controles WordPress',
        "id"                  => [
            "emoji_disable",
            "toolbar_disable"
        ],
        "options"             => [
            'Desativar emojis padrão do Wordpress',
            'Desabilitar barra de ferramentas do usuário'
        ],
        "desc"                => 'Marque para desativar',
        "default"             => ["checked","not"]
    ],
    [
        "under_section"     => "configuracoes-wp",
        "type"              => "radio",
        "name"              => "Comentários Padrão",
        "id"                => "commets",
        "options"           => [
            "comt_di"   => 'Disqus',
            "comt_wp"   => 'Wordpress',
            "comtno"    => 'Nenhum'
        ],
        "desc"              => 'Escolha uma opção',
        "default"           => "not"
    ],
    [
        "under_section"     => "configuracoes-wp",
        "type"              => "text",
        "name"              => 'Shorname Disqus',
        "id"                => "shortname_disqus",
        "desc"              => "Adicione o nome da sua comunidade <a href=\"https://disqus.com/\" target=\"_blank\"> Disqus </a>"

    ],
    [
        "under_section"     => "configuracoes-custom",
        "type"              => "image",
        "name"              => 'Favicon',
        "id"                => "web_favicon",
        "desc"              => 'Faça o upload da imagem que ira ser o favicon do site!'
    ],
    [
        "under_section"     => "configuracoes-custom",
        "type"              => "small_heading",
        "title"             => 'Integrações de código'
    ],
    [
        "under_section"         => "configuracoes-custom",
        "type"                  => "editor",
        "name"                  => 'CSS',
        "editor"                => [
            'theme'         => 'mbo',
            'cdnURL'        => 'https://cdn.jsdelivr.net/npm/codemirror@5.60.0',
            'tabSize'       => 4,
            'lineNumbers'   => true,
            'mode'          => 'css'
        ],
        "id"                    => "css_code",
        "desc"                  => 'Campo para css personalizado!',
    ],
    [
        "under_section"         => "configuracoes-custom",
        "type"                  => "editor",
        "name"                  => 'Javascript',
        "editor"                => [
            'theme'         => 'mbo',
            'cdnURL'        => 'https://cdn.jsdelivr.net/npm/codemirror@5.60.0',
            'tabSize'       => 4,
            'lineNumbers'   => true,
            'mode'          => 'javascript'
        ],
        "id"                    => "javascript_code",
        "desc"                  => 'Campo para javascript personalizado!',
    ],
    [
        "under_section"         => "configuracoes",
        "type"                  => "editor",
        "name"                  => 'Código no cabeçalho do site',
        "editor"                => [
            'theme'         => 'mbo',
            'cdnURL'        => 'https://cdn.jsdelivr.net/npm/codemirror@5.60.0',
            'tabSize'       => 4,
            'lineNumbers'   => true
        ],
        "id"                    => "php_header_code",
        "desc"                  => 'Adicione o seu código aqui!',
    ],
    [
        "under_section"         => "configuracoes",
        "type"                  => "editor",
        "name"                  => 'Código no rodapé do site',
        "editor"                => [
            'theme'         => 'mbo',
            'cdnURL'        => 'https://cdn.jsdelivr.net/npm/codemirror@5.60.0',
            'tabSize'       => 4,
            'lineNumbers'   => true
        ],
        "id"                    => "php_footer_code",
        "desc"                  => 'Adicione o seu código aqui!',
    ],
    /**
     * SEO Geral
     * 
     **/
    [
        "under_section"     => "seo",
        "type"              => "small_heading",
        "title"             => 'SiteMap',
    ],
    [
        "under_section"     => "seo",
        "type"              => "checkbox",
        "name"              => "Funções de SEO",
        "id"                => [
            "seo_map",
            "seo_articles"
        ],
        "options"           => [
            'Sitemap',
            'Personalizar seo nos artigos'
        ],
        "desc"                => 'Clique para ativar ou desativar',
        "default"             => ["not","not"]
    ],
    [
        "under_section"     => "seo",
        "type"              => "radio",
        "name"              => "Atualização do sitemap",
        "id"                => "sitemap_time_update",
        "options"           => [
            'daily' => 'Diariamente',
            'weekly' => 'Semanalmente',
            'monthly' => 'Mensalmente'
        ],
        "desc"                => 'Clique para ativar ou desativar',
        "default"             => ["not","yes","not"]
    ],
    [
        "under_section"     => "seo",
        "type"              => "text",
        "name"              => "Limite de links para cada pagina",
        "id"                => "sitemap_limit",
        "placeholder"       => 100,
        "desc"              => 'Digite o número de postagens a ser ter a para cada sitemap ser divido eg: 100',
    ],
    [
        "under_section"     => "seo",
        "type"              => "small_heading",
        "title"             => 'Artigos',
    ],
    [
        "under_section"     => "seo",
        "type"              => "radio",
        "name"              => "Frequencia de Atualização",
        "id"                => "sitemap_articles_frequency",
        "options"           => [
            'daily' => 'Diariamente',
            'weekly' => 'Semanalmente',
            'monthly' => 'Mensalmente'
        ],
        "desc"                => 'Com que frequência a página provavelmente mudará ou sera alterada.',
        "default"             => ["not","yes","not"]
    ],
    [
        "under_section"     => "seo",
        "type"              => "radio",
        "name"              => "Prioridade",
        "id"                => "sitemap_articles_priority",
        "options"           => [
            '0.0' => 'Extra Baixa',
            '0.3' => 'Baixa',
            '0.5' => 'Regular',
            '0.6' => 'Media',
            '0.8' => 'Boa',
            '1.0' => 'Alta'
        ],
        "desc"                => 'A prioridade deste URL em relação a outros URLs no seu site. Os valores válidos variam de 0,0 a 1,0.',
        "default"             => ["not","not","yes","not","not"]
    ],
    [
        "under_section"     => "seo",
        "type"              => "small_heading",
        "title"             => 'Páginas',
    ],
    [
        "under_section"     => "seo",
        "type"              => "radio",
        "name"              => "Frequencia de Atualização",
        "id"                => "sitemap_pages_frequency",
        "options"           => [
            'daily' => 'Diariamente',
            'weekly' => 'Semanalmente',
            'monthly' => 'Mensalmente'
        ],
        "desc"                => 'Com que frequência a página provavelmente mudará ou sera alterada.',
        "default"             => ["not","yes","not"]
    ],
    [
        "under_section"     => "seo",
        "type"              => "radio",
        "name"              => "Prioridade",
        "id"                => "sitemap_pages_priority",
        "options"           => [
            '0.0' => 'Extra Baixa',
            '0.3' => 'Baixa',
            '0.5' => 'Regular',
            '0.6' => 'Media',
            '0.8' => 'Boa',
            '1.0' => 'Alta'
        ],
        "desc"                => 'A prioridade deste URL em relação a outros URLs no seu site. Os valores válidos variam de 0,0 a 1,0.',
        "default"             => ["not","not","yes","not","not"]
    ],
    [
        "under_section"     => "seo",
        "type"              => "small_heading",
        "title"             => 'Cartões',
    ],
    [
        "under_section"     => "seo",
        "type"              => "radio",
        "name"              => "Frequencia de Atualização",
        "id"                => "sitemap_cartoes_frequency",
        "options"           => [
            'daily' => 'Diariamente',
            'weekly' => 'Semanalmente',
            'monthly' => 'Mensalmente'
        ],
        "desc"                => 'Com que frequência a página provavelmente mudará ou sera alterada.',
        "default"             => ["not","yes","not"]
    ],
    [
        "under_section"     => "seo",
        "type"              => "radio",
        "name"              => "Prioridade",
        "id"                => "sitemap_cartoes_priority",
        "options"           => [
            '0.0' => 'Extra Baixa',
            '0.3' => 'Baixa',
            '0.5' => 'Regular',
            '0.6' => 'Media',
            '0.8' => 'Boa',
            '1.0' => 'Alta'
        ],
        "desc"                => 'A prioridade deste URL em relação a outros URLs no seu site. Os valores válidos variam de 0,0 a 1,0.',
        "default"             => ["not","not","yes","not","not"]
    ],
    [
        "under_section"     => "seo",
        "type"              => "small_heading",
        "title"             => 'Bancos',
    ],
    [
        "under_section"     => "seo",
        "type"              => "radio",
        "name"              => "Frequencia de Atualização",
        "id"                => "sitemap_bancos_frequency",
        "options"           => [
            'daily' => 'Diariamente',
            'weekly' => 'Semanalmente',
            'monthly' => 'Mensalmente'
        ],
        "desc"                => 'Com que frequência a página provavelmente mudará ou sera alterada.',
        "default"             => ["not","yes","not"]
    ],
    [
        "under_section"     => "seo",
        "type"              => "radio",
        "name"              => "Prioridade",
        "id"                => "sitemap_bancos_priority",
        "options"           => [
            '0.0' => 'Extra Baixa',
            '0.3' => 'Baixa',
            '0.5' => 'Regular',
            '0.6' => 'Media',
            '0.8' => 'Boa',
            '1.0' => 'Alta'
        ],
        "desc"                => 'A prioridade deste URL em relação a outros URLs no seu site. Os valores válidos variam de 0,0 a 1,0.',
        "default"             => ["not","not","yes","not","not"]
    ],
    [
        "under_section"     => "seo",
        "type"              => "small_heading",
        "title"             => 'Empréstimos',
    ],
    [
        "under_section"     => "seo",
        "type"              => "radio",
        "name"              => "Frequencia de Atualização",
        "id"                => "sitemap_emprestimos_frequency",
        "options"           => [
            'daily' => 'Diariamente',
            'weekly' => 'Semanalmente',
            'monthly' => 'Mensalmente'
        ],
        "desc"                => 'Com que frequência a página provavelmente mudará ou sera alterada.',
        "default"             => ["not","yes","not"]
    ],
    [
        "under_section"     => "seo",
        "type"              => "radio",
        "name"              => "Prioridade",
        "id"                => "sitemap_emprestimos_priority",
        "options"           => [
            '0.0' => 'Extra Baixa',
            '0.3' => 'Baixa',
            '0.5' => 'Regular',
            '0.6' => 'Media',
            '0.8' => 'Boa',
            '1.0' => 'Alta'
        ],
        "desc"                => 'A prioridade deste URL em relação a outros URLs no seu site. Os valores válidos variam de 0,0 a 1,0.',
        "default"             => ["not","not","yes","not","not"]
    ],
    [
        "under_section"     => "seo",
        "type"              => "small_heading",
        "title"             => 'Seguimentos',
    ],
    [
        "under_section"     => "seo",
        "type"              => "radio",
        "name"              => "Frequencia de Atualização",
        "id"                => "sitemap_seguimentos_frequency",
        "options"           => [
            'daily' => 'Diariamente',
            'weekly' => 'Semanalmente',
            'monthly' => 'Mensalmente'
        ],
        "desc"                => 'Com que frequência a página provavelmente mudará ou sera alterada.',
        "default"             => ["not","yes","not"]
    ],
    [
        "under_section"     => "seo",
        "type"              => "radio",
        "name"              => "Prioridade",
        "id"                => "sitemap_seguimentos_priority",
        "options"           => [
            '0.0' => 'Extra Baixa',
            '0.3' => 'Baixa',
            '0.5' => 'Regular',
            '0.6' => 'Media',
            '0.8' => 'Boa',
            '1.0' => 'Alta'
        ],
        "desc"                => 'A prioridade deste URL em relação a outros URLs no seu site. Os valores válidos variam de 0,0 a 1,0.',
        "default"             => ["not","not","yes","not","not"]
    ],
    [
        "under_section"     => "seo",
        "type"              => "small_heading",
        "title"             => 'SEO',
    ],
    [
        "under_section"     => "seo",
        "type"              => "small_heading",
        "title"             => 'Descrição Padrão',
    ],
    [
        "under_section"     => "seo",
        "type"              => "small_heading",
        "desc"              => '<span class="titleD">Tags:</span><ul class="dots_tags"><li data-toggle="tooltip" data-placement="top" title="Nome do site">{site_name}</li><li data-toggle="tooltip" data-placement="top" title="Descrição do site">{site_descricao}</li><li data-toggle="tooltip" data-placement="top" title="Mude o id de acordo com o necessário">{category:1}</li><li data-toggle="tooltip" data-placement="top" title="Mude o id de acordo com o necessário">{tag:1}</li><li data-toggle="tooltip" data-placement="top" title="Use o separado que é igual: -">{separador}</li>
        </ul>',
    ],
    [
        "under_section"     => "seo",
        "type"              => "textarea",
        "name"              => 'Meta Description',
        "id"                => "seo_geral_desc",
        "rows"              => "5",
        "seo"               => true,
        "desc"              => 'É o texto geralmente utilizado pelo Google para a exibição dos resultados de texto das segundas e terceiras linhas dos resultados de busca',
        "default"           => null
    ],
    /**
     * SEO Home
     * 
     **/
    [
        "under_section"     => "seo-home",
        "type"              => "small_heading",
        "title"             => 'Como funciona?',
        "desc"              => '<p>Faça uma descrição que mais atende ao seu site!</p>'
    ],
    [
        "under_section"     => "seo-home",
        "type"              => "small_heading",
        "desc"              => '<span class="titleD">Tags:</span><ul class="dots_tags"><li data-toggle="tooltip" data-placement="top" title="Nome do site">{site_name}</li><li data-toggle="tooltip" data-placement="top" title="Descrição do site">{site_descricao}</li><li data-toggle="tooltip" data-placement="top" title="Mude o id de acordo com o necessário">{cartao_name:1}</li><li data-toggle="tooltip" data-placement="top" title="Mude o id de acordo com o necessário">{emprestimo_name:1}</li><li data-toggle="tooltip" data-placement="top" title="Mude o id de acordo com o necessário">{banco_name:1}</li><li data-toggle="tooltip" data-placement="top" title="Use o separado que é igual: -">{separador}</li>
        </ul>',
    ],
    [
        "under_section"     => "seo-home",
        "type"              => "text",
        "name"              => 'Titulo do navegador',
        "id"                => "seo_home_title",
        "preview"           => STCODE_URI.'/assets/imgs/editar-title.png',
        "desc"              => 'A Title Tag é um dos itens que mais influencia o posicionamento no Google, se não for o mais importante.',
    ],
    [
        "under_section"         => "seo-home",
        "type"                  => "text",
        "name"                  => 'Cabeçalho 1',
        "id"                    => "seo_home_h1",
        "placeholder"           => null,
        "desc"                  => 'As Heading Tags facilitam a leitura, entendimento e até mesmo a indexação do conteúdo e sua utilização. Entenda mais <a href="https://www.seomarketing.com.br/tutorial-seo/heading-tags-h1-h2-h3/">Ler agora!</a>',
        "default"               => null
    ],
    [
        "under_section"     => "seo-home",
        "type"              => "textarea",
        "name"              => 'Meta Description',
        "id"                => "seo_home_desc",
        "rows"              => "5",
        "seo"               => true,
        "desc"              => 'É o texto geralmente utilizado pelo Google para a exibição dos resultados de texto das segundas e terceiras linhas dos resultados de busca',
        "default"           => null
    ],
    /**
     * SEO Artigos
     * 
     **/
    [
        "under_section"     => "seo-articles",
        "type"              => "small_heading",
        "title"             => 'Como funciona?',
        "desc"              => '<p>Faça uma descrição que mais atende ao seu site!</p>'
    ],
    [
        "under_section"     => "seo-articles",
        "type"              => "small_heading",
        "desc"              => '<span class="titleD">Tags:</span><ul class="dots_tags"><li data-toggle="tooltip" data-placement="top" title="Nome da postagem">{post_name}</li><li data-toggle="tooltip" data-placement="top" title="Resumo da postagem">{post_excerpt}</li><li data-toggle="tooltip" data-placement="top" title="Nome do site">{site_name}</li><li data-toggle="tooltip" data-placement="top" title="Descrição do site">{site_descricao}</li><li data-toggle="tooltip" data-placement="top" title="Mude o id de acordo com o necessário">{category:1}</li><li data-toggle="tooltip" data-placement="top" title="Mude o id de acordo com o necessário">{tag:1}</li><li data-toggle="tooltip" data-placement="top" title="Use o separado que é igual: -">{separador}</li>
        </ul>',
    ],
    [
        "under_section"     => "seo-articles",
        "type"              => "text",
        "name"              => 'Titulo do navegador',
        "id"                => "seo_article_title",
        "preview"           => STCODE_URI.'/assets/imgs/editar-title.png',
        "desc"              => 'A Title Tag é um dos itens que mais influencia o posicionamento no Google, se não for o mais importante.',
    ],
    [
        "under_section"     => "seo-articles",
        "type"              => "textarea",
        "name"              => 'Meta Description',
        "id"                => "seo_article_desc",
        "rows"              => "5",
        "seo"               => true,
        "desc"              => 'É o texto geralmente utilizado pelo Google para a exibição dos resultados de texto das segundas e terceiras linhas dos resultados de busca',
        "default"           => null
    ],
    /**
     * SEO Cartoes de Credito
     * 
     **/
    [
        "under_section"     => "seo-cartao",
        "type"              => "small_heading",
        "title"             => 'Como funciona?',
        "desc"              => '<p>Faça uma descrição que mais atende ao seu site!</p>'
    ],
    [
        "under_section"     => "seo-cartao",
        "type"              => "small_heading",
        "desc"              => '<span class="titleD">Tags:</span><ul class="dots_tags"><li data-toggle="tooltip" data-placement="top" title="Nome da postagem">{post_name}</li><li data-toggle="tooltip" data-placement="top" title="Resumo da postagem">{post_excerpt}</li><li data-toggle="tooltip" data-placement="top" title="Nome do site">{site_name}</li><li data-toggle="tooltip" data-placement="top" title="Descrição do site">{site_descricao}</li><li data-toggle="tooltip" data-placement="top" title="Mude o id de acordo com o necessário">{category:1}</li><li data-toggle="tooltip" data-placement="top" title="Mude o id de acordo com o necessário">{tag:1}</li><li data-toggle="tooltip" data-placement="top" title="Use o separado que é igual: -">{separador}</li>
        </ul>',
    ],
    [
        "under_section"     => "seo-cartao",
        "type"              => "text",
        "name"              => 'Titulo do navegador',
        "id"                => "seo_cartao_title",
        "preview"           => STCODE_URI.'/assets/imgs/editar-title.png',
        "desc"              => 'A Title Tag é um dos itens que mais influencia o posicionamento no Google, se não for o mais importante.',
    ],
    [
        "under_section"     => "seo-cartao",
        "type"              => "textarea",
        "name"              => 'Meta Description',
        "id"                => "seo_cartao_desc",
        "rows"              => "5",
        "seo"               => true,
        "desc"              => 'É o texto geralmente utilizado pelo Google para a exibição dos resultados de texto das segundas e terceiras linhas dos resultados de busca',
        "default"           => null
    ],
    /**
     * SEO Emprestimo
     * 
     **/
    [
        "under_section"     => "seo-emprestimo",
        "type"              => "small_heading",
        "title"             => 'Como funciona?',
        "desc"              => '<p>Faça uma descrição que mais atende ao seu site!</p>'
    ],
    [
        "under_section"     => "seo-emprestimo",
        "type"              => "small_heading",
        "desc"              => '<span class="titleD">Tags:</span><ul class="dots_tags"><li data-toggle="tooltip" data-placement="top" title="Nome da postagem">{post_name}</li><li data-toggle="tooltip" data-placement="top" title="Resumo da postagem">{post_excerpt}</li><li data-toggle="tooltip" data-placement="top" title="Nome do site">{site_name}</li><li data-toggle="tooltip" data-placement="top" title="Descrição do site">{site_descricao}</li><li data-toggle="tooltip" data-placement="top" title="Mude o id de acordo com o necessário">{category:1}</li><li data-toggle="tooltip" data-placement="top" title="Mude o id de acordo com o necessário">{tag:1}</li><li data-toggle="tooltip" data-placement="top" title="Use o separado que é igual: -">{separador}</li>
        </ul>',
    ],
    [
        "under_section"     => "seo-emprestimo",
        "type"              => "text",
        "name"              => 'Titulo do navegador',
        "id"                => "seo_emprestimo_title",
        "preview"           => STCODE_URI.'/assets/imgs/editar-title.png',
        "desc"              => 'A Title Tag é um dos itens que mais influencia o posicionamento no Google, se não for o mais importante.',
    ],
    [
        "under_section"     => "seo-emprestimo",
        "type"              => "textarea",
        "name"              => 'Meta Description',
        "id"                => "seo_emprestimo_desc",
        "rows"              => "5",
        "seo"               => true,
        "desc"              => 'É o texto geralmente utilizado pelo Google para a exibição dos resultados de texto das segundas e terceiras linhas dos resultados de busca',
        "default"           => null
    ],
    /**
     * SEO Banco
     * 
     **/
    [
        "under_section"     => "seo-banco",
        "type"              => "small_heading",
        "title"             => 'Como funciona?',
        "desc"              => '<p>Faça uma descrição que mais atende ao seu site!</p>'
    ],
    [
        "under_section"     => "seo-banco",
        "type"              => "small_heading",
        "desc"              => '<span class="titleD">Tags:</span><ul class="dots_tags"><li data-toggle="tooltip" data-placement="top" title="Nome da postagem">{post_name}</li><li data-toggle="tooltip" data-placement="top" title="Resumo da postagem">{post_excerpt}</li><li data-toggle="tooltip" data-placement="top" title="Nome do site">{site_name}</li><li data-toggle="tooltip" data-placement="top" title="Descrição do site">{site_descricao}</li><li data-toggle="tooltip" data-placement="top" title="Mude o id de acordo com o necessário">{category:1}</li><li data-toggle="tooltip" data-placement="top" title="Mude o id de acordo com o necessário">{tag:1}</li><li data-toggle="tooltip" data-placement="top" title="Use o separado que é igual: -">{separador}</li>
        </ul>',
    ],
    [
        "under_section"     => "seo-banco",
        "type"              => "text",
        "name"              => 'Titulo do navegador',
        "id"                => "seo_banco_title",
        "preview"           => STCODE_URI.'/assets/imgs/editar-title.png',
        "desc"              => 'A Title Tag é um dos itens que mais influencia o posicionamento no Google, se não for o mais importante.',
    ],
    [
        "under_section"     => "seo-banco",
        "type"              => "textarea",
        "name"              => 'Meta Description',
        "id"                => "seo_banco_desc",
        "rows"              => "5",
        "seo"               => true,
        "desc"              => 'É o texto geralmente utilizado pelo Google para a exibição dos resultados de texto das segundas e terceiras linhas dos resultados de busca',
        "default"           => null
    ],
    /**
     * SEO Seguimento
     * 
     **/
    [
        "under_section"     => "seo-seguimento",
        "type"              => "small_heading",
        "title"             => 'Como funciona?',
        "desc"              => '<p>Faça uma descrição que mais atende ao seu site!</p>'
    ],
    [
        "under_section"     => "seo-seguimento",
        "type"              => "small_heading",
        "desc"              => '<span class="titleD">Tags:</span><ul class="dots_tags"><li data-toggle="tooltip" data-placement="top" title="Nome da postagem">{post_name}</li><li data-toggle="tooltip" data-placement="top" title="Resumo da postagem">{post_excerpt}</li><li data-toggle="tooltip" data-placement="top" title="Nome do site">{site_name}</li><li data-toggle="tooltip" data-placement="top" title="Descrição do site">{site_descricao}</li><li data-toggle="tooltip" data-placement="top" title="Mude o id de acordo com o necessário">{category:1}</li><li data-toggle="tooltip" data-placement="top" title="Mude o id de acordo com o necessário">{tag:1}</li><li data-toggle="tooltip" data-placement="top" title="Use o separado que é igual: -">{separador}</li>
        </ul>',
    ],
    [
        "under_section"     => "seo-seguimento",
        "type"              => "text",
        "name"              => 'Titulo do navegador',
        "id"                => "seo_seguimento_title",
        "preview"           => STCODE_URI.'/assets/imgs/editar-title.png',
        "desc"              => 'A Title Tag é um dos itens que mais influencia o posicionamento no Google, se não for o mais importante.',
    ],
    [
        "under_section"     => "seo-seguimento",
        "type"              => "textarea",
        "name"              => 'Meta Description',
        "id"                => "seo_seguimento_desc",
        "rows"              => "5",
        "seo"               => true,
        "desc"              => 'É o texto geralmente utilizado pelo Google para a exibição dos resultados de texto das segundas e terceiras linhas dos resultados de busca',
        "default"           => null
    ],
     /**
     * SEO Pagina
     * 
     **/
    [
        "under_section"     => "seo-pages",
        "type"              => "small_heading",
        "title"             => 'Como funciona?',
        "desc"              => '<p>Faça uma descrição que mais atende ao seu site!</p>'
    ],
    [
        "under_section"     => "seo-pages",
        "type"              => "small_heading",
        "desc"              => '<span class="titleD">Tags:</span><ul class="dots_tags"><li data-toggle="tooltip" data-placement="top" title="Nome da postagem">{post_name}</li><li data-toggle="tooltip" data-placement="top" title="Resumo da postagem">{post_excerpt}</li><li data-toggle="tooltip" data-placement="top" title="Nome do site">{site_name}</li><li data-toggle="tooltip" data-placement="top" title="Descrição do site">{site_descricao}</li><li data-toggle="tooltip" data-placement="top" title="Mude o id de acordo com o necessário">{category:1}</li><li data-toggle="tooltip" data-placement="top" title="Mude o id de acordo com o necessário">{tag:1}</li><li data-toggle="tooltip" data-placement="top" title="Use o separado que é igual: -">{separador}</li>
        </ul>',
    ],
    [
        "under_section"     => "seo-pages",
        "type"              => "text",
        "name"              => 'Titulo do navegador',
        "id"                => "seo_page_title",
        "preview"           => STCODE_URI.'/assets/imgs/editar-title.png',
        "desc"              => 'A Title Tag é um dos itens que mais influencia o posicionamento no Google, se não for o mais importante.',
    ],
    [
        "under_section"     => "seo-pages",
        "type"              => "textarea",
        "name"              => 'Meta Description',
        "id"                => "seo_page_desc",
        "rows"              => "5",
        "seo"               => true,
        "desc"              => 'É o texto geralmente utilizado pelo Google para a exibição dos resultados de texto das segundas e terceiras linhas dos resultados de busca',
        "default"           => null
    ],
     /**
     * SEO Quiz
     * 
     **/
    [
        "under_section"     => "seo-quiz",
        "type"              => "small_heading",
        "title"             => 'Como funciona?',
        "desc"              => '<p>Faça uma descrição que mais atende ao seu site!</p>'
    ],
    [
        "under_section"     => "seo-quiz",
        "type"              => "small_heading",
        "desc"              => '<span class="titleD">Tags:</span><ul class="dots_tags"><li data-toggle="tooltip" data-placement="top" title="Tipo de quiz">{name_quiz}</li><li data-toggle="tooltip" data-placement="top" title="Nome do site">{site_name}</li><li data-toggle="tooltip" data-placement="top" title="Descrição do site">{site_descricao}</li><li data-toggle="tooltip" data-placement="top" title="Mude o id de acordo com o necessário">{category:1}</li><li data-toggle="tooltip" data-placement="top" title="Mude o id de acordo com o necessário">{tag:1}</li><li data-toggle="tooltip" data-placement="top" title="Use o separado que é igual: -">{separador}</li>
        </ul>',
    ],
    [
        "under_section"     => "seo-quiz",
        "type"              => "text",
        "name"              => 'Titulo do navegador',
        "id"                => "seo_quiz_title",
        "preview"           => STCODE_URI.'/assets/imgs/editar-title.png',
        "desc"              => 'A Title Tag é um dos itens que mais influencia o posicionamento no Google, se não for o mais importante.',
    ],
    [
        "under_section"     => "seo-quiz",
        "type"              => "textarea",
        "name"              => 'Meta Description',
        "id"                => "seo_quiz_desc",
        "rows"              => "5",
        "seo"               => true,
        "desc"              => 'É o texto geralmente utilizado pelo Google para a exibição dos resultados de texto das segundas e terceiras linhas dos resultados de busca',
        "default"           => null
    ],
    /**
     * SEO Comparador
     * 
     **/
    [
        "under_section"     => "seo-comparador",
        "type"              => "small_heading",
        "title"             => 'Como funciona?',
        "desc"              => '<p>Faça uma descrição que mais atende ao seu site!</p>'
    ],
    [
        "under_section"     => "seo-comparador",
        "type"              => "small_heading",
        "desc"              => '<span class="titleD">Tags:</span><ul class="dots_tags"><li data-toggle="tooltip" data-placement="top" title="Nome da categoria">{tag_name}</li><li data-toggle="tooltip" data-placement="top" title="Resumo da categoria">{tag_excerpt}</li><li data-toggle="tooltip" data-placement="top" title="Nome do site">{site_name}</li><li data-toggle="tooltip" data-placement="top" title="Descrição do site">{site_descricao}</li><li data-toggle="tooltip" data-placement="top" title="Mude o id de acordo com o necessário">{category:1}</li><li data-toggle="tooltip" data-placement="top" title="Mude o id de acordo com o necessário">{tag:1}</li><li data-toggle="tooltip" data-placement="top" title="Use o separado que é igual: -">{separador}</li>
        </ul>',
    ],
    [
        "under_section"     => "seo-comparador",
        "type"              => "text",
        "name"              => 'Titulo do navegador',
        "id"                => "seo_comparador_title",
        "preview"           => STCODE_URI.'/assets/imgs/editar-title.png',
        "desc"              => 'A Title Tag é um dos itens que mais influencia o posicionamento no Google, se não for o mais importante.',
    ],
    [
        "under_section"     => "seo-comparador",
        "type"              => "textarea",
        "name"              => 'Meta Description',
        "id"                => "seo_comparador_desc",
        "rows"              => "5",
        "seo"               => true,
        "desc"              => 'É o texto geralmente utilizado pelo Google para a exibição dos resultados de texto das segundas e terceiras linhas dos resultados de busca',
        "default"           => null
    ],
];