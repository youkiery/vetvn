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

define('BUILDER_INSERT_NAME', 0);
define('BUILDER_INSERT_VALUE', 1);
define('BUILDER_EDIT', 2);

$userinfo = getUserInfo();
if (empty($userinfo)) {
	header('location: /' . $module_name . '/login/');
	die();
}

$action = $nv_Request->get_string('action', 'post', '');

if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
    case 'dismiss':
			$id = $nv_Request->get_string('id', 'post');
			$filter = $nv_Request->get_array('filter', 'post');

      if (!empty($id)) {
        $sql = 'delete from `'. PREFIX .'_trade` where id = ' . $id;
        if ($db->query($sql) && !empty($html = sendbackList($userinfo['id'], $filter))) {
          $result['status'] = 1;
          $result['html'] = $html;
        }
      } 
    break;
    case 'filter':
			$filter = $nv_Request->get_array('filter', 'post');

      if (!empty($html = sendbackList($userinfo['id'], $filter))) {
        $result['status'] = 1;
        $result['html'] = $html;
      } 
    break;
	}
	echo json_encode($result);
	die();
}

$xtpl = new XTemplate("sendback.tpl", "modules/". $module_name ."/template");

$page_title = "Danh sách trả về";

$xtpl->assign('content', sendbackList($userinfo['id']));
$xtpl->parse("main");
$contents = $xtpl->text("main");
include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_file ."/layout/footer.php");

