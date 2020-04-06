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

$page_title = "Quản lý trang trại";

$action = $nv_Request->get_string('action', 'post', '');

$userinfo = getUserinfo();
if (empty($userinfo) || $userinfo['active'] == 0) {
	header('location: /'. $module_name .'/login/');
	die();
}
else {
  if (empty($userinfo['center'])) {
    header('location: /'. $module_name .'/private');
  }
}

if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
    case 'done':
      $id = $nv_Request->get_int('id', 'post', 0);
			$filter = $nv_Request->get_array('filter', 'post');
			$tabber = $nv_Request->get_array('tabber', 'post');
      $result['notify'] = 'Có lỗi xảy ra';

      if (checkPetOwner($id, $userinfo['id'])) {
        $sql = 'update `'. PREFIX .'_pet` set sell = 1 where id = ' . $id;
        if ($db->query($sql)) {
          $result['status'] = 1;
          $result['html'] = userDogRowByList($userinfo['id'], $tabber, $filter);
          $result['notify'] = 'Đã đưa vào lưu trữ';
        }
      }
    break;
    case 'buy':
      $data = $nv_Request->get_array('data', 'post');

      $sql = 'insert into `'. PREFIX .'_buy` (userid, '. sqlBuilder($data, BUILDER_INSERT_NAME) .', status, time) values('. $userinfo['id'] .', '. sqlBuilder($data, BUILDER_INSERT_VALUE) . ', '. $config['trade'] .', '. time() .')';
      if ($db->query($sql)) {
        $result['status'] = 1;
        $result['notify'] = 'Đã thêm cần mua';
      }
    break;
    case 'get-sell':
      $id = $nv_Request->get_string('id', 'post', '0');
      if (!empty($html = getMarketContent($id))) {
        $result['status'] = 1;
        $result['html'] = $html;
      }
    break;
    case 'breeding':
      $id = $nv_Request->get_string('id', 'post', '0');

      if (checkPetOwner($id, $userinfo['id'])) {
        $sql = 'insert into `'. PREFIX .'_trade` (petid, type, status, time, note) values ('. $id .', 2, '. $config['trade'] .', '. time() .', "")';
        $sql2 = 'delete from `'. PREFIX .'_trade` where status = 2 and type = 2 and petid = ' . $id;
        if ($db->query($sql) && $db->query($sql2)) {
          $result['status'] = 1;
          $result['html'] = getMarketContent($id);
        }
      }
    break;
    case 'unbreeding':
      $id = $nv_Request->get_string('id', 'post', '0');

      if (checkPetOwner($id, $userinfo['id'])) {
        $sql = 'delete from `'. PREFIX .'_trade` where type = 2 and petid = ' . $id;
        if ($db->query($sql)) {
          $result['status'] = 1;
          $result['html'] = getMarketContent($id);
        }
      }
    break;
    case 'sell':
      $id = $nv_Request->get_string('id', 'post', '0');

      if (checkPetOwner($id, $userinfo['id'])) {
        $sql = 'insert into `'. PREFIX .'_trade` (petid, type, status, time, note) values ('. $id .', 1, '. $config['trade'] .', '. time() .', "")';
        $sql2 = 'delete from `'. PREFIX .'_trade` where status = 2 and type = 1 and petid = ' . $id;
        if ($db->query($sql) && $db->query($sql2)) {
          $result['status'] = 1;
          $result['html'] = getMarketContent($id);
        }
      }
    break;
    case 'unsell':
      $id = $nv_Request->get_string('id', 'post', '0');

      if (checkPetOwner($id, $userinfo['id'])) {
        $sql = 'delete from `'. PREFIX .'_trade` where type = 1 and petid = ' . $id;
        if ($db->query($sql)) {
          $result['status'] = 1;
          $result['html'] = getMarketContent($id);
        }
      }
    break;
    case 'change-mail':
      $mail = $nv_Request->get_string('mail', 'post', '');

      if (empty($mail)) {
        $result['error'] = 'Các trường không được trống';
      }
      else {
        $sql = 'update `'. PREFIX .'_user` set mail = "'. strtolower($mail) .'" where id = ' . $userinfo['id'];
        $query = $db->query($sql);

        if ($db->query($sql)) {
          $result['status'] = 1;
          $result['error'] = '';
          $result['notify'] = 'Đã lưu email';
        }
        else {
          $result['error'] = 'Có lỗi xảy ra';
        }
      }
    break;
    case 'change-pass':
      $npass = $nv_Request->get_string('npass', 'post', '');
      $opass = $nv_Request->get_string('opass', 'post', '');

      if (empty($npass) || empty($opass)) {
        $result['notify'] = 'Mật khẩu không được trống';
      }
      else {
        $sql = 'select * from `'. PREFIX .'_user` where password = "'. md5($opass) .'" and id = ' . $userinfo['id'];
        $query = $db->query($sql);

        if (empty($query->fetch())) {
          $result['notify'] = 'Mật khẩu sai';
        }
        else {
          $sql = 'update `'. PREFIX .'_user` set password = "'. md5($npass) .'" where id = ' . $userinfo['id'];
          if ($db->query($sql)) {
            $result['status'] = 1;
            $result['notify'] = 'Đã đổi mật khẩu';
          }
        }
      }
    break;
		case 'filter':
			$filter = $nv_Request->get_array('filter', 'post');
			$tabber = $nv_Request->get_array('tabber', 'post');
			
			if (count($filter) > 1) {
				// $result['html'] = userDogRowByList($userinfo['id'], $filter, $tabber);
				$result['html'] = userDogRowByList($userinfo['id'], $tabber, $filter);
				if ($result['html']) {
					$result['status'] = 1;
				}
        else {
          $result['notify'] = 'Có lỗi xảy ra';
        }
			}
		break;
    case 'get-request':
      $id = $nv_Request->get_string('id', 'post', 0);

      if (!empty($id)) {
        $result['status'] = 1;
        $result['html'] = requestDetail($id);
      }
      else {
        $result['notify'] = 'Có lỗi xảy ra';
      }
    break;
    case 'request':
      $id = $nv_Request->get_string('id', 'post', 0);
      $type = $nv_Request->get_string('type', 'post', 0);
      $value = $nv_Request->get_string('value', 'post', 0);

      if (!empty($id)) {
        $sql = 'select * from `'. PREFIX .'_request` where type = '. $type .' and value = '. $value .' and petid = ' . $id;
        $query = $db->query($sql);

        $request = $query->fetch();
        if (!empty($request) && count($request) > 0) {
          $sql = 'update `'. PREFIX .'_request` set time = ' . time() . ', status = 1 where id = ' . $request['id'];
          if ($db->query($sql)) {
            $result['status'] = 1;
            $result['html'] = requestDetail($id);
          }
        }
        else {
          $sql = 'insert into `'. PREFIX .'_request` (petid, type, value, status, time) values('. $id .', '. $type .', '. $value .', 1, '. time() .')';
          if ($db->query($sql)) {
            $result['status'] = 1;
            $result['html'] = requestDetail($id);
          }
        }
        if (empty($result['html'])) {
          $result['notify'] = 'Có lỗi xảy ra';
        }
      }
      else {
        $result['notify'] = 'Có lỗi xảy ra';
      }
    break;
    case 'cancel':
      $id = $nv_Request->get_string('id', 'post', 0);
      $type = $nv_Request->get_string('type', 'post', 0);
      $value = $nv_Request->get_string('value', 'post', 0);

      if (!empty($id)) {
        $sql = 'update `'. PREFIX .'_request` set time = ' . time() . ', status = 0 where type = '. $type .' and value = '. $value .' and petid = ' . $id;
        if ($db->query($sql)) {
          $result['status'] = 1;
          $result['html'] = requestDetail($id);
        }
        if (empty($result['html'])) {
          $result['notify'] = 'Có lỗi xảy ra';
        }
      }
      else {
        $result['notify'] = 'Có lỗi xảy ra';
      }
    break;
		case 'filteruser':
			$filter = $nv_Request->get_array('filter', 'post');
			
			if (count($filter) > 1) {
				$result['html'] = userRowList($filter);
				if ($result['html']) {
					$result['status'] = 1;
				}
        else {
          $result['notify'] = 'Có lỗi xảy ra';
        }
			}
		break;
    case 'insert-vaccine':
			$id = $nv_Request->get_string('id', 'post', 0);
			$data = $nv_Request->get_array('data', 'post');
      $result['notify'] = 'Có lỗi xảy ra';
      
      if (!empty($id) && count($data) > 0) {
        $data['time'] = totime($data['time']);
        $data['recall'] = totime($data['recall']);
        if (!empty($row = checkPrvVaccine($data))) {
          // 
          $sql = 'update `'. PREFIX .'_vaccine` set status =  1 where id = ' . $row['id'];
        }
        else {
          checkDisease($userinfo['id'], $data['val']);
          
          $sql = 'insert into `'. PREFIX .'_vaccine` (petid, time, recall, type, val, status) values ("'. $id .'", "'. $data['time'] .'", "'. $data['recall'] .'", "'. $data['type'] .'",  "'. $data['val'] .'", 0)';
          if ($db->query($sql)) {
            $result['status'] = 1;
            $result['notify'] = 'Đã thêm tiêm phòng';
          }
        }
      }
    break;
		case 'get':
			$id = $nv_Request->get_string('id', 'post', 0);
			
      $sql = 'select * from `'. PREFIX .'_lock` where petid = ' . $id;
      $query = $db->query($sql);
      if (empty($query->fetch())) {
        $sql = 'select * from `'. PREFIX .'_pet` where id = ' . $id;
        $query = $db->query($sql);

        if (!empty($row = $query->fetch())) {
          $result['data'] = array('name' => $row['name'], 'dob' => date('d/m/Y', $row['dateofbirth']), 'species' => $row['species'], 'breed' => $row['breed'], 'color' => $row['color'], 'microchip' => $row['microchip'], 'parentf' => $row['fid'], 'parentm' => $row['mid'], 'miear' => $row['miear'], 'origin' => $row['origin']);
          $result['more'] = array('breeder' => $row['breeder'],'sex' => intval($row['sex']), 'm' => getPetNameId($row['mid']), 'f' => getPetNameId($row['fid']));
          $result['image'] = $row['image'];
          $result['status'] = 1;
        }
        else {
          $result['notify'] = 'Có lỗi xảy ra';
        }
      }
      else {
        $result['notify'] = 'Thú cưng đã bị khóa, không thể chỉnh sửa';
      }
		break;
		case 'getuser':
			$id = $nv_Request->get_string('id', 'post');
			
			$sql = 'select * from `'. PREFIX .'_user` where id = ' . $id;
			$query = $db->query($sql);

			if (!empty($row = $query->fetch())) {
        $row['address'] = xdecrypt($row['address']);
        $row['mobile'] = xdecrypt($row['mobile']);
				$result['data'] = array('fullname' => $row['fullname'], 'mobile' => $row['mobile'], 'address' => $row['address'], 'username' => $row['username'], 'politic' => $row['politic']);
				$result['more'] = array('al1' => $row['a1'], 'al2' => $row['a2'], 'al3' => $row['a3']);
				$result['image'] = $row['image'];
				$result['status'] = 1;
			}
		break;
		case 'remove':
			$id = $nv_Request->get_string('id', 'post');
			$filter = $nv_Request->get_array('filter', 'post');
			$tabber = $nv_Request->get_array('tabber', 'post');
      $result['notify'] = 'Có lỗi xảy ra';

			$sql = 'delete from `'. PREFIX .'_pet` where id = ' . $id;
			if ($db->query($sql)) {
  			$result['html'] = userDogRowByList($userinfo['id'], $tabber, $filter);
				if ($result['html']) {
					$result['status'] = 1;
				}
			}
		break;
		case 'insert-owner':
			$data = $nv_Request->get_array('data', 'post');
      $result['notify'] = 'Có lỗi xảy ra';

			if (count($data) > 1 && !checkObj($data)) {
        $result['notify'] = 'Các trường không được bỏ trống';
      }
      else {
        // ???
        $sql = 'select * from `'. PREFIX .'_contact` where mobile = "'. $data['mobile'] .'"';
        $query = $db->query($sql);
        if (empty($query->fetch)) {
          $row['mobile'] = xencrypt($row['mobile']);
          $row['address'] = xencrypt($row['address']);

          $sql = 'insert into `'. PREFIX .'_contact` (fullname, address, mobile, politic, userid) values ("'. $data['fullname'] .'", "'. $data['address'] .'", "'. $data['mobile'] .'", "'. $data['politic'] .'", '. $userinfo['id'] .')';

          if ($db->query($sql)) {
            $result['status'] = 1;
            $result['id'] = $db->lastInsertId();
            $result['name'] = $data['fullname'];
            // $result['html'] = userDogRowByList($userinfo['id']);
          }
        }
			}
		break;
 		case 'transfer-owner':
			$petid = $nv_Request->get_string('petid', 'post', 0);
			$ownerid = $nv_Request->get_string('ownerid', 'post', 0);
			$type = $nv_Request->get_string('type', 'post', 2);
      $filter = $nv_Request->get_array('filter', 'post');
			$tabber = $nv_Request->get_array('tabber', 'post');
      $result['notify'] = 'Có lỗi xảy ra';

      $check = 0;

      if (empty($pet = getPetById($petid))) {
        $result['notify'] = 'Thú cưng không tồn tại';
      }
      else if (empty($owner = getOwnerById($ownerid, $type))) {
        $result['notify'] = 'Chủ nuôi không tồn tại';
      }
      else {
        if ($type == 1) {
          $sql2 = 'insert into `'. PREFIX .'_transfer_request` (userid, petid, time, note) values('. $ownerid .', '. $petid .', '. time() .', "")';
          if ($db->query($sql2)) {
            $check = 1;
          }
        }
        else {
          $type = 2;
          $sql = 'update `'. PREFIX .'_pet` set userid = ' . $ownerid . ', type = '. $type .' where id = ' . $petid;
          $sql2 = 'insert into `'. PREFIX .'_transfer` (fromid, targetid, petid, time, type) values('. $pet['userid'] .', '. $ownerid .', '. $petid .', '. time() .', '. $type .')';
          if ($db->query($sql) && $db->query($sql2)) {
            $check = 1;
          }
        }

        if ($check) {
          $result['status'] = 1;
          $result['notify'] = 'Đã chuyển nhượng';
    			$result['html'] = userDogRowByList($userinfo['id'], $tabber, $filter);
        }
			}
		break;
    case 'parent2':
			$keyword = $nv_Request->get_string('keyword', 'post', '');

			$sql = 'select * from ((select id, fullname, mobile, address, 1 as type from `'. PREFIX .'_user`) union (select id, fullname, mobile, address, 2 as type from `'. PREFIX .'_contact` where userid = '. $userinfo['id'] .')) as a';
			$query = $db->query($sql);

			$html = '';
      $count = 0;
      // checkMobile
			while (($row = $query->fetch()) && $count < 10) {
        if (checkMobile($row['mobile'], $keyword)) {
          $html .= '
          <div class="suggest_item" onclick="pickOwner(\''. $row['fullname'] .'\', '. $row['id'] .', '. $row['type'] .')">
            <p>
            '. $row['fullname'] .'
            </p>
          </div>
          ';
          $count ++;
        }
			}

			if (empty($html)) {
				$html = 'Không có kết quả trùng khớp';
			}

			$result['status'] = 1;
			$result['html'] = $html;
		break;

    case 'species':
			$keyword = $nv_Request->get_string('keyword', 'post', '');

			$sql = 'select * from `'. PREFIX .'_species` where (name like "%'. $keyword .'%" or fci like "%'. $keyword .'%" or origin like "%'. $keyword .'%") limit 10';
			$query = $db->query($sql);

			$html = '';
			while ($row = $query->fetch()) {
				$html .= '
				<div class="suggest_item" onclick="pickSpecies(\''. $row['name'] .'\', '. $row['id'] .')">
					'. $row['name'] .'
				</div>
				';
			}

			if (empty($html)) {
				$html = 'Không có kết quả trùng khớp';
			}

			$result['status'] = 1;
			$result['html'] = $html;
		break;

		case 'insertpet':
			$data = $nv_Request->get_array('data', 'post');
			$filter = $nv_Request->get_array('filter', 'post');
			$tabber = $nv_Request->get_array('tabber', 'post');
			$image = $nv_Request->get_string('image', 'post');
      $result['notify'] = 'Có lỗi xảy ra';

      if (empty($data['name']) || empty($data['species']) || empty($data['breed'])) {
        $result['notify'] = 'Các trường bắt buộc không được bỏ trống';
      }
      else if (checkPet($data['name'], $userinfo['id'])) {
        $result['notify'] = 'Tên thú cưng đã tồn tại';
      }
      else {
        // ???
        $sex = 1;
        if ($data['sex1'] == 'false') {
          $sex = 0;
        }
				$data['sex'] = $sex;
				$data['dateofbirth'] = totime($data['dob']);
        $data['fid'] = $data['parentf'];
				$data['mid'] = $data['parentm'];

        if ($data['breeder'] == 'true') {
          if ($data['sex']) {
            $data['breeder'] = 1;
          }
          else {
            $data['breeder'] = 0;
          }
        }
        else {
          $data['breeder'] = 2;
        }

        unset($data['sex0']);
        unset($data['sex1']);
				unset($data['dob']);
        unset($data['parentf']);        
				unset($data['parentm']);

        checkRemind($data['species'], 'species');
        checkRemind($data['breed'], 'breed');
        checkRemind($data['origin'], 'origin');

				$sql = 'insert into `'. PREFIX .'_pet` (userid, '. sqlBuilder($data, BUILDER_INSERT_NAME) .', active, image, type, time) values('. $userinfo['id'] .', '. sqlBuilder($data, BUILDER_INSERT_VALUE) .', '. $config['pet'] .', "'. $image .'", 1, '. time() .')';

				if ($db->query($sql)) {
					$result['status'] = 1;
					$result['notify'] = 'Đã thêm thú cưng';
					$result['remind'] = json_encode(getRemind());
					$result['html'] = userDogRowByList($userinfo['id'], $tabber, $filter);
				}
			}
		break;
		case 'insert-parent':
			$data = $nv_Request->get_array('data', 'post');
			$image = $nv_Request->get_string('image', 'post');
			$filter = $nv_Request->get_array('filter', 'post');
			$tabber = $nv_Request->get_array('tabber', 'post');
      $result['notify'] = 'Có lỗi xảy ra';

      if (empty($data['name']) || empty($data['species']) || empty($data['breed'])) {
        $result['notify'] = 'Các trường bắt buộc không được bỏ trống';
      }
      else if (checkPet($data['name'], $userinfo['id'])) {
        $result['notify'] = 'Tên thú cưng đã tồn tại';
      }
      else {
        $sex = 1;
        if ($data['sex1'] == 'false') {
          $sex = 0;
        }
				$data['dateofbirth'] = totime($data['dob']);
				$data['sex'] = $sex;
        $data['fid'] = $data['parentf'];
				$data['mid'] = $data['parentm'];

        if ($data['breeder'] == 'true') {
          if ($data['sex']) {
            $data['breeder'] = 1;
          }
          else {
            $data['breeder'] = 0;
          }
        }
        else {
          $data['breeder'] = 2;
        }

        unset($data['sex0']);
        unset($data['sex1']);
        unset($data['parentf']);        
				unset($data['parentm']);
				unset($data['dob']);

        checkRemind($data['species'], 'species');
        checkRemind($data['breed'], 'breed');

				$sql = 'insert into `'. PREFIX .'_pet` (userid, '. sqlBuilder($data, BUILDER_INSERT_NAME) .', active, image, type, origin, graph, time) values('. $userinfo['id'] .', '. sqlBuilder($data, BUILDER_INSERT_VALUE) .', '. $config['pet'] .', "'. $image .'", 1, "", "", '. time() .')';

				if ($db->query($sql)) {
					$result['status'] = 1;
					$result['name'] = $data['name'];
					$result['notify'] = 'Đã thêm thú cưng';
					$result['id'] = $db->lastInsertId();
					$result['remind'] = json_encode(getRemind());
					$result['html'] = userDogRowByList($userinfo['id'], $tabber, $filter);
				}
			}
		break;
		case 'editpet':
			$id = $nv_Request->get_string('id', 'post', '');
			$image = $nv_Request->get_string('image', 'post');
			$data = $nv_Request->get_array('data', 'post');
			$filter = $nv_Request->get_array('filter', 'post');
			$tabber = $nv_Request->get_array('tabber', 'post');
      $result['notify'] = 'Có lỗi xảy ra';

			if (count($data) > 1 && !empty($id)) {
				$data['dateofbirth'] = totime($data['dob']);
				$data['fid'] = $data['parentf'];
				$data['mid'] = $data['parentm'];
        $sex = 1;
        if ($data['sex1'] == 'false') {
          $sex = 0;
        }
				$data['sex'] = $sex;

        unset($data['sex0']);
        unset($data['sex1']);

				unset($data['dob']);
				unset($data['parentf']);        
				unset($data['parentm']);
        
        checkRemind($data['species'], 'species');
        checkRemind($data['breed'], 'breed');
        checkRemind($data['origin'], 'origin');

        if ($data['breeder'] == 'true') {
          if ($data['sex']) {
            $data['breeder'] = 1;
          }
          else {
            $data['breeder'] = 0;
          }
        }
        else {
          $data['breeder'] = 2;
        }
        $xtra = '';
        if (!empty($image)) {
          $pet = getPetById($id);
          $result['image'] = $pet['image'];
          $xtra = ',image = "'. $image .'"';
        }

        $sql = 'update `' . PREFIX . '_pet` set ' . sqlBuilder($data, BUILDER_EDIT) . ' '. $xtra .' where id = ' . $id;

				if ($db->query($sql)) {
					$result['status'] = 1;
					$result['notify'] = 'Đã chỉnh sửa thú cưng';
					$result['remind'] = json_encode(getRemind());
					$result['html'] = userDogRowByList($userinfo['id'], $tabber, $filter);
				}
			}
		break;
		case 'edituser':
			$id = $nv_Request->get_string('id', 'post', '');
			$data = $nv_Request->get_array('data', 'post');
			$image = $nv_Request->get_string('image', 'post');

			if (count($data) > 1 && !empty($id)) {
        $data['mobile'] = xencrypt($data['mobile']);
        $data['address'] = xencrypt($data['address']);
        $xtra = '';
        if (!empty($image)) {
          $owner = getOwnerById($id);
          $result['image'] = $owner['image'];
          $xtra = ',image = "'. $image .'"';
        }

				$sql = 'update `'. PREFIX .'_user` set '. sqlBuilder($data, BUILDER_EDIT) . ' '. $xtra .' where id = ' . $id;
				if ($db->query($sql)) {
					$result['status'] = 1;
					$result['notify'] = 'Đã chỉnh sửa thông tin';
				}
			}
		break;
    case 'new-request':
      $name = $nv_Request->get_string('name', 'post');
      $id = $nv_Request->get_string('id', 'post', '');
      $result['notify'] = 'Có lỗi xảy ra';

      if (!empty($name) && !empty($id)) {
        $type = checkRemind($name, 'request');

        $sql = 'insert into `'. PREFIX .'_request` (petid, type, status, time, value) values ("'. $id .'", 2, 1, '. time() .', '. $type .')';

        if ($db->query($sql)) {
          $result['status'] = 1;
          $result['notify'] = 'Đã thêm yêu cầu';
          $result['html'] = requestDetail($id);
        }
      }
    break;
		case 'private':
			if (!empty($userinfo)) {
				$sql = 'update `'. PREFIX .'_user` set center = 0 where id = ' . $userinfo['id'];

				if ($db->query($sql)) {
					$result['status'] = 1;
				}
			}
		break;
		case 'parent':
			$keyword = $nv_Request->get_string('keyword', 'post', '');

			$sql = 'select * from ((select id, fullname, mobile, address, 1 as type from `'. PREFIX .'_user`) union (select id, fullname, mobile, address, 2 as type from `'. PREFIX .'_contact` where userid = '. $userinfo['id'] .')) as c';
			$query = $db->query($sql);

			$html = '';
      $count = 0;
      // checkMobile
			while (($row = $query->fetch()) && $count < 20) {
        if (checkMobile($row['mobile'], $keyword)) {
          $sql2 = 'select * from `'. PREFIX .'_pet` where active = 1 and userid = ' . $row['id'];
          if ($userinfo['id'] == $row['id']) {
            $sql2 = 'select * from `'. PREFIX .'_pet` where userid = ' . $row['id'];
          }
          $query2 = $db->query($sql2);

          while ($row2 = $query2->fetch()) {
            $html .= '
            <div class="suggest_item2" onclick="pickParent(this, \''. $row2['name'] .'\', '. $row2['id'] .')">
              <p> '. $row['fullname'] .' </p>
              <p> '. $row2['name'] .' </p>
            </div>';
            $count ++;
          }
        }
			}

			if (empty($html)) {
				$html = 'Không có kết quả trùng khớp';
			}

			$result['status'] = 1;
			$result['html'] = $html;
		break;
    case 'insert-disease-suggest':
			$disease = $nv_Request->get_string('disease', 'post');
      $result['notify'] = 'Có lỗi xảy ra';

      $sql = 'select * from `'. PREFIX .'_disease_suggest` where disease = "'. $disease .'"';
      $query = $db->query($sql);

      if (empty($disease)) {
        $result['notify'] = 'Các trường không được để trống';
      }
      else if (!empty($row = $query->fetch())) {
        if ($row['active'] = 1) {
          $result['notify'] = 'Đã có trong danh sách';
        }
        else {
          $sql = 'update into `'. PREFIX .'_disease_suggest` set rate = rate + 1';
        }
      }
      else {
        $sql = 'insert into `'. PREFIX .'_disease_suggest` (userid, disease, active, rate) values('. $userinfo['id'] .', "'. $disease .'", 0, 1)';
      }

      if (!empty($sql) && $db->query($sql)) {
        $result['status'] = 1;
        $result['notify'] = 'Đã thêm danh sách';
        $result['html'] = parseVaccineType($userinfo['id']);
      }
		break;
	}
	echo json_encode($result);
	die();
}

