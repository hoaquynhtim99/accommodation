<!-- BEGIN: main -->
<p class="accom-detail-pagetitle clearfix">
     {LANG.detail_info}
     <span class="pull-right">
          {ROW.addtime}
     </span>
</p>
<!-- BEGIN: image -->
<div class="text-center">
     <img src="{ROW.image}" alt="{ROW.title}" class="img-thumbnail img-responsive m-bottom">
</div>
<!-- END: image -->
<div class="text-center">
     <h1>{ROW.title}</h1>
     <p>{LANG.code}: {ROW.code}</p>
</div>
<table class="table table-bordered table-striped">
     <col class="col-xs-4">
     <col class="col-xs-8">
     <col class="col-xs-4">
     <col class="col-xs-8">
     <tbody>
          <tr>
               <td>{LANG.house_post_name}</td>
               <td>{ROW.post_name}</td>
               <td>{LANG.house_owner_name}</td>
               <td>{ROW.owner_name}</td>
          </tr>
          <tr>
               <td>{LANG.house_owner_address}</td>
               <td>{ROW.owner_address}</td>
               <td>{LANG.house_owner_phone}</td>
               <td>{ROW.owner_phone}</td>
          </tr>
          <tr>
               <td>{LANG.house_owner_email}</td>
               <td>{ROW.owner_email}</td>
               <td>{LANG.house_area}</td>
               <td>{ROW.area} m<sup>2</sup></td>
          </tr>
          <tr>
               <td>{LANG.house_guest_gender}</td>
               <td>{ROW.guest_gender}</td>
               <td>{LANG.house_guest_number}</td>
               <td>{ROW.guest_number}</td>
          </tr>
          <tr>
               <td>{LANG.house_price}</td>
               <td>{ROW.price} {LANG.unit}</td>
               <td>{LANG.house_in_cat}</td>
               <td>{ROW.cat}</td>
          </tr>
          <tr>
               <td>{LANG.house_facility}</td>
               <td colspan="3">{ROW.facility}</td>
          </tr>
          <tr>
               <td>{LANG.house_rules}</td>
               <td colspan="3">{ROW.rules}</td>
          </tr>
     </tbody>
</table>
[INNER_PAGE]
<!-- BEGIN: others -->
<p class="accom-detail-pagetitle clearfix">
     {LANG.detail_other}
</p>
<!-- BEGIN: loop -->
<div class="accom-items">
     <div class="row">
          <div class="col-xs-3 text-center">
               <img class="img-thumbnail img-responsive" src="{OTHER.image_thumb}" alt="{OTHER.title}"/>
               {OTHER.code}
          </div>
          <div class="col-xs-21">
               <h3><a href="{OTHER.link}">{OTHER.title}</a></h3>
               <p>{LANG.address}: {OTHER.owner_address}</p>
               <p>{LANG.price}: <span class="money">{OTHER.price} {LANG.unit}</span> | {LANG.area}: {OTHER.area} m<sup>2</sup> | {LANG.addtime}: {OTHER.addtime}</p>
          </div>
     </div>
</div>
<!-- END: loop -->
<!-- END: others -->
<!-- END: main -->