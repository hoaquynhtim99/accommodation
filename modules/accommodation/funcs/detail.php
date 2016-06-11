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

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE status = 1 AND alias = :alias';
$sth = $db->prepare($sql);
$sth->bindParam(':alias', $array_op[0], PDO::PARAM_STR);
$sth->execute();

$row = $sth->fetch();

if (empty($row)) {
    nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content']);
}

$page_title = $row['title'];
$description = strip_tags($row['facility']);

if (is_file(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['image'])) {
    $row['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['image'];
} else {
    $row['image'] = '';
}

$row['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $row['alias'] . $global_config['rewrite_exturl'];
$row['code'] = sprintf($global_code, $row['id']);

// Other
$db->sqlreset()->select('id, image, owner_address, title, alias, price, area, addtime')->from(NV_PREFIXLANG . '_' . $module_data . '_rows')->where('status = 1 AND id != ' . $row['id'])->order('id DESC')->limit(5)->offset(0);

$others = array();
$result = $db->query($db->sql());

while ($other = $result->fetch()) {
    if (is_file(NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_upload . '/' . $other['image'])) {
        $other['image_thumb'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $other['image'];
    } elseif (is_file(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $other['image'])) {
        $other['image_thumb'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $other['image'];
    } else {
        $other['image_thumb'] = '';
    }

    $other['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $other['alias'] . $global_config['rewrite_exturl'];
    $other['code'] = sprintf($global_code, $other['id']);

    $others[] = $other;
}
$contents = nv_detail_theme($row, $others);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
