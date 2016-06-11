<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->
<form method="post" action="{FORM_ACTION}">
     <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
               <col class="w200"/>
               <tbody>
                    <tr>
                         <td class="text-right text-strong">{LANG.house_in_cat}</td>
                         <td>
                              <select name="catid" class="form-control w300">
                                   <!-- BEGIN: cat --><option value="{CAT.catid}"{CAT.selected}>{CAT.title}</option><!-- END: cat -->
                              </select>
                         </td>
                    </tr>
                    <tr>
                         <td class="text-right text-strong">{LANG.house_post_name}</td>
                         <td>
                              <input type="text" name="post_name" value="{DATA.post_name}" class="form-control w500">
                         </td>
                    </tr>
                    <tr>
                         <td class="text-right text-strong">{LANG.house_owner_name}</td>
                         <td>
                              <input type="text" name="owner_name" value="{DATA.owner_name}" class="form-control w500">
                         </td>
                    </tr>
                    <tr>
                         <td class="text-right text-strong">{LANG.house_owner_address}</td>
                         <td>
                              <input type="text" name="owner_address" value="{DATA.owner_address}" class="form-control w500">
                         </td>
                    </tr>
                    <tr>
                         <td class="text-right text-strong">{LANG.house_owner_phone}</td>
                         <td>
                              <input type="text" name="owner_phone" value="{DATA.owner_phone}" class="form-control w500">
                         </td>
                    </tr>
                    <tr>
                         <td class="text-right text-strong">{LANG.house_owner_email}</td>
                         <td>
                              <input type="text" name="owner_email" value="{DATA.owner_email}" class="form-control w500">
                         </td>
                    </tr>
                    <tr>
                         <td class="text-right text-strong">{LANG.title}</td>
                         <td>
                              <input type="text" id="idtitle" name="title" value="{DATA.title}" class="form-control w500">
                         </td>
                    </tr>
                    <tr>
                         <td class="text-right text-strong">{LANG.alias}</td>
                         <td>
                              <div class="input-group w500">
                                   <input type="text" id="idalias" name="alias" value="{DATA.alias}" class="form-control">
                                   <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><i class="fa fa-retweet"></i></button>
                                   </span>
                              </div>
                         </td>
                    </tr>
                    <tr>
                         <td class="text-right text-strong">{LANG.house_area}</td>
                         <td>
                              <input type="text" name="area" value="{DATA.area}" class="form-control w100">
                         </td>
                    </tr>
                    <tr>
                         <td class="text-right text-strong">{LANG.house_guest_gender}</td>
                         <td>
                              <select name="guest_gender" class="form-control w200">
                                   <!-- BEGIN: gender --><option value="{GENDER.key}"{GENDER.selected}>{GENDER.title}</option><!-- END: gender -->
                              </select>
                         </td>
                    </tr>
                    <tr>
                         <td class="text-right text-strong">{LANG.house_guest_number}</td>
                         <td>
                              <input type="text" name="guest_number" value="{DATA.guest_number}" class="form-control w100">
                         </td>
                    </tr>
                    <tr>
                         <td class="text-right text-strong">{LANG.house_price}</td>
                         <td>
                              <input type="text" name="price" value="{DATA.price}" class="form-control w100">
                         </td>
                    </tr>
                    <tr>
                         <td class="text-right text-strong">{LANG.image}</td>
                         <td>
                              <div class="input-group w500">
                                   <input type="text" id="post-image" name="image" value="{DATA.image}" class="form-control">
                                   <span class="input-group-btn">
                                        <button data-path="{UPLOADS_DIR}" id="select-image" class="btn btn-default" type="button"><i class="fa fa-file-image-o"></i></button>
                                   </span>
                              </div>
                         </td>
                    </tr>
                    <tr>
                         <td class="text-right text-strong">{LANG.house_facility}</td>
                         <td>
                              {DATA.facility}
                         </td>
                    </tr>
                    <tr>
                         <td class="text-right text-strong">{LANG.house_rules}</td>
                         <td>
                              {DATA.rules}
                         </td>
                    </tr>
                    <!-- BEGIN: istmp -->
                    <tr>
                         <td class="text-right text-strong">{LANG.house_queue_accept}</td>
                         <td>
                              <input type="checkbox" name="accept" value="1"{ACCEPT}>
                         </td>
                    </tr>
                    <!-- END: istmp -->
               </tbody>
               <tfoot>
                    <tr>
                         <td colspan="2">
                              <input type="hidden" name="id" value="{DATA.id}">
                              <input type="submit" name="submit" value="{GLANG.submit}" class="btn btn-primary">
                         </td>
                    </tr>
               </tfoot>
          </table>
     </div>
</form>
<!-- BEGIN: getalias -->
<script type="text/javascript">
$(document).ready(function(){
     $("#idtitle").change(function(){
          get_alias('{DATA.id}');
     });
});
</script>
<!-- END: getalias -->
<!-- END: main -->