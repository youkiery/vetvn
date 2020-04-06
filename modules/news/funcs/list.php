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

$action = $nv_Request->get_string('action', 'post', '');
if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
    case 'filter':
      $data = $nv_Request->get_array('data', 'post');

      $result['status'] = 1;
      $result['html'] = mainPetList($data['keyword'], $data['page']);
    break;
	}
	echo json_encode($result);
	die();
}

$xtpl = new XTemplate("list.tpl", "modules/". $module_name ."/template");

$keyword = $nv_Request->get_string('keyword', 'get', '');

$page_title = "Danh sách thú cưng";
if (!empty($keyword)) {
  $page_title = $keyword . " - Tìm kiếm thú cưng";
}

$xtpl->assign('keyword', $keyword);
$xtpl->assign('content', mainPetList($keyword));
$xtpl->assign('module_file', $module_file);

$xtpl->parse("main");
$contents = $xtpl->text("main");
include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_file ."/layout/footer.php");

