<?php

/**
 * @Project Petcoffee-tech
 * @Chistua (hchieuthua@gmail.com)
 * @Copyright (C) 2019
 * @Createdate 21-03-2019 13:15
 */

if (!defined('NV_ADMIN')) {
    die('Stop!!!');
}

$submenu['user'] = "Quản lý người dùng";
$submenu['pet'] = "Quản lý thú cưng";
$submenu['request'] = "Yêu cầu tiêm phòng";
$submenu['remind'] = "Danh sách gợi nhớ";
$submenu['disease'] = "Gợi nhớ loại tiêm phòng";
$submenu['intro'] = "Duyệt liên hệ";
$submenu['trade'] = "Duyệt bán, phôi";
$submenu['buy'] = "Duyệt mua";
$submenu['revenue'] = "Quản lý thu chi";
$submenu['manager'] = "Danh sách quản lý";
$submenu['review'] = "Danh sách góp ý";
$submenu['sendinfo'] = "Quản lý Giấy chứng nhận";
$submenu['ceti-print'] = "In giấy chứng nhận";
$submenu['config'] = "Cấu hình";
// $submenu['center'] = "Quản lý yêu cầu trang trại";

$allow_func = array('main', 'user', 'pet', 'request', 'remind', 'disease', 'intro', 'trade', 'buy', 'config', 'revenue', 'manager', 'review', 'ceti-print', 'ceti-detail', 'sendinfo'); 
