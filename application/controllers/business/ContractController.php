<?php
/**
 * @desc 合同管理控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-10-14
 */
class ContractController extends MY_Controller {
	
	protected $customerArray = array();
    protected $table = 'crm_contract';
    const MENU_LIST  = "business/ContractController/contractList";

    public function  __construct() {
        parent::__construct();
        $this->config->load('customer', TRUE);
        $this->load->model('admin/UserModel','',true);
        $this->load->model('admin/SiteModel','',true);
        $this->load->model('business/ContractModel','',true);
        $this->customerArray['service'] = $this->config->item('service','customer');    //增值服务
        $this->customerArray['industry']= $this->config->item('industry','customer');   //所属行业
    }

    public function contractList() {
        $where = $urlArray = array();
        $urlStr = $whereStr = '';
        $data = $this->View('customer');

        if(!in_array('allContract',$data['userOpera'])) {
            $where[] = "a.operator in".$this->uIdDispose();
        }

        $clientname = trim($this->input->get_post('name',true));        //获取客户名称
        $username = trim($this->input->get_post('username',true));      //获取姓名
        $industry = trim($this->input->get_post('industry',true));      //获取行业
        $sTime = $this->input->get_post('sTime',true);
        $eTime = $this->input->get_post('eTime',true);
        $sTime1 = strtotime($sTime);
        $eTime1 = strtotime($eTime);
        
        if(!empty($sTime1)) {
        	$list['sTime'] = $sTime;
            $where[] = ' a.issueDate >='.$sTime1;
            $urlArray[] = 'sTime='.$sTime;
        }
        if(!empty($eTime1)) {
        	$list['eTime'] = $eTime;
            $where[] = ' a.underDate <='.$eTime1;
            $urlArray[] = 'eTime='.$eTime;
        }
        //客户名称搜索
        if(!empty($clientname)) {
            $list['clientname'] = $clientname;
            $where[] = ' c.name like '."'%".$clientname."%'";
            $urlArray[] = 'clientname='.$clientname;
        }
        //搜索行业
        if(!empty($industry)) {
            $list['industry'] = $industry;
            $where[] = ' c.industry='.$industry;
            $urlArray[] = 'industry='.$industry;
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
        $modelArray['modelName'] = 'ContractModel';
        $modelArray['sqlTplName'] = 'publicSql';
        $modelArray['sqlTplFucName'] = 'contractList';
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
        $list['getResult']  = $this->ContractModel->contractList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);

        foreach($list['getResult'] as $key=>$val) {
            $list['getResult'][$key]['flow'] = $this->PublicModel->getFlowList($val['contractId'],$this->table);
            $billing = $this->PublicModel->selectSave('money','crm_billing',array('contractId'=>$val['contractId'],'isDel'=>0,'state'=>1),2);
            $billingTotal = 0;
            if(!empty($billing)){
            	foreach($billing as $v){
            		$billingTotal += $v['money'];
            	}
            }
            $list['getResult'][$key]['noBilling'] = $val['money']-$billingTotal;
        }
        
        $list['customer'] = $this->customerArray;
        $list['getMoney'] =  $this->ContractModel->getMoneyNum($whereStr);
        $data['content'] = $this->load->view('business/contractListView',$list,true);
        $this->load->view('index/index',$data);
    }

