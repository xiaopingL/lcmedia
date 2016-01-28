<?php
/**
 * @desc 广告排期表
 * @author xiaoping <lxp_phper@163.com>
 * @date 2016-1-18
 */
class LinedController extends MY_Controller {
	
    protected $table = 'crm_ad_lined';
    const MENU_LIST  = "media/LinedController/linedList";

    public function  __construct() {
        parent::__construct();
        $this->load->model('media/AdvertModel','',true);
    }

    public function linedList() {
        $where = $urlArray = array();
        $urlStr = $whereStr = '';
        $data = $this->View('media');

        if(!in_array('allAdLined',$data['userOpera'])) {
            $where[] = "a.operator in".$this->uIdDispose();
        }

        $username = trim($this->input->get_post('username',true));      //获取姓名
        $name = trim($this->input->get_post('name',true));
        $sTime = $this->input->get_post('sTime',true);
        $eTime = $this->input->get_post('eTime',true);
        $sTime1 = strtotime($sTime);
        $eTime1 = strtotime($eTime);
        
        if(!empty($name)){
            $list['name'] = $name;
            $urlArray[] = 'name='.$name;
            $where[] = ' c.name like '."'%".$name."%'";
        }
        if(!empty($sTime1)) {
        	$list['sTime'] = $sTime;
            $where[] = ' a.createTime >='.$sTime1;
            $urlArray[] = 'sTime='.$sTime;
        }
        if(!empty($eTime1)) {
        	$list['eTime'] = $eTime;
            $where[] = ' a.createTime <='.$eTime1;
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
        $modelArray['sqlTplFucName'] = 'linedList';
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
        $list['getResult']  = $this->AdvertModel->linedList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        
        $data['content'] = $this->load->view('media/linedListView',$list,true);
        $this->load->view('index/index',$data);
    }

    public function linedAdd(){
    	$data = $this->View('media');
    	if($this->input->post('submitCreate') != FALSE){
    		$customerName = trim($this->input->post('name'));
    		$customerInfo = $this->PublicModel->selectSave('sId','crm_studio',array('name'=>$customerName,'isDel'=>0),1);
    		if(empty($customerInfo)){
    			$this->showMsg(2,'该影城不存在，请核对影城名称或创建新影城！'); exit;
    		}
    		
    	    $result = array(
    	        'studioId' => $customerInfo['sId'],
    	        'title' => $this->input->post('title'),
    	        'month' => $this->input->post('month'),
    	        'days' => $this->input->post('days'),
    	        'startDate' => strtotime($this->input->post('startDate')),
    	        'endDate' => strtotime($this->input->post('endDate')),
    	        'content' => $this->input->post('content'),
    	        'overplus_min' => $this->input->post('overplus_min'),
	    	    'overplus_sec' => $this->input->post('overplus_sec'),
    	        'operator' => $this->session->userdata('uId'),
	    	    'createTime' => time(),
    	    );
    	    
    	    $checkWhere = array(
    	        'isDel' => 0,
    	        'studioId' => $result['studioId'],
    	        'startDate <=' => $result['endDate'],
    	        'endDate >=' => $result['startDate'],
    	    );
    	    
    	    $checkLined = $this->PublicModel->selectSave('sId',$this->table,$checkWhere,3);
    	    if($checkLined > 0){
    	    	$this->showMsg(2,'该影城在所选排期时间内已经存在排期！'); exit;
    	    }
    	    
    	    $result['title'] = '领程传媒'.$result['month'].'月'.$result['days'].'日广告排期表';

    	    $signal = $this->PublicModel->insertSave($this->table,$result);
    	    if($signal != FALSE){
    	    	$this->showMsg(1,'排期表提交成功！',self::MENU_LIST);
    	    }else{
    	    	$this->showMsg(2,'提交失败！');
    	    }
    	}
    	
    	$dVal['putName'] = 'name';
        $dVal['idName'] = 'cId';
        $list['public_view_js'] = $this->load->view('index/public_view_js',$dVal,true);
    	$data['content'] = $this->load->view('media/linedAddView',$list,true);
        $this->load->view('index/index',$data);
    }
    
    public function linedEdit($editId){
    	$data = $this->View('media');
    	if($this->input->post('submitCreate') != FALSE){
    	    $result = array(
    	        'month' => $this->input->post('month'),
                'days' => $this->input->post('days'),
                'startDate' => strtotime($this->input->post('startDate')),
                'endDate' => strtotime($this->input->post('endDate')),
                'content' => $this->input->post('content'),
                'overplus_min' => $this->input->post('overplus_min'),
                'overplus_sec' => $this->input->post('overplus_sec'),
    	    );
    	    
    	    $result['title'] = '领程传媒'.$result['month'].'月'.$result['days'].'日广告排期表';

    	    $signal = $this->PublicModel->updateSave($this->table,array('sId'=>$editId),$result);
    	    if($signal != FALSE){
    	    	$this->showMsg(1,'排期表修改成功',self::MENU_LIST);
    	    }else{
    	    	$this->showMsg(2,'提交失败！');
    	    }
    	}
    	
        $list = $this->AdvertModel->getLinedInfo($editId);
    	$data['content'] = $this->load->view('media/linedEditView',$list,true);
        $this->load->view('index/index',$data);
    }
    
    public function linedDetail($detailId){
    	$data = $this->View('media');
    	$parameter = $this->AdvertModel->getLinedInfo($detailId);

        $data['content'] = $this->load->view('media/linedDetailView',$parameter,true);
        $this->load->view('index/index',$data);
    }
    
    public function linedDel($delId) {
        $signal = $this->PublicModel->updateSave($this->table,array('sId'=>$delId),array('isDel'=>1));
        if($signal != FALSE) {
            $this->showMsg(1,'信息删除成功',self::MENU_LIST);
        }else {
            $this->showMsg(2,'信息删除失败！');
        }
    }
    

}
?>
