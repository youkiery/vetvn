<?php

/**
 * @Project Mining 0.1
 * @Author Frogsis
 * @Createdate Mon, 28 Oct 2019 15:00:00 GMT
 */

if (!defined('NV_IS_MOD_CONGVAN')) die('Stop!!!');

$action = $nv_Request->get_string('action', 'post', '');
if (!empty($action)) {
  $result = array('status' => 0);
  switch ($action) {
    case 'signup':
      $data = $nv_Request->get_array('data', 'post');

      $query = $db->query("select * from `". PREFIX ."row` where mobile = '$data[mobile]'");
      if ($row = $query->fetch()) {
        $result['notify'] = 'Số điện thoại đã đăng ký';
      }
      else {
        $species = checkSpecies($data['species']);
        $test = json_encode($data['test'], JSON_UNESCAPED_UNICODE);
        $sql = "insert into `". PREFIX ."row` (name, petname, species, address, mobile, test) values('$data[name]', '$data[petname]', $species, '$data[address]', '$data[mobile]', '$test')";
        if (!$db->query($sql)) {
          $result['notify'] = 'Lỗi đăng ký';
        }
        else {
          $result['status'] = 1;
          $result['notify'] = 'Đã đăng ký thành công';
        }
      }
    break;
    case 'filter':
      $result['status'] = 1;
      $result['html'] = confirmList();
    break;
  }
  echo json_encode($result);
  die();
}
$xtpl = new XTemplate("main.tpl", NV_ROOTDIR . "/modules/". $module_file ."/template/". $op);

$query = $db->query('select * from `'. PREFIX .'config` where name = "show_content"');
$contest_config = $query->fetch();
if (empty($contest_config)) {
  $db->query('insert into `'. PREFIX .'config` (name, value) values("show_content", 1)');
  $contest_config = array('value' => 1);
}

if ($contest_config['value']) {
  $xtpl->assign('confirm_list', confirmList());
  $query = $db->query('select * from `'. PREFIX .'species` order by rate desc');
  while ($row = $query->fetch()) {
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('species', ucwords($row['name']));
    $xtpl->parse('main.list.species');
  }
  
  $query = $db->query('select * from `'. PREFIX .'test` where active = 1');
  while ($row = $query->fetch()) {
    $xtpl->assign('id', $row['id']);
    $xtpl->assign('contest', $row['name']);
    $xtpl->parse('main.list.contest');
  }
  $xtpl->parse('main.list');
}

$query = $db->query("select * from `". PREFIX ."test` where active = 1");
while ($row = $query->fetch()) {
  $xtpl->assign('id', $row['id']);
  $xtpl->assign('name', $row['name']);
  $xtpl->parse('main.test');
}

$query = $db->query('select * from `'. PREFIX .'species` order by rate desc');
$species = array();
while ($row = $query->fetch()) {
  $species[] = ucwords($row['name']);
}

$xtpl->assign('species', json_encode($species, JSON_UNESCAPED_UNICODE));
$xtpl->parse('main');
$contents = $xtpl->text();

include NV_ROOTDIR . "/modules/$module_file/template/layout/header.php";
echo $contents;
include NV_ROOTDIR . "/module/$module_file/template/layout/footer.php";
