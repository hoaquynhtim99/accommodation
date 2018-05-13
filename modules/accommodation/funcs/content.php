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

$page_title = $lang_module['content_pagetitle'];
$key_words = $module_info['keywords'];

if (!defined('NV_IS_USER')) {
    $link = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=users&" . NV_OP_VARIABLE . "=login&nv_redirect=" . nv_base64_encode($client_info['selfurl']);
    $contents = nv_info_theme($lang_module['content_login'], $link, 'info');

    include NV_ROOTDIR . '/includes/header.php';
    echo nv_site_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}

$last_submited = $nv_Request->get_int($module_data . '_submited', 'session', 0);

if (!empty($last_submited)) {
    if ((NV_CURRENTTIME - $last_submited) > 360) {
        $nv_Request->unset_request($module_data . '_submited', 'session');
    } else {
        $link = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name;
        $contents = nv_info_theme($lang_module['content_waiting'], $link, 'info');

        include NV_ROOTDIR . '/includes/header.php';
        echo nv_site_theme($contents);
        include NV_ROOTDIR . '/includes/footer.php';
    }
}

$error = '';

$array = array(
    'catid' => 0,
    'post_id' => $user_info['userid'],
    'post_name' => $user_info['full_name'],
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
    'istmp' => 1
);

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
    $array['price'] = $nv_Request->get_float('price', 'post', 0);
    $array['facility'] = $nv_Request->get_string('facility', 'post', '');
    $array['facility'] = nv_nl2br(nv_htmlspecialchars(strip_tags(trim($array['facility']))), '<br />');
    $array['rules'] = $nv_Request->get_string('rules', 'post', '');
    $array['rules'] = nv_nl2br(nv_htmlspecialchars(strip_tags(trim($array['rules']))), '<br />');

    $array['alias'] = empty($array['alias']) ? change_alias($array['title']) : change_alias($array['alias']);
    $array['alias'] = $array['alias'] . '-rand' . mt_rand(1, 9999);

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
        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE alias = :alias';
        $sth = $db->prepare($sql);
        $sth->bindParam(':alias', $array['alias'], PDO::PARAM_STR);
        $sth->execute();
        $num = $sth->fetchColumn();

        if (!empty($num)) {
            $error = $lang_module['house_error_exists'];
        } else {
            // Upload image
            if (isset($_FILES['image']) and is_uploaded_file($_FILES['image']['tmp_name'])) {
                $upload = new NukeViet\Files\Upload(array('images'), $global_config['forbid_extensions'], $global_config['forbid_mimes'], 2097152 /* 2MB */, NV_MAX_WIDTH, NV_MAX_HEIGHT);
                $upload->setLanguage($lang_global);
                $upload_info = $upload->save_file($_FILES['image'], NV_UPLOADS_REAL_DIR . '/' . $module_upload, false);

                @unlink($_FILES['image']['tmp_name']);

                if (empty($upload_info['error'])) {
                    mt_srand((double)microtime() * 1000000);
                    $maxran = 1000000;
                    $random_num = mt_rand(0, $maxran);
                    $random_num = md5($random_num);
                    $nv_pathinfo_filename = nv_pathinfo_filename($upload_info['name']);
                    $new_name = NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $nv_pathinfo_filename . '.' . $random_num . '.' . $upload_info['ext'];
                    $rename = nv_renamefile($upload_info['name'], $new_name);

                    if ($rename[0] == 1) {
                        $fileupload = $new_name;
                    } else {
                        $fileupload = $upload_info['name'];
                    }

                    @chmod($fileupload, 0644);
                    $fileupload = str_replace(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/', '', $fileupload);
                    $array['image'] = $fileupload;
                } else {
                    $error = $upload_info['error'];
                }

                unset($upload, $upload_info);
            }

            if (empty($error)) {
                $sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_rows (catid, post_id, post_name, owner_name, owner_address, owner_phone, owner_email, title, alias,
                              area, guest_gender, guest_number, facility, rules, price, image, addtime, edittime, status, istmp) VALUES (
                         :catid, ' . $array['post_id'] . ', :post_name, :owner_name, :owner_address, :owner_phone, :owner_email, :title, :alias, :area, :guest_gender, :guest_number, 
                         :facility, :rules, :price, :image, ' . NV_CURRENTTIME . ', ' . NV_CURRENTTIME . ', 0, 1
                    )';

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
                        $nv_Cache->delMod($module_name);
                        $nv_Request->set_Session($module_data . '_submited', NV_CURRENTTIME);

                        $link = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name;
                        $contents = nv_info_theme($lang_module['content_waiting'], $link, 'info');

                        include NV_ROOTDIR . '/includes/header.php';
                        echo nv_site_theme($contents);
                        include NV_ROOTDIR . '/includes/footer.php';
                    } else {
                        $error = $lang_module['errorsave'];
                    }
                } catch (PDOException $e) {
                    $error = $lang_module['errorsave'];
                }
            }
        }
    }
}

$contents = nv_content_theme($array, $error);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
