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
define('BUILDER_INSERT', 0);
define('BUILDER_EDIT', 1);

$page_title = "Đăng ký";

$action = $nv_Request->get_string('action', 'post', '');
$userinfo = getUserInfo();
if (!empty($userinfo)) {
  if ($userinfo['center']) {
    header('location: /'. $module_name .'/center');
  }
  header('location: /'. $module_name .'/private');
}

if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
		case 'signup':
			$data = $nv_Request->get_array('data', 'post');

			$data['username'] = mb_strtolower($data['username']);
      if (checkUsername($data['username'])) {
        $result['error'] = 'Tài khoản đã tồn tại';
      }
      else if (checkLogin($data['username'], $data['password'])) {
        $result['error'] = 'Mật khẩu sai';
      }
      else {
        if (!checkMobileExist($data['phone'])) {
          $data['phone'] = xencrypt($data['phone']);
          $data['address'] = xencrypt($data['address']);
          $sql = 'insert into `'. PREFIX .'_user` (username, password, fullname, mobile, politic, address, active, image, a1, a2, a3, time) values("'. $data['username'] .'", "'. md5($data['password']) .'", "'. $data['fullname'] .'", "'. $data['phone'] .'", "'. $data['politic'] .'", "'. $data['address'] .'", '. $config['user'] .', "", "'. $data['al1'] .'", "'. $data['al2'] .'", "'. $data['al3'] .'", '. time() .')';
          if ($db->query($sql)) {
            $_SESSION['username']	 = $data['username'];
            $_SESSION['password'] = $data['password'];
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

$id = $nv_Request->get_int('id', 'get', 0);
$global = array();
$global['login'] = 0;
$position = json_decode('[{"name":"Đắk Lắk","district":["Buôn Hồ","Buôn Ma Thuột","Buôn Đôn","Cư Kuin","Cư Mgar","Ea HLeo","Ea Kar","Ea Súp","Krông Ana","Krông Buk","Krông Bông","Krông Năng","Krông Pắc","Lăk","MĐrăk"]},{"name":"An Giang","district":["An Phú","Châu Phú","Châu Thành","Châu Đốc","Chợ Mới","Long Xuyên","Phú Tân","Thoại Sơn","Tri Tôn","Tân Châu","Tịnh Biên"]},{"name":"Bà Rịa Vũng Tàu","district":["Bà Rịa","Châu Đức","Côn Đảo","Long Điền","Tân Thành","Vũng Tàu","Xuyên Mộc","Đất Đỏ"]},{"name":"Bình Dương","district":["Bàu Bàng","Bến Cát","Dĩ An","Dầu Tiếng","Phú Giáo","Thuận An","Thủ Dầu Một","Tân Uyên"]},{"name":"Bình Phước","district":["Bình Long","Bù Gia Mập","Bù Đăng","Bù Đốp","Chơn Thành","Hớn Quản","Lộc Ninh","Phú Riềng","Phước Long","Đồng Phú","Đồng Xoài"]},{"name":"Bình Thuận  ","district":["Bắc Bình","Hàm Thuận Bắc","Hàm Thuận Nam","Hàm Tân","La Gi","Phan Thiết","Tuy Phong","Tánh Linh","Đảo Phú Quý","Đức Linh"]},{"name":"Bình Định","district":["An Lão","An Nhơn","Hoài Nhơn","Hoài Ân","Phù Cát","Phù Mỹ","Quy Nhơn","Tuy Phước","Tây Sơn","Vân Canh","Vĩnh Thạnh"]},{"name":"Bạc Liêu","district":["Bạc Liêu","Giá Rai","Hòa Bình","Hồng Dân","Phước Long","Vĩnh Lợi","Đông Hải"]},{"name":"Bắc Giang","district":["Bắc Giang","Hiệp Hòa","Lạng Giang","Lục Nam","Lục Ngạn","Sơn Động","Tân Yên","Việt Yên","Yên Dũng","Yên Thế"]},{"name":"Bắc Kạn","district":["Ba Bể","Bạch Thông","Bắc Kạn","Chợ Mới","Chợ Đồn","Na Rì","Ngân Sơn","Pác Nặm"]},{"name":"Bắc Ninh","district":["Bắc Ninh","Gia Bình","Lương Tài","Quế Võ","Thuận Thành","Tiên Du","Từ Sơn","Yên Phong"]},{"name":"Bến Tre","district":["Ba Tri","Bình Đại","Bến Tre","Châu Thành","Chợ Lách","Giồng Trôm","Mỏ Cày Bắc","Mỏ Cày Nam","Thạnh Phú"]},{"name":"Cao Bằng","district":["Bảo Lâm","Bảo Lạc","Cao Bằng","Hà Quảng","Hòa An","Hạ Lang","Nguyên Bình","Phục Hòa","Quảng Uyên","Thông Nông","Thạch An","Trà Lĩnh","Trùng Khánh"]},{"name":"Cà Mau","district":["Cà Mau","Cái Nước","Ngọc Hiển","Năm Căn","Phú Tân","Thới Bình","Trần Văn Thời","U Minh","Đầm Dơi"]},{"name":"Cần Thơ","district":[" Thới Lai","Bình Thủy","Cái Răng","Cờ Đỏ","Ninh Kiều","Phong Điền","Thốt Nốt","Vĩnh Thạnh","Ô Môn"]},{"name":"Gia Lai","district":["AYun Pa","An Khê","Chư Păh","Chư Pưh","Chư Sê","ChưPRông","Ia Grai","Ia Pa","KBang","Krông Pa","Kông Chro","Mang Yang","Phú Thiện","Plei Ku","Đăk Pơ","Đăk Đoa","Đức Cơ"]},{"name":"Hà Nội","district":["Ba Vì","Ba Đình","Bắc Từ Liêm","Chương Mỹ","Cầu Giấy","Gia Lâm","Hai Bà Trưng","Hoài Đức","Hoàn Kiếm","Hoàng Mai","Hà Đông","Long Biên","Mê Linh","Mỹ Đức","Nam Từ Liêm","Phú Xuyên","Phúc Thọ","Quốc Oai","Sóc Sơn","Sơn Tây","Thanh Oai","Thanh Trì","Thanh Xuân","Thường Tín","Thạch Thất","Tây Hồ","Đan Phượng","Đông Anh","Đống Đa","Ứng Hòa"]},{"name":"Hà Giang","district":["Bắc Mê","Bắc Quang","Hoàng Su Phì","Hà Giang","Mèo Vạc","Quang Bình","Quản Bạ","Vị Xuyên","Xín Mần","Yên Minh","Đồng Văn"]},{"name":"Hà Nam","district":["Bình Lục","Duy Tiên","Kim Bảng","Lý Nhân","Phủ Lý","Thanh Liêm"]},{"name":"Hà Tĩnh","district":["Can Lộc","Cẩm Xuyên","Hà Tĩnh","Hương Khê","Hương Sơn","Hồng Lĩnh","Kỳ Anh","Lộc Hà","Nghi Xuân","Thạch Hà","Vũ Quang","Đức Thọ"]},{"name":"Hòa Bình","district":["Cao Phong","Hòa Bình","Kim Bôi","Kỳ Sơn","Lương Sơn","Lạc Sơn","Lạc Thủy","Mai Châu","Tân Lạc","Yên Thủy","Đà Bắc"]},{"name":"Hưng Yên","district":["Hưng Yên","Khoái Châu","Kim Động","Mỹ Hào","Phù Cừ","Tiên Lữ","Văn Giang","Văn Lâm","Yên Mỹ","Ân Thi"]},{"name":"Hải Dương","district":["Bình Giang","Chí Linh","Cẩm Giàng","Gia Lộc","Hải Dương","Kim Thành","Kinh Môn","Nam Sách","Ninh Giang","Thanh Hà","Thanh Miện","Tứ Kỳ"]},{"name":"Hải Phòng","district":["An Dương","An Lão","Bạch Long Vĩ","Cát Hải","Dương Kinh","Hải An","Hồng Bàng","Kiến An","Kiến Thụy","Lê Chân","Ngô Quyền","Thủy Nguyên","Tiên Lãng","Vĩnh Bảo","Đồ Sơn"]},{"name":"Hậu Giang","district":["Châu Thành","Châu Thành A","Long Mỹ","Ngã Bảy","Phụng Hiệp","Vị Thanh","Vị Thủy"]},{"name":"Hồ Chí Minh","district":["Bình Chánh","Bình Thạnh","Bình Tân","Cần Giờ","Củ Chi","Gò Vấp","Hóc Môn","Nhà Bè","Phú Nhuận","Quận 1","Quận 10","Quận 11","Quận 12","Quận 2","Quận 3","Quận 4","Quận 5","Quận 6","Quận 7","Quận 8","Quận 9","Thủ Đức","Tân Bình","Tân Phú"]},{"name":"Khánh Hòa","district":["Cam Lâm","Cam Ranh","Diên Khánh","Khánh Sơn","Khánh Vĩnh","Nha Trang","Ninh Hòa","Trường Sa","Vạn Ninh"]},{"name":"Kiên Giang","district":["An Biên","An Minh","Châu Thành","Giang Thành","Giồng Riềng","Gò Quao","Hà Tiên","Hòn Đất","Kiên Hải","Kiên Lương","Phú Quốc","Rạch Giá","Tân Hiệp","U minh Thượng","Vĩnh Thuận"]},{"name":"Kon Tum","district":["Ia HDrai","Kon Plông","Kon Rẫy","KonTum","Ngọc Hồi","Sa Thầy","Tu Mơ Rông","Đăk Glei","Đăk Hà","Đăk Tô"]},{"name":"Lai Châu","district":["Lai Châu","Mường Tè","Nậm Nhùn","Phong Thổ","Sìn Hồ","Tam Đường","Than Uyên","Tân Uyên"]},{"name":"Long An","district":["Bến Lức","Châu Thành","Cần Giuộc","Cần Đước","Kiến Tường","Mộc Hóa","Thạnh Hóa","Thủ Thừa","Tân An","Tân Hưng","Tân Thạnh","Tân Trụ","Vĩnh Hưng","Đức Huệ","Đức Hòa"]},{"name":"Lào Cai","district":["Bát Xát","Bảo Thắng","Bảo Yên","Bắc Hà","Lào Cai","Mường Khương","Sa Pa","Văn Bàn","Xi Ma Cai"]},{"name":"Lâm Đồng","district":["Bảo Lâm","Bảo Lộc","Cát Tiên","Di Linh","Lâm Hà","Lạc Dương","Đam Rông","Đà Lạt","Đơn Dương","Đạ Huoai","Đạ Tẻh","Đức Trọng"]},{"name":"Lạng Sơn","district":["Bình Gia","Bắc Sơn","Cao Lộc","Chi Lăng","Hữu Lũng","Lạng Sơn","Lộc Bình","Tràng Định","Văn Lãng","Văn Quan","Đình Lập"]},{"name":"Nam Định","district":["Giao Thủy","Hải Hậu","Mỹ Lộc","Nam Trực","Nam Định","Nghĩa Hưng","Trực Ninh","Vụ Bản","Xuân Trường","Ý Yên"]},{"name":"Nghệ An","district":["Anh Sơn","Con Cuông","Cửa Lò","Diễn Châu","Hoàng Mai","Hưng Nguyên","Kỳ Sơn","Nam Đàn","Nghi Lộc","Nghĩa Đàn","Quế Phong","Quỳ Châu","Quỳ Hợp","Quỳnh Lưu","Thanh Chương","Thái Hòa","Tân Kỳ","Tương Dương","Vinh","Yên Thành","Đô Lương"]},{"name":"Ninh Bình","district":["Gia Viễn","Hoa Lư","Kim Sơn","Nho Quan","Ninh Bình","Tam Điệp","Yên Khánh","Yên Mô"]},{"name":"Ninh Thuận","district":["Bác Ái","Ninh Hải","Ninh Phước","Ninh Sơn","Phan Rang - Tháp Chàm","Thuận Bắc","Thuận Nam"]},{"name":"Phú Thọ","district":["Cẩm Khê","Hạ Hòa","Lâm Thao","Phù Ninh","Phú Thọ","Tam Nông","Thanh Ba","Thanh Sơn","Thanh Thủy","Tân Sơn","Việt Trì","Yên Lập","Đoan Hùng"]},{"name":"Phú Yên","district":["Phú Hòa","Sông Cầu","Sông Hinh","Sơn Hòa","Tuy An","Tuy Hòa","Tây Hòa","Đông Hòa","Đồng Xuân"]},{"name":"Quảng Bình","district":["Ba Đồn","Bố Trạch","Lệ Thủy","Minh Hóa","Quảng Ninh","Quảng Trạch","Tuyên Hóa","Đồng Hới"]},{"name":"Quảng Nam","district":["Bắc Trà My","Duy Xuyên","Hiệp Đức","Hội An","Nam Giang","Nam Trà My","Nông Sơn","Núi Thành","Phú Ninh","Phước Sơn","Quế Sơn","Tam Kỳ","Thăng Bình","Tiên Phước","Tây Giang","Điện Bàn","Đông Giang","Đại Lộc"]},{"name":"Quảng Ngãi","district":["Ba Tơ","Bình Sơn","Lý Sơn","Minh Long","Mộ Đức","Nghĩa Hành","Quảng Ngãi","Sơn Hà","Sơn Tây","Sơn Tịnh","Trà Bồng","Tây Trà","Tư Nghĩa","Đức Phổ"]},{"name":"Quảng Ninh","district":["Ba Chẽ","Bình Liêu","Cô Tô","Cẩm Phả","Hoành Bồ","Hạ Long","Hải Hà","Móng Cái","Quảng Yên","Tiên Yên","Uông Bí","Vân Đồn","Đông Triều","Đầm Hà"]},{"name":"Quảng Trị","district":["Cam Lộ","Gio Linh","Hướng Hóa","Hải Lăng","Quảng Trị","Triệu Phong","Vĩnh Linh","Đa Krông","Đông Hà","Đảo Cồn cỏ"]},{"name":"Sóc Trăng","district":["Châu Thành","Cù Lao Dung","Kế Sách","Long Phú","Mỹ Tú","Mỹ Xuyên","Ngã Năm","Sóc Trăng","Thạnh Trị","Trần Đề","Vĩnh Châu"]},{"name":"Sơn La","district":["Bắc Yên","Mai Sơn","Mường La","Mộc Châu","Phù Yên","Quỳnh Nhai","Sông Mã","Sơn La","Sốp Cộp","Thuận Châu","Vân Hồ","Yên Châu"]},{"name":"Thanh Hóa","district":["Bá Thước","Bỉm Sơn","Cẩm Thủy","Hoằng Hóa","Hà Trung","Hậu Lộc","Lang Chánh","Mường Lát","Nga Sơn","Ngọc Lặc","Như Thanh","Như Xuân","Nông Cống","Quan Hóa","Quan Sơn","Quảng Xương","Sầm Sơn","Thanh Hóa","Thiệu Hóa","Thường Xuân","Thạch Thành","Thọ Xuân","Triệu Sơn","Tĩnh Gia","Vĩnh Lộc","Yên Định","Đông Sơn"]},{"name":"Thái Bình","district":["Hưng Hà","Kiến Xương","Quỳnh Phụ","Thái Bình","Thái Thuỵ","Tiền Hải","Vũ Thư","Đông Hưng"]},{"name":"Thái Nguyên","district":["Phú Bình","Phú Lương","Phổ Yên","Sông Công","Thái Nguyên","Võ Nhai","Đại Từ","Định Hóa","Đồng Hỷ"]},{"name":"Thừa Thiên Huế","district":["A Lưới","Huế","Hương Thủy","Hương Trà","Nam Đông","Phong Điền","Phú Lộc","Phú Vang","Quảng Điền"]},{"name":"Tiền Giang","district":["Cai Lậy","Châu Thành","Chợ Gạo","Cái Bè","Gò Công","Gò Công Tây","Gò Công Đông","Huyện Cai Lậy","Mỹ Tho","Tân Phú Đông","Tân Phước"]},{"name":"Trà Vinh","district":["Châu Thành","Càng Long","Cầu Kè","Cầu Ngang","Duyên Hải","Tiểu Cần","Trà Cú","Trà Vinh"]},{"name":"Tuyên Quang","district":["Chiêm Hóa","Hàm Yên","Lâm Bình","Na Hang","Sơn Dương","Tuyên Quang","Yên Sơn"]},{"name":"Tây Ninh","district":["Bến Cầu","Châu Thành","Dương Minh Châu","Gò Dầu","Hòa Thành","Trảng Bàng","Tân Biên","Tân Châu","Tây Ninh"]},{"name":"Vĩnh Long","district":["Bình Minh","Bình Tân","Long Hồ","Mang Thít","Tam Bình","Trà Ôn","Vĩnh Long","Vũng Liêm"]},{"name":"Vĩnh Phúc","district":["Bình Xuyên","Lập Thạch","Phúc Yên","Sông Lô","Tam Dương","Tam Đảo","Vĩnh Tường","Vĩnh Yên","Yên Lạc"]},{"name":"Yên Bái","district":["Lục Yên","Mù Cang Chải","Nghĩa Lộ","Trạm Tấu","Trấn Yên","Văn Chấn","Văn Yên","Yên Bái","Yên Bình"]},{"name":"Điện Biên","district":["Mường Chà","Mường Lay","Mường Nhé","Mường Ảng","Nậm Pồ","Tuần Giáo","Tủa Chùa","Điện Biên","Điện Biên Phủ","Điện Biên Đông"]},{"name":"Đà Nẵng","district":["Cẩm Lệ","Hoàng Sa","Hòa Vang","Hải Châu","Liên Chiểu","Ngũ Hành Sơn","Sơn Trà","Thanh Khê"]},{"name":"Đắk Nông","district":["Cư Jút","Dăk GLong","Dăk Mil","Dăk RLấp","Dăk Song","Gia Nghĩa","Krông Nô","Tuy Đức"]},{"name":"Đồng Nai","district":["Biên Hòa","Cẩm Mỹ","Long Khánh","Long Thành","Nhơn Trạch","Thống Nhất","Trảng Bom","Tân Phú","Vĩnh Cửu","Xuân Lộc","Định Quán"]},{"name":"Đồng Tháp","district":["Cao Lãnh","Châu Thành","Huyện Cao Lãnh","Huyện Hồng Ngự","Hồng Ngự","Lai Vung","Lấp Vò","Sa Đéc","Tam Nông","Thanh Bình","Tháp Mười","Tân Hồng"]}]');

$xtpl = new XTemplate("signup.tpl", "modules/". $module_name ."/template");
$xtpl->assign('module_file', $module_file);

foreach ($position as $l1i => $l1) {
	$xtpl->assign('l1name', $l1->{name});
	$xtpl->assign('l1id', $l1i);
	$xtpl->parse('main.l1');
  foreach ($l1->{district} as $l2i => $l2) {
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
// die();
$xtpl->assign('position', json_encode($position));

if (count($userinfo) > 0) {
	// logged
	$xtpl->assign('fullname', $userinfo['fullname']);
	$xtpl->assign('mobile', $userinfo['mobile']);
	$xtpl->assign('address', $userinfo['address']);
	$xtpl->assign('image', $userinfo['image']);
	$xtpl->assign('list', userDogRowByList($userinfo['id']));

	if (!empty($user_info) && !empty($user_info['userid']) && (in_array('1', $user_info['in_groups']) || in_array('2', $user_info['in_groups']))) {
		$xtpl->assign('userlist', userRowList());
	
		$xtpl->parse('main.log.user');
		$xtpl->parse('main.log.mod');
		$xtpl->parse('main.log.mod2');
	}

	$xtpl->parse('main.log');
}
else {
	$xtpl->parse('main.nolog');
}

$xtpl->assign('origin', '/' . $module_name . '/' . $op . '/');

$xtpl->parse("main");
$contents = $xtpl->text("main");
include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_name ."/layout/footer.php");
