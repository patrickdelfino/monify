jQuery(function($){
    $( '.stcode_loadmore' ).click(function(){
        const button = $(this)
        const data = {
            'action' : 'loadmore',
            'query': loadmore_params.posts, // that's how we get params from wp_localize_script() function
            'page' : loadmore_params.cur_page
        }
 
        $.ajax({ // you can also use $.post here
            url : loadmore_params.ajaxurl, // AJAX handler
            data : data,
            type : 'POST',
            beforeSend : function ( xhr ) {
                button.hide(); // change the button text, you can also add a preloader image
                $('.load').show();
            },
            success : function( data ){
                if( data ) {
                    button.show();
                    $('.load').hide();
                    $('.articles').append(data) // insert new posts
                    loadmore_params.cur_page++
                    
                    if ( parseInt(loadmore_params.cur_page) >= parseInt(loadmore_params.max_page) ) { 
                        button.remove() // if last page, remove the button
                    }
                    // you can also fire the "post-load" event here if you use a plugin that requires it
                    // $( document.body ).trigger( 'post-load' );
                } 
            }
        })
    });
});
