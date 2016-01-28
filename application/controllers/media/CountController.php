<?php
/**
 * @desc 影城数据统计
 * @author xiaoping <lxp_phper@163.com>
 * @date 2016-1-27
 */
class CountController extends MY_Controller {
	
    protected $table = 'crm_ad_count';
    const MENU_LIST  = "media/CountController/countList";
    const MENU_ADD   = "media/CountController/countAdd";

    public function  __construct() {
        parent::__construct();
        $this->load->model('media/AdvertModel','',true);
    }

    public function countList() {
        $where = $urlArray = array();
        $urlStr = $whereStr = '';
        $data = $this->View('media');

        if(!in_array('allAdCount',$data['userOpera'])) {
            $where[] = "a.operator in".$this->uIdDispose();
        }

        $username = trim($this->input->get_post('username',true));      //获取姓名
        $name = trim($this->input->get_post('name',true));
        $sTime = $this->input->get_post('sTime',true);
        $eTime = $this->input->get_post('eTime',true);
        
        $sTime_arr = explode(' ',$sTime);
        $eTime_arr = explode(' ',$eTime);
        
        $sTime1 = strtotime($sTime_arr[0].'-'.$sTime_arr[1].'-01');
        $eTime1 = strtotime($eTime_arr[0].'-'.$eTime_arr[1].'-01');
        
        if(!empty($name)){
            $list['name'] = $name;
            $urlArray[] = 'name='.$name;
            $where[] = ' c.name like '."'%".$name."%'";
        }
        if(!empty($sTime1)) {
        	$list['sTime'] = $sTime;
            $where[] = ' a.countDate >='.$sTime1;
            $urlArray[] = 'sTime='.$sTime;
        }
        if(!empty($eTime1)) {
        	$list['eTime'] = $eTime;
            $where[] = ' a.countDate <='.$eTime1;
            $urlArray[] = 'eTime='.$eTime;
        }
        //搜索姓名
        if(!empty($username)) {
        	$list['username'] = $username;
            $urlArray[] = 'username='.$username;
            $where[] = ' b.userName like '."'%".$username."%'";
        }

        //拼接查询条件
        if(!empty($urlArray)) {
            $urlStr = '/?'.implode('&', $urlArray);
        }
        if(!empty($where)) {
            $whereStr = ' and '.implode(" and ",$where);
        }
        $modelArray['modelPath'] = 'media';
        $modelArray['modelName'] = 'AdvertModel';
        $modelArray['sqlTplName'] = 'publicSql';
        $modelArray['sqlTplFucName'] = 'countList';
        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);
        $argument	= array(
                'base_url'      => self::MENU_LIST,
                'per_page'		=> 12,
                'num_links'		=> 3,
                'uri_segment'	=> 4,
                'total_rows'    => $rows,
        );
        $getPaginDatas		= $this->createPagination($argument,$urlStr);
        $list['pagination']	= $getPaginDatas['pagination'];
        $list['rows']       = $rows;
        $list['getResult']  = $this->AdvertModel->countList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        
        $data['content'] = $this->load->view('media/countListView',$list,true);
        $this->load->view('index/index',$data);
    }

    public function countAdd(){
    	$data = $this->View('media');
    	if($this->input->post('submitCreate') != FALSE){
    		$customerName = trim($this->input->post('name'));
    		$customerInfo = $this->PublicModel->selectSave('sId','crm_studio',array('name'=>$customerName,'isDel'=>0),1);
    		if(empty($customerInfo)){
    			$this->showMsg(2,'该影城不存在，请核对影城名称或创建新影城！'); exit;
    		}
    		
    		$countDate = explode(' ',$this->input->post('countDate'));
    		
    	    $result = array(
    	        'studioId' => $customerInfo['sId'],
    	        'countDate' => strtotime($countDate[0].'-'.$countDate[1].'-01'),
    	        'box_num' => intval($this->input->post('box_num')),
    	        'person_num' => intval($this->input->post('person_num')),
    	        'advert_num' => intval($this->input->post('advert_num')),
    	        'film_num' => intval($this->input->post('film_num')),
    	        'operator' => $this->session->userdata('uId'),
	    	    'createTime' => time(),
    	    );
    	    
    	    $checkWhere = array(
    	        'isDel' => 0,
    	        'studioId' => $result['studioId'],
                'countDate' => $result['countDate']
    	    );
    	    
    	    $checkMonitor = $this->PublicModel->selectSave('sId',$this->table,$checkWhere,3);
    	    if($checkMonitor > 0){
    	    	$this->showMsg(2,'该影城所在月份已经存在记录！'); exit;
    	    }

    	    $signal = $this->PublicModel->insertSave($this->table,$result);
    	    if($signal != FALSE){
    	    	$this->showMsg(1,'提交成功！',self::MENU_ADD);
    	    }else{
    	    	$this->showMsg(2,'提交失败！');
    	    }
    	}
    	
    	$dVal['putName'] = 'name';
        $dVal['idName'] = 'cId';
        $list['public_view_js'] = $this->load->view('index/public_view_js',$dVal,true);
    	$data['content'] = $this->load->view('media/countAddView',$list,true);
        $this->load->view('index/index',$data);
    }
    
    public function countDel($delId) {
        $signal = $this->PublicModel->updateSave($this->table,array('sId'=>$delId),array('isDel'=>1));
        if($signal != FALSE) {
            $this->showMsg(1,'信息删除成功',self::MENU_LIST);
        }else {
            $this->showMsg(2,'信息删除失败！');
        }
    }
    

}
?>
