<?php

/**
 * @Project ACCOMMODATION 4.x
 * @Author PHAN TAN DUNG (phantandung92@gmail.com)
 * @Copyright (C) 2016 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sat, 11 Jun 2016 16:20:15 GMT
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE'))
    die('Stop!!!');

$module_version = array(
    'name' => 'Accommodation',
    'modfuncs' => 'main,content,rss,detail',
    'is_sysmod' => 0,
    'virtual' => 1,
    'version' => '4.2.00',
    'date' => 'Monday, May 14, 2018 1:25:11 AM GMT+07:00',
    'author' => 'PHAN TAN DUNG (phantandung92@gmail.com)',
    'note' => '',
    'uploads_dir' => array($module_upload)
);
