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

$page_title = "Tổng kết điều trị";

$action = $nv_Request->get_string('action', 'post', '');
$userinfo = getUserInfo();

if (empty($userinfo)) {
	header('location: /' . $module_name . '/login/');
	die();
}

if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
		case 'signup':
      $x=1;
		break;
	}
	echo json_encode($result);
	die();
}

$xtpl = new XTemplate("summary.tpl", "modules/". $module_name ."/template");
require NV_ROOTDIR . '/modules/' . $module_file . '/modal/treat.php';
$disease = $nv_Request->get_string('disease', 'get');
$keyword = $nv_Request->get_string('keyword', 'get');

$xtpl->assign('module_file', $module_file);
$xtpl->assign('content', summaryByDisease($disease, $keyword));

$xtpl->parse("main");
$contents = $xtpl->text("main");
include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_name ."/layout/footer.php");
