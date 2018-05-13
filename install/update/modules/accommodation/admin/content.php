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

$id = $nv_Request->get_int('id', 'post,get', 0);
$error = '';

if (!empty($id)) {
    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id = ' . $id;
    $result = $db->query($sql);
    $array = $result->fetch();

    if (empty($array)) {
        nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content']);
    }

    $array['facility'] = nv_editor_br2nl($array['facility']);
    $array['rules'] = nv_editor_br2nl($array['rules']);

    $page_title = $lang_module['edit'];
} else {
    $array = array(
        'id' => 0,
        'catid' => 0,
        'post_id' => $admin_info['userid'],
        'post_name' => $admin_info['full_name'],
        'owner_name' => '',
        'owner_address' => '',
        'owner_phone' => '',
        'owner_email' => '',
        'title' => '',
        'alias' => '',
        'area' => 0,
        'guest_gender' => 'M',
        'guest_number' => 0,
        'facility' => '',
        'rules' => '',
        'price' => 0,
        'image' => '',
        'istmp' => 0
    );

    $page_title = $lang_module['add'];
}

$accept = $nv_Request->get_int('accept', 'post', 0);

if ($nv_Request->isset_request('submit', 'post')) {
    $array['catid'] = $nv_Request->get_int('catid', 'post', 0);
    $array['post_name'] = $nv_Request->get_title('post_name', 'post', '', true);
    $array['owner_name'] = $nv_Request->get_title('owner_name', 'post', '', true);
    $array['owner_address'] = $nv_Request->get_title('owner_address', 'post', '', true);
    $array['owner_phone'] = $nv_Request->get_title('owner_phone', 'post', '', true);
    $array['owner_email'] = $nv_Request->get_title('owner_email', 'post', '', true);
    $array['title'] = $nv_Request->get_title('title', 'post', '', true);
    $array['alias'] = $nv_Request->get_title('alias', 'post', '', true);
    $array['area'] = $nv_Request->get_float('area', 'post', 0);
    $array['guest_gender'] = $nv_Request->get_title('guest_gender', 'post', '', true);
    $array['guest_number'] = $nv_Request->get_int('guest_number', 'post', 0);
    $array['facility'] = $nv_Request->get_editor('facility', '', NV_ALLOWED_HTML_TAGS);
    $array['rules'] = $nv_Request->get_editor('rules', '', NV_ALLOWED_HTML_TAGS);
    $array['price'] = $nv_Request->get_float('price', 'post', 0);
    $array['image'] = $nv_Request->get_string('image', 'post', '');

    $array['alias'] = empty($array['alias']) ? change_alias($array['title']) : change_alias($array['alias']);

    if (!empty($array['image'])) {
        $array['image'] = substr($array['image'], strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/'));
    }

    if (empty($array['post_name'])) {
        $error = $lang_module['house_error_post_name'];
    } elseif (empty($array['owner_address'])) {
        $error = $lang_module['house_error_owner_address'];
    } elseif (empty($array['owner_phone'])) {
        $error = $lang_module['house_error_owner_phone'];
    } elseif (empty($array['title'])) {
        $error = $lang_module['house_error_title'];
    } elseif (empty($array['catid'])) {
        $error = $lang_module['house_error_cat'];
    } elseif (empty($array['guest_gender'])) {
        $error = $lang_module['house_error_guest_gender'];
    } elseif (empty($array['guest_number'])) {
        $error = $lang_module['house_error_guest_number'];
    } elseif (empty($array['price'])) {
        $error = $lang_module['house_error_price'];
    } elseif (empty($array['facility'])) {
        $error = $lang_module['house_error_facility'];
    } elseif (empty($array['rules'])) {
        $error = $lang_module['house_error_rules'];
    } else {
        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE alias = :alias' . ($array['id'] ? ' AND id != ' . $array['id'] : '');
        $sth = $db->prepare($sql);
        $sth->bindParam(':alias', $array['alias'], PDO::PARAM_STR);
        $sth->execute();
        $num = $sth->fetchColumn();

        if (!empty($num)) {
            $error = $lang_module['house_error_exists'];
        } else {
            if (!$array['id']) {
                $sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_rows (catid, post_id, post_name, owner_name, owner_address, owner_phone, owner_email, title, alias,
                              area, guest_gender, guest_number, facility, rules, price, image, addtime, edittime, status, istmp) VALUES (
                         :catid, ' . $array['post_id'] . ', :post_name, :owner_name, :owner_address, :owner_phone, :owner_email, :title, :alias, :area, :guest_gender, :guest_number, 
                         :facility, :rules, :price, :image, ' . NV_CURRENTTIME . ', ' . NV_CURRENTTIME . ', 1, 0
                    )';
            } else {
                $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET 
                         catid = :catid, post_name = :post_name, owner_name = :owner_name, owner_address = :owner_address, owner_phone = :owner_phone, owner_email = :owner_email,
                         title = :title, alias = :alias, area = :area, guest_gender = :guest_gender, guest_number = :guest_number, facility = :facility, rules = :rules, price = :price, image = :image,';

                if ($accept) {
                    $sql .= ' status = 1, istmp = 0,';
                }

                $sql .= ' edittime = ' . NV_CURRENTTIME . ' WHERE id = ' . $array['id'];
            }

            $array['facility'] = nv_editor_nl2br($array['facility']);
            $array['rules'] = nv_editor_nl2br($array['rules']);

            try {
                $sth = $db->prepare($sql);
                $sth->bindParam(':catid', $array['catid'], PDO::PARAM_INT);
                $sth->bindParam(':post_name', $array['post_name'], PDO::PARAM_STR);
                $sth->bindParam(':owner_name', $array['owner_name'], PDO::PARAM_STR);
                $sth->bindParam(':owner_address', $array['owner_address'], PDO::PARAM_STR);
                $sth->bindParam(':owner_phone', $array['owner_phone'], PDO::PARAM_STR);
                $sth->bindParam(':owner_email', $array['owner_email'], PDO::PARAM_STR);
                $sth->bindParam(':title', $array['title'], PDO::PARAM_STR);
                $sth->bindParam(':alias', $array['alias'], PDO::PARAM_STR);
                $sth->bindParam(':area', $array['area'], PDO::PARAM_INT);
                $sth->bindParam(':guest_gender', $array['guest_gender'], PDO::PARAM_STR);
                $sth->bindParam(':guest_number', $array['guest_number'], PDO::PARAM_INT);
                $sth->bindParam(':facility', $array['facility'], PDO::PARAM_STR, strlen($array['facility']));
                $sth->bindParam(':rules', $array['rules'], PDO::PARAM_STR, strlen($array['rules']));
                $sth->bindParam(':price', $array['price'], PDO::PARAM_STR);
                $sth->bindParam(':image', $array['image'], PDO::PARAM_STR);
                $sth->execute();

                if ($sth->rowCount()) {
                    if ($array['id']) {
                        nv_insert_logs(NV_LANG_DATA, $module_name, 'Edit', 'ID: ' . $array['id'], $admin_info['userid']);
                    } else {
                        nv_insert_logs(NV_LANG_DATA, $module_name, 'Add', ' ', $admin_info['userid']);
                    }

                    $nv_Cache->delMod($module_name);
                    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
                } else {
                    $error = $lang_module['errorsave'];
                }
            } catch (PDOException $e) {
                $error = $lang_module['errorsave'];
            }
        }
    }
}

if (!empty($array['facility']))
    $array['facility'] = nv_htmlspecialchars($array['facility']);
if (!empty($array['rules']))
    $array['rules'] = nv_htmlspecialchars($array['rules']);

if (defined('NV_EDITOR'))
    require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';

if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
    $array['facility'] = nv_aleditor('facility', '100%', '300px', $array['facility']);
} else {
    $array['facility'] = '<textarea style="width:100%;height:300px" name="facility">' . $array['facility'] . '</textarea>';
}

if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
    $array['rules'] = nv_aleditor('rules', '100%', '300px', $array['rules']);
} else {
    $array['rules'] = '<textarea style="width:100%;height:300px" name="rules">' . $array['rules'] . '</textarea>';
}

if (!empty($array['image'])) {
    $array['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $array['image'];
}

$xtpl = new XTemplate('content.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('FORM_ACTION', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op);
$xtpl->assign('DATA', $array);
$xtpl->assign('UPLOADS_DIR', NV_UPLOADS_DIR . '/' . $module_upload);

if (!empty($array['istmp'])) {
    $xtpl->assign('ACCEPT', $accept ? ' checked="checked"' : '');
    $xtpl->parse('main.istmp');
}

if (empty($array['alias'])) {
    $xtpl->parse('main.getalias');
}

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
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
