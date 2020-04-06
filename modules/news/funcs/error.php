<?php

/**
 * @Project Petcoffee-tech
 * @Chistua (hchieuthua@gmail.com)
 * @Copyright (C) 2019
 * @Createdate 21-03-2019 13:15
 */

if (!defined('NV_IS_FORM')) {
	die('Stop!!!');
}

$page_title = "Thông báo";

$error = $nv_Request->get_string('error', 'get', '0');

switch ($error) {
  case '0':
    $html = 'Người dùng khôn';    
  break;
  default:
    $html = 'Trang không tồn tại';    
}

$contents = $html;
include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_name ."/layout/footer.php");
