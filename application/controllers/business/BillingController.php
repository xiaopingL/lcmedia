<?php
/**
 * @desc 开票管理控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-10-31
 */
class BillingController extends MY_Controller {
	
	protected $billingArray = array();
    protected $table = 'crm_billing';
    const MENU_LIST  = "business/BillingController/billingList";

    public function  __construct() {
        parent::__construct();
        $this->config->load('customer', TRUE);
        $this->load->model('admin/UserModel','',true);
        $this->load->model('business/BillingModel','',true);
        $this->load->model('business/ContractModel','',true);
        $this->billingArray['billingClass'] = $this->config->item('billingClass','customer');  //开票分类
        $this->billingArray['billingType']  = $this->config->item('billingType','customer');   //发票性质
        $this->billingArray['billingOur']   = $this->config->item('billingOur','customer');    //我方开票公司
        $this->billingArray['billingCate']  = $this->config->item('billingCate','customer');   //发票类型
    }

    public function billingList() {
        $where = $urlArray = array();
        $urlStr = $whereStr = '';
        $data = $this->View('customer');

        if(!in_array('allBilling',$data['userOpera'])) {
            $where[] = "a.operator in".$this->uIdDispose();
        }

        $clientname = trim($this->input->get_post('name',true));        //获取客户名称
        $username = trim($this->input->get_post('username',true));      //获取姓名
        $sTime = $this->input->get_post('sTime',true);
        $eTime = $this->input->get_post('eTime',true);
        $sTime1 = strtotime($sTime);
        $eTime1 = strtotime($eTime);
        
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
        //客户名称搜索
        if(!empty($clientname)) {
            $list['clientname'] = $clientname;
            $where[] = ' d.name like '."'%".$clientname."%'";
            $urlArray[] = 'clientname='.$clientname;
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
        $modelArray['modelPath'] = 'business';
        $modelArray['modelName'] = 'BillingModel';
        $modelArray['sqlTplName'] = 'publicSql';
        $modelArray['sqlTplFucName'] = 'billingList';
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
        $list['getResult']  = $this->BillingModel->billingList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);

        foreach($list['getResult'] as $key=>$val) {
            $list['getResult'][$key]['flow'] = $this->PublicModel->getFlowList($val['billingId'],$this->table);
        }
        
        $list['getMoney'] =  $this->BillingModel->getMoneyNum($whereStr);
        $data['content'] = $this->load->view('business/billingListView',$list,true);
        $this->load->view('index/index',$data);
    }

    public function billingAdd($contractId){
    	$data = $this->View('customer');
    	$list = $this->ContractModel->getContractInfo($contractId);
    	if($this->input->post('submitCreate') != FALSE){
    	    $result = array(
    	        'contractId' => $contractId,
    	        'company' => trim($this->input->post('company')),
    	        'money' => trim($this->input->post('money')),
    	        'class' => $this->input->post('class'),
	    	    'type' => $this->input->post('type'),
	    	    'ourCompany' => $this->input->post('ourCompany'),
	    	    'cate' => $this->input->post('cate'),
    	        'cate_other' => $this->input->post('cate_other'),
	    	    'remark' => $this->input->post('remark'),
    	        'operator' => $this->session->userdata('uId'),
	    	    'createTime' => time(),
    	    );
    	    
    	    //开票累计金额与合同总金额比较
    	    $moneyCount = 0;
    	    $billing = $this->PublicModel->selectSave('money',$this->table,array('contractId'=>$contractId,'state <>'=>2,'isDel'=>0));
    	    if(!empty($billing)){
    	    	foreach($billing as $value){
    	    		$moneyCount += $value['money'];
    	    	}
    	    }
    	    
    	    $moneyCount = $moneyCount+$result['money'];
    	    
    	    if($moneyCount > $list['money']){
    	    	$this->showMsg(2,'开票累计金额不能超过合同金额！');  exit;
    	    }

    	    $signal = $this->PublicModel->insertSave($this->table,$result);
    	    if($signal != FALSE){
    	    	$this->PublicModel->controlProcess($this->table,$signal,1);
    	    	$this->showMsg(1,'提交成功，已经进入开票审核程序',self::MENU_LIST);
    	    }else{
    	    	$this->showMsg(2,'提交失败！');
    	    }
    	}
    	
    	$list['billing']  = $this->billingArray;
    	$data['content'] = $this->load->view('business/billingAddView',$list,true);
        $this->load->view('index/index',$data);
    }
    
