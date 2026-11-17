$(document).ready(function() {
    // Evento de clique para os botões no lado esquerdo (.border-right)
    $('.border-right .change_card button').on('click', function() {
        // Aqui, você atualiza as informações do cartão do lado esquerdo
        // Esta função precisa ser adaptada com a lógica específica de atualização
        updateCardInfo($(this), 'left');
    });

    // Evento de clique para os botões no lado direito (sem .border-right)
    $('.cell:not(.border-right) .change_card button').on('click', function() {
        // Aqui, você atualiza as informações do cartão do lado direito
        // Esta função precisa ser adaptada com a lógica específica de atualização
        updateCardInfo($(this), 'right');
    });

    function updateCardInfo(button, side) {
        var cardContainer = button.closest('.list__card');
        var ctn,lrd;
        // Exemplo de como você poderia buscar novos dados.
        $.ajax({
            url: loadmore_params.ajaxurl, // Substitua pelo caminho correto para o seu script PHP
            type: 'GET',
            data: { id: cardId },
            dataType: 'json',
            success: function(response) {
                // Atualizar os dados no card com os novos valores
                ctn = '.cell:not(.border-right)';
                lrd = '.sections-right';
                if (side === 'left') {
                    ctn = '.border-right';
                    lrd = '.sections-left';
                }
                $(ctn+' .list__details').html(response.list__details);
                $('.row-anuidade '+lrd).html(response.anuidade);
                $('.row-beneficios '+lrd).html(response.beneficios);
                $('.row-bandeiras '+lrd).html(response.bandeiras);
                $('.row-pros '+lrd).html(response.pros);
                $('.row-contras '+lrd).html(response.contras);

                cardContainer.find('.list__img img').attr('src', response.imageUrl).attr('alt', response.altText).attr('title', response.title);
                cardContainer.find('.item__headline h3').text(response.title);
                cardContainer.find('.list__cta a').attr('href', response.link);
            },
            error: function(xhr, status, error) {
                // Trate erros aqui
                console.log(error);
            }
        });
    }
});