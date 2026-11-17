let selectedCards = [];

function updateComparison() {
    const card1Container = document.getElementById('card1');
    const card2Container = document.getElementById('card2');

    if (selectedCards.length > 0) {
        const card1Image = selectedCards[0] ? extractImageTag(selectedCards[0]) : '';
        card1Container.innerHTML = card1Image;

        if (selectedCards.length > 1) {
            const card2Image = selectedCards[1] ? extractImageTag(selectedCards[1]) : '';
            card2Container.innerHTML = card2Image;
        } else {
            card2Container.innerHTML = ''; // Limpar a segunda área se não houver segundo cartão selecionado
        }
    } else {
        card1Container.innerHTML = '';
        card2Container.innerHTML = '';
    }
}

function extractImageTag(html) {
    const tempElement = document.createElement('div');
    tempElement.innerHTML = html;
    const imgElement = tempElement.querySelector('.list__img img');
    return imgElement ? imgElement.outerHTML : '';
}

function compareCards() {
    // Verificar se há dois cartões selecionados
    if (selectedCards.length === 2) {
        // Exibir o modal
        const comparar = document.getElementById('comparacao'),
        revel = document.getElementById('reveal-mod');
        if (comparar && revel) {
            comparar.style.display = 'block';
            revel.style.display = 'block';
            document.querySelector('html').classList.add('is-reveal-open');
        }

        // Preencher o HTML para o Cartão 1
        const card1HTML = createCardHTML(selectedCards[0]);
        document.getElementById('comparar__card__left').innerHTML = card1HTML;

        // Preencher o HTML para o Cartão 2
        const card2HTML = createCardHTML(selectedCards[1]);
        document.getElementById('comparar__card__right').innerHTML = card2HTML;
    } else {
        alert('Selecione exatamente dois cartões para comparar.');
    }
}

