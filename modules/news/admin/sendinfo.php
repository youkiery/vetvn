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

$page_title = "Quản lý yêu cầu";

$action = $nv_Request->get_string('action', 'post', '');
$filter = array(
	'page' => $nv_Request->get_int('page', 'get', 1),
	'limit' => $nv_Request->get_int('limit', 'get', 10),
	'keyword' => $nv_Request->get_string('keyword', 'get', ''),
	'status' => $nv_Request->get_int('status', 'get', 0)
);

if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
		case 'edit-info':
			$id = $nv_Request->get_int('id', 'post');
			$data = $nv_Request->get_array('data', 'post');

			// check các remind
			$data['species'] = checkRemind($data['species'], 'species2');
			$data['color'] = checkRemind($data['color'], 'color');
			$data['type'] = checkRemind($data['type'], 'type');
			$data['birthtime'] = totime($data['birthtime']);

			// cập nhật bảng
			$sql = 'update `'. PREFIX .'_sendinfo` set name = "'. $data['name'] .'", sex = "'. $data['sex'] .'", birthtime = "'. $data['birthtime'] .'", species = "'. $data['species'] .'", color = "'. $data['color'] .'", type = "'. $data['type'] .'", breeder = "'. $data['breeder'] .'", owner = "'. $data['owner'] .'", father = '. $data['father'] .', mother = '. $data['mother'] .' where id = ' . $id;
			if ($db->query($sql)) {
				// thông báo
				$result['status'] = 1;
				$result['html'] = sendinfoContent();
			}
		break;
		case 'get-pet':
			$id = $nv_Request->get_int('id', 'post', '');
			$type = $nv_Request->get_string('type', 'post', '');
			$keyword = $nv_Request->get_string('keyword', 'post', '');

			$sql = 'select * from `'. PREFIX .'_sendinfo` where id = ' . $id;
			$query = $db->query($sql);
			$info = $query->fetch();

			$sql = 'select * from `'. PREFIX .'_pet` where name like "%'. $keyword .'%" and userid = '. $info['userid'] .' and sex = '. $type .' order by name limit 20';
			$query = $db->query($sql);
			$xtpl = new XTemplate('pet.tpl', PATH2);
			$xtpl->assign('type', $type);
			
			$check = true;
			while ($pet = $query->fetch()) {
				$check = false;
				$xtpl->assign('id', $pet['id']);
				$xtpl->assign('name', $pet['name']);
				$xtpl->parse('main.row');
			}
			if ($check) $xtpl->parse('main.no');
			$xtpl->parse('main');
      $result['status'] = 1;
			$result['html'] = $xtpl->text();
		break;
		case 'get-remind':
			$keyword = $nv_Request->get_string('keyword', 'post', '');
			$type = $nv_Request->get_string('type', 'post', '');

			$sql = 'select * from `'. PREFIX .'_remind` where type = "'. $type .'" and visible = 1 and name like "%'. $keyword .'%" order by rate limit 20';
			$query = $db->query($sql);
			$xtpl = new XTemplate('remind.tpl', PATH2);
			$xtpl->assign('type', $type);

			$check = true;
			while ($remind = $query->fetch()) {
				$check = false;
				$xtpl->assign('name', $remind['name']);
				$xtpl->parse('main.row');
			}
			if ($check) $xtpl->parse('main.no');
			$xtpl->parse('main');
      $result['status'] = 1;
			$result['html'] = $xtpl->text();
		break;
		case 'get-info':
			$id = $nv_Request->get_int('id', 'post');

			$sql = 'select * from `'. PREFIX .'_sendinfo` where id = ' . $id;
			$query = $db->query($sql);
			$info = $query->fetch();

			$father = getPetById($info['father'])['name'];
			$mother = getPetById($info['mother'])['name'];

			$info['fathername'] = $father;
			$info['mothername'] = $mother;
			// đang sửa chỗ này nè má xxx
			$info['breeder'] = getContactId(intval($info['breeder']), $info['userid']);
			$info['owner'] = getContactId(intval($info['owner']), $info['userid']);
			$info['birthtime'] = date('d/m/Y', $info['birthtime']);
			$info['species'] = getRemindId($info['species'])['name'];
			$info['color'] = getRemindId($info['color'])['name'];
			$info['type'] = getRemindId($info['type'])['name'];
			$info['image'] = explode(',', $info['image']);
			$result['status'] = 1;
			$result['data'] = $info;
		break;
		case 'get-user':
			$id = $nv_Request->get_int('id', 'post');
			$keyword = $nv_Request->get_string('keyword', 'post', '');
			$type = $nv_Request->get_string('type', 'post', '');

			$sql = 'select * from `'. PREFIX .'_sendinfo` where id = ' . $id;
			$query = $db->query($sql);
			$info = $query->fetch();

			$xtpl = new XTemplate("user.tpl", PATH2);
			$sql = 'select * from `'. PREFIX .'_contact` where (fullname like "%'. $keyword .'%" or address like "%'. $keyword .'%" or mobile like "%'. $keyword .'%") and userid = ' . $info['userid'];
			$query = $db->query($sql);
			
			$check = true;
			while ($row = $query->fetch()) {
				$check = false;
				$xtpl->assign('name', $type);			
				$xtpl->assign('id', $row['id']);			
				$xtpl->assign('fullname', $row['fullname']);					
				$xtpl->assign('mobile', $row['mobile']);					
				$xtpl->parse('main.row');
			}
			if ($check) $xtpl->parse('main.no');
			$xtpl->parse('main');
			$result['status'] = 1;
			$result['html'] = $xtpl->text();
		break;
		case 'insert-user':
			$data = $nv_Request->get_array('data', 'post');

			$sql = 'select * from `'. PREFIX .'_contact` where mobile = "'. $data['mobile'] .'"';
			$query = $db->query($sql);
			if (empty($query->fetch)) {
				$sql = 'insert into `'. PREFIX .'_contact` (fullname, address, mobile, politic, userid) values ("'. $data['name'] .'", "'. $data['address'] .'", "'. $data['mobile'] .'", "'. $data['politic'] .'", '. $userinfo['id'] .')';

				if ($db->query($sql)) {
					$result['status'] = 1;
					$result['id'] = $db->lastInsertId();
				}
			}
		break;
		case 'get-preview':
			$id = $nv_Request->get_int('id', 'post');

			$sql = 'select * from `'. PREFIX .'_sendinfo` where id = '. $id;
			$query = $db->query($sql);
			$info = $query->fetch();

			$breeder = getContactId(intval($info['breeder']), $info['userid']);
			$owner = getContactId(intval($info['owner']), $info['userid']);

			$image = explode(',', $info['image']);
			$info['image'] = $image[0];
			$info['breeder'] = $breeder['fullname'] . ', ' . $breeder['address'];
			$info['owner'] = $owner['fullname'] . ', ' . $owner['address'];
			$info['sex'] = $sex_data[$info['sex']];
			$info['birthtime'] = date('d/m/Y', $info['birthtime']);
			$info['species'] = getRemindId($info['species'])['name'];
			$info['color'] = getRemindId($info['color'])['name'];
			$info['type'] = getRemindId($info['type'])['name'];

			$result['status'] = 1;
			$result['data'] = $info;
		break;
		case 'done':
			$id = $nv_Request->get_int('id', 'post', 0);
			$sign = $nv_Request->get_int('sign', 'post', 0);
			$micro = $nv_Request->get_string('micro', 'post');

			$regno = checkRegno();
			// kích hoạt thú cưng
			$sql = 'update `'. PREFIX .'_sendinfo` set active = 1, active2 = 2, micro = "'. $micro .'", regno = "'. ($regno++) .'", time = "'. time() .'" where id = ' . $id;
			// xác nhận cấp giấy thú cưng
			$sql2 = 'insert into `'. PREFIX .'_certify` (petid, signid, price, time) values('. $id .', '. $sign .', 0, '. time() .')';
			if ($db->query($sql) && $db->query($sql2)) {
				setRegno($regno);
				$result['status'] = 1;
				$result['html'] = sendinfoContent();
			}
		break;
		case 'remove-info':
			$id = $nv_Request->get_int('id', 'post');

			// đang sửa chỗ này nè má
			$sql = 'delete from `'. PREFIX .'_sendinfo` where id = ' . $id;
			// $sql2 = 'delete from `'. PREFIX .'_certify` where id = ' . $id;
			if ($db->query($sql)) {
				$result['status'] = 1;
				$result['html'] = sendinfoContent();
			}
		break;
		case 'insert-sign':
			$name = $nv_Request->get_string('name', 'post', '');

			$sql = 'select * from `'. PREFIX .'_sign` where name = "'. $name .'"';
			$query = $db->query($sql);
			
			if (!empty($name)) {
				if (empty($row = $query->fetch())) {
					$sql = 'insert into `'. PREFIX .'_sign` (name, time) values ("'. $name .'", '. time() .')';
				}
				else {
					$sql = 'update `'. PREFIX .'_sign` set active = 1, time = "'. time() .'" where id = ' . $row['id'];
				}
				if ($db->query($sql)) {
					$result['status'] = 1;
					$result['html'] = signContent();
				}
			}	
			
		break;
		case 'update-sign':
			$id = $nv_Request->get_int('id', 'post');
			$name = $nv_Request->get_string('name', 'post', '');

			$sql = 'select * from `'. PREFIX .'_sign` where name = "'. $name .'" and id <> ' . $id;
			$query = $db->query($sql);
			
			if (!empty($name) && empty($query->fetch())) {
				$sql = 'update `'. PREFIX .'_sign` set name = "'. $name .'" where id = ' . $id;
				if ($db->query($sql)) {
					$result['status'] = 1;
					$result['html'] = signContent();
				}
			}
		break;
		case 'remove-sign':
			$id = $nv_Request->get_int('id', 'post');

			$sql = 'update `'. PREFIX .'_sign` set active = 0 where id = ' . $id;
			if ($db->query($sql)) {
				$result['status'] = 1;
				$result['html'] = signContent();
			}
		break;
	}
	echo json_encode($result);
	die();
}
$xtpl = new XTemplate("main.tpl", PATH2);

$xtpl->assign('keyword', $filter['keyword']);
$xtpl->assign('status' . $filter['status'], 'selected');
$xtpl->assign('content', sendinfoContent());
$xtpl->assign('modal', sendinfoModal());
$xtpl->parse("main");
$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
include (NV_ROOTDIR . "/modules/". $module_file ."/layout/prefix.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");