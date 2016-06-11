/**
 * @Project ACCOMMODATION 4.x
 * @Author PHAN TAN DUNG (phantandung92@gmail.com)
 * @Copyright (C) 2016 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sat, 11 Jun 2016 16:20:15 GMT
 */

$(document).ready(function(){
     $('#form-search-accom').submit(function(e){
          e.preventDefault();
          
          if( $(this).find('[name="submit"]').is(':disabled') ){
               return;
          }
          $(this).find('[name="submit"]').prop('disabled', true);
          
          window.location = nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=cat-' + $(this).find('[name="cat"]').val() + '/price-' + $(this).find('[name="price"]').val();
     });
});