// Função para criar o HTML de um cartão com base nos dados fornecidos
function createCardHTML(cardData) {
    // Você precisa implementar a lógica para extrair os dados do HTML e criar o HTML
    // Aqui está um exemplo básico, você deve ajustar conforme necessário
    const cardElement = document.createElement('div');
    cardElement.innerHTML = cardData;

    const ctaButton = cardElement.querySelector('.cpr.item-label');

    if (!ctaButton) {
        const cardElement = document.createElement('div');
        cardElement.innerHTML = selectedCards[0];

        const cardElement2 = document.createElement('div');
        cardElement2.innerHTML = selectedCards[1];

        const button1 = cardElement.querySelector('.item-label');
        const button2 = cardElement2.querySelector('.item-label');

        if (!button2 && !button1) {
            console.error('Elemento .item-label não encontrado no HTML do cartão.');
            return '';
        }

        window.location.href = STCode.homeurl + '/comparador-de-cartao-de-credito/comparar/?cartoes=' + button1.getAttribute('data-slug') + 'X' + button2.getAttribute('data-slug');
    } else {

        const data = {
            cardUrl: ctaButton.getAttribute('data-permalink') || '',
            cardImage: cardElement.querySelector('.list__img img').getAttribute('src') || '',
            cardTitle: ctaButton.getAttribute('data-name') || '',
            cardStars: cardElement.querySelector('.item__stars').innerHTML || '',
            cardVerification: cardElement.querySelector('.list__cta .color-gray small').innerHTML || '',
            cardDetails: cardElement.querySelector('.list__details').innerHTML || '',
            cardJSON: ctaButton.getAttribute('data-card') || '',
            rowJSON: ctaButton.getAttribute('data-row') || '',
        };

        try {
            const jsonData = JSON.parse(data.cardJSON);
            var jsonRow = false,
            textoButton = 'Solicitar Cartão';
            if (data.rowJSON !== '') {
                jsonRow = JSON.parse(data.rowJSON);
            }

            const prosHTML = createProsConsHTML(jsonData.pros, 'bx bx-check');
            const contrasHTML = createProsConsHTML(jsonData.contras, 'bx bx-x');
            var perfilHTML = '';
            if (jsonRow) {
                perfilHTML = createPerfilHTML(jsonData.perfil);
            }

            if (jsonRow) {
                textoButton = 'Abrir Conta';
            }

            if (jsonRow) {
                document.getElementById('url_compare').style.display = 'none';
            } else {
                const cardElement = document.createElement('div');
                cardElement.innerHTML = selectedCards[0];

                const cardElement2 = document.createElement('div');
                cardElement2.innerHTML = selectedCards[1];

                const button1 = cardElement.querySelector('.item-label');
                const button2 = cardElement2.querySelector('.item-label');

                if (!button2 && !button1) {
                    console.error('Elemento .item-label não encontrado no HTML do cartão.');
                    return '';
                }

                document.getElementById('url_compare').setAttribute('href', STCode.homeurl + '/comparador-de-cartao-de-credito/comparar/?cartoes=' + button1.getAttribute('data-slug') + 'X' + button2.getAttribute('data-slug'));
            }

            var cardHTML = '';
            cardHTML += `<div class="list">
                        <div id="start"></div>
                        <div class="list__card">
                            <div class="list__img ahref">
                                <a class="cta__params" href="${data.cardUrl}" target="_blank">
                                    <img width="140" height="90" src="${data.cardImage}" alt="${data.cardTitle}" title="${data.cardTitle}">
                                </a>
                            </div>
                            <div class="list__title">
                                <div class="item__headline ahref">
                                    <a class="cta__params" href="${data.cardUrl}" target="_blank">
                                        <span title="${data.cardTitle}">${data.cardTitle}</span>
                                    </a>
                                </div>`;
                                if (!jsonRow) {
                                    cardHTML += `<div class="item__stars">${data.cardStars}</div>`;
                                }
                            cardHTML += `</div>
                        </div>
                        <div class="list__cta text-center">
                            <a class="button expanded" target="_blank" data-offer-context="offer-card" href="${data.cardUrl}">${textoButton} <i class="bx bx-check-shield icon-button"></i></a>
                            <div class="color-gray"><small>${data.cardVerification}</small></div>
                        </div>`;
                        if (jsonRow) {
                            cardHTML += `
                                <div class="column-loan">
                                    <div class="column-loan-row loan-review show-for-medium">
                                        <div class="reviews__stars lista">
                                            <b itemprop="name">Avaliação Monify:</b>
                                            <div class="item__stars">${data.cardStars}</div>
                                        </div>
                                    </div>
                                    <div class="column-loan-row" itemprop="additionalProperty" itemscope="" itemtype="https://schema.org/PropertyValue">
                                        <b itemprop="name">Valor:</b>
                                        <span itemprop="value">${jsonRow.valor}</span>
                                    </div>
                                    <div class="column-loan-row" itemprop="additionalProperty" itemscope="" itemtype="https://schema.org/PropertyValue">
                                        <b itemprop="name">Juros:</b>
                                        <span itemprop="value">${jsonRow.juros}</span>
                                    </div>
                                    <div class="column-loan-row" itemprop="additionalProperty" itemscope="" itemtype="https://schema.org/PropertyValue">
                                        <b itemprop="name">Tipo:</b>
                                        <span itemprop="value">${jsonRow.tipo}</span>
                                    </div>
                                    <div class="column-loan-row" itemprop="additionalProperty" itemscope="" itemtype="https://schema.org/PropertyValue">
                                        <b itemprop="name">Prazo de liberação:</b>
                                        <span itemprop="value">${jsonRow.prazo}</span>
                                    </div>
                                    <div class="column-loan-row" itemprop="additionalProperty" itemscope="" itemtype="https://schema.org/PropertyValue">
                                        <b itemprop="name">Número de parcelas:</b>
                                        <span itemprop="value">${jsonRow.parcela}</span>
                                    </div>
                                    <div class="column-loan-row" itemprop="additionalProperty" itemscope="" itemtype="https://schema.org/PropertyValue">
                                        <b itemprop="name">Perfil ideal:</b>
                                        <span itemprop="value">
                                        <ul>${perfilHTML}</ul>
                                    </div>
                                </div>
                            `;
                        } else {
                            cardHTML += '<div class="list__details text-center">'+data.cardDetails+'</div>'; // Caso não seja um array, use data.cardDetails
                        }
                        cardHTML += `
                        </div>
                        <div class="list__more text-left">
                            <div class="list__group group list__none">
                                <div class="pros_contra">
                                    <div class="list__more__title">Prós</div>
                                    ${prosHTML}
                                </div>
                                <div class="pros_contra">
                                    <div class="list__more__title">Contras</div>
                                    ${contrasHTML}
                                </div>
                            </div>
                        </div>
                    </div>
                `;

            return cardHTML;
        } catch (error) {
            console.error('Erro ao analisar JSON do atributo data-card:', error);
            return '';
        }
    }
}

