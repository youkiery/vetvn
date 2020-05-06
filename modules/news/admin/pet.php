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

$page_title = "Quản lý thú cưng";

$action = $nv_Request->get_string('action', 'post', '');
$filter = array(
  'page' => $nv_Request->get_int('page', 'get', 1),
  'limit' => $nv_Request->get_int('limit', 'get', 10),
  'status' => $nv_Request->get_int('status', 'get', 0),
  'username' => $nv_Request->get_string('username', 'get', ''),
  'owner' => $nv_Request->get_string('owner', 'get', ''),
  'mobile' => $nv_Request->get_string('mobile', 'get', ''),
  'name' => $nv_Request->get_string('name', 'get', ''),
  'species' => $nv_Request->get_string('species', 'get', ''),
  'mc' => $nv_Request->get_string('mc', 'get', '')
);

if (!empty($action)) {
  $result = array('status' => 0);
  switch ($action) {
    case 'lock':
      $id = $nv_Request->get_string('id', 'post', '0');
      $type = $nv_Request->get_string('type', 'post', '0');
			

      if ($type == '1') {
        $sql = 'insert into `'. PREFIX .'_lock` (petid) values('. $id .')';
      }
      else {
        $sql = 'delete from `'. PREFIX .'_lock` where petid = ' . $id;
      }

      if ($db->query($sql)) {
        $result['html'] = petContent();
				if ($result['html']) {
					$result['status'] = 1;
				}
      }
    break;
    case 'push':
      $id = $nv_Request->get_string('id', 'post', '0');

      $sql = 'update `'. PREFIX .'_sendinfo` set time = '. time() .' where id = ' . $id;
      if ($db->query($sql)) {
        $result['status'] = 1;
        $result['notify'] = 'Đã đưa lên đầu trang';
      }
    break;
    case 'remove-user-list':
      $list = $nv_Request->get_string('list', 'post', '');
			

      $sql = 'delete from `'. PREFIX .'_pet` where id in ('. $list .')' ;
      if ($db->query($sql)) {
        $result['html'] = petContent();
				if ($result['html']) {
					$result['notify'] = 'Đã xóa';
					$result['status'] = 1;
				}
      }
    break;
    case 'active-user-list':
      $list = $nv_Request->get_string('list', 'post', '');
			

      $sql = 'update `'. PREFIX .'_pet` set active = 1 where id in ('. $list .')' ;
      if ($db->query($sql)) {
        $result['html'] = petContent();
				if ($result['html']) {
					$result['notify'] = 'Đã lưu';
					$result['status'] = 1;
				}
      }
    break;
    case 'deactive-user-list':
      $list = $nv_Request->get_string('list', 'post', '');
			

      $sql = 'update `'. PREFIX .'_pet` set active = 0 where id in ('. $list .')' ;
      if ($db->query($sql)) {
        $result['html'] = petContent();
				if ($result['html']) {
					$result['notify'] = 'Đã lưu';
					$result['status'] = 1;
				}
      }
    break;
    case 'insert-parent':
      $data = $nv_Request->get_array('data', 'post');
      $userid = $nv_Request->get_string('userid', 'post');
      $type = $nv_Request->get_string('type', 'post');
      $image = $nv_Request->get_string('image', 'post');
      
      $tabber = $nv_Request->get_array('tabber', 'post');
      $result['notify'] = 'Có lỗi xảy ra';

      // if (empty(getOwnerById($userid, $type))) {
      //   $result['notify'] = 'Chưa chọn chủ';
      // }
      // else
      if (empty($data['name']) || empty($data['species']) || empty($data['breed'])) {
        $result['notify'] = 'Các trường bắt buộc không được bỏ trống';
      } else if (checkPet($data['name'], $userid)) {
        $result['notify'] = 'Tên thú cưng đã tồn tại';
      } else {
        $sex = 1;
        if ($data['sex1'] == 'false') {
          $sex = 0;
        }
        $data['dateofbirth'] = totime($data['dob']);
        $data['sex'] = $sex;
        $data['fid'] = $data['parentf'];
        $data['mid'] = $data['parentm'];

        $data['breeder'] = 1;
        if ($data['sex']) {
          $data['breeder'] = 1;
        } else {
          $data['breeder'] = 0;
        }

        unset($data['sex0']);
        unset($data['sex1']);
        unset($data['parentf']);
        unset($data['parentm']);
        unset($data['dob']);

        checkRemind($data['species'], 'species');
        checkRemind($data['breed'], 'breed');

        $sql = 'insert into `' . PREFIX . '_pet` (userid, ' . sqlBuilder($data, BUILDER_INSERT_NAME) . ', active, image, type, origin, graph) values(' . $userid . ', ' . sqlBuilder($data, BUILDER_INSERT_VALUE) . ', 0, "'. $image .'", 1, "", "")';
        // chọn chủ mặc định = 0
        // $sql = 'insert into `' . PREFIX . '_pet` (userid, ' . sqlBuilder($data, BUILDER_INSERT_NAME) . ', active, image, type, origin, graph) values(0, ' . sqlBuilder($data, BUILDER_INSERT_VALUE) . ', 0, "", 1, "", "")';

        if ($db->query($sql)) {
          $result['status'] = 1;
          $result['name'] = $data['name'];
          $result['notify'] = 'Đã thêm thú cưng';
          $result['id'] = $db->lastInsertId();
          $result['remind'] = json_encode(getRemind());
          $result['html'] = petContent();
        }
      }
      break;
    case 'filter-parent':
      $key = $nv_Request->get_string('key', 'post', '');
   		$html = '';
      $count = 0;

      // if ($type == 1) {
        $sql = 'select * from `'. PREFIX .'_user`';
        $query = $db->query($sql);
        while (($row = $query->fetch()) && $count < 20) {
          if (checkMobile($row['mobile'], $key)) {
            $count ++;
            $row['mobile'] = xdecrypt($row['mobile']);
            $html .= '
              <div style="overflow: auto;">
                '. $row['fullname'] .'<br>
                '. $row['mobile'] .'
                <button class="btn btn-info" style="float: right;" onclick="thisOwner('. $row['id'] .')">
                  Chọn
                </button>
              </div>
              <hr>
            ';
          }
        }
        $result['status'] = 1;
        if (empty($html)) {
          $result['html'] = 'Không có mục nào trùng';
        }
        else {
          $result['html'] = $html;
        }
      // }
      // else if ($type == 2) {
      //   $sql = 'select * from `'. PREFIX .'_contact`';
      //   $query = $db->query($sql);
      //   while (($row = $query->fetch()) && $count < 20) {
      //     if (checkMobile($row['mobile'], $key)) {
      //       $count ++;
      //       $html .= '
      //         <div>

      //         </div>
      //       ';
      //     }
      //   }
      // }
    break;
    case 'change-owner':
      $id = $nv_Request->get_int('id', 'post', 0);
      $userid = $nv_Request->get_int('userid', 'post', 0);
      
      $sql = 'update `'. PREFIX .'_pet` set userid = ' . $userid . ' where id = ' . $id;
      if ($db->query($sql)) {
        $result['html'] = petContent();
        if ($result['html']) {
          $result['notify'] = 'Đã lưu';
          $result['status'] = 1;
        }
      }
    break;
    case 'filter-owner':
      $key = $nv_Request->get_string('key', 'post', '');
   		$html = '';
      $count = 0;

      $sql = 'select * from `'. PREFIX .'_user`';
      $query = $db->query($sql);
      while (($row = $query->fetch()) && $count < 20) {
        if (checkMobile($row['mobile'], $key)) {
          $count ++;
          $row['mobile'] = xdecrypt($row['mobile']);
          $html .= '
            <div style="overflow: auto;">
              '. $row['fullname'] .'<br>
              '. $row['mobile'] .'
              <button class="btn btn-info" style="float: right;" onclick="thisOwner('. $row['id'] .')">
                Chọn
              </button>
            </div>
            <hr>
          ';
        }
      }
      $result['status'] = 1;
      if (empty($html)) {
        $result['html'] = 'Không có mục nào trùng';
      }
      else {
        $result['html'] = $html;
      }
    break;
    case 'filter-pet':
      $key = $nv_Request->get_string('key', 'post', '');
      $parentid = $nv_Request->get_int('parentid', 'post', 0);
      
   		$html = '';

      if (!empty($owner = getOwnerById($parentid))) {
        $sql = 'select * from `'. PREFIX .'_pet` where id = ' . $parentid . ' and name like "%'. $key .'%" or breed like "%'. $key .'%" or species like "%'. $key .'%" limit 20';
        $query = $db->query($sql);
        while (($row = $query->fetch())) {
          $html .= '
            <div style="overflow: auto;">
              '. $row['name'] .'<br>
              '. $row['breed'] .'
              <button class="btn btn-info" style="float: right;" onclick="thisPet('. $row['id'] .', "'. $row['name'] .'")">
                Chọn
              </button>
            </div>
            <hr>
          ';
        }
        $result['status'] = 1;
        if (empty($html)) {
          $result['html'] = 'Không có mục nào trùng';
        }
        else {
          $result['html'] = $html;
        }
      }
    break;
		case 'parent':
			$keyword = $nv_Request->get_string('keyword', 'post', '');

			$sql = 'select * from ((select id, fullname, mobile, address, 1 as type from `'. PREFIX .'_user`) union (select id, fullname, mobile, address, 2 as type from `'. PREFIX .'_contact`)) as c';
			$query = $db->query($sql);

			$html = '';
      $count = 0;
      // checkMobile
			while (($row = $query->fetch()) && $count < 20) {
        if (checkMobile($row['mobile'], $keyword)) {
          $sql2 = 'select * from `'. PREFIX .'_pet` where userid = ' . $row['id'];
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
    case 'species':
      $keyword = $nv_Request->get_string('keyword', 'post', '');

      $sql = 'select * from `' . PREFIX . '_species` where (name like "%' . $keyword . '%" or fci like "%' . $keyword . '%" or origin like "%' . $keyword . '%") limit 10';
      $query = $db->query($sql);

      $html = '';
      while ($row = $query->fetch()) {
        $html .= '
				<div class="suggest_item" onclick="pickSpecies(\'' . $row['name'] . '\', ' . $row['id'] . ')">
					' . $row['name'] . '
				</div>
				';
      }

      if (empty($html)) {
        $html = 'Không có kết quả trùng khớp';
      }

      $result['status'] = 1;
      $result['html'] = $html;
      break;
    case 'parent2':
      $keyword = $nv_Request->get_string('keyword', 'post', '');

      $sql = 'select * from ((select id, fullname, mobile, address, 1 as type from `' . PREFIX . '_user`) union (select id, fullname, mobile, address, 2 as type from `' . PREFIX . '_contact`)) as a';
      // die($sql);
      $query = $db->query($sql);

      $html = '';
      $count = 0;
      // checkMobile
      while (($row = $query->fetch()) && $count < 10) {
        if (checkMobile($row['mobile'], $keyword)) {
          $html .= '
      <div class="suggest_item" onclick="pickOwner(\'' . $row['fullname'] . '\', ' . $row['id'] . ', ' . $row['type'] . ')">
      <p>
      ' . $row['fullname'] . '
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

    case 'checkpet':
      $id = $nv_Request->get_string('id', 'post');
      $type = $nv_Request->get_string('type', 'post');
      
      $sql = 'update `' . PREFIX . '_sendinfo` set active = ' . $type . ', time = '. time().' where id = ' . $id;
      if ($db->query($sql)) {
        $result['html'] = petContent();
        $result['status'] = 1;
      }
    break;
    case 'ceti':
      $petid = $nv_Request->get_string('petid', 'post');
      
      if (empty($certify = checkCertify($petid))) {
        $sql = 'insert into `' . PREFIX . '_certify` (petid, signid, price, time) values ('. $petid .', 0, 0, '. time() .')';
      }
      else {
        $sql = 'delete from `' . PREFIX . '_certify` where id = ' . $certify['id'];
      }
      if ($db->query($sql)) {
        $result['html'] = petContent();
        $result['status'] = 1;
      }
    break;
    case 'remove-ceti':
      $petid = $nv_Request->get_string('petid', 'post');
      
      $sql = 'update `' . PREFIX . '_pet` set ceti = 0, price = 0 where id = ' . $petid;
      
      if ($db->query($sql)) {
        $result['html'] = petContent();
        if ($result['html']) {
          $result['notify'] = 'Đã xóa';
          $result['status'] = 1;
        }
      }
    break;

    case 'filter':
      
      if (count($filter) > 1) {
        $result['html'] = petContent();
        if ($result['html']) {
          $result['status'] = 1;
        }
      }
      break;
    case 'get':
      $id = $nv_Request->get_string('id', 'post', 0);

      $sql = 'select * from `' . PREFIX . '_pet` where id = ' . $id;
      $query = $db->query($sql);

      if (!empty($row = $query->fetch())) {
        $result['data'] = array('name' => $row['name'], 'dob' => date('d/m/Y', $row['dateofbirth']), 'species' => $row['species'], 'breed' => $row['breed'], 'color' => $row['color'], 'microchip' => $row['microchip'], 'parentf' => $row['fid'], 'parentm' => $row['mid'], 'miear' => $row['miear'], 'origin' => $row['origin']);
        $result['more'] = array('breeder' => $row['breeder'], 'sex' => intval($row['sex']), 'm' => getPetNameId($row['mid']), 'f' => getPetNameId($row['fid']), 'userid' => $row['userid'], 'username' => getOwnerById($row['userid'], $row['type'])['fullname']);
        $result['image'] = $row['image'];
        $result['status'] = 1;
      } else {
        $result['notify'] = 'Có lỗi xảy ra';
      }
      break;
    case 'remove':
      $id = $nv_Request->get_string('id', 'post');
      
      $sql = 'delete from `' . PREFIX . '_sendinfo` where id = ' . $id;
      $sql2 = 'delete from `' . PREFIX . '_certify` where petid = ' . $id;
      if ($db->query($sql) && $db->query($sql2)) {
        $result['html'] = petContent();
        $result['status'] = 1;
      }
      break;
    case 'insertpet':
      $data = $nv_Request->get_array('data', 'post');
      
      $tabber = $nv_Request->get_array('tabber', 'post');
      $image = $nv_Request->get_string('image', 'post');
      $result['notify'] = 'Có lỗi xảy ra';

      if (empty($data['name']) || empty($data['species']) || empty($data['breed'])) {
        $result['notify'] = 'Các trường bắt buộc không được bỏ trống';
      } else {
        // ???
        $sex = 1;
        if ($data['sex1'] == 'false') {
          $sex = 0;
        }
        $data['dob'] = totime($data['dob']);
        $data['sex'] = $sex;
        $data['dateofbirth'] = $data['dob'];
        $data['fid'] = $data['parentf'];
        $data['mid'] = $data['parentm'];

        if ($data['sex']) {
          $data['breeder'] = 1;
        } else {
          $data['breeder'] = 0;
        }

        unset($data['sex0']);
        unset($data['sex1']);
        unset($data['dob']);
        unset($data['parentf']);
        unset($data['parentm']);

        checkRemind($data['species'], 'species');
        checkRemind($data['breed'], 'breed');

        $sql = 'insert into `' . PREFIX . '_pet` (userid, ' . sqlBuilder($data, BUILDER_INSERT_NAME) . ', active, image, type) values(0, ' . sqlBuilder($data, BUILDER_INSERT_VALUE) . ', '. $config['pet'] .', "' . $image . '", 1)';
        // die($sql);

        if ($db->query($sql)) {
          $result['status'] = 1;
          $result['notify'] = 'Đã thêm thú cưng';
          $result['id'] = $db->lastInsertId();
          $result['remind'] = json_encode(getRemind());
          $result['html'] = petContent();
        }
      }
      break;
    case 'editpet':
      $id = $nv_Request->get_string('id', 'post', '');
      $image = $nv_Request->get_string('image', 'post');
      $data = $nv_Request->get_array('data', 'post');
      
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

        unset($data['sex0']);
        unset($data['sex1']);
        $data['sex'] = $sex;

        unset($data['dob']);
        unset($data['parentf']);
        unset($data['parentm']);

        checkRemind($data['species'], 'species');
        checkRemind($data['breed'], 'breed');
        checkRemind($data['origin'], 'origin');

        if ($data['sex']) {
          $data['breeder'] = 1;
        } else {
          $data['breeder'] = 0;
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
          $result['html'] = petContent();
        }
      }
      break;
      case 'filter-owner':
        $keyword = $nv_Request->get_string('keyword', 'post', '');

        $sql = 'select * from ((select id, fullname, mobile, address, 1 as type from `' . PREFIX . '_user`) union (select id, fullname, mobile, address, 2 as type from `' . PREFIX . '_contact`)) as a';
        $query = $db->query($sql);

        $html = '';
        $count = 0;
        // checkMobile
        while (($row = $query->fetch()) && $count < 10) {
          if ((checkMobile($row['mobile'], $keyword)) || (mb_strpos($row['fullname'], $keyword) !== false)) {
            $html .= '
              <div>
                <span>
                ' . $row['fullname'] . '
                </span>
                <button class="btn btn-info" style="float: right;" onclick="pickOwnerSubmit(\'' . $row['fullname'] . '\', ' . $row['id'] . ', ' . $row['type'] . ')">
                  Chọn
                </button>
              </div>
              <hr style="clear: both;">
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
    case 'insert-user':
			$data = $nv_Request->get_array('data', 'post');

			$data['username'] = mb_strtolower($data['username']);
      if (checkUsername($data['username'])) {
        $result['error'] = 'Tài khoản đã tồn tại';
      }
      else if (checkLogin($data['username'], $data['password'])) {
        $result['error'] = 'Mật khẩu sai';
      }
      else {
        if (!checkMobileExist($data['mobile'])) {
          $data['mobile'] = xencrypt($data['mobile']);
          $data['address'] = xencrypt($data['address']);
          $sql = 'insert into `'. PREFIX .'_user` (username, password, fullname, mobile, politic, address, active, image, a1, a2, a3, time) values("'. $data['username'] .'", "'. md5($data['password']) .'", "'. $data['fullname'] .'", "'. $data['mobile'] .'", "'. $data['politic'] .'", "'. $data['address'] .'", '. $config['user'] .', "", "'. $data['al1'] .'", "'. $data['al2'] .'", "'. $data['al3'] .'", '. time() .')';
          if ($db->query($sql)) {
            $result['id'] = $db->lastInsertId();
            $result['mobile'] = $data['mobile'];
            $result['status'] = 1;
          }
        }
        else {
          $result['error'] = 'Số điện thoại đã được sử dụng';
        }
      }
    break;
    case 'edit-info':
			$id = $nv_Request->get_int('id', 'post');
			$data = $nv_Request->get_array('data', 'post');

			// check các remind
			$data['species'] = checkRemind($data['species'], 'species2');
			$data['color'] = checkRemind($data['color'], 'color');
			$data['type'] = checkRemind($data['type'], 'type');
			$data['birthtime'] = totime($data['birthtime']);

			// cập nhật bảng
      $sql = 'update `'. PREFIX .'_sendinfo` set userid = "'. $data['petuser'] .'", micro = "'. $data['micro'] .'", regno = "'. $data['regno'] .'", name = "'. $data['name'] .'", sex = "'. $data['sex'] .'", birthtime = "'. $data['birthtime'] .'", species = "'. $data['species'] .'", color = "'. $data['color'] .'", type = "'. $data['type'] .'", breeder = "'. $data['breeder'] .'", owner = "'. $data['owner'] .'", father = '. $data['father'] .', mother = '. $data['mother'] .' where id = ' . $id;
			if ($db->query($sql)) {
				// thông báo
				$result['status'] = 1;
				$result['html'] = petContent();
			}
		break;
		case 'get-pet':
			$id = $nv_Request->get_int('id', 'post', '');
			$type = $nv_Request->get_string('type', 'post', '');
			$keyword = $nv_Request->get_string('keyword', 'post', '');

      $sql = 'select * from `'. PREFIX .'_sendinfo` where name like "%'. $keyword .'%" and userid = '. $id .' and sex = '. $type .' order by name limit 20';
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
      $info['petuser'] = getUserInfo(intval($info['userid']));
      $info['petuser']['mobile'] = xdecrypt($info['petuser']['mobile']);
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

      $xtpl = new XTemplate("user.tpl", PATH2);
      $sql = 'select * from `'. PREFIX .'_contact` where (fullname like "%'. $keyword .'%" or address like "%'. $keyword .'%" or mobile like "%'. $keyword .'%") and userid = ' . $id;
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
		case 'insert-user2':
			$data = $nv_Request->get_array('data', 'post');
			$id = $nv_Request->get_int('id', 'post', 0);

			$sql = 'select * from `'. PREFIX .'_contact` where mobile = "'. $data['mobile'] .'"';
			$query = $db->query($sql);
			if (empty($query->fetch)) {
				$sql = 'insert into `'. PREFIX .'_contact` (fullname, address, mobile, politic, userid) values ("'. $data['name'] .'", "'. $data['address'] .'", "'. $data['mobile'] .'", "'. $data['politic'] .'", '. $id .')';

				if ($db->query($sql)) {
					$result['status'] = 1;
					$result['id'] = $db->lastInsertId();
				}
			}
    break;
    case 'send-info':
			$data = $nv_Request->get_array('data', 'post');
			$image = $nv_Request->get_array('image', 'post');

			// check các remind
			$data['species'] = checkRemind($data['species'], 'species2');
			$data['color'] = checkRemind($data['color'], 'color');
			$data['type'] = checkRemind($data['type'], 'type');
			$data['birthtime'] = totime($data['birthtime']);

      // insert vào bảng
      $sql = 'insert into `'. PREFIX .'_sendinfo` (name, micro, regno, sex, birthtime, species, color, type, breeder, owner, image, userid, active, active2, father, mother, intro, time) values("'. $data['name'] .'", "'. $data['micro'] .'", "'. $data['regno'] .'", "'. $data['sex'] .'", "'. $data['birthtime'] .'", "'. $data['species'] .'", "'. $data['color'] .'", "'. $data['type'] .'", "'. $data['breeder'] .'", "'. $data['owner'] .'", "'. implode(',', $image) .'", "'. $data['petuser'] .'", 0, 1, '. $data['father'] .', '. $data['mother'] .',  "", '. time() .')';
			if ($db->query($sql)) {
				// thông báo
				$result['status'] = 1;
				$result['html'] = petContent();
			}
		break;
		case 'get-petuser':
      $keyword = $nv_Request->get_string('keyword', 'post', '');
      $keyword = deuft8($keyword);

      $sql = 'select * from `'. PREFIX .'_user` where LOWER(username) like "%'. $keyword .'%" or LOWER(fullname) like "%'. $keyword .'%" order by fullname limit 10';
			$query = $db->query($sql);

			$xtpl = new XTemplate('petuser.tpl', PATH2);
      
			$check = true;
			while ($user = $query->fetch()) {
        $user['mobile'] = xdecrypt($user['mobile']);
				$check = false;
				$xtpl->assign('id', $user['id']);
				$xtpl->assign('fullname', $user['fullname']);
				$xtpl->assign('mobile', $user['mobile']);
				$xtpl->parse('main.row');
			}
			if ($check) $xtpl->parse('main.no');
			$xtpl->parse('main');
      $result['status'] = 1;
			$result['html'] = $xtpl->text();
		break;
  }
  echo json_encode($result);
  die();
}

$xtpl = new XTemplate("main.tpl", PATH2);
include_once(LAYOUT . '/position.php');

$xtpl->assign('status' . $filter['status'], 'selected');
$xtpl->assign('name', $filter['name']);
$xtpl->assign('species', $filter['species']);
$xtpl->assign('micro', $filter['mc']);
$xtpl->assign('username', $filter['username']);
$xtpl->assign('owner', $filter['owner']);
$xtpl->assign('mobile', $filter['mobile']);
$xtpl->assign('modal', petModal());
$xtpl->assign('position', json_encode($position));
$xtpl->assign('list', petContent());
$xtpl->assign('module_file', $module_file);
$xtpl->assign('remind', json_encode(getRemind()));
$xtpl->parse("main");
$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
include (LAYOUT . "/prefix.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
