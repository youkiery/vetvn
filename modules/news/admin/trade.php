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

$page_title = "Duyệt bài đăng";

$action = $nv_Request->get_string('action', 'post', '');

if (!empty($action)) {
  $result = array('status' => 0);
  switch ($action) {
    case 'push':
      $id = $nv_Request->get_string('id', 'post', '0');

      $sql = 'update `'. PREFIX .'_trade` set time = '. time() .' where id = ' . $id;
      if ($db->query($sql)) {
        $result['status'] = 1;
        $result['notify'] = 'Đã đưa lên đầu trang';
      }
    break;
    case 'remove-list':
      $list = $nv_Request->get_string('list', 'post', '');
			$filter = $nv_Request->get_array('filter', 'post');

      $sql = 'delete from `'. PREFIX .'_trade` where id in ('. $list .')' ;
      if ($db->query($sql)) {
        $result['html'] = tradeList($filter);
  			if ($result['html']) {
					$result['notify'] = 'Đã xóa';
					$result['status'] = 1;
				}
      }
    break;
    case 'active-list':
      $list = $nv_Request->get_string('list', 'post', '');
			$filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `'. PREFIX .'_trade` set status = 1 where id in ('. $list .')' ;
      if ($db->query($sql)) {
        $result['html'] = tradeList($filter);
				if ($result['html']) {
					$result['notify'] = 'Đã lưu';
					$result['status'] = 1;
				}
      }
    break;
    case 'deactive-list':
      $list = $nv_Request->get_string('list', 'post', '');
			$filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `'. PREFIX .'_trade` set status = 0 where id in ('. $list .')' ;
      if ($db->query($sql)) {
        $result['html'] = tradeList($filter);
				if ($result['html']) {
					$result['notify'] = 'Đã lưu';
					$result['status'] = 1;
				}
      }
    break;
    case 'sendback-list':
      $list = $nv_Request->get_string('list', 'post', '');
      $note = $nv_Request->get_string('note', 'post', '');
			$filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `'. PREFIX .'_trade` set status = 2, note = "'. $note .'" where id in ('. $list .')' ;
      if ($db->query($sql)) {
        $result['html'] = tradeList($filter);
				if ($result['html']) {
					$result['notify'] = 'Đã lưu';
					$result['status'] = 1;
				}
      }
    break;
    case 'filter':
      $filter = $nv_Request->get_array('filter', 'post');

      if (count($filter) > 1) {
        $result['html'] = tradeList($filter);
        if ($result['html']) {
          $result['status'] = 1;
        }
      }
    break;
    case 'check':
      $id = $nv_Request->get_string('id', 'post');
      $filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `' . PREFIX . '_trade` set status = 1, time = '. time() .' where id = ' . $id;
      if ($db->query($sql)) {
        $result['html'] = tradeList($filter);
        if ($result['html']) {
          $result['status'] = 1;
        }
      }
    break;
    case 'uncheck':
      $id = $nv_Request->get_string('id', 'post');
      $filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `' . PREFIX . '_trade` set status = 0 where id = ' . $id;
      if ($db->query($sql)) {
        $result['html'] = tradeList($filter);
        if ($result['html']) {
          $result['status'] = 1;
        }
      }
    break;
    case 'sendback':
      $id = $nv_Request->get_string('id', 'post');
      $note = $nv_Request->get_string('note', 'post');
      $filter = $nv_Request->get_array('filter', 'post');

      $sql = 'update `' . PREFIX . '_trade` set status = 2, note = "'.$note.'" where id = ' . $id;
      if ($db->query($sql)) {
        $result['html'] = tradeList($filter);
        if ($result['html']) {
          $result['status'] = 1;
        }
      }
    break;
    case 'remove':
      $id = $nv_Request->get_string('id', 'post');
      $filter = $nv_Request->get_array('filter', 'post');

      $sql = 'delete from `' . PREFIX . '_trade` where id = ' . $id;
      if ($db->query($sql)) {
        $result['html'] = tradeList($filter);
        if ($result['html']) {
          $result['status'] = 1;
        }
      }
    break;
		case 'get':
			$id = $nv_Request->get_string('id', 'post', 0);
			
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
		break;
		case 'editpet':
			$id = $nv_Request->get_string('id', 'post', '');
			$image = $nv_Request->get_string('image', 'post');
			$data = $nv_Request->get_array('data', 'post');
			$filter = $nv_Request->get_array('filter', 'post');
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
					$result['html'] = tradeList($filter);
				}
			}
		break;
  }
  echo json_encode($result);
  die();
}

$xtpl = new XTemplate("trade.tpl", PATH);
$xtpl->assign('remind', json_encode(getRemind()));
$xtpl->assign('content', tradeList());
$xtpl->parse("main");
$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
include (NV_ROOTDIR . "/modules/" . $module_file . "/layout/prefix.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
