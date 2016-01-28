<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['leaveType'] = array(
    '1'=>'事假',
    '2'=>'病假',
    '3'=>'婚假',
    '4'=>'产假',
    '5'=>'丧假',
	'6'=>'年假'
);

$config['falsesignType'] = array(
    '1'=>'上班',
    '2'=>'下班',
    '3'=>'全天',
);

$config['political'] = array(
    '1'=>'团员',
    '2'=>'党员',
    '3'=>'民主党派',
    '4'=>'其他',
);

$config['marriage'] = array(
    '1'=>'未婚',
    '2'=>'已婚',
    '3'=>'离异',
    '4'=>'丧偶',
);

$config['blood'] = array(
    '1'=>'A型',
    '2'=>'B型',
    '3'=>'O型',
    '4'=>'AB型',
    '5'=>'其他',
);

$config['education'] = array(
    '1'=>'初中',
    '2'=>'高中',
    '3'=>'中专',
    '4'=>'大专',
    '5'=>'本科',
    '6'=>'双学士',
    '7'=>'硕士',
    '8'=>'博士及以上',
);

$config['attendance']=array(
    'OverworkController/overworkListView'=>'加班单',
    'LeaveController/leaveListView'=>'请假单',
    'FalsesignController/falsesignListView'=>'误打卡单',
    'AttendController/holidayList'=>'公休日设置',
);

?>