<?php

/**
 * @Project Petcoffee-tech
 * @Chistua (hchieuthua@gmail.com)
 * @Copyright (C) 2019
 * @Createdate 21-03-2019 13:15
 */

if (!defined('NV_MAINFILE')) {
	die('Stop!!!');
}

define("PREFIX", $db_config['prefix'] . "_" . $module_name);
define('PERMISSION_MODULE', 1);

include_once(NV_ROOTDIR . "/modules/". $module_name ."/src/Aes.php");
use PhpAes\Aes;
$aes = new Aes('abcdefgh01234567', 'CBC', '1234567890abcdef');

function xencrypt($str) {
  global $aes;

  return base64_encode($aes->encrypt($str));
}

function xdecrypt($code) {
  global $aes;

  return $aes->decrypt(base64_decode($code));
}

$sex_array = array(
  0 => 'Đực', 'Cái'
);

$request_array = array(
  array(
    'title' => 'Bắn microchip',
    'type' => 0
  ),
  array(
    'title' => 'Tiêm phòng bệnh',
    'type' => 1
  ),
  array(
    'title' => 'Tiêm phòng dại',
    'type' => 2
  )
);
$vaccine_array = array(
  array(
    'title' => 'Dại',
    'type' => 0
  ),
  array(
    'title' => '5 bệnh',
    'type' => 1
  ),
  array(
    'title' => '6 bệnh',
    'type' => 2
  ),
  array(
    'title' => '7 bệnh',
    'type' => 3
  )
);

$sql = 'select * from `'. PREFIX .'_config`';
$query = $db->query($sql);

while ($row = $query->fetch()) {
  $config[$row['name']] = $row['value'];
}

function selectPetidOfOwner($userid) {
  global $db;

  $list = array();
  $sql = 'select id from `'. PREFIX .'_pet` where userid = ' . $userid;
  $query = $db->query($sql);

  while ($row = $query->fetch()) {
    $list[] = $row['id'];
  }

  return implode(', ', $list);
}

function getTradeById($id) {
  global $db;

  $sql = 'select * from `'. PREFIX .'_trade` where petid = ' . $id;
  $query = $db->query($sql);

  while ($row = $query->fetch()) {
    $list[$row['type']] = $row;
  }
  return $list;
}

function checkMobile($source, $target) {
  if (empty($target)) {
    return true;
  }
  $source = xdecrypt($source);
  $res = strpos($source, $target);
  // echo "$source, $target (". var_dump($res) .")<br>";
  if ($res !== false) {
    return true;
  }
  return false;
}

function checkMobileExist($mobile) {
  global $db;

  $check = false;
  $sql = 'select * from `'. PREFIX .'_user`';
  $query = $db->query($sql);

  while (!$check && $row = $query->fetch()) {
    $row['mobile'] = xdecrypt($row['mobile']);
    if ($row['mobile'] == $mobile) {
      $check = true;
    }
  }
  return $check;
}

function parseAgeTime($datetime) {
  $str = '';
  $time = time() - $datetime;
  $year = floor($time / 60 / 60 / 24 / 365.25);
  $time -= $year * 60 * 60 * 24 * 365.25;
  $month = round($time / 60 / 60 / 24 / 30);
  if ($year > 0) {
    $str .= $year . ' năm ';
  }
  if ($year > 0 && $month == 0) {
    $str .= '';
  }
  else if ($year == 0 && $month == 0) {
    $month = 1;
  }
  $str .= $month . ' tháng';
  return $str;
}

function checkObj($obj) {
  $check = true;
  foreach ($obj as $key => $value) {
    if (empty($value)) {
      $check = false;
    }
  }

  return $check;
}

function cdate($time) {
  return date('d/m/Y', $time);
}

function ctime($time) {
  if (preg_match("/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/", $time, $m)) {
    $time = mktime(0, 0, 0, $m[2], $m[1], $m[3]);
    if (!$time) {
      $time = time();
    }
  }
  else {
    $time = time();
  }
  return $time;
}

function checkRemind($name, $type) {
	global $db;

	if (!empty($name)) {
		if ($id = getRemindIdv2($name, $type)) {
			$sql = 'update `'. PREFIX .'_remind` set rate = rate + 1 where id = ' . $id;
			if ($db->query($sql)) {
				return $id;
			}
			return 0;
		}
		else {
			$sql = 'insert into `'. PREFIX .'_remind` (type, name, visible) values ("'. $type .'", "'. $name .'", 0)';
			if ($db->query($sql)) {
				return $db->lastInsertId();
			}
			return 0;
		}
	}
	return 0;
}

