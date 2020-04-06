<?php

/**
 * @Project Mining 0.1
 * @Author Frogsis
 * @Createdate Mon, 28 Oct 2019 15:00:00 GMT
 */

if (!defined('NV_IS_FILE_ADMIN')) { die('Stop!!!'); }

$xco = array(1 => 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
$yco = array(1 => 'SBD', 'Tên Chủ nuôi', 'Địa chỉ', 'Số điện thoại', 'Tên thú cưng', 'Giống loài', 'Phần thi');

if ($nv_Request->get_string('download', 'get')) {
  header('location: /assets/excel-output.xlsx?' . time());
}

$action = $nv_Request->get_string('action', 'post', '');
if (!empty($action)) {
  $result = array('status' => 0);
  switch ($action) {
    case 'excel':
      include NV_ROOTDIR . '/PHPExcel/IOFactory.php';
      $fileType = 'Excel2007'; 
      $objPHPExcel = PHPExcel_IOFactory::load(NV_ROOTDIR . '/assets/excel.xlsx');
  
      $contest = $nv_Request->get_array('contest', 'post');
      $test = getTestDataList();
      $xtra = array();
      foreach ($contest as $id) {
        $xtra[] = 'test like \'%"'. $id .'"%\' ';
      }
      
      $species = [];
      $sql = 'select * from `'. PREFIX .'species`';
      $query = $db->query($sql);
      while ($row = $query->fetch()) {
        $species[$row['id']] = $row['name'];
      }

      $sql = 'select * from `'. PREFIX .'row` ' . ((count($xtra) > 0) ? ' where ' . implode(' or ', $xtra) : "") . ' order by species desc';
      $query = $db->query($sql);
      $i = 1;
      $j = 1;

      foreach ($yco as $index => $value) {
        $objPHPExcel
        ->setActiveSheetIndex(0)
        ->setCellValue($xco[$j ++] . $i, $value);
      }
      
      $index = 1;
      while ($row = $query->fetch()) {
        $i++;
        $j = 1;
        $list = array();
        $test_data = json_decode($row['test']);
        foreach ($test_data as $id) {
          $list[] = $test[$id];
        }

        $objPHPExcel
        ->setActiveSheetIndex(0)
        ->setCellValue($xco[$j ++] . $i, checkCallNumber($index++))
        ->setCellValue($xco[$j ++] . $i, $row['name'])
        ->setCellValue($xco[$j ++] . $i, $row['address'])
        ->setCellValue($xco[$j ++] . $i, $row['mobile'])
        ->setCellValue($xco[$j ++] . $i, $row['petname'])
        ->setCellValue($xco[$j ++] . $i, $species[$row['species']])
        ->setCellValue($xco[$j ++] . $i, implode(', ', $list));
      } 
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
      $objWriter->save(NV_ROOTDIR . '/assets/excel-output.xlsx');
      $objPHPExcel->disconnectWorksheets();
      unset($objWriter, $objPHPExcel);
      $result['status'] = 1;
    break;
    case 'insert-test':
      $id = $nv_Request->get_int('id', 'post', 0);
      $name = $nv_Request->get_string('name', 'post', '');

      if ($db->query("insert into `". PREFIX ."test` (name) values ('$name')")) {
        $result['status'] = 1;
        $result['html'] = testList();
        $result['notify'] = 'Đã thêm';
      }
    break;
    case 'update-test':
      $id = $nv_Request->get_int('id', 'post', 0);
      $name = $nv_Request->get_string('name', 'post', '');

      if ($db->query("update `". PREFIX ."test` set name = '$name' where id = $id")) {
        $result['status'] = 1;
        $result['notify'] = 'Đã cập nhật';
      }
    break;
    case 'update-test-all':
      $data = $nv_Request->get_array('data', 'post');
      $update = 0;
      $total = count($data);

      foreach ($data as $id => $name) {
        if ($db->query("update `". PREFIX ."test` set name = '$name' where id = $id")) {
          $update ++;
        }
      }
      $result['status'] = 1;
      $result['notify'] = "Đã cập nhật $update trên $total";
    break;
    case 'remove-contest':
      $id = $nv_Request->get_int('id', 'post', 0);

      if ($db->query("delete from `". PREFIX ."row` where id = $id")) {
        $result['status'] = 1;
        $result['html'] = contestList();
        $result['notify'] = 'Đã xóa';
      }
    break;
    case 'remove-all-contest':
      $list = $nv_Request->get_array('list', 'post');
      $delete = 0;
      $total = count($list);

      foreach ($list as $id) {
        if ($db->query("delete from `". PREFIX ."row` where id = $id")) $delete ++;
      }
      $result['status'] = 1;
      $result['html'] = contestList();
      $result['notify'] = "Đã xóa $delete trên tổng số $total";
    break;
    case 'toggle-test':
      $id = $nv_Request->get_string('id', 'post', 0);
      $type = $nv_Request->get_string('type', 'post', 0);

      if ($db->query("update `". PREFIX ."test` set active = $type where id = $id")) {
        $result['status'] = 1;
        $result['html'] = testList();
        $result['notify'] = 'Đã ẩn';
      }
    break;
    case 'confirm-contest':
      $id = $nv_Request->get_string('id', 'post', 0);
      $type = $nv_Request->get_string('type', 'post', 0);

      if ($db->query('update `'. PREFIX .'row` set active = ' . $type . ' where id = ' . $id)) {
        $result['status'] = 1;
        $result['html'] = contestList();
        if ($type) $result['notify'] = 'Đã duyệt';
        else $result['notify'] = 'Đã bỏ duyệt';
      }
      else $result['notify'] = 'Có lỗi xảy ra';
    break;
    case 'done-all-contest':
      $list = $nv_Request->get_array('list', 'post');
      $type = $nv_Request->get_string('type', 'post', 0);
      $update = 0;
      $total = count($list);

      foreach ($list as $id) {
        if ($db->query('update `'. PREFIX .'row` set active = ' . $type . ' where id = ' . $id)) $update ++;
      }
      
      $result['status'] = 1;
      $result['html'] = contestList();
      if ($type) $result['notify'] = "Đã duyệt $update trên tổng số $total";
      else $result['notify'] = "Đã bỏ duyệt $update trên tổng số $total";
    break;
    case 'filter':
      $result['status'] = 1;
      $result['html'] = contestList();
    break;
    case 'get-contest':
      $id = $nv_Request->get_int('id', 'post', 0);

      $query = $db->query('select * from `'. PREFIX .'row` where id = ' . $id);
      if (!($row = $query->fetch())) {
        $result['notify'] = 'Có lỗi xảy ra';
      }
      else {
        $result['status'] = 1;
        $row['species'] = ucwords(getSpecies($row['species']));
        $row['test'] = json_decode($row['test']);
        $result['data'] = $row;
      }
    break;
    case 'edit-contest':
      $id = $nv_Request->get_int('id', 'post', 0);
      $data = $nv_Request->get_array('data', 'post');

      $query = $db->query("select * from `". PREFIX ."row` where mobile = '$data[mobile]' and id <> $id");
      if ($row = $query->fetch()) {
        $result['notify'] = 'Số điện thoại đã đăng ký';
      }
      else {
        // echo json_encode($data);die();
        $species = checkSpecies($data['species']);
        $test = json_encode($data['test'], JSON_UNESCAPED_UNICODE);
        $sql = "update `". PREFIX ."row` set name = '$data[name]', petname = '$data[petname]', species = $species, address = '$data[address]', mobile = '$data[mobile]', test = '$test' where id = $id";
        // die($sql);
        if (!$db->query($sql)) {
          $result['notify'] = 'Lỗi đăng ký';
        }
        else {
          $result['status'] = 1;
          $result['notify'] = 'Đã cập nhật thông tin';
          $result['html'] = contestList();
        }
      }
    break;
    case 'toggle-content':
      $type = $nv_Request->get_int('type', 'post', 0);

      if ($db->query('update `'. PREFIX .'config` set value = ' . $type . ' where name = "show_content"')) {
        $result['status'] = 1;
      }
    break;
  }
  echo json_encode($result);
  die();
}
$xtpl = new XTemplate("main.tpl", NV_ROOTDIR . "/modules/$module_file/template/admin/$op");
$query = $db->query('select * from `'. PREFIX .'config` where name = "show_content"');
$contest_config = $query->fetch();
if (empty($contest_config)) {
  $db->query('insert into `'. PREFIX .'config` (name, value) values("show_content", 1)');
  $contest_config = array('value' => 1);
}

if ($contest_config['value']) {
  $xtpl->assign('show_yes', 'block');
  $xtpl->assign('show_no', 'none');
}
else {
  $xtpl->assign('show_yes', 'none');
  $xtpl->assign('show_no', 'block');
}

$query = $db->query('select * from `'. PREFIX .'species` order by rate desc');
$species = array();
while ($row = $query->fetch()) {
  $species[] = ucwords($row['name']);
  $xtpl->assign('id', $row['id']);
  $xtpl->assign('species', ucwords($row['name']));
  $xtpl->parse('main.species');
  $xtpl->parse('main.species2');
}

$query = $db->query('select * from `'. PREFIX .'test`');
while ($row = $query->fetch()) {
  $xtpl->assign('id', $row['id']);
  $xtpl->assign('contest', $row['name']);
  $xtpl->parse('main.contest');
}

$xtpl->assign('modal_contest', contestModal());
$xtpl->assign('modal_test', testModal());
$xtpl->assign('remove_contest_modal', removeModal());
$xtpl->assign('remove_all_contest_modal', removeAllModal());
$xtpl->assign('content', contestList());
$xtpl->assign('species', json_encode($species, JSON_UNESCAPED_UNICODE));
$xtpl->parse('main');
$contents = $xtpl->text();

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
