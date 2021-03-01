(function( $ ) {
	'use strict';

    $(document).ready(function() {
        function mwb_sfw_show_subscription_settings_tab(){
            if( $('#_mwb_sfw_product').prop('checked') ) {
                
                $(document).find('.mwb_sfw_product_options').show();
                $(document).find('.general_tab').removeClass('active');
                $(document).find('#general_product_data').hide();
            }
            else{
                
             $(document).find('.mwb_sfw_product_options').hide();
             $(document).find('#mwb_sfw_product_target_section').hide();
             $(document).find('.general_tab').addClass('active');
             $(document).find('#general_product_data').show();
             
            }
        }
        mwb_sfw_show_subscription_settings_tab();
        $('#_mwb_sfw_product').on('change', function(){
            //var product_type    = $( 'select#product-type' ).val();
            //console.log(product_type);
            mwb_sfw_show_subscription_settings_tab();
        });
        
        
    });
})( jQuery );