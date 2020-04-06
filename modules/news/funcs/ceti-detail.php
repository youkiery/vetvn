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
  header('location: /news/login');
}

$page_title = "In giấy chứng nhận";
if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
    case 'save':
      $id = $nv_Request->get_int('id', 'post', 0);
      $data = $nv_Request->get_array('data', 'post');

      $query = $db->query('select * from `'. PREFIX .'_print` where rid = ' . $id);
      $subdata = array('regno' => $data['regno'], 'coat' => $data['coat'], 'color' => $data['color'], 'breeder' => $data['breeder'], 'issue' => totime($data['issue']));
      if (!empty($query->fetch())) {
        // update
        $sql = 'update `'. PREFIX .'_print` set ' . sqlBuilder($subdata, BUILDER_EDIT) . ' where rid = ' . $id;
      }
      else {
        // insert
        $sql = 'insert into `'. PREFIX .'_print` (rid, '. sqlBuilder($subdata, BUILDER_INSERT_NAME) .') values("'. $id .'", '. sqlBuilder($subdata, BUILDER_INSERT_VALUE) .')';
      }

      if ($db->query($sql)) {
        $result['status'] = 1;
      }
    break;
	}
	echo json_encode($result);
	die();
}

$xtpl = new XTemplate("ceti-detail.tpl", "modules/". $module_name ."/template/block");
$id = $nv_Request->get_int('id', 'get', 0);

$query = $db->query('select * from `'. PREFIX .'_pet` where id = ' . $id);
if (empty($row = $query->fetch())) {
  $xtpl->parse("main.A");
}
else {
  $query = $db->query('select * from `'. PREFIX .'_print` order by id desc limit 1');
  if (empty($regno = $query->fetch())) {
    $regno = array('regno' => '40070000001');
  }
  else {
    $regno['regno'] += 1;
  }
  $query = $db->query('select * from `'. PREFIX .'_print` where rid = ' . $id);
  $print = $query->fetch();
  $owner = getOwnerById($row['userid']);
  $xtpl->assign('id', $id);
  $xtpl->assign('regno', $regno['regno']);
  $xtpl->assign('micro', $row['microchip']);
  $xtpl->assign('tatto', $row['miear']);
  $xtpl->assign('name', $row['name']);
  $xtpl->assign('species', $row['species']);
  $xtpl->assign('sex_' . $row['sex'], 'checked');
  $xtpl->assign('dob', date('d/m/Y', $row['dateofbirth']));
  $xtpl->assign('coat', '');
  $xtpl->assign('color', '');
  $xtpl->assign('breeder', $row['owner']);
  $xtpl->assign('owner', $owner['fullname']);
  $xtpl->assign('issue', date('d/m/Y'));
  $parent = getAllParent($row);
  foreach ($parent as $l1) {
    foreach ($l1 as $n2 => $l2) {
      if (!empty($l2)) {
        foreach ($l2 as $n3 => $l3) {
          $xtpl->assign($n2 . $n3, $l3['name']);
        }
      }
    }
  }
  // if 

  if (!empty($print)) {
    $xtpl->assign('regno', $print['regno']);
    $xtpl->assign('color', $print['color']);
    $xtpl->assign('coat', $print['coat']);
    $xtpl->assign('breeder', $print['breeder']);
    $xtpl->assign('issue', date('d/m/Y', $print['issue']));
  }
  $result['status'] = 1;
  $result['data'] = $data;
  $xtpl->parse("main.B");
}

$xtpl->parse("main");
$contents = $xtpl->text("main");
include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_name ."/layout/footer.php");