$id = $nv_Request->get_int('id', 'get', 0);
$global = array();
$global['login'] = 0;

$xtpl = new XTemplate("center.tpl", "modules/". $module_name ."/template");

$position = json_decode('[{"name":"Đắk Lắk","district":["Buôn Hồ","Buôn Ma Thuột","Buôn Đôn","Cư Kuin","Cư Mgar","Ea HLeo","Ea Kar","Ea Súp","Krông Ana","Krông Buk","Krông Bông","Krông Năng","Krông Pắc","Lăk","MĐrăk"]},{"name":"An Giang","district":["An Phú","Châu Phú","Châu Thành","Châu Đốc","Chợ Mới","Long Xuyên","Phú Tân","Thoại Sơn","Tri Tôn","Tân Châu","Tịnh Biên"]},{"name":"Bà Rịa Vũng Tàu","district":["Bà Rịa","Châu Đức","Côn Đảo","Long Điền","Tân Thành","Vũng Tàu","Xuyên Mộc","Đất Đỏ"]},{"name":"Bình Dương","district":["Bàu Bàng","Bến Cát","Dĩ An","Dầu Tiếng","Phú Giáo","Thuận An","Thủ Dầu Một","Tân Uyên"]},{"name":"Bình Phước","district":["Bình Long","Bù Gia Mập","Bù Đăng","Bù Đốp","Chơn Thành","Hớn Quản","Lộc Ninh","Phú Riềng","Phước Long","Đồng Phú","Đồng Xoài"]},{"name":"Bình Thuận  ","district":["Bắc Bình","Hàm Thuận Bắc","Hàm Thuận Nam","Hàm Tân","La Gi","Phan Thiết","Tuy Phong","Tánh Linh","Đảo Phú Quý","Đức Linh"]},{"name":"Bình Định","district":["An Lão","An Nhơn","Hoài Nhơn","Hoài Ân","Phù Cát","Phù Mỹ","Quy Nhơn","Tuy Phước","Tây Sơn","Vân Canh","Vĩnh Thạnh"]},{"name":"Bạc Liêu","district":["Bạc Liêu","Giá Rai","Hòa Bình","Hồng Dân","Phước Long","Vĩnh Lợi","Đông Hải"]},{"name":"Bắc Giang","district":["Bắc Giang","Hiệp Hòa","Lạng Giang","Lục Nam","Lục Ngạn","Sơn Động","Tân Yên","Việt Yên","Yên Dũng","Yên Thế"]},{"name":"Bắc Kạn","district":["Ba Bể","Bạch Thông","Bắc Kạn","Chợ Mới","Chợ Đồn","Na Rì","Ngân Sơn","Pác Nặm"]},{"name":"Bắc Ninh","district":["Bắc Ninh","Gia Bình","Lương Tài","Quế Võ","Thuận Thành","Tiên Du","Từ Sơn","Yên Phong"]},{"name":"Bến Tre","district":["Ba Tri","Bình Đại","Bến Tre","Châu Thành","Chợ Lách","Giồng Trôm","Mỏ Cày Bắc","Mỏ Cày Nam","Thạnh Phú"]},{"name":"Cao Bằng","district":["Bảo Lâm","Bảo Lạc","Cao Bằng","Hà Quảng","Hòa An","Hạ Lang","Nguyên Bình","Phục Hòa","Quảng Uyên","Thông Nông","Thạch An","Trà Lĩnh","Trùng Khánh"]},{"name":"Cà Mau","district":["Cà Mau","Cái Nước","Ngọc Hiển","Năm Căn","Phú Tân","Thới Bình","Trần Văn Thời","U Minh","Đầm Dơi"]},{"name":"Cần Thơ","district":[" Thới Lai","Bình Thủy","Cái Răng","Cờ Đỏ","Ninh Kiều","Phong Điền","Thốt Nốt","Vĩnh Thạnh","Ô Môn"]},{"name":"Gia Lai","district":["AYun Pa","An Khê","Chư Păh","Chư Pưh","Chư Sê","ChưPRông","Ia Grai","Ia Pa","KBang","Krông Pa","Kông Chro","Mang Yang","Phú Thiện","Plei Ku","Đăk Pơ","Đăk Đoa","Đức Cơ"]},{"name":"Hà Nội","district":["Ba Vì","Ba Đình","Bắc Từ Liêm","Chương Mỹ","Cầu Giấy","Gia Lâm","Hai Bà Trưng","Hoài Đức","Hoàn Kiếm","Hoàng Mai","Hà Đông","Long Biên","Mê Linh","Mỹ Đức","Nam Từ Liêm","Phú Xuyên","Phúc Thọ","Quốc Oai","Sóc Sơn","Sơn Tây","Thanh Oai","Thanh Trì","Thanh Xuân","Thường Tín","Thạch Thất","Tây Hồ","Đan Phượng","Đông Anh","Đống Đa","Ứng Hòa"]},{"name":"Hà Giang","district":["Bắc Mê","Bắc Quang","Hoàng Su Phì","Hà Giang","Mèo Vạc","Quang Bình","Quản Bạ","Vị Xuyên","Xín Mần","Yên Minh","Đồng Văn"]},{"name":"Hà Nam","district":["Bình Lục","Duy Tiên","Kim Bảng","Lý Nhân","Phủ Lý","Thanh Liêm"]},{"name":"Hà Tĩnh","district":["Can Lộc","Cẩm Xuyên","Hà Tĩnh","Hương Khê","Hương Sơn","Hồng Lĩnh","Kỳ Anh","Lộc Hà","Nghi Xuân","Thạch Hà","Vũ Quang","Đức Thọ"]},{"name":"Hòa Bình","district":["Cao Phong","Hòa Bình","Kim Bôi","Kỳ Sơn","Lương Sơn","Lạc Sơn","Lạc Thủy","Mai Châu","Tân Lạc","Yên Thủy","Đà Bắc"]},{"name":"Hưng Yên","district":["Hưng Yên","Khoái Châu","Kim Động","Mỹ Hào","Phù Cừ","Tiên Lữ","Văn Giang","Văn Lâm","Yên Mỹ","Ân Thi"]},{"name":"Hải Dương","district":["Bình Giang","Chí Linh","Cẩm Giàng","Gia Lộc","Hải Dương","Kim Thành","Kinh Môn","Nam Sách","Ninh Giang","Thanh Hà","Thanh Miện","Tứ Kỳ"]},{"name":"Hải Phòng","district":["An Dương","An Lão","Bạch Long Vĩ","Cát Hải","Dương Kinh","Hải An","Hồng Bàng","Kiến An","Kiến Thụy","Lê Chân","Ngô Quyền","Thủy Nguyên","Tiên Lãng","Vĩnh Bảo","Đồ Sơn"]},{"name":"Hậu Giang","district":["Châu Thành","Châu Thành A","Long Mỹ","Ngã Bảy","Phụng Hiệp","Vị Thanh","Vị Thủy"]},{"name":"Hồ Chí Minh","district":["Bình Chánh","Bình Thạnh","Bình Tân","Cần Giờ","Củ Chi","Gò Vấp","Hóc Môn","Nhà Bè","Phú Nhuận","Quận 1","Quận 10","Quận 11","Quận 12","Quận 2","Quận 3","Quận 4","Quận 5","Quận 6","Quận 7","Quận 8","Quận 9","Thủ Đức","Tân Bình","Tân Phú"]},{"name":"Khánh Hòa","district":["Cam Lâm","Cam Ranh","Diên Khánh","Khánh Sơn","Khánh Vĩnh","Nha Trang","Ninh Hòa","Trường Sa","Vạn Ninh"]},{"name":"Kiên Giang","district":["An Biên","An Minh","Châu Thành","Giang Thành","Giồng Riềng","Gò Quao","Hà Tiên","Hòn Đất","Kiên Hải","Kiên Lương","Phú Quốc","Rạch Giá","Tân Hiệp","U minh Thượng","Vĩnh Thuận"]},{"name":"Kon Tum","district":["Ia HDrai","Kon Plông","Kon Rẫy","KonTum","Ngọc Hồi","Sa Thầy","Tu Mơ Rông","Đăk Glei","Đăk Hà","Đăk Tô"]},{"name":"Lai Châu","district":["Lai Châu","Mường Tè","Nậm Nhùn","Phong Thổ","Sìn Hồ","Tam Đường","Than Uyên","Tân Uyên"]},{"name":"Long An","district":["Bến Lức","Châu Thành","Cần Giuộc","Cần Đước","Kiến Tường","Mộc Hóa","Thạnh Hóa","Thủ Thừa","Tân An","Tân Hưng","Tân Thạnh","Tân Trụ","Vĩnh Hưng","Đức Huệ","Đức Hòa"]},{"name":"Lào Cai","district":["Bát Xát","Bảo Thắng","Bảo Yên","Bắc Hà","Lào Cai","Mường Khương","Sa Pa","Văn Bàn","Xi Ma Cai"]},{"name":"Lâm Đồng","district":["Bảo Lâm","Bảo Lộc","Cát Tiên","Di Linh","Lâm Hà","Lạc Dương","Đam Rông","Đà Lạt","Đơn Dương","Đạ Huoai","Đạ Tẻh","Đức Trọng"]},{"name":"Lạng Sơn","district":["Bình Gia","Bắc Sơn","Cao Lộc","Chi Lăng","Hữu Lũng","Lạng Sơn","Lộc Bình","Tràng Định","Văn Lãng","Văn Quan","Đình Lập"]},{"name":"Nam Định","district":["Giao Thủy","Hải Hậu","Mỹ Lộc","Nam Trực","Nam Định","Nghĩa Hưng","Trực Ninh","Vụ Bản","Xuân Trường","Ý Yên"]},{"name":"Nghệ An","district":["Anh Sơn","Con Cuông","Cửa Lò","Diễn Châu","Hoàng Mai","Hưng Nguyên","Kỳ Sơn","Nam Đàn","Nghi Lộc","Nghĩa Đàn","Quế Phong","Quỳ Châu","Quỳ Hợp","Quỳnh Lưu","Thanh Chương","Thái Hòa","Tân Kỳ","Tương Dương","Vinh","Yên Thành","Đô Lương"]},{"name":"Ninh Bình","district":["Gia Viễn","Hoa Lư","Kim Sơn","Nho Quan","Ninh Bình","Tam Điệp","Yên Khánh","Yên Mô"]},{"name":"Ninh Thuận","district":["Bác Ái","Ninh Hải","Ninh Phước","Ninh Sơn","Phan Rang - Tháp Chàm","Thuận Bắc","Thuận Nam"]},{"name":"Phú Thọ","district":["Cẩm Khê","Hạ Hòa","Lâm Thao","Phù Ninh","Phú Thọ","Tam Nông","Thanh Ba","Thanh Sơn","Thanh Thủy","Tân Sơn","Việt Trì","Yên Lập","Đoan Hùng"]},{"name":"Phú Yên","district":["Phú Hòa","Sông Cầu","Sông Hinh","Sơn Hòa","Tuy An","Tuy Hòa","Tây Hòa","Đông Hòa","Đồng Xuân"]},{"name":"Quảng Bình","district":["Ba Đồn","Bố Trạch","Lệ Thủy","Minh Hóa","Quảng Ninh","Quảng Trạch","Tuyên Hóa","Đồng Hới"]},{"name":"Quảng Nam","district":["Bắc Trà My","Duy Xuyên","Hiệp Đức","Hội An","Nam Giang","Nam Trà My","Nông Sơn","Núi Thành","Phú Ninh","Phước Sơn","Quế Sơn","Tam Kỳ","Thăng Bình","Tiên Phước","Tây Giang","Điện Bàn","Đông Giang","Đại Lộc"]},{"name":"Quảng Ngãi","district":["Ba Tơ","Bình Sơn","Lý Sơn","Minh Long","Mộ Đức","Nghĩa Hành","Quảng Ngãi","Sơn Hà","Sơn Tây","Sơn Tịnh","Trà Bồng","Tây Trà","Tư Nghĩa","Đức Phổ"]},{"name":"Quảng Ninh","district":["Ba Chẽ","Bình Liêu","Cô Tô","Cẩm Phả","Hoành Bồ","Hạ Long","Hải Hà","Móng Cái","Quảng Yên","Tiên Yên","Uông Bí","Vân Đồn","Đông Triều","Đầm Hà"]},{"name":"Quảng Trị","district":["Cam Lộ","Gio Linh","Hướng Hóa","Hải Lăng","Quảng Trị","Triệu Phong","Vĩnh Linh","Đa Krông","Đông Hà","Đảo Cồn cỏ"]},{"name":"Sóc Trăng","district":["Châu Thành","Cù Lao Dung","Kế Sách","Long Phú","Mỹ Tú","Mỹ Xuyên","Ngã Năm","Sóc Trăng","Thạnh Trị","Trần Đề","Vĩnh Châu"]},{"name":"Sơn La","district":["Bắc Yên","Mai Sơn","Mường La","Mộc Châu","Phù Yên","Quỳnh Nhai","Sông Mã","Sơn La","Sốp Cộp","Thuận Châu","Vân Hồ","Yên Châu"]},{"name":"Thanh Hóa","district":["Bá Thước","Bỉm Sơn","Cẩm Thủy","Hoằng Hóa","Hà Trung","Hậu Lộc","Lang Chánh","Mường Lát","Nga Sơn","Ngọc Lặc","Như Thanh","Như Xuân","Nông Cống","Quan Hóa","Quan Sơn","Quảng Xương","Sầm Sơn","Thanh Hóa","Thiệu Hóa","Thường Xuân","Thạch Thành","Thọ Xuân","Triệu Sơn","Tĩnh Gia","Vĩnh Lộc","Yên Định","Đông Sơn"]},{"name":"Thái Bình","district":["Hưng Hà","Kiến Xương","Quỳnh Phụ","Thái Bình","Thái Thuỵ","Tiền Hải","Vũ Thư","Đông Hưng"]},{"name":"Thái Nguyên","district":["Phú Bình","Phú Lương","Phổ Yên","Sông Công","Thái Nguyên","Võ Nhai","Đại Từ","Định Hóa","Đồng Hỷ"]},{"name":"Thừa Thiên Huế","district":["A Lưới","Huế","Hương Thủy","Hương Trà","Nam Đông","Phong Điền","Phú Lộc","Phú Vang","Quảng Điền"]},{"name":"Tiền Giang","district":["Cai Lậy","Châu Thành","Chợ Gạo","Cái Bè","Gò Công","Gò Công Tây","Gò Công Đông","Huyện Cai Lậy","Mỹ Tho","Tân Phú Đông","Tân Phước"]},{"name":"Trà Vinh","district":["Châu Thành","Càng Long","Cầu Kè","Cầu Ngang","Duyên Hải","Tiểu Cần","Trà Cú","Trà Vinh"]},{"name":"Tuyên Quang","district":["Chiêm Hóa","Hàm Yên","Lâm Bình","Na Hang","Sơn Dương","Tuyên Quang","Yên Sơn"]},{"name":"Tây Ninh","district":["Bến Cầu","Châu Thành","Dương Minh Châu","Gò Dầu","Hòa Thành","Trảng Bàng","Tân Biên","Tân Châu","Tây Ninh"]},{"name":"Vĩnh Long","district":["Bình Minh","Bình Tân","Long Hồ","Mang Thít","Tam Bình","Trà Ôn","Vĩnh Long","Vũng Liêm"]},{"name":"Vĩnh Phúc","district":["Bình Xuyên","Lập Thạch","Phúc Yên","Sông Lô","Tam Dương","Tam Đảo","Vĩnh Tường","Vĩnh Yên","Yên Lạc"]},{"name":"Yên Bái","district":["Lục Yên","Mù Cang Chải","Nghĩa Lộ","Trạm Tấu","Trấn Yên","Văn Chấn","Văn Yên","Yên Bái","Yên Bình"]},{"name":"Điện Biên","district":["Mường Chà","Mường Lay","Mường Nhé","Mường Ảng","Nậm Pồ","Tuần Giáo","Tủa Chùa","Điện Biên","Điện Biên Phủ","Điện Biên Đông"]},{"name":"Đà Nẵng","district":["Cẩm Lệ","Hoàng Sa","Hòa Vang","Hải Châu","Liên Chiểu","Ngũ Hành Sơn","Sơn Trà","Thanh Khê"]},{"name":"Đắk Nông","district":["Cư Jút","Dăk GLong","Dăk Mil","Dăk RLấp","Dăk Song","Gia Nghĩa","Krông Nô","Tuy Đức"]},{"name":"Đồng Nai","district":["Biên Hòa","Cẩm Mỹ","Long Khánh","Long Thành","Nhơn Trạch","Thống Nhất","Trảng Bom","Tân Phú","Vĩnh Cửu","Xuân Lộc","Định Quán"]},{"name":"Đồng Tháp","district":["Cao Lãnh","Châu Thành","Huyện Cao Lãnh","Huyện Hồng Ngự","Hồng Ngự","Lai Vung","Lấp Vò","Sa Đéc","Tam Nông","Thanh Bình","Tháp Mười","Tân Hồng"]}]');

