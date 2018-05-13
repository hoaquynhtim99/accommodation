<?php

/**
 * @Project ACCOMMODATION 4.x
 * @Author PHAN TAN DUNG (phantandung92@gmail.com)
 * @Copyright (C) 2016 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sat, 11 Jun 2016 16:20:15 GMT
 */

if (!defined('NV_MAINFILE'))
    die('Stop!!!');

global $lang_module, $module_info, $global_array_cat, $search_cat, $search_price;

$xtpl = new XTemplate('block.search.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
$xtpl->assign('LANG', $lang_module);

foreach ($global_array_cat as $cat) {
    $cat['selected'] = $search_cat == $cat['catid'] ? ' selected="selected"' : '';

    $xtpl->assign('CAT', $cat);
    $xtpl->parse('main.cat');
}

for ($i = 0; $i <= 4; $i++) {
    $price = array(
        'key' => $i,
        'title' => $lang_module['search_price' . $i],
        'selected' => $i == $search_price ? ' selected="selected"' : ''
    );

    $xtpl->assign('PRICE', $price);
    $xtpl->parse('main.price');
}

$xtpl->parse('main');
$content = $xtpl->text('main');
