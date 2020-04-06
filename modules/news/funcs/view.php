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

$action = $nv_Request->get_string('action', 'post', '');
if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
		case 'send-contact':
      $id = $nv_Request->get_string('id', 'post', '0');
      $data = $nv_Request->get_array('data', 'post');
      $filter = $nv_Request->get_array('filter', 'post');

      $sql = 'insert into `'. PREFIX .'_info` ('. sqlBuilder($data, BUILDER_INSERT_NAME) .', rid, type, status, time) values ('. sqlBuilder($data, BUILDER_INSERT_VALUE) .', '. $id .', 1, '. $config['info'] .', '. time() .')';

      if ($db->query($sql)) {
        $result['status'] = 1;
        $result['notify'] = 'Đã gửi thông tin cho người đăng';
      }
		break;
	}
	echo json_encode($result);
	die();
}

$id = $nv_Request->get_int('id', 'get', 0);

$xtpl = new XTemplate("view.tpl", "modules/". $module_name ."/template");

$sql = 'select * from `'. PREFIX .'_pet` where id = ' . $id . ' order by id desc';
$query = $db->query($sql);

$page_title = "Thông tin thú cưng";
if (!empty($row = $query->fetch())) {
  $page_title = $row['name'] . " - Thông tin thú cưng";
  $owner = getOwnerById($row['userid'], $row['type']);
	$xtpl->assign('graph', $row['graph']);
	$xtpl->assign('name', $row['name']);
	$xtpl->assign('dob', date('d/m/Y', $row['dateofbirth']));
	$xtpl->assign('breed', $row['breed']);
	$xtpl->assign('species', $row['species']);
  $xtpl->assign('sex', $sex_array[$row['sex']]);
	$xtpl->assign('color', $row['color']);
	$xtpl->assign('microchip', $row['microchip']);
	$xtpl->assign('owner', $owner['fullname']);
	$xtpl->assign('politic', $owner['politic']);
	$xtpl->assign('image', $row['image']);

  $relation = getPetRelation($id);
  // $bay = array('grand' => array(), 'parent' => array(), 'sibling' => array(), 'child' => array());

  // echo json_encode($relation); die();
  
  foreach ($relation['grand'] as $lv1) {
    foreach ($lv1 as $lv2) {
      $xtpl->assign($lv2['ns'], parseLink($lv2));
      $xtpl->assign('ig' . $lv2['ns'], parseInfo($lv2));
    }
    foreach ($lv1['m'] as $lv2) {
      $xtpl->assign($lv2['ns'], parseLink($lv2));
      $xtpl->assign('ig' . $lv2['ns'], parseInfo($lv2));
    }
  }

  $xtpl->assign('mama', parseLink($relation['parent']['f']));
  $xtpl->assign('igmama', parseInfo($relation['parent']['f']));
  $xtpl->assign('papa', parseLink($relation['parent']['m']));
  $xtpl->assign('igpapa', parseInfo($relation['parent']['m']));

  // foreach ($relation['parent'] as $lv1) {
  //   $xtpl->assign($lv1['ns'], parseLink($lv1));
  //   $xtpl->assign('ig' . $lv1['ns'], parseInfo($lv1));
  // }
  // if ($row = $relation['grand']['e']['m']) {
  //   $xtpl->assign('egrandpa', '<a href="/index.php?nv=biograph&op=detail&id=' . $row['id'] . '">' . $row['name'] . '</a>');
  //   $xtpl->assign('efgrandpa', parseInfo($row));
  // }
  // if ($row = $relation['grand']['i']['f']) {
  //   $xtpl->assign('igrandma', '<a href="/index.php?nv=biograph&op=detail&id=' . $row['id'] . '">' . $row['name'] . '</a>');
  //   $xtpl->assign('ifgrandma', parseInfo($row));
  // }
  // if ($row = $relation['grand']['i']['m']) {
  //   $xtpl->assign('igrandpa', '<a href="/index.php?nv=biograph&op=detail&id=' . $row['id'] . '">' . $row['name'] . '</a>');
  //   $xtpl->assign('ifgrandpa', parseInfo($row));
  // }
  // if ($row = $relation['parent']['m']) {
  //   $xtpl->assign('mama', '<a href="/index.php?nv=biograph&op=detail&id=' . $row['id'] . '">' . $row['name'] . '</a>');
  //   $xtpl->assign('ifmama', parseInfo($row));
  // }
  // if ($row = $relation['parent']['f']) {
  //   $xtpl->assign('papa', '<a href="/index.php?nv=biograph&op=detail&id=' . $row['id'] . '">' . $row['name'] . '</a>');
  //   $xtpl->assign('ifpapa', parseInfo($row));
  // }

  // if (count($child = $relation['child'])) {
  //   $html = '';    
  //   foreach ($child as $row) {
  //     $html = '<a href="/index.php?nv=biograph&op=detail&id=' . $row['id'] . '">' . $row['name'] . '</a>';
  //   }
  //   $xtpl->assign('child', $html);
  // }


  // if ($relation['grand']) {    
  //   foreach ($relation['grand'] as $row) {
  //     foreach ($row as $row2) {
  //       if ($row2) {
  //         $bay['grand'][] = '<a href="/index.php?nv=biograph&op=detail&id=' . $row['name'] . '">' . $row['name'] . '</a>';
  //       }
  //     }
  //   }
  // }
  // if ($relation['parent']) {    
  //   foreach ($relation['parent'] as $row) {
  //     if ($row) {
  //       $bay['parent'][] = '<a href="/index.php?nv=biograph&op=detail&id=' . $row['name'] . '">' . $row['name'] . '</a>';
  //     }
  //   }
  // }
  // if ($relation['sibling']) {    
  //   foreach ($relation['sibling'] as $row) {
  //     if ($row['id']) {
  //       $bay['parent'][] = '<a href="/index.php?nv=biograph&op=detail&id=' . $row['name'] . '">' . $row['name'] . '</a>';
  //     }
  //   }
  // }
  // if ($relation['child']) {    
  //   foreach ($relation['child'] as $row) {
  //     if ($row['id']) {
  //       $bay['child'][] = '<a href="/index.php?nv=biograph&op=detail&id=' . $row['name'] . '">' . $row['name'] . '</a>';
  //     }
  //   }
  // }

  $xtpl->assign('grand', implode('<br>', $bay['grand']));
  $xtpl->assign('parent', implode('<br>', $bay['parent']));
  $xtpl->assign('sibling', implode('<br>', $bay['sibling']));
  $xtpl->assign('child', implode('<br>', $bay['child']));

	$xtpl->parse("main.detail");
}
else {
	$xtpl->parse("main.error");
}

if (!empty($userinfo = getUserinfo())) {
  $userinfo['address'] = xdecrypt($userinfo['address']);
  $userinfo['mobile'] = xdecrypt($userinfo['mobile']);
  $xtpl->assign('fullname', $userinfo['fullname']);
  $xtpl->assign('address', $userinfo['address']);
  $xtpl->assign('mobile', $userinfo['mobile']);
}

$xtpl->assign('url', '/' . $module_name . '/' . $op . '/');
$xtpl->assign('module_file', $module_file);
$xtpl->assign('id', $id);
$xtpl->parse("main");

$contents = $xtpl->text("main");
include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_file ."/layout/footer.php");

