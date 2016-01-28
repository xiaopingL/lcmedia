<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['attendance'] = array(
    'AnnounceController/announceList/?type=1'=>'公告',
    'AnnounceController/announceList/?type=2'=>'通知',
);

$config['journalType'] = array(
    'public/JournalController/journalListView'=>'后台工作日志',
    'public/DailyController/dailyListView'=>'业务工作日志',
	'public/ReportController/reportListView/?type=week'=>'工作周报',
	'public/ReportController/reportListView/?type=month'=>'工作月报',
);

$config['dailyShape'] = array(
    '1'=>'面谈',
    '2'=>'电话',
    '3'=>'微信',
    '4'=>'QQ',
);

$config['speedPro'] = array(
    '1'=>'5%',
    '2'=>'10%',
    '3'=>'15%',
    '4'=>'20%',
    '5'=>'25%',
    '6'=>'30%',
    '7'=>'35%',
    '8'=>'40%',
    '9'=>'45%',
    '10'=>'50%',
    '11'=>'55%',
    '12'=>'60%',
    '13'=>'65%',
    '14'=>'70%',
    '15'=>'75%',
    '16'=>'80%',
    '17'=>'85%',
    '18'=>'90%',
    '19'=>'95%',
    '20'=>'100%',
);


?>