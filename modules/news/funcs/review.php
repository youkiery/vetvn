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

$userinfo = getUserinfo();

$action = $nv_Request->get_string('action', 'post', '');
$result = array('status' => 0);
if (!empty($action)) {
	switch ($action) {
		case 'send-review':
      $username = $nv_Request->get_string('username', 'post', '');
      $content = $nv_Request->get_string('content', 'post', '');

      $userid = 0;
      if (!empty($userinfo)) {
        $userid = $userinfo['id'];
        $username = '';
      }

      $sql = 'insert into `'. PREFIX .'_review` (userid, username, content, time) values ('. $userid .', "'. $username .'", "'. $content .'", '. time() .')';
      if ($db->query($sql)) {
        $result['status'] = 1;
        $result['notify'] = 'Đã gửi thư góp ý';
      }

		break;
	}
}

echo json_encode($result);
die();