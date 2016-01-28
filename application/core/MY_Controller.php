<?php
/**
 * @desc 核心控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-07-08
 */
class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->PublicModel->authenticate();         //登录权限控制
    }

    public function View($type) {
        $data['base_url'] = base_url();
        $data['in'] = 'in';
        $data['type'] = $type;
        $data['inClass'] = $this->uri->rsegment(2);
        $data['title'] = "领程传媒企业资源管理系统";
        $data['position']   = array('5'=>'员工', '4'=> '主管','3'=>'经理','2'=>'总监', '1'=>'总经理');
        $data['allRole']    = $this->PublicModel->getAllRole(0);
        $data['userRole']   = $this->PublicModel->getUserRole();
        $data['userOpera']  = $this->PublicModel->getUserOpera();
        $data['directory']  = $this->PublicModel->getDirectory($data['inClass'],0);
        $data['navbar']  = $this->load->view('index/navbar',null,true);
        $data['sidebar'] = $this->load->view('index/sidebar',$data,true);
        return $data;
    }

    public function showMsg($status,$info,$nexturl='',$data='') {
        $op_success	= '<img src="'.base_url().'img/success.png" border="0" align="absmiddle" />';
        $op_failure	= '<img src="'.base_url().'img/failure.png" border="0" align="absmiddle" />';
        if($status == 1) {
            $message = $op_success.$info;
        }else {
            $message = $op_failure.$info;
        }
        $this->session->set_flashdata('suggestion',$message);
        if($nexturl == '') {
            $nexturl	= isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
            header("Location: ".$nexturl);
        }else {
            redirect($nexturl);
        }
    }

    public function createPagination($argument,$urlStr='') {
        $paginationDatas		= array();

        $config['base_url']		= $this->getFixedURL($argument['base_url']);
        $config['first_link']	= '第一页';
        $config['prev_link'] 	= '前一页';
        $config['next_link'] 	= '下一页';
        $config['last_link'] 	= '最后一页';

        $config['cur_tag_open'] = '<a class="p_curpage">';
        $config['cur_tag_close']= '</a>';

        $config['num_links']	= $argument['num_links'];
        $config['uri_segment']	= $argument['uri_segment'];
        $config['total_rows']	= $argument['total_rows'];
        $config['per_page']	= $argument['per_page'];

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $paginationDatas['pagination']	= $this->pagination->create_links($urlStr);

        if($this->uri->segment($argument['uri_segment']) > $argument['total_rows']) {
            $page	= (int)($argument['total_rows']/$argument['per_page']);
        }elseif(is_numeric($this->uri->segment($argument['uri_segment']))) {
            $page	= $this->uri->segment($argument['uri_segment']);
        }else
            $page 	= 0;

        $paginationDatas['start']		= $page;
        $paginationDatas['offset']		= $argument['per_page'];
        return $paginationDatas;
    }

    public function getFixedURL($uriSegment) {
        if(index_page() == '')
            return base_url().$uriSegment;
        else
            return base_url().index_page().'/'.$uriSegment;
    }

    /**
     * @param 去除空格
     */
    function _clearSpace($str,$all=true) {
        if($all==true) {//去除所有空格
            Return preg_replace("/[\s]{2,}/","",trim($str) );
        }else {//去除头尾空格。正文连续空格为一个
            Return preg_replace("!( ){2,}!s"," ",trim($str));
        }
    }

    /**
     * @param 数组转换
     */
    function converArr($array,$key) {
        $newArray = array();
        if(!is_array($array)) {
            return false;
        }
        foreach($array as $k=>$value) {
            $newArray[] = $value[$key];
        }
        return $newArray;
    }

    function array_multiTwosingle($array) {
        static $result_array=array();
        foreach($array as $key=>$value) {
            if(is_array($value)) {
                $this->array_multiTwosingle($value);
            }
            else
                $result_array[$key]=$value;
        }
        return $result_array;
    }
    
    /**
     * @param 去除二维数组中重复数据
     */
    public function remove_duplicate($array) {
        $result=array();
        for($i=0;$i<count($array);$i++) {
            $source=$array[$i];
            if(array_search($source,$array)==$i && $source<>"" ) {
                $result[]=$source;
            }
        }
        return $result;
    }
    
    /**
     * @param $comCode  操作权限代码
     */
    public function operaControl($comCode) {
        $operaList= $this->PublicModel->getUserOpera();
        if(!in_array($comCode,$operaList)) {
            $this->showMsg(2,'没有操作权限！');
            exit;
        }
    }

    /**
     * @param 获取所有用户信息
     */
    public function getAllUserInfo() {
        $this->load->model('admin/UserModel','',true);
        $allUserInfo = $this->UserModel->getAllUserInfo();
        foreach($allUserInfo as $v){
            $allUserInfoArray[$v['uId']] = $v['userName'];
        }
        return $allUserInfoArray;
    }

    /**
     * @param 获取在职用户信息
     */
    public function getOnUserInfo() {
        $this->load->model('admin/UserModel','',true);
        $getUserInfo = $this->UserModel->getOnUserInfo();
        foreach($getUserInfo as $v) {
            $getUserInfoArray[$v['uId']] = $v['userName'];
        }
        return $getUserInfoArray;
    }

    /**
     * @parm 获取所有组织架构信息
     */
    public function getAllStructrue() {
        $this->load->model('admin/OrgModel','',true);
        $allStructrue = $this->OrgModel->getAllStructrue();
        foreach($allStructrue as $val) {
            $allStructrueArray[$val['sId']] = $val['name'];
        }
        return $allStructrueArray;
    }


    /**
     * @param 获取所有组织架构人员对应的SID
     */
    public function getAllSidStructrue() {
        $this->load->model('admin/OrgModel','',true);
        $allSidStructrue = $this->OrgModel->getAllSidStructrue();
        foreach($allSidStructrue as $v) {
            $allSidStructrueArray[$v['uId']] = $v['sId'];
        }
        return $allSidStructrueArray;
    }

    /**
     * @param 获取所有人员组织架构 siteId信息
     */
    public function getAllUserJobIdSiteId() {
        $this->load->model('admin/UserModel','',true);
        $allUserInfo = $this->UserModel->getAllUserJobIdSiteId();
        foreach($allUserInfo as $v){
            $allUserInfoArray[$v['siteId']][] = $v['uId'];
        }
        return $allUserInfoArray;
    }
    
    /**
     * @param 获取客户信息
     */
    public function getClientInfoArray() {
        $this->load->model('business/CustomerModel','',true);
        $clientInfo = $this->CustomerModel->getAllClientInfo();
        foreach($clientInfo as $v) {
            $clientInfoArray[$v['cId']] = $v['name'];
         }
        return $clientInfoArray;
    }
    
    /**
     * @param 获取影城信息
     */
    public function getStudioInfoArray() {
        $this->load->model('media/StudioModel','',true);
        $studioInfo = $this->StudioModel->getAllStudioInfo();
        foreach($studioInfo as $v) {
            $studioInfoArray[$v['sId']] = $v['name'];
         }
        return $studioInfoArray;
    }

    /**
     * @param 附件上传统一调用
     */
    public function uploadFile($field = 'userfile') {
        if($_FILES[$field]['size'] > 1024*1024*10) {
            $this->showMsg(2,'附件大小不能超过10M！');
            exit;
        }

        $upload_config	= $this->config->item('upload_config');
        $upload_config['upload_path'] = makeDir($this->config->item('upload_path'));
        $this->load->library('upload', $upload_config);
        if (!$this->upload->do_upload($field))
            $upload_data = $this->upload->display_errors();
        else
            $upload_data = $this->upload->data();
        if(!is_array($upload_data)){
            echo "<script language=javascript>alert('$upload_data!');history.go(-1);</script>";
            die();
        }

        $result	= array(
                'fileName'		=> $upload_data['file_name'],
                'filePath'		=> $upload_data['file_path'],
                'origName'		=> str_replace("—","-",$upload_data['orig_name']),
                'fileExt'		=> $upload_data['file_ext'],
                'fileSize'		=> $upload_data['file_size'],
        );
        $signal = $this->PublicModel->insertSave('crm_file',$result);
        return $signal;
    }

    public function uIdDispose($checkId='') {
        $uId = '';
        $uIdArray = $this->getUserUidContract();

        if(!empty($uIdArray)) {
            if($this->session->userdata['jobId'] == 5) {
                $uId = str_replace('a.operator=', '(', implode(" and ",$uIdArray).')');
            }elseif ($this->session->userdata['jobId'] == 1) {
                if(empty($checkId)) {
                    $uId = str_replace('a.salesmanId in', '', implode(" and ",$uIdArray));
                }else {
                    $uId = str_replace('a.'.$checkId.' in', '', implode(" and ",$uIdArray));
                }
            }else {
                $uId = str_replace('a.operator in ', '', implode(" and ",$uIdArray));
            }
        }
        return $uId;
    }
    
    public function getUserUidContract($checkId='') {
        $where = array();
        switch($this->session->userdata['jobId']) {
            case 5:
                $where[] = ' a.operator='.$this->session->userdata['uId'];
                break;
            case 3:
            case 4:
                $sIdArray = $this->PublicModel->getAllOrgSublevel($arrayList=array(),$this->session->userdata['sId'],0);
                if(!empty($sIdArray)) {
                    $sIdStr = implode(',', $sIdArray);
                }else {
                    $sIdStr = $this->session->userdata['sId'];
                }
                $uIdArray = $this->PublicModel->getContactAllUid($sIdStr,0);
                $uIdArray[]['uId'] = $this->session->userdata['uId'];
                $uIdAssemble = $this->converArr($uIdArray,'uId');
                $where[] = ' a.operator in ('.implode(',', $uIdAssemble).')';
                break;
            case 2:
                $sIdArray = $this->PublicModel->getAllOrgSublevel($arrayList=array(),$this->session->userdata['sId'],0);
                if(!empty($sIdArray)) {
                    $sIdStr = implode(',', $sIdArray);
                }else {
                    $sIdStr = $this->session->userdata['sId'];
                }

                $uIdArray = $this->PublicModel->getContactAllUid($sIdStr,0);
                $uIdArray[]['uId'] = $this->session->userdata['uId'];
                $uIdAssemble = $this->converArr($uIdArray,'uId');
                $where[] = ' a.operator in ('.implode(',', $uIdAssemble).')';
                break;
            case 1:
                $sIdArray = $this->PublicModel->getAllOrgSublevel($arrayList=array(),$this->session->userdata['sId'],0);
                if(!empty($sIdArray)) {
                    $sIdStr = implode(',', $sIdArray);
                }else {
                    $sIdStr = $this->session->userdata['sId'];
                }
                $uIdArray = $this->PublicModel->getContactAllUid($sIdStr,0);
                $uIdArray[]['uId'] = $this->session->userdata['uId'];

                $uIdAssemble = $this->converArr($uIdArray,'uId');
                //此处解决字段兼容性问题 uId
                if(!empty($checkId)) {
                    $where[] = ' a.'.$checkId.' in ('.implode(',', $uIdAssemble).')';
                }else {
                    $where[] = ' a.salesmanId in ('.implode(',', $uIdAssemble).')';
                }
                break;
        }
        return $where;
    }
    
    public function getWeek(){
   	    $firstday = date('Y-m-01', strtotime(date('Y').'-'.(date('m')-1).'-01'));
        $lastday  = date('Y-m-d', strtotime("$firstday +1 month -1 day"));

        $start_time = strtotime($firstday);
        $end_time   = strtotime($lastday);
	    while($start_time<=$end_time){
		   $date_arr[] = date('Y-m-d',$start_time);
		   $start_time = strtotime('+1 day',$start_time);
		}

        $flag = 0;
        $week = 0;
        $str  = '';
        foreach($date_arr as $key=>$val){
        	if(date('w',strtotime($val)) == 1){
        		$flag++;
        	}
        }

        $firstday2 = date('Y-m-01', strtotime(date('Y-m-d')));
        $lastday2  = date('Y-m-d', strtotime("$firstday1 +1 month -1 day"));

        $start_time2 = strtotime($firstday2);
        $end_time2   = strtotime($lastday2);
	    while($start_time2<=$end_time2){
		   $date_arr2[] = date('Y-m-d',$start_time2);
		   $start_time2 = strtotime('+1 day',$start_time2);
		}

        foreach($date_arr2 as $key=>$val){
        	if(date('w',strtotime($val)) == 1){
        		$date[] = $val;
        	}
        }

		$month = date('m', time()); // 获取本月
        $year = date('Y', time()); // 获取本年
        $firstday = date('w', mktime(0, 0, 0, $month, 1, $year)); //本月1号星期数
        $firstweek = 7 - $firstday; // 第1周天数

        if($firstweek<6 && strtotime(date('Y-m-d'))<strtotime($date[0])){
        	$week = $flag;
        	if(date('m') == 1){
        		$m = 13;
        		$str = (date('Y')-1).'年'.($m-1).'月第'.$week.'周';
        	}else{
        		$m = date('m');
        		if($m>10){
        		   $str = date('Y').'年'.($m-1).'月第'.$week.'周';
        		}else{
        		   $str = date('Y').'年'.'0'.($m-1).'月第'.$week.'周';
        		}
        	}
        }else{
            foreach($date as $key=>$val){
            	if(strtotime(date('Y-m-d'))>=strtotime($val)){
            		$week++;
            	}
            }
            $str = date('Y').'年'.date('m').'月第'.$week.'周';
        }
        return $str;
   }


}

?>
