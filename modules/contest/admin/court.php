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
    case 'get-info':
      $id = $nv_Request->get_int('id', 'post', 0);
      $sql = 'select * from `'. PREFIX .'court` where id = ' . $id;
      $query = $db->query($sql);

      if ($row = $query->fetch()) {
        $result['data'] = $row;
        $result['status'] = 1;
      }
    break;
    case 'update':
      $id = $nv_Request->get_int('id', 'post', 0);
      $data = $nv_Request->get_array('data', 'post');

      $sql = 'update `'. PREFIX .'court` set parent = '. $data['parent'] .', name = "'. $data['name'] .'", price = "'. $data['price'] .'", intro = "'. $data['intro'] .'" where id = ' . $id;
      if ($db->query($sql)) {
        $result['status'] = 1;
        $result['html'] = courtList();
      }
    break;
    case 'insert':
      $data = $nv_Request->get_array('data', 'post', 0);

      $sql = 'insert into `'. PREFIX .'court` (name, price, intro, parent) values("'. $data['name'] .'", '. $data['price'] .', "'. $data['intro'] .'", '. $data['parent'] .')';
      if ($db->query($sql)) {
        $result['status'] = 1;
        $result['html'] = courtList();
      }
    break;
  }
  echo json_encode($result);
  die();
}
$xtpl = new XTemplate("main.tpl", PATH);

// Quản lý khóa học
$xtpl->assign('modal', courtModal());
$xtpl->assign('content', courtList());

$xtpl->parse('main');
$contents = $xtpl->text();

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
