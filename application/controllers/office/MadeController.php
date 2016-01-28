<?php
/**
 * @desc 客户定制票务管理控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-08-24
 */
class MadeController extends MY_Controller {
	
    protected $table = 'crm_office_made';
    
    const MENU_LIST  = "office/MadeController/madeList";
    
    public function  __construct() {
        parent::__construct();
        $this->load->model('office/ToolsModel','',true);
    }
    
    public function madeList() {
    	$this->operaControl('allMade');
        $data = $this->View('office');
        $whereStr = '';
        $goodsName = trim($this->input->get_post('goodsName',true));
        $clientName = $this->input->get_post('clientName',true);
        if(!empty($goodsName)) {
            $where[] = "c.name like '%".$goodsName."%'";
            $urlArray[] = 'name='.$goodsName;
            $data['goodsName'] = $goodsName;
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
            $where[] = ' a.madeDate >='.$sTime1;
            $urlArray[] = 'sTime='.$sTime;
            $data['sTime'] = $sTime;
        }
        if(!empty($eTime1)) {
            $where[] = ' a.madeDate <='.$eTime1;
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
        $modelArray['sqlTplFucName'] = 'madeList';
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
        $data['arr']  = $this->ToolsModel->madeList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        $data['content'] = $this->load->view('office/madeListView',$data,true);
        $this->load->view('index/index',$data);
    }

    public function madeAddView() {
        $data = $this->View('office');
        if($this->input->post('submitCreate') != FALSE){
	        $result = array(
	              'tId' => $this->input->post('tId'),
	              'madeDate' => strtotime($this->input->post('madeDate')),
	              'lastDate' => strtotime($this->input->post('lastDate')),
	              'madeNum' => trim($this->input->post('madeNum')),
	              'price' => trim($this->input->post('price')),
	              'operator' => $this->session->userdata('uId'),
	              'createTime'=>time(),
	        );

	        $customerName = trim($this->input->post('name'));
	        $customerInfo = $this->PublicModel->selectSave('cId','crm_client',array('name'=>$customerName,'isDel'=>0,'isStop'=>0),1);
	        if(empty($customerInfo)){
	        	$this->showMsg(2,'该客户不存在，请核对客户名称或创建新客户！'); exit;
	        }
	        $result['cId'] = $customerInfo['cId'];
	        
	        $mId = $this->PublicModel->insertSave($this->table,$result);
            if(!empty($mId)){
                $this->showMsg(1,'填写成功',self::MENU_LIST);
	        }else {
	            $this->showMsg(2,'填写失败！');
	        }
        }
        
        $dVal['putName'] = 'name';
        $dVal['idName'] = 'cId';
        $data['public_view_js'] = $this->load->view('index/public_view_js',$dVal,true);
        $data['toolsList'] = $this->PublicModel->selectSave('*','crm_office_tools',array('isDel'=>0,'type'=>1),2);
        $data['content'] = $this->load->view('office/madeAddView',$data,true);
        $this->load->view('index/index',$data);
    }
    
    public function madeBackView($mId) {
        $data = $this->View('office');
        $data['arr'] = $this->ToolsModel->getMadeDetail($mId);
        if($this->input->post('submitCreate') != FALSE){
            $result = array(
                  'mId' => $mId,
                  'getDate' => strtotime($this->input->post('getDate')),
                  'getNum' => trim($this->input->post('getNum')),
            );
            
            $updateId = $this->PublicModel->insertSave('crm_office_madedetail',$result);
            if(!empty($updateId)){
                $this->showMsg(1,'填写成功');
            }else {
                $this->showMsg(2,'填写失败！');
            }
        }
        
        $data['detail'] = $this->PublicModel->selectSave('*','crm_office_madedetail',array('mId'=>$mId),2);
        if(!empty($data['detail'])){
        	foreach($data['detail'] as $val){
        		$data['total'] += $val['getNum'];
        	}
        	$data['profit'] = substr(($data['total']/$data['arr']['madeNum'])*100,0,5);
        }
        $data['content'] = $this->load->view('office/madeBackView',$data,true);
        $this->load->view('index/index',$data);
    }
    
    public function madeDel($mId){
        $signal = $this->PublicModel->updateSave($this->table,array('mId'=>$mId),array('isDel'=>1));
        if($signal != FALSE) {
            $this->showMsg(1,'信息删除成功',self::MENU_LIST);
        }else {
            $this->showMsg(2,'信息删除失败！');
        }
    }
    
    

}


?>