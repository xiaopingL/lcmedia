<?php
/**
 * @desc 客户管理控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-08-18
 */
class CustomerController extends MY_Controller {
	
    protected $CustomerArray = array();
    protected $table = 'crm_client_relation';
    protected $tableClient = 'crm_client';
    const MENU_LIST  = "business/CustomerController/customerList";

    public function  __construct() {
        parent::__construct();
        $this->config->load('customer', TRUE);
        $this->load->model('admin/UserModel','',true);
        $this->load->model('admin/SiteModel','',true);
        $this->load->model('business/CustomerModel','',true);
        $this->CustomerArray['Level'] = $this->config->item('Level','customer');                //客户级别
        $this->CustomerArray['Source'] = $this->config->item('Source','customer');              //客户来源
        $this->CustomerArray['industry'] = $this->config->item('industry','customer');          //所属行业
    }

    public function customerList() {
        $where = $urlArray = array();
        $urlStr = $whereStr = '';
        $data = $this->View('customer');

        if(!in_array('allCustomer',$data['userOpera'])) {
            $where[] = "a.salesmanId in".$this->uIdDispose();
        }
        $where[] = " a.endDate >= ".time();
        $name = trim($this->input->get_post('name',true));             //获取客户名称
        $salesman = trim($this->input->get_post('salesman',true));     //获取业务员名称
        //客户名称搜索
        if(!empty($name)) {
            $list['name'] = $name;
            $where[] = ' b.name like '."'%".$name."%'";
            $urlArray[] = 'name='.$name;
        }
        //搜索业务员
        if(!empty($salesman)) {
            $urlArray[] = 'salesman='.$salesman;
            $where[] = ' c.userName like '."'%".$salesman."%'";
            $list['salesman'] = $salesman;
        }

        //拼接查询条件
        if(!empty($urlArray)) {
            $urlStr = '/?'.implode('&', $urlArray);
        }
        if(!empty($where)) {
            $whereStr = implode(" and ",$where);
        }
        $modelArray['modelPath'] = 'business';
        $modelArray['modelName'] = 'CustomerModel';
        $modelArray['sqlTplName'] = 'publicSql';
        $modelArray['sqlTplFucName'] = 'customerList';
        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);
        $argument	= array(
                'base_url'      => self::MENU_LIST,
                'per_page'		=> 14,
                'num_links'		=> 3,
                'uri_segment'	=> 4,
                'total_rows'    => $rows,
        );
        $getPaginDatas		= $this->createPagination($argument,$urlStr);
        $list['pagination']	= $getPaginDatas['pagination'];
        $list['rows']       = $rows;
        $list['getResult']  = $this->CustomerModel->customerList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);

        foreach($list['getResult'] as $key=>$val) {
            //判断该员工是否离职
            $result = $this->PublicModel->selectSave('isDel','crm_user',array('uId'=>$val['salesmanId']),1);
            $list['getResult'][$key]['isDel'] = $result['isDel'];
        }

        $siteId = $this->SiteModel->getSiteList(0,100,'');
        foreach($siteId as $vs) {
            $siteIdArray[$vs['siteId']] = $vs['name'];
        }
        $list['siteId'] = $siteIdArray;
        $list['customer'] = $this->CustomerArray;
        $data['content'] = $this->load->view('business/customerListView',$list,true);
        $this->load->view('index/index',$data);
    }

    public function customerAddView() {
    	$data = $this->View('customer');
        $parameter['customer'] = $this->CustomerArray;
        $parameter['siteId'] = $this->SiteModel->getSiteList(0,100,'');
        $parameter['siteIdArray'] = explode(',', $this->session->userdata['siteId']);
        
        if($this->input->post('submitCreate') != FALSE){
        	$result = array(
        	    'name' => trim($this->input->post('name')),
        	    'proname' => trim($this->input->post('proname')),
        	    'industry' => $this->input->post('industry'),
        	    'source' => $this->input->post('source'),
        	    'siteId' => $this->input->post('siteId'),
        	    'level' => $this->input->post('level'),
	        	'phone' => trim($this->input->post('clientPhone')),
	        	'address' => $this->input->post('address'),
        		'dockName' => $this->input->post('dockName'),
	            'position' => $this->input->post('position'),
        	    'createTime' => time(),
        	    'operator' => $this->session->userdata('uId'),
        	);
            $checkCustomer = $this->PublicModel->selectSave('*',$this->tableClient,array('name'=>$result['name'],'isDel'=>0,'isStop'=>0),1);
            if(!empty($checkCustomer)){
                $this->showMsg(2,'该客户名称已经存在，请勿重复创建！'); exit;
            }
            $cId = $this->PublicModel->insertSave($this->tableClient,$result);
            if(!empty($cId)){
            	$relationRes = array(
            	   'cId' => $cId,
            	   'salesmanId' => $this->session->userdata('uId'),
            	   'startDate' => time(),
            	   'endDate' => strtotime('2030-01-01'),
            	   'createTime' => time(),
            	   'state' => 1,
            	);
            	$this->PublicModel->insertSave($this->table,$relationRes);
                $this->showMsg(1,'客户新增成功',self::MENU_LIST);
            }else {
                $this->showMsg(2,'新增失败！');
            }
        }

        $data['content'] = $this->load->view('business/customerAddView',$parameter,true);
        $this->load->view('index/index',$data);
    }

    public function customerEditView($cId) {
        $data = $this->View('customer');
        $parameter['customer'] = $this->CustomerArray;
        $parameter['siteId'] = $this->SiteModel->getSiteList(0,100,'');
        $parameter['siteIdArray'] = explode(',', $this->session->userdata['siteId']);
        $parameter['detail'] = $this->PublicModel->selectSave('*',$this->tableClient,array('cId'=>$cId),1);
        
        if($this->input->post('submitCreate') != FALSE){
            $result = array(
                'name' => trim($this->input->post('name')),
                'proname' => trim($this->input->post('proname')),
        	    'industry' => $this->input->post('industry'),
                'source' => $this->input->post('source'),
                'siteId' => $this->input->post('siteId'),
                'level' => $this->input->post('level'),
                'phone' => trim($this->input->post('clientPhone')),
                'address' => $this->input->post('address'),
	            'dockName' => $this->input->post('dockName'),
	            'position' => $this->input->post('position'),
            );
            $checkCustomer = $this->PublicModel->selectSave('*',$this->tableClient,array('name'=>$result['name'],'isDel'=>0,'isStop'=>0,'cId <>'=>$cId),1);
            if(!empty($checkCustomer)){
                $this->showMsg(2,'该客户名称已经存在，请勿重复创建！'); exit;
            }
            $cId = $this->PublicModel->updateSave($this->tableClient,array('cId'=>$cId),$result);
            if(!empty($cId)){
                $this->showMsg(1,'客户编辑成功',self::MENU_LIST);
            }else {
                $this->showMsg(2,'编辑失败！');
            }
        }

        $data['content'] = $this->load->view('business/customerEditView',$parameter,true);
        $this->load->view('index/index',$data);
    }

    public function customerDel($cId){
        $signal = $this->PublicModel->updateSave($this->tableClient,array('cId'=>$cId),array('isDel'=>1));
        $this->PublicModel->updateSave($this->table,array('cId'=>$cId),array('isDel'=>1));
        if($signal != FALSE) {
            $this->showMsg(1,'信息删除成功',self::MENU_LIST);
        }else {
            $this->showMsg(2,'信息删除失败！');
        }
    }
    
    public function getCustomerInfo() {
        $developersInfo = array();
        $developersStr = '';
        $where[] = "siteId in (".$this->session->userdata('siteId').")";
        $dName = $this->_clearSpace($this->input->post('value',true),true);
        $where[] = "name like '%$dName%'";
        $client = $this->CustomerModel->customerListResult($where);
        if(!empty($client)) {
            foreach($client as $value) {
                $developersInfo[] = $value;
            }
        }
        if(!empty($developersInfo)) {
            foreach($developersInfo as $v) {
                if(!empty($v['cId'])) {
                    $developersStr .= $v['cId'].'#'.$v['name'].'|';
                }
            }
        }
        echo $developersStr;
    }
    
    public function customerHandover($cId){
    	$data = $this->View('customer');
    	$parameter['detail'] = $this->PublicModel->selectSave('*',$this->tableClient,array('cId'=>$cId),1);
    	if(!empty($parameter['detail']['status'])){
    		$this->showMsg(2,'该客户已存在转交记录，正在审批中！'); exit;
    	}
    	if($this->input->post('submitCreate') != FALSE){
    	     $result = array(
                    'cId'          =>  $cId,
                    'salesmanId'   =>  $this->input->post('receiveId'),
                    'startDate'    =>  strtotime($this->input->post('startDate')),
                    'endDate'      =>  strtotime('2030-01-01'),
                    'createTime'   =>  time(),
            );
            if(empty($result['salesmanId'])){
            	$this->showMsg(2,'该选择接收业务员！'); exit;
            }
            $signal = $this->PublicModel->insertSave('crm_client_relation',$result);
            if($signal != FALSE){
            	$this->PublicModel->updateSave($this->tableClient,array('cId'=>$cId),array('status'=>1));
            	$this->PublicModel->controlProcess($this->table,$signal,1);
            	$this->showMsg(1,'已经进入转交审核程序',self::MENU_LIST);
            }else {
                $this->showMsg(2,'转交提交失败！');
            }
    	}
    	$parameter['org'] = $this->PublicModel->getDepList($arrayList=array(),0,0);
    	$data['content'] = $this->load->view('business/customerHandView',$parameter,true);
        $this->load->view('index/index',$data);
    }
    
    public function relationDetail($relationId){
    	$data = $this->View('customer');
    	$parameter['relation'] = $this->PublicModel->selectSave('*',$this->table,array('relationId'=>$relationId),1);
    	$parameter['oldRelation'] = $this->CustomerModel->getRelationInfo($parameter['relation']['cId'],$parameter['relation']['createTime']);
    	$parameter['client'] = $this->PublicModel->selectSave('*',$this->tableClient,array('cId'=>$parameter['relation']['cId']),1);
    	$getFlowList = $this->PublicModel->getFlowList($relationId,$this->table);
        $parameter['flowlist']	= $getFlowList;
        $parameter['customer'] = $this->CustomerArray;
        $parameter['userInfo'] = $this->getAllUserInfo();
        if($this->input->post('submitCreate') != FALSE){
        	$app_type = $this->input->post('app_type');     //审批结果
            $app_con  = $this->input->post('app_con');      //审批意见
            $flowid   = $this->input->post('flowid');
            if($app_type == 2){
                $this->db->delete($this->table,array('relationId'=>$relationId));
            }else{
            	$this->PublicModel->updateSave($this->tableClient,array('cId'=>$parameter['relation']['cId']),array('status'=>0));
            	$this->PublicModel->updateSave($this->table,array('relationId'=>$parameter['oldRelation']['relationId']),array('endDate'=>time()));
            }
            $this->PublicModel->controlProcess($this->table,$relationId,2,0,$app_type,$app_con,$flowid);
            $this->showMsg(1,'提交成功','panel/PanelController/panelList');
        }
        $data['directory']  = $this->PublicModel->getProDirectory($getFlowList[0]['fromName'],$getFlowList[0]['fromUid'],$getFlowList[0]['createTime']);
        $data['content'] = $this->load->view('business/relationDetailView',$parameter,true);
        $this->load->view('index/index',$data);
    }
    
    public function customerDetail($cId){
    	$data = $this->View('customer');
    	$list['customer'] = $this->CustomerArray;
        $siteId = $this->SiteModel->getSiteList(0,100,'');
        foreach($siteId as $vs) {
            $siteIdArray[$vs['siteId']] = $vs['name'];
        }
        $list['siteId'] = $siteIdArray;
    	$list['userInfo'] = $this->getAllUserInfo();
    	$list['client'] = $this->PublicModel->selectSave('*',$this->tableClient,array('cId'=>$cId),1);
    	//拜访记录
    	$this->config->load('journal',true);
    	$list['dailyShape'] = $this->config->item('dailyShape','journal');
    	$list['visit'] = $this->PublicModel->selectSave('*','crm_daily_detail',array('clientName'=>$cId,'type'=>1,'isDel'=>0),2,'createTime desc');
        
    	//业务员维护记录
    	$list['client_relation'] = $this->PublicModel->selectSave('*',$this->table,array('cId'=>$cId,'isDel'=>0,'state'=>1),2,'createTime desc');
    	$data['content'] = $this->load->view('business/customerDetailView',$list,true);
        $this->load->view('index/index',$data);
    }
    
    

}
?>