    public function contractAdd($cId){
    	$data = $this->View('customer');
    	if($this->input->post('submitCreate') != FALSE){
    		$service = $this->input->post('service');
    		$remark = $this->input->post('remark');
    		$serviceSum = '';
    		if(count($service)>0){
    			foreach($service as $key=>$val){
    				$serviceSum .= $val."##".$remark[$key]."||";
    			}
    		}

    	    $result = array(
    	        'cId' => $cId,
    	        'title' => trim($this->input->post('title')),
    	        'money' => trim($this->input->post('money')),
    	        'discount' => trim($this->input->post('discount')),
	    	    'market' => trim($this->input->post('market')),
	    	    'markeyNote' => trim($this->input->post('markeyNote')),
	    	    'service' => $serviceSum,
	    	    'issueDate' => strtotime($this->input->post('issueDate')),
    	        'underDate' => strtotime($this->input->post('underDate')),
    	        'contractNumber' => $this->getContractNumber(),
	    	    'content' => html_entity_decode($this->input->post('content'),ENT_QUOTES,'utf-8'),
    	        'description' => $this->input->post('description'),
    	        'operator' => $this->session->userdata('uId'),
	    	    'createTime' => time(),
    	    );

    	    $signal = $this->PublicModel->insertSave($this->table,$result);
    	    if($signal != FALSE){
    	    	$this->PublicModel->controlProcess($this->table,$signal,1);
    	    	$this->showMsg(1,'已经进入合同审核程序',self::MENU_LIST);
    	    }else{
    	    	$this->showMsg(2,'提交失败！');
    	    }
    	}
    	$list['contract'] = $this->customerArray;
    	$list['client'] = $this->PublicModel->selectSave('*','crm_client',array('cId'=>$cId),1);
    	$data['content'] = $this->load->view('business/contractAddView',$list,true);
        $this->load->view('index/index',$data);
    }
    
    public function contractEdit($contractId){
    	$data = $this->View('customer');
    	if($this->input->post('submitCreate') != FALSE){
    	    $service = $this->input->post('service');
    		$remark = $this->input->post('remark');
    		$serviceSum = '';
    		if(count($service)>0){
    			foreach($service as $key=>$val){
    				$serviceSum .= $val."##".$remark[$key]."||";
    			}
    		}
    		
    	    $result = array(
    	        'title' => trim($this->input->post('title')),
    	        'money' => trim($this->input->post('money')),
    	        'discount' => trim($this->input->post('discount')),
    	        'market' => trim($this->input->post('market')),
                'markeyNote' => trim($this->input->post('markeyNote')),
	    	    'service' => $serviceSum,
	    	    'issueDate' => strtotime($this->input->post('issueDate')),
    	        'underDate' => strtotime($this->input->post('underDate')),
	    	    'content' => html_entity_decode($this->input->post('content'),ENT_QUOTES,'utf-8'),
    	        'description' => $this->input->post('description'),
    	    );

    	    $signal = $this->PublicModel->updateSave($this->table,array('contractId'=>$contractId),$result);
    	    if($signal != FALSE){
    	    	$this->showMsg(1,'合同修改成功',self::MENU_LIST);
    	    }else{
    	    	$this->showMsg(2,'提交失败！');
    	    }
    	}
    	$list = $this->ContractModel->getContractInfo($contractId);
    	if(!empty($list['service'])){
    		$serviceSum = explode('||',$list['service']);
    	    foreach($serviceSum as $key=>$value) {
            if(!empty($value)) {
	                $serviceDet = explode('##',$value);
	                $serviceList[$key]['service']  = $serviceDet[0];
	                $serviceList[$key]['remark']   = $serviceDet[1];
	            }
	        }
	        $list['serviceList'] = $serviceList;
    	}
    	$list['contract'] = $this->customerArray;
    	$data['content'] = $this->load->view('business/contractEditView',$list,true);
        $this->load->view('index/index',$data);
    }
    
    public function contractDetail($contractId){
    	$data = $this->View('customer');
    	$parameter = $this->ContractModel->getContractInfo($contractId);
        if(!empty($parameter['service'])){
    		$serviceSum = explode('||',$parameter['service']);
    	    foreach($serviceSum as $key=>$value) {
            if(!empty($value)) {
	                $serviceDet = explode('##',$value);
	                $serviceList[$key]['service']  = $serviceDet[0];
	                $serviceList[$key]['remark']   = $serviceDet[1];
	            }
	        }
	        $parameter['serviceList'] = $serviceList;
    	}
    	$getFlowList = $this->PublicModel->getFlowList($contractId,$this->table);
        $parameter['flowlist'] = $getFlowList;
        $parameter['contract'] = $this->customerArray;
        $parameter['userInfo'] = $this->getAllUserInfo();
        if($this->input->post('submitCreate') != FALSE){
        	$app_type = $this->input->post('app_type');     //审批结果
            $app_con  = $this->input->post('app_con');      //审批意见
            $flowid   = $this->input->post('flowid');

            $this->PublicModel->controlProcess($this->table,$contractId,2,0,$app_type,$app_con,$flowid);
            $this->showMsg(1,'提交成功','panel/PanelController/panelList');
        }
        $data['directory']  = $this->PublicModel->getProDirectory($getFlowList[0]['fromName'],$getFlowList[0]['fromUid'],$getFlowList[0]['createTime']);
        $data['content'] = $this->load->view('business/contractDetailView',$parameter,true);
        $this->load->view('index/index',$data);
    }
    
