<?php

/**
 * @Project ACCOMMODATION 4.x
 * @Author PHAN TAN DUNG (phantandung92@gmail.com)
 * @Copyright (C) 2016 PHAN TAN DUNG. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sat, 11 Jun 2016 16:20:15 GMT
 */

if (!defined('NV_ADMIN'))
    die('Stop!!!');

$submenu['content'] = $lang_module['add'];
$submenu['cat'] = $lang_module['cat'];

$allow_func = array(
    'main',
    'content',
    'cat'
);
