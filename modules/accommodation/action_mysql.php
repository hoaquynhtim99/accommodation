<?php

/**
 * @Project ACCOMMODATION 4.x
 * @Author PHAN TAN DUNG (phantandung92@gmail.com)
 * @Copyright (C) 2016 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sat, 11 Jun 2016 16:20:15 GMT
 */

if (!defined('NV_IS_FILE_MODULES'))
    die('Stop!!!');

$sql_drop_module = array();
$array_table = array('cat', 'rows');
$table = $db_config['prefix'] . '_' . $lang . '_' . $module_data;
$result = $db->query('SHOW TABLE STATUS LIKE ' . $db->quote($table . '_%'));
while ($item = $result->fetch()) {
    $name = substr($item['name'], strlen($table) + 1);
    if (preg_match('/^' . $db_config['prefix'] . '\_' . $lang . '\_' . $module_data . '\_/', $item['name']) and (preg_match('/^([0-9]+)$/', $name) or in_array($name, $array_table) or preg_match('/^bodyhtml\_([0-9]+)$/', $name))) {
        $sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $item['name'];
    }
}

$sql_create_module = $sql_drop_module;

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat (
  catid smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(250) NOT NULL,
  description text NOT NULL,
  weight smallint(5) unsigned NOT NULL DEFAULT '0',
  add_time int(11) unsigned NOT NULL DEFAULT '0',
  edit_time int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (catid)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows (
 id int(11) unsigned NOT NULL auto_increment,
 catid smallint(5) unsigned NOT NULL DEFAULT '0',
 post_id mediumint(8) unsigned NOT NULL DEFAULT '0',
 post_name varchar(255) NOT NULL DEFAULT '' COMMENT 'Họ tên người đăng tin',
 owner_name varchar(255) NOT NULL DEFAULT '' COMMENT 'Họ tên chủ nhà trọ',
 owner_address varchar(255) NOT NULL DEFAULT '' COMMENT 'Địa chỉ nhà trọ',
 owner_phone varchar(255) NOT NULL DEFAULT '' COMMENT 'Điện thoại chủ nhà trọ',
 owner_email varchar(255) NOT NULL DEFAULT '' COMMENT 'Email chủ nhà trọ',
 title varchar(250) NOT NULL DEFAULT '',
 alias varchar(250) NOT NULL DEFAULT '',
 area double unsigned NOT NULL DEFAULT '0' COMMENT 'Diện tích',
 guest_gender varchar(255) NOT NULL DEFAULT '' COMMENT 'Đối tượng cho thuê M/F',
 guest_number mediumint(8) NOT NULL DEFAULT '0' COMMENT 'Số lượng người ở',
 facility text NOT NULL COMMENT 'Cơ sở vật chất nhà trọ',
 rules text NOT NULL COMMENT 'Nội quy phòng trọ',
 price double unsigned NOT NULL DEFAULT '0',
 image varchar(255) NOT NULL DEFAULT '',
 addtime int(11) unsigned NOT NULL DEFAULT '0',
 edittime int(11) unsigned NOT NULL DEFAULT '0',
 status tinyint(4) NOT NULL DEFAULT '1' COMMENT '0: Dừng, 1: Hoạt động',
 istmp tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Chờ duyệt',
 PRIMARY KEY (id),
 KEY catid (catid),
 KEY post_id (post_id),
 KEY title (title),
 KEY status (status),
 KEY istmp (istmp),
 UNIQUE KEY alias (alias)
) ENGINE=MyISAM";
