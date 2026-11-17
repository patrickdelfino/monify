# Monify

Catálogo financeiro em WordPress com busca, filtros e comparação de dois cartões lado a lado. Esta edição executável de portfólio recria o fluxo central do Monify 1.0.2 e mantém o modelo de conteúdo do projeto. Os cartões, condições e valores da demonstração são fictícios.

**Tecnologias principais** — WordPress, PHP, MySQL/MariaDB e Docker Compose.

## Executar a demonstração

Com Git e Docker Compose disponíveis, clone este repositório e entre na pasta `monify`.

```sh
git clone https://github.com/patrickdelfino/monify.git
cd monify
```

Crie um arquivo `.env` a partir de [`.env.example`](.env.example) e defina as duas senhas locais. Em seguida, execute:

```sh
docker compose up -d wordpress
docker compose run --rm --entrypoint sh cli /demo/setup.sh
```

Abra [`http://localhost:8080`](http://localhost:8080) ou a porta que você definiu em `MONIFY_PORT`. O painel fica em `/wp-admin/`, com o usuário `monify-admin` e a senha que você definiu. O script pode ser executado novamente para atualizar os seis cartões fictícios sem duplicá-los.

## O que explorar

- **Catálogo.** Busque por título e filtre por bandeira, benefício ou renda mensal. O filtro de renda aceita cartões cuja exigência mínima cabe no valor informado. A paginação mantém os filtros selecionados.
- **Comparação.** Selecione dois cartões da lista e compare anuidade, renda mínima, limite e benefícios. A seleção pode ser compartilhada pelo endereço da página.
- **Administração.** Abra **Cartões** no painel do WordPress para consultar as fichas e alterar as condições. O tema usa tipos de conteúdo, taxonomias e metadados próprios.

## Estrutura

- [`theme/functions.php`](theme/functions.php) registra o modelo, valida o salvamento, monta a consulta e verifica a seleção do comparador.
- [`theme/index.php`](theme/index.php) apresenta catálogo, ficha individual e comparação.
- [`scripts/seed.php`](scripts/seed.php) carrega o catálogo fictício.
- [Estudo de caso](https://github.com/patrickdelfino/patrickdelfino/blob/main/projetos/monify.md) e [recortes do código original](https://github.com/patrickdelfino/patrickdelfino/tree/main/amostras/monify) documentam o escopo da versão 1.0.2.

A edição de portfólio cobre o fluxo de cartões. O quiz de recomendação, os catálogos de empréstimos e contas digitais e as integrações financeiras pertencem ao escopo descrito no estudo de caso.
