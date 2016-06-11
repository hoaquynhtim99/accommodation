<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-10-2010 20:59
 */

if (! defined('NV_ADMIN')) {
    die('Stop!!!');
}

/**
 * Note:
 * 	- Module var is: $lang, $module_file, $module_data, $module_upload, $module_theme, $module_name
 * 	- Accept global var: $db, $db_config, $global_config
 */

$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat (catid, title, description, weight, add_time, edit_time) VALUES
(1, 'Phòng cho thuê', 'Phòng cho thuê', 1, 1438586073, 1438586536),
(2, 'Nhà nguyên căn', 'Nhà nguyên căn', 2, 1438586083, 1438586672),
(4, 'Cần ở ghép', 'Cần ở ghép', 3, 1438588143, 1438588143);
");

$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows (id, catid, post_id, post_name, owner_name, owner_address, owner_phone, owner_email, title, alias, area, guest_gender, guest_number, facility, rules, price, image, addtime, edittime, status, istmp) VALUES
(2, 2, 1, 'Phan Tấn Dũng', 'Nguyễn Văn A', 'Kontum', '0123456', 'phantandung92@gmail.com', 'Nhà trọ tầm trung 1', 'Nha-tro-tam-trung', 16, 'F', 2, 'Vệ sinh trong', 'Về trước 22h', 500000, '', 1438610387, 1438611257, 1, 0),
(3, 2, 1, 'Phan Tấn Dũng', 'Nguyễn Văn A', 'Kontum', '0123456', 'phantandung92@gmail.com', 'Nhà trọ tầm trung 2', 'Nha-tro-tam-trung-1', 16, 'F', 2, 'Vệ sinh trong', 'Về trước 22h', 500000, '', 1438610387, 1438610387, 1, 0),
(4, 2, 1, 'Phan Tấn Dũng', 'Nguyễn Văn A', 'Kontum', '0123456', 'phantandung92@gmail.com', 'Nhà trọ tầm trung 3', 'Nha-tro-tam-trung-2', 16, 'F', 2, 'Vệ sinh trong', 'Về trước 22h', 500000, '', 1438610387, 1439264009, 1, 0);
");