function getRemindIdv2($name, $type) {
	global $db;

	$sql = 'select * from `'. PREFIX .'_remind` where name = "' . $name . '" and type = "'. $type .'"';

	// if ($type == "owner") {
	// 	die($sql);
	// }
	// echo $sql . '<br>';
	$query = $db->query($sql);
	$row = $query->fetch();

	if (!empty($row)) {
		return $row['id'];
	}
	return 0;
}

function getRemind($type = '') {
	global $db;
	$list = array();

	if (!empty($type)) {
		$sql = 'select * from `'. PREFIX .'_remind` where type = "'. $type .'"';
	}
	else {
		$sql = 'select * from `'. PREFIX .'_remind`';
	}
	$query = $db->query($sql);

	while ($row = $query->fetch()) {
		if (empty($list[$row['type']])) {
			$list[$row['type']] = array();
		}
		$list[$row['type']][] = $row;
	}

	return $list;
}

function checkUserinfo($userid, $type) {
  global $db;

  if ($type == 1) {
    $sql = 'select * from `'. PREFIX .'_user` where id = ' . $userid;
    $query = $db->query($sql);
    return $query->fetch();
  }
  else {
    $sql = 'select * from `'. PREFIX .'_contact` where id = ' . $userid;
    $query = $db->query($sql);
    return $query->fetch();
  }
  return false;
}

function getPetById($id) {
  global $db;

  if (intval($id)) {
    $sql = 'select * from `'. PREFIX .'_pet` where id = ' . $id;
    $query = $db->query($sql);
    if (!empty($row = $query->fetch())) {
        return $row;
    }
  }
  return false;
}

function getOwnerById($id, $type = 1) {
  global $db;

  if (intval($id)) {
    if ($type == 1) {
      $sql = 'select * from `'. PREFIX .'_user` where id = ' . $id;
    }
    else {
      $sql = 'select * from `'. PREFIX .'_contact` where id = ' . $id;
    }
    // die($sql);
    $query = $db->query($sql);
    return $query->fetch();
  }
  return false;
}

function getRequestId($id) {
  global $db;

  if (intval($id)) {
    $sql = 'select * from `'. PREFIX .'_request` where id = ' . $id;
    $query = $db->query($sql);
    return $query->fetch();
  }
  return false;
}

function getPetNameId($id) {
  global $db;

  if ($id && !empty($pet = getPetById($id)) && !empty($pet['name'])) {
    return $pet['name'];
  }
  return '';
}

function updatePet($data, $id) {
  global $db;
  $sql_part = array();
  foreach ($data as $key => $value) {
    $sql_part[] = $key . ' = "' . $value . '" ';
  }

  $sql = 'update `'. PREFIX .'_pet` set ' . implode(', ', $sql_part) . ' where id = ' . $id;

  if ($db->query($sql)) {
    return true;
  }
  return false;
}

function updateUser($data, $id) {
  global $db;
  $sql_part = array();
  foreach ($data as $key => $value) {
    $sql_part[] = $key . ' = "' . $value . '" ';
  }

  $sql = 'update `'. PREFIX .'_user` set ' . implode(', ', $sql_part) . ' where id = ' . $id;

  if ($db->query($sql)) {
    return true;
  }
  return false;
}

function checkUser($username, $password) {
  global $db;

  $sql = 'select * from `'. PREFIX .'_user` where username = "'. $username .'" and password = "'. md5('pet_' . $password) .'"';
  $query = $db->query($sql);

  if ($row = $query->fetch()) {
    return $row;
  }
  return false;
}

function getPetDeactiveList($keyword = '', $page = 1, $limit = 10) {
  global $db;
  $data = array('list' => array(), 'count' => 0);

  $sql = 'select count(*) as count from `'. PREFIX .'_pet` where name like "%'. $keyword .'%" or microchip like "%'.$keyword.'%" and active = 0';
  $query = $db->query($sql);
  $data['count'] = $query->fetch()['count'];

  $sql = 'select * from `'. PREFIX .'_pet` where name like "%'. $keyword .'%" or microchip like "%'.$keyword.'%" and active = 0 limit ' . $limit . ' offset ' . (($page - 1) * $limit);
  $query = $db->query($sql);

  while($row = $query->fetch()) {
    $data['list'][] = $row;
  }
  return $data;
}

function checkPetOwner($petid, $userid) {
  global $db;

  $sql = 'select * from `'. PREFIX .'_pet` where id = "'. $petid .'" and userid = ' . $userid;
  $query = $db->query($sql);

  if (!empty($row = $query->fetch())) {
    return 1;
  }
  return 0;
}

function checkPet($name, $userid) {
  global $db;

  $sql = 'select * from `'. PREFIX .'_pet` where name = "'. $name .'" and userid = ' . $userid;
  $query = $db->query($sql);

  if (!empty($row = $query->fetch())) {
    return 1;
  }
  return 0;
}

