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

$page_title = "Lấy lại mật khẩu";

$action = $nv_Request->get_string('action', 'post', '');
$userinfo = getUserInfo();
if (!empty($userinfo)) {
  if (!empty($userinfo['center'])) {
    header('location: /'. $module_name .'/center');
  }
  else {
    header('location: /'. $module_name .'/private');
  }
}

include '/assets/js/PHPMailer/Exception.php';
include '/assets/js/PHPMailer/OAuth.php';
include '/assets/js/PHPMailer/PHPMailer.php';
include '/assets/js/PHPMailer/POP3.php';
include '/assets/js/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$rkey = $_SESSION['rkey'];
$rtime = $_SESSION['rtime'];
$userid = $_SESSION['userid'];
$passing = $_SESSION['passing'];
$time = time();

if (!empty($action)) {
	$result = array('status' => 0);
	switch ($action) {
    case 'recover':
			$keyword = $nv_Request->get_string('keyword', 'post', '');

      if (empty($keyword)) {
        $result['error'] = 'Các trường không được trống';
      }
      else {
        $keyword = strtolower($keyword);
        $sql = 'select * from `'. PREFIX .'_user` where username = "'. $keyword .'" or mail = "'. $keyword .'"';
        $query = $db->query($sql);

        if (!empty($row = $query->fetch())) {
          if (empty($row['mail'])) {
            $result['error'] = 'Lỗi: Tài khoản Không có email';
          }
          else if (!filter_var($row['mail'], FILTER_VALIDATE_EMAIL)) {
            $result['error'] = 'Lỗi: Email tài khoản không hợp lệ';
          }
          else {
            $rkey = generateRandomString();
            $rtime = time() + 60 * 60 * 24 * 6;
            $_SESSION['rkey'] = $rkey;
            $_SESSION['rtime'] = $rtime;
            $_SESSION['userid'] = $row['id'];
            $_SESSION['passing'] = 0;

            $mail = new PHPMailer(true); 
            try {
              //Server settings
              $mail->SMTPDebug = 2;                                 // Enable verbose debug output
              $mail->isSMTP();                                      // Set mailer to use SMTP
              $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
              $mail->SMTPAuth = true;                               // Enable SMTP authentication
              $mail->Username = 'petcoffee.com@gmail.com';                 // SMTP username
              $mail->Password = 'petxuan2014';                           // SMTP password
              // $mail->Username = 'youkiery@gmail.com';                 // SMTP username
              // $mail->Password = 'Gmyk.2511';                           // SMTP password
              $mail->SMTPSecure = 'tsl';                            // Enable TLS encryption, `ssl` also accepted
              $mail->Port = 587;                                    // TCP port to connect to
          
              // //Recipients
              $mail->setFrom('petcoffee.com@gmail.com', 'He thong');
              $mail->addAddress($row['mail'], 'Nguoi dung');     // Add a recipient
              // // $mail->addAddress('ellen@example.com');               // Name is optional
              // // $mail->addReplyTo('info@example.com', 'Information');
              // // $mail->addCC('cc@example.com');
              // // $mail->addBCC('bcc@example.com');
          
              // //Content
              $mail->isHTML(true);                                  // Set email format to HTML
              $mail->Subject = 'Vetvn.com - Lay lai mat khau';
              $mail->Body    = 'Truy cap duong link de lay lai mat khau: <a href="vetvn.com/news/losspass">http://vetvn.com/news/losspass</a><br>Ma xac nhan: '. $rkey .'<br>Đường link có hiệu lực dưới 6h';
          
              $mail->send();
              $result['status'] = '1';
              $result['error'] = '';
              $result['notify'] = 'Đã gửi mail lấy lại mật khẩu tới email đăng ký';
            } catch (Exception $e) {
              $result['error'] = 'Lỗi: Hệ thống không thể gửi mail, xin hãy liên lạc với ban quản trị';
            }
          }
        }
      }
    break;
    case 'checking-key':
			$keyword = $nv_Request->get_string('keyword', 'post', '');

      if ($keyword == $_SESSION['rkey']) {
        $_SESSION['rkey'] = '';
        $_SESSION['rtime'] = 0;
        $_SESSION['passing'] = 1;
        $result['status'] = 1;
      }
      else {

      }
    break;
    case 'change-pass':
      $npass = $nv_Request->get_string('npass', 'post', '');
      $userid = $_SESSION['userid'];

      if (empty($npass)) {
        $result['notify'] = 'Mật khẩu không được trống';
      }
      else {
        $sql = 'select * from `'. PREFIX .'_user` where id = ' . $userid;
        $query = $db->query($sql);

        if (empty($query->fetch())) {
          $result['notify'] = 'Người dùng không tồn tại';
        }
        else {
          $sql = 'update `'. PREFIX .'_user` set password = "'. md5($npass) .'" where id = ' . $userid;
          if ($db->query($sql)) {
            $_SESSION['passing'] = 0;
            $_SESSION['userid'] = 0;
            $result['status'] = 1;
            $result['notify'] = 'Đã đổi mật khẩu';
          }
        }
      }
    break;
	}
	echo json_encode($result);
	die();
}

$xtpl = new XTemplate("main.tpl", PATH2);
$xtpl->assign('origin', '/' . $module_name . '/' . $op . '/');
$xtpl->assign('module_file', $module_file);
// var_dump($_SESSION);die();

if (!empty($passing)) {
  $xtpl->parse('main.checked');
  $xtpl->parse('main.nonchecked');
}
else if (empty($rkey) || empty($rtime) || $rtime < $time || empty($owner = getOwnerById($userid))) {
  $xtpl->parse('main.nonchecked');
  $xtpl->parse('main.end');
}
else {
  $xtpl->parse('main.nonchecked');
  $xtpl->parse('main.checking');
}

$xtpl->parse("main");
$contents = $xtpl->text("main");
include ("modules/". $module_file ."/layout/header.php");
echo $contents;
include ("modules/". $module_name ."/layout/footer.php");
