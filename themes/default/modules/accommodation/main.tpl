<!-- BEGIN: main -->
<!-- BEGIN: result -->
<div class="m-bottom text-right">
     {LANG.search_result}: <strong class="text-danger">{RESULT}</strong> {LANG.search_result1}.
</div>
<!-- END: result -->
<!-- BEGIN: loop -->
<div class="accom-items">
     <div class="row">
          <div class="col-xs-3 text-center">
               <img class="img-thumbnail img-responsive" src="{ROW.image_thumb}" alt="{ROW.title}"/>
               {ROW.code}
          </div>
          <div class="col-xs-21">
               <h3><a href="{ROW.link}">{ROW.title}</a></h3>
               <p>{LANG.address}: {ROW.owner_address}</p>
               <p>{LANG.price}: <span class="money">{ROW.price} {LANG.unit}</span> | {LANG.area}: {ROW.area} m<sup>2</sup> | {LANG.addtime}: {ROW.addtime}</p>
          </div>
     </div>
</div>
<!-- END: loop -->
<!-- BEGIN: generate_page -->
{GENERATE_PAGE}
<!-- END: generate_page -->
<!-- END: main -->