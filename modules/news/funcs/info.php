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
	header('location: /' . $module_name . '/login/');
	die();
}

$id = $nv_Request->get_int('id', 'get', 0);
$action = $nv_Request->get_string('action', 'post', '');

if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
    case 'youtube':
			$data = $nv_Request->get_array('data', 'post');
      $sql = 'update `'. PREFIX .'_pet` set youtube = \''. json_encode($data) .'\' where id = ' . $id;
      if ($db->query($sql)) {
        $result['status'] = 1;
        $result['notify'] = 'Đã lưu';
      }
    break;
    case 'save-graph':
			$data = $nv_Request->get_string('data', 'post');
      $result['notify'] = 'Có lỗi xảy ra';

        $sql = 'update `'. PREFIX .'_sendinfo` set intro = "'. $data .'" where id = ' . $id;
        if ($db->query($sql)) {
          $result['status'] = 1;
          $result['notify'] = 'Đã lưu';
        }

    break;
		case 'insert-disease-suggest':
			$disease = $nv_Request->get_string('disease', 'post');
      $result['notify'] = 'Có lỗi xảy ra';

      $sql = 'select * from `'. PREFIX .'_disease_suggest` where disease = "'. $disease .'"';
      $query = $db->query($sql);

      $sql = "";
      if (!empty($row = $query->fetch())) {
        if ($row['active'] = 1) {
          $result['error'] = 'Đã có trong danh sách';
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
    case 'get-breeder':
			$id = $nv_Request->get_string('id', 'post', 0);

      $sql = 'select * from `'. PREFIX .'_breeder` where id = ' . $id;
      $query = $db->query($sql);
      if ($row = $query->fetch()) {
        $pet = getPetById($row['targetid']);
        $result['data'] = array('time' => date('d/m/Y', $row['time']), 'target' => $pet['id'], 'number' => $row['number'], 'note' => $row['note']);
        $result['name'] = $pet['name'];
        $result['status'] = 1;
      }
      else {
        $result['notify'] = 'Có lỗi xảy ra';
      }
    break;
		case 'edit-breeder':
			$data = $nv_Request->get_array('data', 'post');
			$bid = $nv_Request->get_string('bid', 'post', 0);
			$id = $nv_Request->get_string('id', 'post', 0);
      $result['notify'] = 'Có lỗi xảy ra';

      $data['time'] = totime($data['time']);
      $list = array();
      $data['targetid'] = $data['target'];
      unset($data['target']);

      $sql = 'update `'. PREFIX .'_breeder` set '. sqlBuilder($data, BUILDER_EDIT) .' where id = ' . $bid;
      if ($db->query($sql)) {
        $result['status'] = 1;
        $result['html'] = breederList($id);
        $result['notify'] = 'Đã lưu thông tin thú cưng';
      }

		break;
		case 'insert-breeder':
			$data = $nv_Request->get_array('data', 'post');
			// $child = $nv_Request->get_array('child', 'post');
			$id = $nv_Request->get_string('id', 'post', 0);
      $result['notify'] = 'Có lỗi xảy ra';

      $data['time'] = totime($data['time']);
      $list = array();

      if (empty($pet = getPetById($data['target']))) {
        $result['notify'] = 'Đối tượng không tồn tại';
      }
      else {
        $sql = 'insert into `'. PREFIX .'_breeder` (petid, targetid, child, time, number, note) values('. $id .', '. $data['target'] .', "[]", "'. $data['time'] .'", '. $data['number'] .', "'. $data['note'] .'")';
        // die($sql);
        if ($db->query($sql)) {
          $result['status'] = 1;
          $result['notify'] = 'Đã thêm danh sách';
          $result['html'] = breederList($id);
        }
      }
		break;
		case 'insert-disease':
			$id = $nv_Request->get_string('id', 'post', 0);
			$data = $nv_Request->get_array('data', 'post');
      $result['notify'] = 'Có lỗi xảy ra';

      if (empty($data['disease'])) {
        $result['notify'] = 'Loại bệnh không được trống';
      }
      else {
        $data['treat'] = totime($data['treat']);
        $data['treated'] = totime($data['treated']);
        checkRemind($data['disease'], 'disease');

        $sql = 'insert into `'. PREFIX .'_disease` (petid, treat, treated, disease, note) values('. $id .', '. $data['treat'] .', '. $data['treated'] .', "'. $data['disease'] .'", "'. $data['note'] .'")';
        if ($db->query($sql)) {
          $result['status'] = 1;
          $result['notify'] = 'Đã thêm danh sách';
          $result['html'] = diseaseList($id);
        }
      }

		break;
		case 'edit-disease':
			$did = $nv_Request->get_string('did', 'post', 0);
			$id = $nv_Request->get_string('id', 'post', 0);
			$data = $nv_Request->get_array('data', 'post');
      $result['notify'] = 'Có lỗi xảy ra';

      $data['treat'] = totime($data['treat']);
      $data['treated'] = totime($data['treated']);
      checkRemind($data['disease'], 'disease');

      $sql = 'update `'. PREFIX .'_disease` set ' . sqlBuilder($data, BUILDER_EDIT) . ' where id = ' . $did;
      if ($db->query($sql)) {
        $result['status'] = 1;
        $result['notify'] = 'Đã lưu thông tin';
        $result['html'] = diseaseList($id);
      }

		break;
    case 'get-disease':
			$id = $nv_Request->get_string('id', 'post', 0);

      $sql = 'select * from `'. PREFIX .'_disease` where id = ' . $id;
      $query = $db->query($sql);
      if ($row = $query->fetch()) {
        $result['data'] = array('treat' => date('d/m/Y', $row['treat']), 'treated' => date('d/m/Y', $row['treated']), 'note' => $row['note'], 'disease' => $row['disease']);
        $result['status'] = 1;
      }
      else {
        $result['notify'] = 'Có lỗi xảy ra';
      }
    break;
    case 'donevac':
			$pid = $nv_Request->get_string('pid', 'post', 0);
			$id = $nv_Request->get_string('id', 'post', 0);
			$data = $nv_Request->get_array('data', 'post');

      $sql = 'update `'. PREFIX .'_vaccine` set status = 1 where id = ' . $pid;
      if ($db->query($sql) && $html = vaccineList($id)) {
        $result['status'] = 1;
        $result['html'] = $html;
      }
    break;
    case 'get-vaccine':
			$id = $nv_Request->get_string('id', 'post', 0);

      $sql = 'select * from `'. PREFIX .'_vaccine` where id = ' . $id;
      $query = $db->query($sql);
      if ($row = $query->fetch()) {
        $pet = getPetById($row['targetid']);
        $result['data'] = array('type' => $row['type'] . '-' . $row['val'], 'time' => date('d/m/Y', $row['time']), 'recall' => date('d/m/Y', $row['recall']));
        $result['status'] = 1;
      }
      else {
        $result['notify'] = 'Có lỗi xảy ra';
      }
    break;
    case 'edit-vaccine':
			$id = $nv_Request->get_string('id', 'post', 0);
			$vid = $nv_Request->get_string('vid', 'post', 0);
			$data = $nv_Request->get_array('data', 'post');
      $result['notify'] = 'Có lỗi xảy ra';
      
      if (!empty($id) && count($data) > 0) {
        $data['time'] = totime($data['time']);
        $data['recall'] = totime($data['recall']);
        
        $sql = 'update `'. PREFIX .'_vaccine` set ' . sqlBuilder($data, BUILDER_EDIT) . ' where id = ' . $vid;
        // die($sql);
        if ($db->query($sql)) {
          $result['status'] = 1;
          $result['html'] = vaccineList($id);
        }
        else {
          $result['notify'] = 'Đã lưu';
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
        if (!empty($rowid = checkPrvVaccine($data, $id))) {
          // 
          $sql = 'update `'. PREFIX .'_vaccine` set status = 1 where type = ' . $data['type'] . ' and petid = ' . $id;
          $db->query($sql);
        }
        checkDisease($userinfo['id'], $data['val']);
        $sql = 'insert into `'. PREFIX .'_vaccine` (petid, time, recall, type, val, status) values ("'. $id .'", "'. $data['time'] .'", "'. $data['recall'] .'", "'. $data['type'] .'",  "'. $data['val'] .'", 0)';
        if ($db->query($sql)) {
          $result['status'] = 1;
          $result['html'] = vaccineList($id);
          $result['notify'] = 'Đã thêm tiêm phòng';
        }
      }
    break;

 		case 'target':
			$keyword = $nv_Request->get_string('keyword', 'post', '');
			$index = $nv_Request->get_int('index', 'post', -1);
			$func = $nv_Request->get_string('func', 'post', '');

			$sql = 'select a.id, a.name, b.fullname, b.mobile, b.image from `'. PREFIX .'_pet` a inner join `'. PREFIX .'_user` b on a.userid = b.id where userid = ' . $userinfo['id'];
			$query = $db->query($sql);

			$html = '';
      $xtra = '';
      $ex = 'pickTarget';
      if (!empty($func)) {
        $ex = $func;
      }
      else if ($index >= 0) {
        $xtra .= ', 0, ' . $index;
      }
      $count = 0;
      // checkMobile
			while (($row = $query->fetch()) && $count < 10) {
        if (checkMobile($row['mobile'], $keyword)) {
          $html .= '
          <div class="suggest_item2" onclick="'. $ex .'(\''. $row['name'] .'\', '. $row['id'] . $xtra .')">
            <div class="xleft">
            </div>
            <div class="xright">
              <p> '. $row['fullname'] .' </p>
              <p> '. $row['name'] .' </p>
            </div>
          </div>';
          $count ++;
        }
      }

			if (empty($html)) {
				$html = 'Không có kết quả trùng khớp';
			}

			$result['status'] = 1;
			$result['html'] = $html;
		break;
 		case 'disease':
			$keyword = $nv_Request->get_string('keyword', 'post', '');

			$sql = 'select * from `'. PREFIX .'_remind` where type = "disease" and name like "%'. $keyword .'%"';
			$query = $db->query($sql);

			$html = '';
			while ($row = $query->fetch()) {
				$html .= '
				<div class="suggest_item" onclick="pickDisease(\''. $row['name'] .'\')">
					<div>
						<p> '. $row['name'] .' </p>
					</div>
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
      $result['notify'] = 'Có lỗi xảy ra';

			if (count($data) > 1 && !checkPet($data['name'], $userinfo['id'])) {
        // ???
        $sex = 0;
        if ($data['sex1']) {
          $sex = 1;
        }
				$data['dob'] = totime($data['dob']);
				$data['sex'] = $sex;
				$data['dateofbirth'] = totime($data['dob']);

        if (!empty($data['breeder'])) {
          if ($data['sex']) {
            $data['breeder'] = 0;
          }
          else {
            $data['breeder'] = 1;
          }
        }
        else {
          $data['breeder'] = 2;
        }

        unset($data['sex0']);
        unset($data['sex1']);
				unset($data['dob']);

        checkRemind($data['species'], 'species');
        checkRemind($data['breed'], 'breed');

				$sql = 'insert into `'. PREFIX .'_pet` (userid, '. sqlBuilder($data, BUILDER_INSERT_NAME) .', active, image, fid, mid, time) values('. $userinfo['id'] .', '. sqlBuilder($data, BUILDER_INSERT_VALUE) .', '. $config['pet'] .', "", 0, 0, '. time() .')';
        // die($sql);

				if ($db->query($sql)) {
					$result['status'] = 1;
					$result['notify'] = 'Đã thêm thú cưng';
					$result['name'] = $data['name'];
					$result['id'] = $db->lastInsertId();
					$result['remind'] = json_encode(getRemind());
				}
			}
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
    case 'owner':
			$keyword = $nv_Request->get_string('keyword', 'post', '');

			$sql = 'select * from ((select id, fullname, mobile, address, 1 as type from `'. PREFIX .'_user`) union (select id, fullname, mobile, address, 2 as type from `'. PREFIX .'_contact` where userid = '. $userinfo['id'] .')) as a limit 10';
			$query = $db->query($sql);

			$html = '';
      $count = 0;
      // checkMobile
			while (($row = $query->fetch()) && $count < 10) {
        if (checkMobile($row['mobile'], $keyword)) {
          $html .= '
          <div class="suggest_item" onclick="pickOwner(\''. $row['fullname'] .'\', '. $row['id'] .', '. $row['type'] .')">
            '. $row['fullname'] .'
          </div>';
          $count ++;
        }
			}

			if (empty($html)) {
				$html = 'Không có kết quả trùng khớp';
			}

			$result['status'] = 1;
			$result['type'] = 2;
			$result['html'] = $html;
		break;
		case 'insert-owner':
			$data = $nv_Request->get_array('data', 'post');
      $result['notify'] = 'Có lỗi xảy ra';

			if (count($data) > 1 && !empty($userinfo['id'])) {
        // ???
        if (!checkMobileExist($data['mobile'])) {
          $data['mobile'] = xencrypt($data['mobile']);
          $data['address'] = xencrypt($data['address']);
          $sql = 'insert into `'. PREFIX .'_contact` (fullname, address, mobile, userid) values ("'. $data['fullname'] .'", "'. $data['address'] .'", "'. $data['mobile'] .'", '. $userinfo['id'] .')';

          if ($db->query($sql)) {
            $result['status'] = 1;
            $result['id'] = $db->lastInsertId();
            $result['name'] = $data['fullname'];
            $result['notify'] = 'Đã thêm khách';
            // $result['html'] = userDogRowByList($userinfo['id']);
          }
        }
			}
		break;
	}
	echo json_encode($result);
	die();
}

$xtpl = new XTemplate("main.tpl", PATH2);

$page_title = "Quản lý thú cưng";
$pet = getPetRelation($id);

if (!empty($pet['data']['id'])) {
  $page_title = $pet['data']['name'] . " - Thông tin thú cưng";
  // echo json_encode($pet);die();

  $owner = getOwnerById($pet['data']['userid'], $pet['data']['type']);
	$xtpl->assign('owner', $pet['data']['owner']['fullname']);
	$xtpl->assign('politic', $pet['data']['owner']['politic']);
	$xtpl->assign('name', $pet['data']['name']);
	$xtpl->assign('dob', $pet['data']['birthtime']);
	$xtpl->assign('species', $pet['data']['species']);
	$xtpl->assign('color', $pet['data']['color']);
	$xtpl->assign('type', $pet['data']['type']);
  $xtpl->assign('sex', $pet['data']['sex']);
	$xtpl->assign('micro', $pet['data']['micro']);
	$xtpl->assign('image', $pet['data']['image']);
  $xtpl->assign('intro', $pet['data']['intro']);
  
  if (!empty($pet['data']['certify'])) {
    $xtpl->parse('main.row.ddc');
  }

  // Bố
  $xtpl->assign('papa', parseLink($pet['father']['data']));
  $xtpl->assign('igpapa', parseInfo($pet['father']['data']));
  // Ông nội
  $xtpl->assign('igrandpa', parseLink($pet['father']['father']));
  $xtpl->assign('igigrandpa', parseInfo($pet['father']['father']));
  // Bà nội
  $xtpl->assign('igrandma', parseLink($pet['father']['mother']));
  $xtpl->assign('igigrandma', parseInfo($pet['father']['mother']));
  // mẹ
  $xtpl->assign('mama', parseLink($pet['mother']['data']));
  $xtpl->assign('igmama', parseInfo($pet['mother']['data']));
  // ông ngoại
  $xtpl->assign('egrandpa', parseLink($pet['mother']['father']));
  $xtpl->assign('igegrandpa', parseInfo($pet['mother']['father']));
  // bà ngoại
  $xtpl->assign('egrandma', parseLink($pet['mother']['mother']));
  $xtpl->assign('igegrandma', parseInfo($pet['mother']['mother']));

	$xtpl->parse("main.detail");
}
else {
	$xtpl->parse("main.error");
}

$xtpl->assign('today', date('d/m/Y', time()));
$xtpl->assign('recall', date('d/m/Y', time() + 60 * 60 * 24 * 21));
$xtpl->assign('url', '/' . $module_name . '/' . $op . '/');
$xtpl->assign('remind', json_encode(getRemind()));
$xtpl->assign('id', $id);

$request = 'breeder';
if (!empty($_REQUEST['target']) && in_array($_REQUEST['target'], array('vaccine', 'disease'))) {
  $request = $_REQUEST['target'];
}

switch ($request) {
  case 'vaccine':
    $xtpl->assign('a2', 'class="active"');
    $xtpl->assign('al2', 'in active');
  break;
  case 'disease':
    $xtpl->assign('a3', 'class="active"');
    $xtpl->assign('al3', 'in active');
  break;
  default:
    $xtpl->assign('a1', 'class="active"');
    $xtpl->assign('al1', 'in active');
  break;
}

// try {
//   $youtube = json_decode($pet['youtube']);
//   if (empty($youtube)) $youtube = array();
//   foreach ($youtube as $url) {
//     $rx = '~
//       ^(?:https?://)?
//       (?:www[.])?
//       (?:youtube[.]com/watch[?]v=|youtu[.]be/)
//       ([^&]{11})
//         ~x';
//     $has_match = preg_match($rx, $url);
//     // $has_match = true;

//     if (!empty($url) && $has_match) {
//       $http_check = strpos($url, 'http://');
//       // var_dump($http_check);die();
//       if ($http_check == false) {
//         $url = 'http://' . $url;
//       }
//       $xtpl->assign('youtube', str_replace('watch?v=', 'embed/', $url));
//       $xtpl->parse('main.youtube');
//     }
//   }
// }
// catch (Exception $e) {
//   // echo 'Caught exception: ',  $e->getMessage(), "\n";
// }

$xtpl->assign('modal', infoModal());
$xtpl->assign('module_file', $module_file);
$xtpl->parse("main");
$contents = $xtpl->text("main");
include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_file ."/layout/footer.php");

