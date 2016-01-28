<?php
/**
 * @desc 应收账款管理控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-11-26
 */
class RetrieveController extends MY_Controller {
	
    protected $table = 'crm_billing';
    const MENU_LIST  = "business/RetrieveController/retrieveList";

    public function  __construct() {
        parent::__construct();
        $this->config->load('customer', TRUE);
        $this->load->model('admin/UserModel','',true);
        $this->load->model('business/BillingModel','',true);
    }

    public function retrieveList() {
        $where = $urlArray = array();
        $urlStr = $whereStr = '';
        $data = $this->View('customer');

        if(!in_array('allRetrieve',$data['userOpera'])) {
            $where[] = "a.operator in".$this->uIdDispose();
        }

        $clientname = trim($this->input->get_post('name',true));        //获取客户名称
        $username = trim($this->input->get_post('username',true));      //获取姓名
        $sTime = $this->input->get_post('sTime',true);
        $eTime = $this->input->get_post('eTime',true);
        $sTime1 = strtotime($sTime);
        $eTime1 = strtotime($eTime);
        
        $where[] = ' a.state = 1';
        
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
        if(!empty($list['getResult'])){
        	foreach($list['getResult'] as $key=>$val){
	        	$actualRetrieveMoney = 0;
	    	    $payment = $this->PublicModel->selectSave('retrieveMoney','crm_payment',array('billingId'=>$val['billingId'],'isDel'=>0));
	    	    if(!empty($payment)){
	    	    	foreach($payment as $value){
	    	    		$actualRetrieveMoney += $value['retrieveMoney'];
	    	    	}
	    	    }
	    	    $list['getResult'][$key]['actualRetrieveMoney'] = $actualRetrieveMoney;
	    	    $list['getResult'][$key]['waitRetrieveMoney']   = $val['money']-$actualRetrieveMoney;
        	}
        }
        
        $list['getMoney'] =  $this->BillingModel->getMoneyNum($whereStr);
        $data['content'] = $this->load->view('business/retrieveListView',$list,true);
        $this->load->view('index/index',$data);
    }
    
    

}
?>
