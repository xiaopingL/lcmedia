<?php
/**
 * @desc 票务回收控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-08-24
 */
class CallbackController extends MY_Controller {
	
    protected $table = 'crm_office_callback';
    
    const MENU_LIST  = "office/CallbackController/callbackList";
    
    public function  __construct() {
        parent::__construct();
        $this->load->model('office/ToolsModel','',true);
    }
    
    public function callbackList() {
    	$this->operaControl('allCallback');
        $data = $this->View('office');
        $whereStr = '';
        $tId = trim($this->input->get_post('tId',true));
        $clientName = $this->input->get_post('clientName',true);
        if(!empty($tId)) {
            $where[] = "a.tId = ".$tId;
            $urlArray[] = 'tId='.$tId;
            $data['tId'] = $tId;
            $data['toolsInfo'] = $this->PublicModel->selectSave('name','crm_office_tools',array('tId'=>$tId),1);
        }
        if(!empty($clientName)) {
            $where[] = "d.name like '%".$clientName."%'";
            $urlArray[] = 'clientName='.$clientName;
            $data['clientName'] = $clientName;
        }
        
        $sTime = $this->input->get_post('sTime',true);
        $eTime = $this->input->get_post('eTime',true);
        $sTime1 = strtotime($sTime);
        $eTime1 = strtotime($eTime);
        if(!empty($sTime1)) {
            $where[] = ' a.callbackDate >='.$sTime1;
            $urlArray[] = 'sTime='.$sTime;
            $data['sTime'] = $sTime;
        }
        if(!empty($eTime1)) {
            $where[] = ' a.callbackDate <='.$eTime1;
            $urlArray[] = 'eTime='.$eTime;
            $data['eTime'] = $eTime;
        }

        if(!empty($urlArray)) {
            $urlStr = '/?'.implode('&', $urlArray);
        }
        if(!empty($where)) {
            $whereStr = ' and '.implode(" and ",$where);
        }
        
        $modelArray['modelPath'] = 'office';
        $modelArray['modelName'] = 'ToolsModel';
        $modelArray['sqlTplName'] = 'publicSql';
        $modelArray['sqlTplFucName'] = 'callbackList';
        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);
        $argument	= array(
                'base_url'      => self::MENU_LIST,
                'per_page'		=> 12,
                'num_links'		=> 3,
                'uri_segment'	=> 4,
                'total_rows'	=> $rows
        );
        $getPaginDatas		= $this->createPagination($argument,$urlStr);
        $data['pagination']	= $getPaginDatas['pagination'];
        $data['rows']       = $rows;
        $data['arr']  = $this->ToolsModel->callbackList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        foreach($data['arr'] as $key=>$val){
        	$where = array(
        	    'tId' => $val['tId'],
        	    'isDel' => 0,
        	    'state' => 1,
        	    'createTime >=' => $val['callbackDate'],
        	    'createTime <=' => strtotime(date('Y-m-t',$val['callbackDate']))
        	);
        	$totalNum = 0;
        	$goodsInfo = $this->PublicModel->selectSave('actNum','crm_office_goods',$where,2);
        	if(!empty($goodsInfo)){
        		foreach($goodsInfo as $v){
        			$totalNum += $v['actNum'];
        		}
        	}
        	$data['arr'][$key]['actNum'] = $totalNum;
        	$callbackNum += $val['callbackNum'];
        }
        
        if(!empty($tId) && !empty($sTime1) && !empty($eTime1)){
        	$data['profit'] = substr(($callbackNum/$totalNum)*100,0,5);
        }
        $data['userInfo'] = $this->getAllUserInfo();
        $data['goodsList'] = $this->PublicModel->selectSave('*','crm_office_tools',array('type'=>1,'isDel'=>0),2);
        $data['content'] = $this->load->view('office/callbackListView',$data,true);
        $this->load->view('index/index',$data);
    }

    public function callbackAddView() {
        $data = $this->View('office');
        if($this->input->post('submitCreate') != FALSE){
        	$callbackDate = $this->input->post('callbackDate');
        	$dateInfo = explode(' ',$callbackDate);
	        $result = array(
	              'type'=> $this->input->post('type'),
	              'tId' => $this->input->post('tId'),
	              'callbackDate' => strtotime($dateInfo[0].'-'.$dateInfo[1].'-01'),
	              'callbackNum' => trim($this->input->post('callbackNum')),
	              'totalPrice' => trim($this->input->post('totalPrice')),
	              'operator' => $this->session->userdata('uId'),
	              'salesman' => $this->input->post('receiveId'),
	              'createTime'=>time(),
	        );

	        if($result['type'] == 1){
	        	$customerName = trim($this->input->post('name'));
	        	$customerInfo = $this->PublicModel->selectSave('sId','crm_studio',array('name'=>$customerName,'isDel'=>0),1);
	        	if(empty($customerInfo)){
	        		$this->showMsg(2,'该影城不存在，请核对影城名称或创建新影城！'); exit;
	        	}
	        	$result['cId'] = $customerInfo['sId'];
	        }
	        
	        $backId = $this->PublicModel->insertSave($this->table,$result);
            if(!empty($backId)){
                $this->showMsg(1,'填写成功',self::MENU_LIST);
	        }else {
	            $this->showMsg(2,'填写失败！');
	        }
        }
        
        $dVal['putName'] = 'name';
        $dVal['idName'] = 'cId';
        $data['public_view_js'] = $this->load->view('index/public_view_js',$dVal,true);
        $data['toolsList'] = $this->PublicModel->selectSave('*','crm_office_tools',array('isDel'=>0,'type'=>1),2);
        $data['org'] = $this->PublicModel->getDepList($arrayList=array(),0,0);
        $data['content'] = $this->load->view('office/callbackAddView',$data,true);
        $this->load->view('index/index',$data);
    }
    
    public function callbackDel($backId){
        $signal = $this->PublicModel->updateSave($this->table,array('backId'=>$backId),array('isDel'=>1));
        if($signal != FALSE) {
            $this->showMsg(1,'信息删除成功',self::MENU_LIST);
        }else {
            $this->showMsg(2,'信息删除失败！');
        }
    }
    
    

}


?>