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

$filter = array(
  'page' => $nv_Request->get_int('page', 'get', 1),
  'limit' => $nv_Request->get_int('limit', 'get', 12),
  'keyword' => $nv_Request->get_string('keyword', 'get', '')
);

$action = $nv_Request->get_string('action', 'post', '');
if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
    case 'filter':
      $data = $nv_Request->get_array('data', 'post');

      $result['status'] = 1;
      $result['html'] = listContent();
    break;
	}
	echo json_encode($result);
	die();
}

$xtpl = new XTemplate("main.tpl", PATH2);

$page_title = "Danh sách thú cưng";
if (!empty($filter['keyword'])) {
  $page_title = $filter['keyword'] . " - Tìm kiếm thú cưng";
}

$xtpl->assign('keyword', $filter['keyword']);
$xtpl->assign('content', listContent());
$xtpl->assign('module_file', $module_file);

$xtpl->parse("main");
$contents = $xtpl->text("main");
include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_file ."/layout/footer.php");

