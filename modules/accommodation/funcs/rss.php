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

$channel = array();
$items = array();

$channel['title'] = $module_info['custom_title'];
$channel['link'] = NV_MY_DOMAIN . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;
$channel['description'] = !empty($module_info['description']) ? $module_info['description'] : $global_config['site_description'];

$db->sqlreset()->select('id, image, title, alias, facility, addtime')->order('id DESC')->limit(30);

$db->from(NV_PREFIXLANG . '_' . $module_data . '_rows')->where('status=1');

if ($module_info['rss']) {
    $result = $db->query($db->sql());
    while (list($id, $image, $title, $alias, $hometext, $publtime) = $result->fetch(3)) {
        $rimages = '';

        if (is_file(NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_upload . '/' . $image)) {
            $rimages = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $image;
        }
        if (is_file(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $image)) {
            $rimages = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $image;
        }

        $rimages = (!empty($rimages)) ? '<img src="' . $rimages . '" width="100" align="left" border="0">' : '';

        $items[] = array(
            'title' => $title,
            'link' => NV_MY_DOMAIN . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $alias . $global_config['rewrite_exturl'], //
            'guid' => $module_name . '_' . $id,
            'description' => $rimages . nv_clean60(strip_tags($hometext), 100),
            'pubdate' => $publtime
        );
    }
}

nv_rss_generate($channel, $items);
die();
