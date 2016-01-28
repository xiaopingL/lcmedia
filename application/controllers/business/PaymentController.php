<?php
/**
 * @desc 回款管理控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-11-26
 */
class PaymentController extends MY_Controller {
	
	protected $paymentArray = array();
    protected $table = 'crm_payment';
    const MENU_LIST  = "business/PaymentController/paymentList";

    public function  __construct() {
        parent::__construct();
        $this->config->load('customer', TRUE);
        $this->load->model('admin/UserModel','',true);
        $this->load->model('business/BillingModel','',true);
        $this->paymentArray['bank'] = $this->config->item('bank','customer');  //收款银行
        $this->paymentArray['paymentMode']  = $this->config->item('paymentMode','customer'); //付款方式
    }

    public function paymentList() {
        $where = $urlArray = array();
        $urlStr = $whereStr = '';
        $data = $this->View('customer');

        if(!in_array('allPayment',$data['userOpera'])) {
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
            $where[] = ' e.name like '."'%".$clientname."%'";
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
        $modelArray['sqlTplFucName'] = 'paymentList';
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
        $list['getResult']  = $this->BillingModel->paymentList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        
        $list['payment']  = $this->paymentArray;
        $list['getMoney'] =  $this->BillingModel->getPamentMoneyNum($whereStr);
        $data['content'] = $this->load->view('business/paymentListView',$list,true);
        $this->load->view('index/index',$data);
    }
    
    public function retrieveAdd($editId){
    	$data = $this->View('customer');
    	$list = $this->BillingModel->getBillingInfo($editId);
    	if($this->input->post('submitCreate') != FALSE){
    	    $result = array(
    	        'billingId' => $editId,
    	        'payUnit' => trim($this->input->post('payUnit')),
    	        'retrieveTime' => strtotime($this->input->post('retrieveTime')),
    	        'retrieveMoney' => trim($this->input->post('paymentMoney')),
	    	    'type' => $this->input->post('type'),
	    	    'bank' => $this->input->post('retrieveBank'),
	    	    'remark' => $this->input->post('remark'),
    	        'operator' => $this->session->userdata('uId'),
	    	    'createTime' => time(),
    	    );
    	    
    	    //回款累计金额与开票总金额比较
    	    $moneyCount = 0;
    	    $payment = $this->PublicModel->selectSave('retrieveMoney',$this->table,array('billingId'=>$editId,'isDel'=>0));
    	    if(!empty($payment)){
    	    	foreach($payment as $value){
    	    		$moneyCount += $value['retrieveMoney'];
    	    	}
    	    }
    	    
    	    $moneyCount = $moneyCount+$result['retrieveMoney'];
    	    
    	    if($moneyCount > $list['money']){
    	    	$this->showMsg(2,'回款累计金额不能超过开票金额！');  exit;
    	    }

    	    $signal = $this->PublicModel->insertSave($this->table,$result);
    	    if($signal != FALSE){
    	    	$this->showMsg(1,'回款信息提交成功',self::MENU_LIST);
    	    }else{
    	    	$this->showMsg(2,'提交失败！');
    	    }
    	}
    	
    	$list['payment']  = $this->paymentArray;
    	$data['content'] = $this->load->view('business/retrieveAddView',$list,true);
        $this->load->view('index/index',$data);
    }
    
    public function paymentDel($delId) {
        $signal = $this->PublicModel->updateSave($this->table,array('paymentId'=>$delId),array('isDel'=>1));
        if($signal != FALSE) {
            $this->showMsg(1,'信息删除成功',self::MENU_LIST);
        }else {
            $this->showMsg(2,'信息删除失败！');
        }
    }
    

}
?>
