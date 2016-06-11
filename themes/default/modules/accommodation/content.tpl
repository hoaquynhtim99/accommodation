<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->
<p class="text-danger text-right">
     <i>{LANG.content_required}</i>
</p>
<form method="post" action="{FORM_ACTION}" enctype="multipart/form-data">
     <div class="table-responsive">
          <table class="post-table">
               <col class="w200"/>
               <tbody>
                    <tr>
                         <td class="text-right text-strong">{LANG.house_post_name}</td>
                         <td class="required">
                              <input type="text" name="post_name" value="{DATA.post_name}" class="form-control">
                         </td>
                    </tr>
                    <tr>
                         <td class="text-right text-strong">{LANG.house_owner_name}</td>
                         <td>
                              <input type="text" name="owner_name" value="{DATA.owner_name}" class="form-control">
                         </td>
                    </tr>
                    <tr>
                         <td class="text-right text-strong">{LANG.house_owner_address}</td>
                         <td class="required">
                              <input type="text" name="owner_address" value="{DATA.owner_address}" class="form-control">
                         </td>
                    </tr>
                    <tr>
                         <td class="text-right text-strong">{LANG.house_owner_phone}</td>
                         <td class="required">
                              <input type="text" name="owner_phone" value="{DATA.owner_phone}" class="form-control">
                         </td>
                    </tr>
                    <tr>
                         <td class="text-right text-strong">{LANG.house_owner_email}</td>
                         <td>
                              <input type="text" name="owner_email" value="{DATA.owner_email}" class="form-control">
                         </td>
                    </tr>
                    <tr>
                         <td class="text-right text-strong">{LANG.title}</td>
                         <td class="required">
                              <input type="text" name="title" value="{DATA.title}" class="form-control">
                         </td>
                    </tr>
                    <tr>
                         <td class="text-right text-strong">{LANG.house_in_cat}</td>
                         <td>
                              <select name="catid" class="form-control">
                                   <!-- BEGIN: cat --><option value="{CAT.catid}"{CAT.selected}>{CAT.title}</option><!-- END: cat -->
                              </select>
                         </td>
                    </tr>
                    <tr>
                         <td class="text-right text-strong">{LANG.house_area}</td>
                         <td>
                              <input type="text" name="area" value="{DATA.area}" class="form-control">
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
                    <tr class="required">
                         <td class="text-right text-strong">{LANG.house_guest_number}</td>
                         <td>
                              <input type="text" name="guest_number" value="{DATA.guest_number}" class="form-control w200">
                         </td>
                    </tr>
                    <tr>
                         <td class="text-right text-strong">{LANG.house_price}</td>
                         <td>
                              <input type="text" name="price" value="{DATA.price}" class="form-control w200">
                         </td>
                    </tr>
                    <tr>
                         <td class="text-right text-strong">{LANG.house_facility}</td>
                         <td class="required">
                              <textarea class="form-control" name="facility" rows="7">{DATA.facility}</textarea>
                         </td>
                    </tr>
                    <tr>
                         <td class="text-right text-strong">{LANG.house_rules}</td>
                         <td class="required">
                              <textarea class="form-control" name="rules" rows="7">{DATA.rules}</textarea>
                         </td>
                    </tr>
                    <tr>
                         <td class="text-right text-strong">{LANG.content_image}</td>
                         <td>
                              <input type="file" class="form-control" name="image">
                         </td>
                    </tr>
               </tbody>
               <tfoot>
                    <tr>
                         <td colspan="2" class="text-center">
                              <input type="hidden" name="id" value="{DATA.id}">
                              <input type="submit" name="submit" value="{GLANG.submit}" class="btn btn-primary">
                         </td>
                    </tr>
               </tfoot>
          </table>
     </div>
</form>
<!-- END: main -->