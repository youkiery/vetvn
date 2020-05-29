<?php

/**
 * @Project Mining 0.1
 * @Author Frogsis
 * @Createdate Mon, 28 Oct 2019 15:00:00 GMT
 */

if (!defined('NV_IS_MOD_NEWS')) die('Stop!!!');

$action = $nv_Request->get_string('action', 'post', '');
if (!empty($action)) {
  $result = array('status' => 0);
  switch ($action) {
    case 'signup':
      $data = $nv_Request->get_array('data', 'post');

      $court = array();
      $temp = array(
        'yes' => array(),
        'no' => array()
      );
      foreach ($data['court'] as $key => $value) {
        $query = $db->query("select * from `". PREFIX ."regist` where mobile = '$data[mobile]' and court = $value");
        
        $courtData = checkCourt($value);
        $temp['list'][] = $courtData;
        if (empty($row = $query->fetch())) {
          $court[]= $value;
          $temp['no'][] = $courtData;
        }
      }

      foreach ($court as $value) {
        $sql = "insert into `". PREFIX ."regist` (name, address, mobile, court) values('$data[name]', '$dat[address]', '$data[mobile]', $value)";
        $db->query($sql);
      }
      $result['status'] = 1;
      $result['data'] = $temp;
    break;
  }
  echo json_encode($result);
  die();
}
$xtpl = new XTemplate("main.tpl", PATH2);
$xtpl->assign('module_name', $module_name);
$page_title = 'Đăng ký khóa học thú y';

// $sql = 'select * from `'. PREFIX .'court`';
// $query = $db->query($sql);
// while ($row = $query->fetch()) {
//   $xtpl->assign('id', $row['id']);
//   $xtpl->assign('court', $row['name'] . ' - Giá: ' . number_format($row['price'], 0, '', ',') . ($row['intro'] ? ' - ' : '') . $row['intro']);
//   $xtpl->parse('main.court');
// }

// $xtpl->assign('species', json_encode($species, JSON_UNESCAPED_UNICODE));
$sql = 'select * from (select * from `pet_vi_contest_2` order by id desc limit 4) a inner join `pet_vi_contest_detail` b on a.id = b.id';
$query = $db->query($sql);
$row = $query->fetch();
$xtpl->assign('title', $row['title']);
$xtpl->assign('content', $row['hometext']);
$xtpl->assign('main_content', str_replace('"', '\'', $row['bodyhtml']));
$xtpl->assign('img', $row['homeimgfile']);

$sql = 'select * from (select * from `pet_vi_contest_1` order by id desc limit 4) a inner join `pet_vi_contest_detail` b on a.id = b.id';
$query = $db->query($sql);
$data = array();
$index = 0;
while ($row = $query->fetch()) {
  $xtpl->assign('id', $row['id']);
  $xtpl->assign('1' . $index . 'a', $row['title']);
  $xtpl->assign('1' . $index . 'b', $row['hometext']);
  $xtpl->assign('1' . $index . 'c', str_replace('"', '\'', $row['bodyhtml']));
  $index++;
}

$sql = 'select * from (select * from `pet_vi_contest_3` order by id desc limit 4) a inner join `pet_vi_contest_detail` b on a.id = b.id';
$query = $db->query($sql);
$data = array();
$index = 0;
while ($row = $query->fetch()) {
  $xtpl->assign('id', $row['id']);
  $xtpl->assign('3' . $index . 'a', $row['title']);
  $xtpl->assign('3' . $index . 'b', $row['hometext']);
  $xtpl->assign('3' . $index . 'c', str_replace('"', '\'', $row['bodyhtml']));
  $index++;
}

$sql = 'select * from (select * from `pet_vi_contest_5` order by id desc limit 2) a inner join `pet_vi_contest_detail` b on a.id = b.id';
$query = $db->query($sql);
$data = array();
$index = 0;
while ($row = $query->fetch()) {
  $xtpl->assign('id', $row['id']);
  $xtpl->assign('5' . $index . 'a', $row['title']);
  $xtpl->assign('5' . $index . 'b', $row['hometext']);
  $xtpl->assign('5' . $index . 'c', str_replace('"', '\'', $row['bodyhtml']));
  $index++;
}

$sql = 'select * from (select * from `pet_vi_contest_4` order by id desc limit 1) a inner join `pet_vi_contest_detail` b on a.id = b.id';
$query = $db->query($sql);
$footer = $query->fetch();

$xtpl->assign('footer', $footer['bodyhtml']);
$xtpl->assign('time', time());

$xtpl->assign('data', json_encode($data));
$xtpl->assign('modal', homeModal());

$xtpl->assign('edu_block', eduBlock());
$xtpl->assign('court_block', courtBlock());
$xtpl->assign('help_block', helpBlock());
$xtpl->parse('main');
$contents = $xtpl->text();

include NV_ROOTDIR . "/modules/$module_file/template/layout/header.php";
echo $contents;
include NV_ROOTDIR . "/modules/$module_file/template/layout/footer.php";