function pickVaccineId($id) {
  global $db;

  $sql = 'select * from `'. PREFIX .'_disease_suggest` where id = ' . $id;
  $query = $db->query($sql);

  return $query->fetch();
}

function getDiseaseById($id) {
  global $db;

  $sql = 'select * from `'. PREFIX.'_disease_suggest` where id = ' . $id;
  $query = $db->query($sql);

  if (empty($row = $query->fetch())) {
    $row = array('disease' => '');
  }

  return $row;
}

function checkDisease($userid, $value) {
  global $db;

  $disease = getDiseaseById($value);
  $sql = 'update `'. PREFIX .'_disease_suggest` set rate = rate + 1 where disease = "'. $disease['disease'] .'"';
  if ($db->query($sql)) {
    return true;
  }
  return false;
}

function parseVaccineType($userid) {
  global $db;

  $sql = 'select * from `'. PREFIX .'_disease_suggest` where active = 1 or userid = ' . $userid . ' group by disease order by active desc, id desc';
  $query = $db->query($sql);
  $list = array();

  while ($row = $query->fetch()) {
    $list[] = '<option value="2-'. $row['id'] .'">'. $row['disease'] .'</option>';
  }

  $list = array_reverse($list);
  return implode('', $list);
}

function checkPrvVaccine($data, $id) {
  global $db;

  $sql = 'select * from `'. PREFIX .'_vaccine` where type = ' . $data['type'] . ' and petid = ' . $id;
  $query = $db->query($sql);
  if (!empty($row = $query->fetch())) {
    return $row['id'];
  }
  return false;
}

function sqlBuilder($data, $type) {
  $string = array();
  foreach ($data as $key => $value) {
    switch ($type) {
      case 1:
        // insert value
        $string[] = '"' . $value . '"';
      break;
      case 2:
        // edit
        $string[] = $key . ' = "' . $value . '"';
      break;
      default:
        // insert name
        $string[] = $key;
      break;
    }
  }
  return implode(', ', $string);
}

function getPetRelation($petid) {
  global $db;

  // $sibling = getPetSibling($parent, $petid);
  $pet = getPetById($petid);
  $parent = getPetParent($pet);
  $grand = getPetGrand($parent);
  // $child = getPetChild($petid);

  $result = array('parent' => $parent, 'grand' => $grand);
  return $result;
}

// function getPetSibling($parent, $petid) {
//   global $db;

//   $list = array();
//   $sql = 'select * from `'. PREFIX .'_pet` where (fid = ' . $parent['f']['id'] . ' or mid = ' . $parent['m']['id'] . ') and id <> ' . $petid;
//   $query = $db->query($sql);

//   while ($row = $query->fetch()) {
//     $list[] = $row;
//   }
//   return $list;
// }

function getPetGrand($parent) {
  global $db;

  $grand = array('i' => array('f' => getPetById($parent['f']['fid']), 'm' => getPetById($parent['f']['mid'])), 'e' => array('f' => getPetById($parent['m']['fid']), 'm' => getPetById($parent['m']['mid'])));
  $grand['i']['f']['ns'] = 'igrandpa';
  $grand['i']['m']['ns'] = 'igrandma';
  $grand['e']['f']['ns'] = 'egrandpa';
  $grand['e']['m']['ns'] = 'egrandma';
  return $grand;
}

function getPetParent($pet) {
  global $db;

  $parent = array('f' => getPetById($pet['fid']), 'm' => getPetById($pet['mid']));
  $parent['f']['ns'] = 'papa';
  $parent['m']['ns'] = 'mama';
  return $parent;
}

function getPetChild($petid) {
  global $db;

  $list = array();
  $sql = 'select * from `'. PREFIX .'_pet` where fid = ' . $petid . ' or mid = ' . $petid;
  $query = $db->query($sql);

  while ($row = $query->fetch()) {
    $list[] = $row;
  }

  return $list;
}

function totime($time) {
  if (preg_match("/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/", $time, $m)) {
    $time = mktime(0, 0, 0, $m[2], $m[1], $m[3]);
    if (!$time) {
      $time = time();
    }
  }
  else {
    $time = time();
  }
  return $time;
}

function deuft8($str) {
  $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str);
  $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str);
  $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", "i", $str);
  $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str);
  $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str);
  $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str);
  $str = preg_replace("/(đ)/", "d", $str);
  $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str);
  $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str);
  $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str);
  $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str);
  $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str);
  $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str);
  $str = preg_replace("/(Đ)/", "D", $str);
  $str = mb_strtolower($str);
  //$str = str_replace(" ", "-", str_replace("&*#39;","",$str));
  return $str;
}
