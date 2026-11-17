jQuery(($) => {
    const button = $('.monify-blog .stcode_loadmore');
    const status = $('.monify-blog .load');
    let currentPage = 1;
    let pending = false;
    button.on('click', () => {
        if (pending) return;
        pending = true;
        button.prop('disabled', true);
        status.text('Aguarde...').removeClass('hide').show();
        $.ajax({
            method: 'POST',
            url: loadmore_params.ajaxurl,
            dataType: 'json',
            data: { action: 'blog_load_more', paged: currentPage + 1 },
        }).done((response) => {
            if (typeof response.html !== 'string' || !Number.isFinite(Number(response.max_page))) {
                status.text('Não foi possível carregar. Tente novamente.');
                return;
            }
            $('.monify-blog .articles').append(response.html);
            currentPage += 1;
            status.hide();
            if (currentPage >= Number(response.max_page)) button.remove();
        }).fail(() => {
            status.text('Não foi possível carregar. Tente novamente.');
        }).always(() => {
            pending = false;
            button.prop('disabled', false);
        });
    });
});
