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

$page_title = "Đăng ký";

$action = $nv_Request->get_string('action', 'post', '');
$userinfo = getUserInfo();
if (!empty($userinfo)) {
  if ($userinfo['center']) {
    header('location: /'. $module_name .'/center');
  }
  header('location: /'. $module_name .'/private');
}

if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
		case 'signup':
			$data = $nv_Request->get_array('data', 'post');

			$data['username'] = mb_strtolower($data['username']);
      if (checkUsername($data['username'])) {
        $result['error'] = 'Tài khoản đã tồn tại';
      }
      else if (checkLogin($data['username'], $data['password'])) {
        $result['error'] = 'Mật khẩu sai';
      }
      else {
        if (!checkMobileExist($data['phone'])) {
          $data['phone'] = xencrypt($data['phone']);
          $data['address'] = xencrypt($data['address']);
          $sql = 'insert into `'. PREFIX .'_user` (username, password, fullname, mobile, politic, address, active, image, a1, a2, a3, time) values("'. $data['username'] .'", "'. md5($data['password']) .'", "'. $data['fullname'] .'", "'. $data['phone'] .'", "'. $data['politic'] .'", "'. $data['address'] .'", '. $config['user'] .', "", "'. $data['al1'] .'", "'. $data['al2'] .'", "'. $data['al3'] .'", '. time() .')';
          if ($db->query($sql)) {
            $_SESSION['username']	 = $data['username'];
            $_SESSION['password'] = $data['password'];
            $result['status'] = 1;
          }
        }
        else {
          $result['error'] = 'Số điện thoại đã được sử dụng';
        }
      }
		break;
	}
	echo json_encode($result);
	die();
}

$id = $nv_Request->get_int('id', 'get', 0);
$global = array();
$global['login'] = 0;

include_once(LAYOUT . '/position.php');
// var_dump($position);
// die();

$xtpl = new XTemplate("signup.tpl", PATH2);
$xtpl->assign('module_file', $module_file);

foreach ($position as $l1i => $l1) {
  // echo json_encode($l1);
	$xtpl->assign('l1name', $l1->{'name'});
	$xtpl->assign('l1id', $l1i);
	$xtpl->parse('main.l1');
  foreach ($l1->{'district'} as $l2i => $l2) {
    $xtpl->assign('l2name', $l2);
    $xtpl->assign('l2id', $l2i);
  	$xtpl->parse('main.l2.l2c');
  }

  $xtpl->assign('active', '');
  if ($l1i != 0) {
    $xtpl->assign('active', 'style="display: none;"');
  }
  $xtpl->parse('main.l2');
}
$xtpl->assign('position', json_encode($position));

if (count($userinfo) > 0) {
	// logged
	$xtpl->assign('fullname', $userinfo['fullname']);
	$xtpl->assign('mobile', $userinfo['mobile']);
	$xtpl->assign('address', $userinfo['address']);
	$xtpl->assign('image', $userinfo['image']);
	$xtpl->assign('list', userDogRowByList($userinfo['id']));

	if (!empty($user_info) && !empty($user_info['userid']) && (in_array('1', $user_info['in_groups']) || in_array('2', $user_info['in_groups']))) {
		$xtpl->assign('userlist', userRowList());
	
		$xtpl->parse('main.log.user');
		$xtpl->parse('main.log.mod');
		$xtpl->parse('main.log.mod2');
	}

	$xtpl->parse('main.log');
}
else {
	$xtpl->parse('main.nolog');
}

$xtpl->parse("main");
$contents = $xtpl->text("main");
include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_name ."/layout/footer.php");