// Selecione todos os botões "Ver mais detalhes"
const buttons = document.querySelectorAll('.asx-button');

if (buttons) {
    // Adicione um evento de clique a cada botão
    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Encontre a div pai do botão clicado
            const parentDiv = this.closest('.cartao-modulo');
            
            // Encontre a seção de detalhes adicionais dentro da div pai
            const reviewsExtra = parentDiv.querySelector('.reviews__extra');
            
            // Verifique se a seção está visível ou oculta
            if (reviewsExtra.style.display === 'block') {
                // Se estiver visível, oculte-a
                reviewsExtra.style.display = 'none';
            } else {
                // Se estiver oculta, torne-a visível
                reviewsExtra.style.display = 'block';
            }
        });
    });
}

// Função para criar o HTML para Prós ou Contras
function createProsConsHTML(data, iconClass) {
    const items = data.split(',').map(item => item.trim());

    const itemsHTML = items.map(item => `
            <div class="list__row">
                <div><i class="${iconClass}"></i></div>
                <div class="list__info">${item}</div>
            </div>
        `).join('');

    return itemsHTML;
}

// Função para criar o HTML para Perfil Ideal
function createPerfilHTML(data, iconClass) {
    const items = data.split(',').map(item => item.trim());

    const itemsHTML = items.map(item => `<li class="list__info">${item}</li>`).join('');

    return itemsHTML;
}

function clearComparison() {
    selectedCards = [];
    updateComparison();

    // Desmarcar todos os checkboxes
    const checkboxes = document.querySelectorAll('.item-label input');
    checkboxes.forEach(checkbox => checkbox.checked = false);

    // Esconder a seção de comparação
    document.getElementById('compare').style.display = 'none';
}

if (document.getElementById("back-article")) {
    document.getElementById("back-article").addEventListener("click", function(event) {
        clearComparison();
        document.getElementById('comparacao').style.display = 'none';
        document.getElementById('reveal-mod').style.display = 'none';
        document.querySelector('html').classList.remove('is-reveal-open');
    });
}

if (document.getElementById("close-card")) {
    document.getElementById("close-card").addEventListener("click", function(event) {
        clearComparison();
        document.getElementById('comparacao').style.display = 'none';
        document.getElementById('reveal-mod').style.display = 'none';
        document.querySelector('html').classList.remove('is-reveal-open');
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const checkboxes = document.querySelectorAll('.item-label input');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            const cardContainer = checkbox.closest('.cartao-modulo');

            if (cardContainer) {
                const cardHTML = cardContainer.innerHTML;

                if (checkbox.checked) {
                    if (selectedCards.length < 2) {
                        selectedCards.push(cardHTML);
                    } else {
                        checkbox.checked = false; // Impedir a seleção se já houver dois cartões selecionados
                    }
                } else {
                    selectedCards = selectedCards.filter(card => card !== cardHTML);
                }

                // Atualizar a seção de comparação
                updateComparison();

                // Exibir a seção de comparação se pelo menos um checkbox estiver marcado
                document.getElementById('compare').style.display = selectedCards.length > 0 ? 'block' : 'none';
            }
        });
    });
});