<?php

/**
 * @Project ACCOMMODATION 4.x
 * @Author PHAN TAN DUNG (phantandung92@gmail.com)
 * @Copyright (C) 2016 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sat, 11 Jun 2016 16:20:15 GMT
 */

if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

$page_title = $lang_module['cat'];

// Change cat weight
if ($nv_Request->isset_request('changeweight', 'post')) {
    $catid = $nv_Request->get_int('catid', 'post', 0);

    $sql = 'SELECT catid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat WHERE catid=' . $catid;
    $catid = $db->query($sql)->fetchColumn();
    if (empty($catid))
        die('NO_' . $catid);

    $new_weight = $nv_Request->get_int('new_weight', 'post', 0);
    if (empty($new_weight))
        die('NO_' . $module_name);

    $sql = 'SELECT catid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat WHERE catid!=' . $catid . ' ORDER BY weight ASC';
    $result = $db->query($sql);

    $weight = 0;
    while ($row = $result->fetch()) {
        ++$weight;
        if ($weight == $new_weight)
            ++$weight;

        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_cat SET weight=' . $weight . ' WHERE catid=' . $row['catid'];
        $db->query($sql);
    }

    $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_cat SET weight=' . $new_weight . ' WHERE catid=' . $catid;
    $db->query($sql);

    $nv_Cache->delMod($module_name);

    include NV_ROOTDIR . '/includes/header.php';
    echo 'OK_' . $catid;
    include NV_ROOTDIR . '/includes/footer.php';
}

// Delete cat
if ($nv_Request->isset_request('delete', 'post')) {
    $catid = $nv_Request->get_int('catid', 'post', 0);

    $sql = 'SELECT catid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat WHERE catid=' . $catid;
    $catid = $db->query($sql)->fetchColumn();

    if (empty($catid))
        die('NO_' . $catid);

    $sql = 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat WHERE catid = ' . $catid;

    if ($db->exec($sql)) {
        nv_insert_logs(NV_LANG_DATA, $module_name, 'Delete', 'ID: ' . $catid, $admin_info['userid']);

        $sql = 'SELECT catid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat ORDER BY weight ASC';
        $result = $db->query($sql);
        $weight = 0;

        while ($row = $result->fetch()) {
            ++$weight;
            $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_cat SET weight=' . $weight . ' WHERE catid=' . $row['catid'];
            $db->query($sql);
        }

        $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET catid = 0 WHERE catid =' . $catid);

        $nv_Cache->delMod($module_name);
    } else {
        die('NO_' . $catid);
    }

    include NV_ROOTDIR . '/includes/header.php';
    echo 'OK_' . $catid;
    include NV_ROOTDIR . '/includes/footer.php';
}

$data = array();
$error = '';

$catid = $nv_Request->get_int('catid', 'post,get', 0);

if (!empty($catid)) {
    $sql = 'SELECT catid, title, description FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat WHERE catid = ' . $catid;
    $result = $db->query($sql);
    $data = $result->fetch();

    if (empty($data)) {
        nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content']);
    }

    $caption = $lang_module['cat_edit'];
} else {
    $data = array(
        'catid' => 0,
        'title' => '',
        'description' => '',
    );

    $caption = $lang_module['cat_add'];
}

if ($nv_Request->isset_request('submit', 'post')) {
    $data['title'] = $nv_Request->get_title('title', 'post', '', true);
    $data['description'] = $nv_Request->get_title('description', 'post', '', true);

    if (empty($data['title'])) {
        $error = $lang_module['cat_error_title'];
    } else {
        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat WHERE title = :title' . ($catid ? ' AND catid != ' . $catid : '');
        $sth = $db->prepare($sql);
        $sth->bindParam(':title', $data['title'], PDO::PARAM_STR);
        $sth->execute();
        $num = $sth->fetchColumn();

        if (!empty($num)) {
            $error = $lang_module['cat_error_exists'];
        } else {
            if (!$catid) {
                $sql = 'SELECT MAX(weight) weight FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat';
                $result = $db->query($sql);
                $weight = $result->fetch();
                $weight = $weight['weight'] + 1;

                $sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_cat (title, description, weight, add_time, edit_time) VALUES (
                         :title, :description, ' . $weight . ', ' . NV_CURRENTTIME . ', ' . NV_CURRENTTIME . '
                    )';
            } else {
                $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_cat SET title = :title, description = :description, edit_time = ' . NV_CURRENTTIME . ' WHERE catid = ' . $catid;
            }

            try {
                $sth = $db->prepare($sql);
                $sth->bindParam(':title', $data['title'], PDO::PARAM_STR);
                $sth->bindParam(':description', $data['description'], PDO::PARAM_STR);
                $sth->execute();

                if ($sth->rowCount()) {
                    if ($catid) {
                        nv_insert_logs(NV_LANG_DATA, $module_name, 'Edit', 'ID: ' . $catid, $admin_info['userid']);
                    } else {
                        nv_insert_logs(NV_LANG_DATA, $module_name, 'Add', ' ', $admin_info['userid']);
                    }

                    $nv_Cache->delMod($module_name);
                    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
                } else {
                    $error = $lang_module['errorsave'];
                }
            } catch (PDOException $e) {
                $error = $lang_module['errorsave'];
            }
        }
    }
}

$xtpl = new XTemplate('cat.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('CAPTION', $caption);
$xtpl->assign('FORM_ACTION', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op);
$xtpl->assign('DATA', $data);

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat ORDER BY weight ASC';
$array = $db->query($sql)->fetchAll();
$num = sizeof($array);

foreach ($array as $row) {
    $row['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=cat&amp;catid=' . $row['catid'] . "#addedit";

    for ($i = 1; $i <= $num; ++$i) {
        $xtpl->assign('WEIGHT', array('w' => $i, 'selected' => ($i == $row['weight']) ? ' selected="selected"' : ''));

        $xtpl->parse('main.loop.weight');
    }

    $xtpl->assign('ROW', $row);
    $xtpl->parse('main.loop');
}

if (!empty($error)) {
    $xtpl->assign('ERROR', $error);
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
