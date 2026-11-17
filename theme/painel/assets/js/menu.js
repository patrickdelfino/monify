jQuery(document).ready(function($) {
    $(".stcodes-side-subnav-item a").click(function(e) {
        e.preventDefault();
        localStorage.setItem("activeTab", $(this).attr("href"));
        switch_tabs( $(this) );
    });

    $(".stcodes-side-subnav-link").click(function(e) {
        e.preventDefault();
        // Salvar Tab
        var ms = $(this).data('parent')
        var ss = $(this).data('child')
        $.ajax({
            url: STCode.ajaxurl,
            type: 'POST',
            data: {
                parent: ss,
                child: ms,
                action: 'stcodes-side-subnav-section',
                nonce: STCode.nonce
            },
            error: function(response) {
                console.log(response);
            },
            success: function(response) {
                console.log(response);
            }
        });
    });

    $(".tab-content").hide();

    var a = $(".defaulttab a").attr("rel");
    $("#" + a).show();
    $('.stcodes-side-subnav-item a[href="#'+ a+'"]').addClass("selected");

    // Upload image
    $('.stcodes_upload').click(function(e) {
        var custom_uploader;
        var id = $(this).attr('data-id');
        e.preventDefault();
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: STCode.ititle,
            button: {
                text: STCode.iuse
            },
            multiple: false
        });
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#stcodes_options_'+id).val(attachment.url).trigger('change');
            $('#preview_' + id ).html('<div data-id="'+ id +'" class="img upload_image"><img src="'+ attachment.url +'"></div>');
            $('#remove_' + id ).removeClass( "hiddenex" );
            var uploading = {
                action: "sarthemes_ajax_upload",
                nonce: STCode.nonce,
                data: id,
                url: attachment.url,
            }
            $.post( ajaxurl, uploading );

        });
        custom_uploader.open();
    });

    // Remove Image
    $('.stcodes_remove').on('click', function() {
        var a = $(this),
            b = $(this).attr('data-id');
        a.html( STCode.remov );
        var c = {
            action: "sarthemes_ajax_remove",
            nonce: STCode.nonce,
            data: b
        };
        $.post( ajaxurl, c, function(b) {
            a.prev().prev().val(""), a.next().html(""), a.html( 'Remover' );
        })
    });

    // Save Settings
    $('#stcodes-settings').submit(function() {
        $('.men_save_framework').val( STCode.saving )
        $('.men_save_framework').prop('disabled', true )
        $('.container').addClass('saving')
        $(this).ajaxSubmit({
            success: function(){
                $('.men_save_framework').val( STCode.save )
                $('.men_save_framework').prop('disabled', false )
                $('.container').removeClass('saving')
            },
        });
        return false;
    });
    
    function switch_tabs(a) {
        $(".tab-content").hide().removeClass('tab-show'),
        $(".stcodes-side-subnav-item a").removeClass("selected");
        var b = a.attr("rel");
        $("#" + b).fadeIn(500), a.addClass("selected")
    }

    $(".seo-relative").each(function() {
        var ts = $(this);

        $('textarea',this).keyup(function(){
            var leng = $(this).val().length;
            verificadorMetaSEO(leng,ts);
        });
    });

    function verificadorMetaSEO(currentLength,ts){
        var progress = 0,
        clas = 'progress-bar-danger',
        remove = 'progress-bar-sucess progress-bar-warning',
        skillbar = $(".progressBarValue",ts),
        speach = $(".speech-bubble",ts);
        if (currentLength >= 5 && currentLength < 25) {
            progress = 15;
            speach.fadeIn();
        } if (currentLength >= 25 && currentLength < 30) {
            progress = 35;
            speach.fadeIn();
        } else if (currentLength >= 30 && currentLength < 70) {
            progress = 55;
            speach.fadeIn();
        } else if (currentLength >= 70 && currentLength < 110) {
            progress = 75;
            clas = 'progress-bar-warning';
            remove = 'progress-bar-sucess progress-bar-danger';
            speach.fadeIn();
        } else if(currentLength >= 110 && currentLength <= 160){
            progress = 100;
            clas = 'progress-bar-sucess';
            remove = 'progress-bar-warning progress-bar-danger';
            speach.fadeIn();
        } else if(currentLength >= 161){
            progress = 100;
            clas = 'progress-bar-danger';
            remove = 'progress-bar-sucess progress-bar-warning';
            speach.removeClass('css').addClass('alert');
            speach.css('left','68%');
            speach.text('Limite recomendado: 160');
            speach.fadeIn();
        } else if (currentLength < 10) {
            speach.text('0%');
            speach.css('left','0%');
            speach.fadeOut();
        }

        skillbar.css('width',progress+'%');
        skillbar.addClass(clas).removeClass(remove);
        $('.chars_count .current',ts).text(currentLength);
        if (currentLength < 161) {
            speach.addClass('css').removeClass('alert');
            speach.css('left',(progress-5)+'%');
            speach.text(progress+'%');
        }
    }
});
