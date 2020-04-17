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

define('BUILDER_INSERT', 0);
define('BUILDER_EDIT', 1);

$page_title = "Đăng nhập";

$xtpl = new XTemplate("main.tpl", PATH2);
$userinfo = getUserInfo();

if (!empty($userinfo)) {
	if ($userinfo['active'] == 1) {
		if ($userinfo['center']) {
			header('location: /'. $module_name .'/center');
		}
		header('location: /'. $module_name .'/private');
	}
	else $xtpl->assign('error', 'Tài khoản chưa có quyền truy cập');
}

$username = $nv_Request->get_string('username', 'post', '');
$password = $nv_Request->get_string('password', 'post', '');
$xtpl->assign('module_file', $module_file);
$xtpl->assign('module_name', $module_name);

if (!empty($username)) {
	$xtpl->assign('username', $username);
	$username = strtolower($username);
	if (!checkUsername($username)) {
		$xtpl->assign('error', 'Tài khoản không tồn tại');
	}
	else if (empty($checker = checkLogin($username, $password))) {
		$xtpl->assign('error', 'Sai mật khẩu');
	}
	else {
		if ($checker['active'] == 0) $xtpl->assign('error', 'Tài khoản chưa có quyền truy cập');
		else {
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;
			header("Refresh:0");
		}
	}
}

$xtpl->parse("main");
$contents = $xtpl->text("main");
include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_file ."/layout/footer.php");
