<!-- BEGIN: main -->
<form id="form-search-accom" role="form" class="form-horizontal">
     <div class="form-group">
          <label class="control-label col-xs-4">{LANG.search_cat}</label>
          <div class="col-xs-7">
               <select class="form-control" name="cat">
                    <option value="0">{LANG.search_cat_all}</option>
                    <!-- BEGIN: cat --><option value="{CAT.catid}"{CAT.selected}>{CAT.title}</option><!-- END: cat -->
               </select>
          </div>
          <label class="control-label col-xs-2">{LANG.search_price}</label>
          <div class="col-xs-7">
               <select class="form-control" name="price">
                    <!-- BEGIN: price --><option value="{PRICE.key}"{PRICE.selected}>{PRICE.title}</option><!-- END: price -->
               </select>
          </div>
          <div class="col-xs-4">
               <input type="submit" name="submit" value="{LANG.search}" class="btn btn-primary">
          </div>
     </div>
</form>
<!-- END: main -->