    public function billingEdit($editId){
    	$data = $this->View('customer');
    	if($this->input->post('submitCreate') != FALSE){
    	    $result = array(
    	        'company' => trim($this->input->post('company')),
    	        'money' => trim($this->input->post('money')),
    	        'class' => $this->input->post('class'),
	    	    'type' => $this->input->post('type'),
    	        'ourCompany' => $this->input->post('ourCompany'),
	    	    'cate' => $this->input->post('cate'),
    	        'cate_other' => $this->input->post('cate_other'),
	    	    'remark' => $this->input->post('remark'),
    	    );

    	    $signal = $this->PublicModel->updateSave($this->table,array('billingId'=>$editId),$result);
    	    if($signal != FALSE){
    	    	$this->showMsg(1,'开票修改成功',self::MENU_LIST);
    	    }else{
    	    	$this->showMsg(2,'提交失败！');
    	    }
    	}
    	$list = $this->BillingModel->getBillingInfo($editId);
    	$list['billing'] = $this->billingArray;
    	$data['content'] = $this->load->view('business/billingEditView',$list,true);
        $this->load->view('index/index',$data);
    }
    
    public function billingDetail($detailId){
    	$data = $this->View('customer');
    	$parameter = $this->BillingModel->getBillingInfo($detailId);
    	$getFlowList = $this->PublicModel->getFlowList($detailId,$this->table);
        $parameter['flowlist'] = $getFlowList;
        $parameter['billing']  = $this->billingArray;
        $parameter['userInfo'] = $this->getAllUserInfo();
        if($this->input->post('submitCreate') != FALSE){
        	$app_type = $this->input->post('app_type');     //审批结果
            $app_con  = $this->input->post('app_con');      //审批意见
            $flowid   = $this->input->post('flowid');
            
            if(count($getFlowList)>1 && empty($$parameter['state']) && $this->session->userdata('uId')==$getFlowList[1]['toUid']){
            	$result = array(
            	    'money' => $this->input->post('money'),
            	    'billingDate' => strtotime($this->input->post('billingDate')),
            	    'number' => trim($this->input->post('number'))
            	);
            	$this->PublicModel->updateSave($this->table,array('billingId'=>$detailId),$result);
            }

            $this->PublicModel->controlProcess($this->table,$detailId,2,0,$app_type,$app_con,$flowid);
            $this->showMsg(1,'提交成功','panel/PanelController/panelList');
        }
        $data['directory']  = $this->PublicModel->getProDirectory($getFlowList[0]['fromName'],$getFlowList[0]['fromUid'],$getFlowList[0]['createTime']);
        $data['content'] = $this->load->view('business/billingDetailView',$parameter,true);
        $this->load->view('index/index',$data);
    }
    
    //生成发票唯一编号
    public function getBillingNumber(){
    	$htPrefixion = "FP".date("Y");
    	$contract_info = $this->BillingModel->getNumber($htPrefixion);
    	if(empty($contract_info)){
    		$result = $htPrefixion.'-'.'001';
    	}else{
            $getNumber = explode('-', $contract_info['contractNumber']);
            $result = $getNumber[0].'-'.sprintf("%03d",$getNumber[1]+1);
    	}
    	return $result;
    }
    
    public function billingDel($delId) {
        $signal = $this->PublicModel->updateSave($this->table,array('billingId'=>$delId),array('isDel'=>1));
        if($signal != FALSE) {
            $this->PublicModel->updateSave('crm_pending',array('tableId'=>$delId,'proTable'=>$this->table),array('isDel'=>1));
            $this->showMsg(1,'信息删除成功',self::MENU_LIST);
        }else {
            $this->showMsg(2,'信息删除失败！');
        }
    }
    

}
?>
