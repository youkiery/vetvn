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
define('BUILDER_EDIT', 2);

$page_title = "Quản lý thu chi";

$filter = array(
  'page' => $nv_Request->get_int('page', 'get', 1),
  'limit' => $nv_Request->get_int('limit', 'get', 12),
  'type' => $nv_Request->get_int('type', 'get', 1)
);

$action = $nv_Request->get_string('action', 'post', '');

if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
    case 'statistic':
      $filter = $nv_Request->get_array('filter', 'post');

      $html = statisticContent($filter);
      if (!empty($html)) {
        $result['status'] = 1;
        $result['html'] = $html;
      }
		break;
	}
	echo json_encode($result);
	die();
}

$xtpl = new XTemplate("main.tpl", PATH2);

if ($filter['type'] == 1) {
  $xtpl->assign('content', statisticCollect());
}
else {
  $xtpl->assign('content', statisticPay());
}

$sql = 'select * from `'. PREFIX .'_user` where view = 1';
$query = $db->query($sql);

while ($row = $query->fetch()) {
  $xtpl->assign('userid', $row['id']);
  $xtpl->assign('username', $row['fullname']);
  $xtpl->parse('main.user');
}

$xtpl->assign('type' . $filter['type'], 'selected');
$xtpl->assign('statistic_content', statisticContent());
$xtpl->assign('module_file', $module_file);
$xtpl->parse("main");
$contents = $xtpl->text("main");

include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_file ."/layout/footer.php");
