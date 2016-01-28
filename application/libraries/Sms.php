<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/***********************************************
 * 短信发送类库
 *********************************************
 * @author wudi <thewendy@sina.com> 2012-08
 *********************************************
 * @copyright 合肥同步营销策划有限公司
 **********************************************/


	/*
	 使用案例：
	 $phone		=	'13888888888';
	 // $phone	='13888888888,13966666666,15111111111';	// 新增批量发送功能,以英文逗号分隔 (一次最大20个号码)
	 $content	=	'新短信接口测试送达率,短信发送时间为：'.date('H:i:s',time()).'【合房网】';
	 $ReturnStr = Sms::SendSms($phone,$content);
	*/

@date_default_timezone_set('Asia/Shanghai');
class Sms {
	const EPID 		  = 734;		//企业账号
	const USERNAME	  = 'hefang';	//用户名
	const PASSWORD	  = '75ea57f153e298be';	//密码 75ea57f153e298be
	const POSTURL	  = "http://61.191.26.181:8888/SmsPort.asmx/SendSms";	//提交接口
	static function SendSms($phone, $content){
		if(is_array($phone)){	//数组转换为组合字符串
			$phone = implode(',',$phone);
		}
		//$content=iconv("gbk",'utf-8',$content);
		$postfield="Epid=".self::EPID."&User_Name=".self::USERNAME."&password=".self::PASSWORD."&phone=".$phone."&content=".$content."";
		$user_agent ="Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; SV1)";
		$ch = curl_init();    // 初始化CURL句柄
		curl_setopt($ch, CURLOPT_URL, self::POSTURL); //设置请求的URL
		 //curl_setopt($ch, CURLOPT_FAILONERROR, 1); // 启用时显示HTTP状态码，默认行为是忽略编号小于等于400的HTTP信息
		 //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//启用时会将服务器服务器返回的"Location:"放在header中递归的返回给服务器
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);// 设为TRUE把curl_exec()结果转化为字串，而不是直接输出
		curl_setopt($ch, CURLOPT_POST, 1);//启用POST提交
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfield); //设置POST提交的字符串
		 //curl_setopt($ch, CURLOPT_PORT, 80); //设置端口
		curl_setopt($ch, CURLOPT_TIMEOUT, 25); // 超时时间
		curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);//HTTP请求User-Agent:头
		 //curl_setopt($ch,CURLOPT_HEADER,1);//设为TRUE在输出中包含头信息
		 //$fp = fopen("example_homepage.txt", "w");//输出文件
		 //curl_setopt($ch, CURLOPT_FILE, $fp);//设置输出文件的位置，值是一个资源类型，默认为STDOUT (浏览器)。
		curl_setopt($ch,CURLOPT_HTTPHEADER,array(
			'Accept-Language: zh-cn',
			'Connection: Keep-Alive',
			'Cache-Control: no-cache'
		));//设置HTTP头信息
		$document = curl_exec($ch); //执行预定义的CURL
		$info=curl_getinfo($ch); //得到返回信息的特性
		curl_close($ch);

		if(strpos($document,'00')){
			return 'Result=0'.';ResturnNum:00;Str:Send Success;Sendtime:'.time();
		}elseif(preg_match('/^00$/i','00')=='99'){
			return 'ResturnNum:99;Str:Shield Word';
		}else{
			return $document;
		}
	}
	static function IsMobile($no) {
		return preg_match ( '/^1[3458][\d]{9}$/', $no ) || preg_match ( '/^0[\d]{10,11}$/', $no );
	}
}