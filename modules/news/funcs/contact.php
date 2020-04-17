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

$page_title = "Danh sách khách hàng";

$userinfo = getUserinfo();
if (empty($userinfo) || $userinfo['active'] == 0) {
	header('location: /'. $module_name .'/login/');
	die();
}

$filter = array(
  'page' => $nv_Request->get_int('page', 'get', 1),
  'limit' => $nv_Request->get_int('limit', 'get', 10),
  'keyword' => $nv_Request->get_string('keyword', 'get', '')
);

$action = $nv_Request->get_string('action', 'post', '');
if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
    case 'takeback':
      $id = $nv_Request->get_string('id', 'post');
      $user = $nv_Request->get_string('user', 'post');
      $filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `'. PREFIX .'_pet` set userid = '. $userinfo['id'] .' and type = 1 where id = ' . $id;

      if ($db->query($sql) && $html = contactContent($user, $filter)) {
        $result['status'] = 1;
        $result['notify'] = 'Đã chuyển về';
        $result['html'] = $html;
      }
    break;
    case 'view':
      $id = $nv_Request->get_string('id', 'post');
      $filter = $nv_Request->get_array('filter', 'post');

      if ($html = contactContent($id, $filter)) {
        $result['status'] = 1;
        $result['html'] = $html;
      }
    break;
    case 'filter':
      $filter = $nv_Request->get_array('filter', 'post');

      if (!empty($html = contactList($userinfo['id'], $filter))) {
        $result['status'] = 1;
        $result['html'] = $html;
      }
    break;
    case 'filter2':
      $id = $nv_Request->get_string('id', 'post');
      $filter = $nv_Request->get_array('filter', 'post');

      if (!empty($html = contactContent($id, $filter))) {
        $result['status'] = 1;
        $result['html'] = $html;
      }
    break;
    case 'get-info':
      $id = $nv_Request->get_string('id', 'post');

      $sql = 'select * from `'. PREFIX .'_contact` where id = ' . $id;
      $query = $db->query($sql);

      if ($row = $query->fetch()) {
        $result['status'] = 1;
        $result['data'] = $row;
      }
    break;
    case 'update-info':
      $id = $nv_Request->get_string('id', 'post');
      $data = $nv_Request->get_array('data', 'post');

      $data['fullname'] = $data['name'];
      unset($data['name']);

      $sql = 'update `'. PREFIX .'_contact` set '. sqlBuilder($data, BUILDER_EDIT) .' where id = ' . $id;
      if ($db->query($sql) && $html = contactContent()) {
        $result['status'] = 1;
        $result['notify'] = 'Đã lưu';
        $result['html'] = $html;
      }
    break;
	}
	echo json_encode($result);
	die();
}

$xtpl = new XTemplate("main.tpl", PATH2);

$xtpl->assign('keyword', $filter['keyword']);
$xtpl->assign('modal', contactModal());
$xtpl->assign('content', contactContent());

$xtpl->parse("main");
$contents = $xtpl->text("main");
include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_name ."/layout/footer.php");
