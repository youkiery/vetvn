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

$action = $nv_Request->get_string('action', 'post/get', '');
$userinfo = getUserInfo();
if (empty($userinfo)) {
	header('location: /' . $module_name . '/login/');
	die();
}

if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
    case 'filter':
      $filter = $nv_Request->get_array('filter', 'post');

      if ($html = trading($filter)) {
        $result['status'] = 1;
        $result['html'] = $html;
      }
    break;
    case 'filter-pet':
      $filter = $nv_Request->get_array('filter', 'post');

      if ($html = filterPet($filter)) {
        $result['status'] = 1;
        $result['html'] = $html;
      }
    break;
    case 'cancel':
      $id = $nv_Request->get_int('id', 'post');
      $type = $nv_Request->get_int('type', 'post');
      $filter = $nv_Request->get_array('filter', 'post');

      if ($type == 1) {
        $sql = 'update `'. PREFIX .'_buy` set status = 2 where id = ' . $id;
      }
      else {
        $sql = 'update `'. PREFIX .'_trade` set status = 2 where id = ' . $id;
      }

      if ($db->query($sql) && $html = trading($filter)) {
        $result['status'] = 1;
        $result['html'] = $html;
      }
    break;
    case 'request':
      $id = $nv_Request->get_int('id', 'post');
      $type = $nv_Request->get_int('type', 'post');
      $filter = $nv_Request->get_array('filter', 'post');

      if ($type == 1) {
        $sql = 'update `'. PREFIX .'_buy` set status = '. $config['buy'] .' where id = ' . $id;
      }
      else {
        $sql = 'update `'. PREFIX .'_trade` set status = '. $config['trade'] .' where id = ' . $id;
      }

      if ($db->query($sql) && $html = trading($filter)) {
        $result['status'] = 1;
        $result['html'] = $html;
      }
    break;
    case 'breeding':
      $id = $nv_Request->get_string('id', 'post', '0');
      $filter = $nv_Request->get_array('filter', 'post');

      if (checkPetOwner($id, $userinfo['id'])) {
        $sql2 = 'delete from `'. PREFIX .'_trade` where status = 2 and type = 2 and petid = ' . $id;
        $sql = 'insert into `'. PREFIX .'_trade` (petid, type, status, time, note) values ('. $id .', 2, '. $config['trade'] .', '. time() .', "")';
        if ($db->query($sql) && $db->query($sql2) && $html = filterPet($filter)) {
          $result['status'] = 1;
          $result['html'] = $html;
        }
      }
    break;
    case 'sell':
      $id = $nv_Request->get_string('id', 'post', '0');
      $filter = $nv_Request->get_array('filter', 'post');

      if (checkPetOwner($id, $userinfo['id'])) {
        $sql2 = 'delete from `'. PREFIX .'_trade` where status = 2 and type = 1 and petid = ' . $id;
        $sql = 'insert into `'. PREFIX .'_trade` (petid, type, status, time, note) values ('. $id .', 1, '. $config['trade'] .', '. time() .', "")';
        if ($db->query($sql) && $db->query($sql2) && $html = filterPet($filter)) {
          $result['status'] = 1;
          $result['html'] = $html;
        }
      }
    break;
    case 'info':
      $pid = $nv_Request->get_string('pid', 'post', '0');

      $sql = 'select * from `'. PREFIX .'_info` where rid = ' . $pid . ' order by time desc';
      $query = $db->query($sql);
      $html = '';
      while ($row = $query->fetch()) {
        $html .= '
          <div>
          Tên khách: '. $row['fullname'] .' <br>
          Địa chỉ: '. $row['address'] .' <br>
          Số điện thoại: '. $row['mobile'] .' <br>
          Lúc: '. date('H:i d/m/Y', $row['time']) .'         
          </div>
          <hr>
        ';
      }

      $result['status'] = 1;
      $result['html'] = $html;
    break;
	}
  echo json_encode($result);
  die();
}

$xtpl = new XTemplate("main.tpl", PATH2);

// $xtpl->assign('content', trading());

// $sql = 'select * from `'. PREFIX .'_user` where view = 1';
// $query = $db->query($sql);

// while ($row = $query->fetch()) {
//   $xtpl->assign('userid', $row['id']);
//   $xtpl->assign('username', $row['fullname']);
//   $xtpl->parse('main.user');
// }

// $xtpl->assign('statistic', statistic());
$xtpl->assign('url', '/' . $module_name . '/' . $op . '/');
// $xtpl->assign('module_file', $module_file);
$xtpl->parse("main");
$contents = $xtpl->text("main");

include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_file ."/layout/footer.php");
