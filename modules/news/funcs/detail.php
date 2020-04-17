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

$action = $nv_Request->get_string('action', 'post', '');
if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
		case 'search':
			$keyword = $nv_Request->get_string('keyword', 'post', '');
			
			$result['status'] = 1;
			if (count($list)) {
				$result['html'] = dogRowByList($keyword);
			}

		break;
	}
	echo json_encode($result);
	die();
}


$xtpl = new XTemplate("main.tpl", PATH2);

$id = $nv_Request->get_int('id', 'get', 0);

$page_title = "Thông tin thú cưng";
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

// kiểm tra hiển thị youtube
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

$xtpl->assign('module_file', $module_file);
$xtpl->parse("main");

$contents = $xtpl->text("main");
include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_file ."/layout/footer.php");