foreach ($position as $l1i => $l1) {
	$xtpl->assign('l1name', $l1->{'name'});
	$xtpl->assign('l1id', $l1i);
	$xtpl->parse('main.l1');
  foreach ($l1->{'district'} as $l2i => $l2) {
    $xtpl->assign('l2name', $l2);
    $xtpl->assign('l2id', $l2i);
  	$xtpl->parse('main.l2.l2c');
  }

  if ($l1i == '0') {
    $xtpl->assign('active', 'block');
  }
  else {
    $xtpl->assign('active', 'none');
  }
  $xtpl->parse('main.l2');
}

$xtpl->assign('position', json_encode($position));

$userinfo['mobile'] = xdecrypt($userinfo['mobile']);
$userinfo['address'] = xdecrypt($userinfo['address']);

$tabber = array('0');
if (!$userinfo['center']) {
  $xtpl->assign('tabber', '0, 1, 2');
  $tabber = array('0', '1', '2');
}
else {
  $xtpl->assign('tabber', '0');
}
$xtpl->assign('userid', $userinfo['id']);
$xtpl->assign('fullname', $userinfo['fullname']);
$xtpl->assign('mobile', $userinfo['mobile']);
$xtpl->assign('address', $userinfo['address']);
$xtpl->assign('image', $userinfo['image']);
$xtpl->assign('remind', json_encode(getRemind()));
$xtpl->assign('list', userDogRowByList($userinfo['id'], $tabber));
$xtpl->assign('v', parseVaccineType($userinfo['id']));

