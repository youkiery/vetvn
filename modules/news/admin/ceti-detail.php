<?php

/**
 * @Project Petcoffee-tech
 * @Chistua (hchieuthua@gmail.com)
 * @Copyright (C) 2019
 * @Createdate 21-03-2019 13:15
 */

if (!defined('NV_IS_ADMIN_FORM')) {
	die('Stop!!!');
}

define('BUILDER_INSERT_NAME', 0);
define('BUILDER_INSERT_VALUE', 1);
define('BUILDER_EDIT', 2);

$page_title = "In giấy chứng nhận";
$action = $nv_Request->get_string('action', 'post', '');
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

$xtpl = new XTemplate("ceti-detail.tpl", NV_ROOTDIR . "/modules/". $module_name ."/template/admin/block");
$id = $nv_Request->get_int('id', 'get', 0);

$query = $db->query('select * from `'. PREFIX .'_pet` where id = ' . $id);
if (empty($row = $query->fetch())) {
  $xtpl->parse("main.A");
}
else {
  $query = $db->query('select * from `'. PREFIX .'_print` where rid = ' . $id);
  $print = $query->fetch();
  $owner = getOwnerById($row['userid']);
  // var_dump($owner);die();
  $xtpl->assign('id', $id);
  $xtpl->assign('regno', '');
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

  if (!empty($print)) {
    $xtpl->assign('regno', $print['regno']);
    $xtpl->assign('color', $print['color']);
    $xtpl->assign('coat', $print['coat']);
    $xtpl->assign('breeder', $print['breeder']);
    $xtpl->assign('issue', date('d/m/Y', $print['issue']));
  }
  $xtpl->parse("main.B");
}

$xtpl->parse("main");
$contents = $xtpl->text("main");
include (NV_ROOTDIR . "/includes/header.php");
include (NV_ROOTDIR . "/modules/". $module_file ."/layout/prefix.php");
echo nv_admin_theme($contents);
include ("modules/". $module_name ."/layout/footer.php");
