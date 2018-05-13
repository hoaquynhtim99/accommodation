<?php

/**
 * @Project ACCOMMODATION 4.x
 * @Author PHAN TAN DUNG (phantandung92@gmail.com)
 * @Copyright (C) 2016 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sat, 11 Jun 2016 16:20:15 GMT
 */

if (!defined('NV_SYSTEM'))
    die('Stop!!!');

define('NV_MOD_ACCOMMODATION', true);

$global_array_cat = array();
$array_mod_title = array();
$global_code = "PT%'.06d";
$is_search = false;
$search_cat = -1;
$search_price = -1;

$sql = 'SELECT catid, title, description FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat ORDER BY weight ASC';
$list = $nv_Cache->db($sql, 'catid', $module_name);
foreach ($list as $l) {
    $global_array_cat[$l['catid']] = $l;
}

// Xac dinh RSS
if ($module_info['rss']) {
    $rss[] = array('title' => $module_info['custom_title'], 'src' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['rss']);
}

$page = 1;
$per_page = 10;

if ($op == 'main' and isset($array_op[0])) {
    if (isset($array_op[1])) {
        if (preg_match("/^price\-([0-9]+)$/i", $array_op[1], $m) and preg_match("/^cat\-([0-9]+)$/i", $array_op[0], $k)) {
            if (nv_url_rewrite($_SERVER['REQUEST_URI'], true) != $_SERVER['REQUEST_URI']) {
                nv_redirect_location($_SERVER['REQUEST_URI']);
            }

            $search_cat = intval($k[1]);
            $search_price = intval($m[1]);
            $is_search = true;
        } else {
            $redirect = '<meta http-equiv="Refresh" content="3;URL=' . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, true) . '" />';
            nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content'] . $redirect);
        }

        if (isset($array_op[2])) {
            if (preg_match("/^page\-([0-9]+)$/i", $array_op[2], $m)) {
                $page = intval($m[1]);
            } else {
                $redirect = '<meta http-equiv="Refresh" content="3;URL=' . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, true) . '" />';
                nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content'] . $redirect);
            }
        }
    } elseif (preg_match("/^page\-([0-9]+)$/i", $array_op[0], $m)) {
        $page = intval($m[1]);
    } else {
        $op = 'detail';
    }
}
