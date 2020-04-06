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
        $result['html'] = userDogRow($filter);
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
        $result['html'] = userDogRow($filter);
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
        $result['html'] = userDogRow($filter);
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
        $result['html'] = userDogRow($filter);
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
          $result['html'] = userDogRow($filter);
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
        $result['html'] = userDogRow($filter);
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
        $result['html'] = userDogRow($filter);
        if ($result['html']) {
          $result['status'] = 1;
        }
      }
    break;
    case 'ceti':
      $petid = $nv_Request->get_string('petid', 'post');
      $price = $nv_Request->get_int('price', 'post', 0);
      $filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `' . PREFIX . '_pet` set ceti = 1, price = '. $price .' where id = ' . $petid;
      if ($db->query($sql)) {
        $result['html'] = userDogRow($filter);
        if ($result['html']) {
          $result['notify'] = 'Đã lưu';
          $result['status'] = 1;
        }
      }
    break;
    case 'remove-ceti':
      $petid = $nv_Request->get_string('petid', 'post');
      $filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `' . PREFIX . '_pet` set ceti = 0, price = 0 where id = ' . $petid;
      
      if ($db->query($sql)) {
        $result['html'] = userDogRow($filter);
        if ($result['html']) {
          $result['notify'] = 'Đã xóa';
          $result['status'] = 1;
        }
      }
    break;

    case 'filter':
      $filter = $nv_Request->get_array('filter', 'post');

      if (count($filter) > 1) {
        $result['html'] = userDogRow($filter);
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
        $result['html'] = userDogRow($filter);
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
          $result['html'] = userDogRow($filter);
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
          $result['html'] = userDogRow($filter);
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

$xtpl = new XTemplate("pet.tpl", PATH);
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
$xtpl->assign('list', userDogRow());
$xtpl->assign('module_file', $module_file);
$xtpl->assign('remind', json_encode(getRemind()));
$xtpl->parse("main");
$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
include (NV_ROOTDIR . "/modules/" . $module_file . "/layout/prefix.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
