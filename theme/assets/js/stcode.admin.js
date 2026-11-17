jQuery(document).ready(function($) {
    // Select Personalizado
    $('.initSelectTwo').selectize();
    // Upload image
    $('.stcode_upload').click(function(e) {
        var custom_uploader;
        var id = $(this).attr('data-id');
        e.preventDefault();
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Selecione uma Imagem',
            button: {
                text: 'Usar esta Imagem'
            },
            multiple: false
        });
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#' + id ).val(attachment.url);
            $('#preview_' + id ).html('<div data-id="'+ id +'" class="img upload_image"><img src="'+ attachment.url +'"></div>');
            $('#remove_' + id ).removeClass( "hiddenex" );
        });
        custom_uploader.open();
    });
});