    public function contractDel($delId) {
        $signal = $this->PublicModel->updateSave($this->table,array('contractId'=>$delId),array('isDel'=>1));
        if($signal != FALSE) {
            $this->PublicModel->updateSave('crm_pending',array('tableId'=>$delId,'proTable'=>$this->table),array('isDel'=>1));
            $this->showMsg(1,'信息删除成功',self::MENU_LIST);
        }else {
            $this->showMsg(2,'信息删除失败！');
        }
    }
    
    //生成合同唯一编号
    public function getContractNumber(){
    	$htPrefixion = "LC".date("Y");
    	$contract_info = $this->ContractModel->getNumber($htPrefixion);
    	if(empty($contract_info)){
    		$result = $htPrefixion.'-'.'001';
    	}else{
            $getNumber = explode('-', $contract_info['contractNumber']);
            $result = $getNumber[0].'-'.sprintf("%03d",$getNumber[1]+1);
    	}
    	return $result;
    }
    
    /*-------------拍照 图片上传--------------*/
    public function contractFileView($contractId) {
        $data = $this->View('customer');
        $contracArrayNew = $this->ContractModel->contractFileArray($contractId);
        if(!empty($contracArrayNew)) {
            $data['contracArrayNew'] = $contracArrayNew;
        }

        $data['contractId'] = $contractId;
        $data['content'] = $this->load->view('business/contractFileView',$data,true);
        $this->load->view('index/index',$data);
    }
    
    public function contractFileUpload() {
        $contractId = $this->input->post('contractId');
        $include = $this->input->post('include');
        $result = array(
                'contractId'=>$contractId,
                'fId'=>$include,
        );
        $fileId = $this->PublicModel->insertSave('crm_contract_file',$result);
        if(!empty($fileId)) {
            $this->showMsg(1,"上传成功！");
        }else {
            $this->showMsg(2,"上传失败！");
            exit;
        }
    }
    /*-------------拍照 图片上传--------------*/
    /*-------------电子图片删除--------------*/
    public function contractFileDel($fileId) {
        $rr = array(
                'isDel'=>'1',
        );
        $fileId = $this->PublicModel->updateSave('crm_contract_file',array('fileId'=>$fileId),$rr);
        if(!empty($fileId)) {
            $this->showMsg(1,"删除成功！");
        }else {
            $this->showMsg(2,"删除失败！");
            exit;
        }
    }
    
    public function getContractInfo() {
        $name = $this->input->post('name',true);
        $clientInfo = $this->getClientInfoArray();

        foreach ($clientInfo as $key=>$val) {
            if($val == $name) {
                $cId = $key; break;
            }
        }
        
        $contractStr = '';
        
        if(!empty($cId)) {
            $contractInfo = $this->PublicModel->selectSave('*','crm_contract',array('cId'=>$cId,'state'=>1,'isDel'=>0),2,'createTime desc');
            if(!empty($contractInfo)) {
                $contractStr = '<option value="">--请选择合同--</option>';
                foreach($contractInfo as $v) {
                    $contractStr .= '<option value="'.$v['contractId'].'" >'.$v['title'].'--'.$v['money'].'元--'.date('Y-m-d',$v['createTime']).'</option>';
                }
            }else {
                $contractStr = '<option value="">当前客户没有合同</option>';
            }
        }
        echo $contractStr;
    }
    

}
?>
