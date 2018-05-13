<?php

/**
 * @Project ACCOMMODATION 4.x
 * @Author PHAN TAN DUNG (phantandung92@gmail.com)
 * @Copyright (C) 2016 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sat, 11 Jun 2016 16:20:15 GMT
 */

if (!defined('NV_MOD_ACCOMMODATION'))
    die('Stop!!!');

/**
 * nv_main_theme()
 * 
 * @param mixed $array
 * @param mixed $generate_page
 * @param mixed $is_search
 * @param mixed $num_items
 * @return
 */
function nv_main_theme($array, $generate_page, $is_search, $num_items)
{
    global $lang_module, $module_info;

    $xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);

    foreach ($array as $row) {
        $row['price'] = number_format($row['price'], 0, '.', ',');
        $row['addtime'] = nv_date("d/m/Y", $row['addtime']);

        if (empty($row['image_thumb'])) {
            $row['image_thumb'] = NV_BASE_SITEURL . 'themes/' . $module_info['template'] . '/images/no_image.gif';
        }

        $xtpl->assign('ROW', $row);
        $xtpl->parse('main.loop');
    }

    if (!empty($generate_page)) {
        $xtpl->assign('GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.generate_page');
    }

    if (!empty($is_search)) {
        $xtpl->assign('RESULT', $num_items);
        $xtpl->parse('main.result');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_detail_theme()
 * 
 * @param mixed $row
 * @param mixed $others
 * @return
 */
function nv_detail_theme($row, $others)
{
    global $lang_module, $module_info, $global_array_cat;

    $xtpl = new XTemplate('detail.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);

    $row['price'] = number_format($row['price'], 0, '.', ',');
    $row['addtime'] = nv_date("l, d/m/Y", $row['addtime']);
    $row['guest_gender'] = $lang_module['house_guest_gender' . $row['guest_gender']];
    $row['owner_email'] = nv_EncodeEmail($row['owner_email']);
    $row['cat'] = isset($global_array_cat[$row['catid']]) ? $global_array_cat[$row['catid']]['title'] : 'N/A';

    $xtpl->assign('ROW', $row);

    if (!empty($row['image'])) {
        $xtpl->parse('main.image');
    }

    if (!empty($others)) {
        foreach ($others as $other) {
            $other['price'] = number_format($other['price'], 0, '.', ',');
            $other['addtime'] = nv_date("d/m/Y", $other['addtime']);

            if (empty($other['image_thumb'])) {
                $other['image_thumb'] = NV_BASE_SITEURL . 'themes/' . $module_info['template'] . '/images/no_image.gif';
            }

            $xtpl->assign('OTHER', $other);
            $xtpl->parse('main.others.loop');
        }

        $xtpl->parse('main.others');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_info_theme()
 * 
 * @param mixed $message
 * @param mixed $link
 * @param string $type
 * @return
 */
function nv_info_theme($message, $link, $type = 'info')
{
    global $lang_module, $module_info;

    $xtpl = new XTemplate('info.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('MESSAGE', $message);
    $xtpl->assign('LINK', $link);

    if ($type == 'error') {
        $xtpl->parse('main.error');
    } else {
        $xtpl->parse('main.info');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_content_theme()
 * 
 * @param mixed $array
 * @param mixed $error
 * @return
 */
function nv_content_theme($array, $error)
{
    global $lang_module, $module_info, $lang_global, $module_name, $op, $global_array_cat;

    $xtpl = new XTemplate('content.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('FORM_ACTION', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op);
    $xtpl->assign('DATA', $array);

    foreach (array('M', 'F') as $gender) {
        $gender = array(
            'key' => $gender,
            'title' => $lang_module['house_guest_gender' . $gender],
            'selected' => $gender == $array['guest_gender'] ? ' selected="selected"' : ''
        );

        $xtpl->assign('GENDER', $gender);
        $xtpl->parse('main.gender');
    }

    foreach ($global_array_cat as $cat) {
        $cat['selected'] = $cat['catid'] == $array['catid'] ? ' selected="selected"' : '';

        $xtpl->assign('CAT', $cat);
        $xtpl->parse('main.cat');
    }

    if (!empty($error)) {
        $xtpl->assign('ERROR', $error);
        $xtpl->parse('main.error');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}
