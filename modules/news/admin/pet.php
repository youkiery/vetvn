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

if (!empty($action)) {
  $result = array('status' => 0);
  switch ($action) {
    case 'lock':
      $id = $nv_Request->get_string('id', 'post', '0');
      $type = $nv_Request->get_string('type', 'post', '0');
			$filter = $nv_Request->get_array('filter', 'post');

      if ($type == '1') {
        $sql = 'insert into `'. PREFIX .'_lock` (petid) values('. $id .')';
      }
      else {
        $sql = 'delete from `'. PREFIX .'_lock` where petid = ' . $id;
      }

      if ($db->query($sql)) {
        $result['html'] = petContent($filter);
				if ($result['html']) {
					$result['status'] = 1;
				}
      }
    break;
    case 'push':
      $id = $nv_Request->get_string('id', 'post', '0');

      $sql = 'update `'. PREFIX .'_pet` set time = '. time() .' where id = ' . $id;
      if ($db->query($sql)) {
        $result['status'] = 1;
        $result['notify'] = 'Đã đưa lên đầu trang';
      }
    break;
    case 'remove-user-list':
      $list = $nv_Request->get_string('list', 'post', '');
			$filter = $nv_Request->get_array('filter', 'post');

      $sql = 'delete from `'. PREFIX .'_pet` where id in ('. $list .')' ;
      if ($db->query($sql)) {
        $result['html'] = petContent($filter);
				if ($result['html']) {
					$result['notify'] = 'Đã xóa';
					$result['status'] = 1;
				}
      }
    break;
    case 'active-user-list':
      $list = $nv_Request->get_string('list', 'post', '');
			$filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `'. PREFIX .'_pet` set active = 1 where id in ('. $list .')' ;
      if ($db->query($sql)) {
        $result['html'] = petContent($filter);
				if ($result['html']) {
					$result['notify'] = 'Đã lưu';
					$result['status'] = 1;
				}
      }
    break;
    case 'deactive-user-list':
      $list = $nv_Request->get_string('list', 'post', '');
			$filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `'. PREFIX .'_pet` set active = 0 where id in ('. $list .')' ;
      if ($db->query($sql)) {
        $result['html'] = petContent($filter);
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
      $filter = $nv_Request->get_array('filter', 'post');
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
          $result['html'] = petContent($filter);
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
      $filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `'. PREFIX .'_pet` set userid = ' . $userid . ' where id = ' . $id;
      if ($db->query($sql)) {
        $result['html'] = petContent($filter);
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
      $filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `' . PREFIX . '_pet` set active = ' . $type . ', time = '. time().' where id = ' . $id;
      if ($db->query($sql)) {
        $result['html'] = petContent($filter);
        if ($result['html']) {
          $result['status'] = 1;
        }
      }
    break;
    case 'ceti':
      $petid = $nv_Request->get_string('petid', 'post');
      $filter = $nv_Request->get_array('filter', 'post');

      $sql = 'select * from `' . PREFIX . '_pet` where id = ' . $petid;
      $query = $db->query($sql);
      $pet = $query->fetch();

      if ($pet['ceti']) {
        $sql = 'update `' . PREFIX . '_pet` set ceti = 0, price = 0 where id = ' . $petid;
      }
      else {
        $sql = 'update `' . PREFIX . '_pet` set ceti = 1 where id = ' . $petid;
      }
      if ($db->query($sql)) {
        $result['html'] = petContent($filter);
        if ($result['html']) {
          $result['status'] = 1;
        }
      }
    break;
    case 'remove-ceti':
      $petid = $nv_Request->get_string('petid', 'post');
      $filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `' . PREFIX . '_pet` set ceti = 0, price = 0 where id = ' . $petid;
      
      if ($db->query($sql)) {
        $result['html'] = petContent($filter);
        if ($result['html']) {
          $result['notify'] = 'Đã xóa';
          $result['status'] = 1;
        }
      }
    break;

    case 'filter':
      $filter = $nv_Request->get_array('filter', 'post');

      if (count($filter) > 1) {
        $result['html'] = petContent($filter);
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
      $filter = $nv_Request->get_array('filter', 'post');

      $sql = 'delete from `' . PREFIX . '_pet` where id = ' . $id;
      if ($db->query($sql)) {
        $result['html'] = petContent($filter);
        if ($result['html']) {
          $result['status'] = 1;
        }
      }
      break;
    case 'insertpet':
      $data = $nv_Request->get_array('data', 'post');
      $filter = $nv_Request->get_array('filter', 'post');
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
          $result['html'] = petContent($filter);
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
          $result['html'] = petContent($filter);
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
  }
  echo json_encode($result);
  die();
}

$xtpl = new XTemplate("main.tpl", PATH2);
include_once(PATH2 . '/position.php');

$xtpl->assign('modal', petModal());
$xtpl->assign('position', json_encode($position));
$xtpl->assign('list', petContent());
$xtpl->assign('module_file', $module_file);
$xtpl->assign('remind', json_encode(getRemind()));
$xtpl->parse("main");
$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
include (NV_ROOTDIR . "/modules/" . $module_file . "/layout/prefix.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
