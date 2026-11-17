# Monify

Portal de produtos financeiros desenvolvido por Patrick Delfino em PHP, JavaScript, WordPress e MySQL. O repositório reúne o tema original Monify 1.0.2, com os ajustes de responsividade e do comparador feitos para a demonstração de portfólio.

## Executar localmente

Requer Git e Docker Compose.

~~~sh
git clone https://github.com/patrickdelfino/monify.git
cd monify
~~~

Copie [.env.example](.env.example) para .env e preencha MONIFY_DB_PASSWORD e MONIFY_ADMIN_PASSWORD.

~~~sh
docker compose up -d wordpress
docker compose run --rm --entrypoint sh cli /demo/setup.sh
~~~

Abra [localhost:8080](http://localhost:8080). A porta pode ser alterada em MONIFY_PORT. O painel está em /wp-admin/, com usuário monify-admin e a senha definida no .env.

O instalador ativa o tema, configura as URLs e carrega seis cartões fictícios. Pode ser executado novamente para atualizar esses mesmos cartões. O banco e o WordPress ficam em volumes locais.

## Fluxos disponíveis

- Página inicial com o design original, ilustrações, abas e configurações do tema.
- Catálogo com busca, filtros por bandeira, benefício, categoria e faixa de renda mínima exigida.
- Seleção de dois cartões preservada durante a filtragem e paginação.
- Comparador no layout original, com um seletor por cartão e um botão de atualização que acompanha a rolagem.
- Destaques para menor anuidade, maior limite, menor renda exigida e empates nos valores numéricos informados.
- Fichas individuais com condições, benefícios, prós, contras e conteúdo complementar.
- Blog e artigos com os templates originais.
- Painel de produtos, metadados, taxonomias, configurações de aparência e SEO.

As condições, benefícios, prós e contras dos cartões Aurora, Brisa, Cedro, Duna, Estuário e Farol foram criados para esta demonstração. Os artigos e uploads da instalação original dependem de uma importação própria. A instalação limpa contém o conteúdo padrão do WordPress.

## Organização do código

| Caminho | Responsabilidade |
| --- | --- |
| theme/inc/parts/lista-de-cartoes.php | Catálogo e filtros |
| theme/inc/parts/comparar.php | Seleção, comparação e destaques |
| theme/inc/parts/singles/cartao.php | Ficha do cartão |
| theme/inc/parts/blog.php e theme/single.php | Páginas editoriais |
| theme/assets/css/stcode.responsive.css | Ajustes de celular, tablet e desktop |
| theme/assets/js/monify.archivelist.js | Filtros e seleção no catálogo |
| theme/assets/js/monify.comparador.js | Atualização conjunta dos cartões |
| theme/src | Classes do painel, campos, shortcodes e sitemap |
| scripts/seed.php | Dados fictícios e menu da demonstração |

## Estado dos módulos

O cadastro de questionários permanece desativado. O quiz e o formulário de newsletter da home têm partes pendentes de integração. A demonstração não faz consultas de CPF ou score, não integra ofertas reais e não efetua solicitações de crédito.

O sitemap personalizado é opcional e permanece desabilitado por padrão. Sua geração usa arquivos locais e deve ser validada com o volume real de conteúdo antes da ativação. A verificação de sintaxe abrange esses módulos, enquanto os testes de navegação desta edição se concentram no catálogo, comparador, fichas e blog.

## Autoria e referências

Projeto desenvolvido durante a atuação na Sarthemes, A licença do tema consta em theme/style.css. Fontes, ícones e bibliotecas conservam seus créditos e avisos próprios.

[Estudo de caso](https://github.com/patrickdelfino/patrickdelfino/blob/main/projetos/monify.md) · [Recortes do código original](https://github.com/patrickdelfino/patrickdelfino/tree/main/amostras/monify)