$xtpl->assign('today', date('d/m/Y', time()));
$xtpl->assign('recall', date('d/m/Y', time() + 60 * 60 * 24 * 21));
$xtpl->assign('transfer_count', '');
$xtpl->assign('intro_count', '');

$sql = 'select count(*) as count from ((select a.* from `'. PREFIX .'_info` a inner join `'. PREFIX .'_pet` b on a.rid = b.id where (a.type = 1 or a.type = 3) and b.userid = '. $userinfo['id'] . ' and a.status = 1) union (select a.* from `'. PREFIX .'_info` a inner join `'. PREFIX .'_buy` b on a.rid = b.id where a.type = 2 and b.userid = '. $userinfo['id'] . ' and a.status = 1)) as c';
$query = $db->query($sql);
if (!empty($row = $query->fetch()) && $row['count'] > 0) {
  $xtpl->assign('intro_count', '('. $row['count'] .')');
}

$sql = 'select count(*) as count from `'. PREFIX .'_transfer_request` a inner join `'. PREFIX .'_pet` b on a.petid = b.id inner join `'. PREFIX .'_pet` c on b.userid = c.id where a.userid = ' . $userinfo['id'];
$query = $db->query($sql);
if (!empty($row = $query->fetch()) && $row['count'] > 0) {
  $xtpl->assign('transfer_count', '('. $row['count'] .')');
}

$petid_list = selectPetidOfOwner($userinfo['id']);
if (!empty($petid_list)) {
  $sql = 'select count(*) as count from `'. PREFIX .'_trade` where status = 2 and petid in ('. $petid_list .')';
  $query = $db->query($sql);
  if (!empty($row = $query->fetch()) && $row['count'] > 0) {
    $xtpl->assign('sendback_count', '('. $row['count'] .')');
  }
}

$xtpl->assign('origin', '/' . $module_name . '/' . $op . '/');
$xtpl->assign('module_file', $module_file);
$xtpl->assign('module_name', $module_name);
$xtpl->assign('mail', $userinfo['mail']);

$sql = 'select * from `'. PREFIX .'_user` where manager = 1 and id = ' . $userinfo['id'];
$query = $db->query($sql);
if (!empty($query->fetch())) {
  $xtpl->parse('main.xter');
}

$xtpl->parse("main");
$contents = $xtpl->text("main");
include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_file ."/layout/footer.php");
