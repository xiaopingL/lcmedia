<?php
/**
 * @desc 包场活动执行控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2016-1-8
 */
class BookController extends MY_Controller {
	
	protected $advertArray = array();
    protected $table = 'crm_ad_book';
    const MENU_LIST  = "media/BookController/bookList";

    public function  __construct() {
        parent::__construct();
        $this->config->load('advert', TRUE);
        $this->load->model('media/AdvertModel','',true);
        $this->advertArray['nature'] = $this->config->item('nature','advert');  //活动性质
        $this->advertArray['film_type'] = $this->config->item('film_type','advert');   //影片类型
    }

    public function bookList() {
        $where = $urlArray = array();
        $urlStr = $whereStr = '';
        $data = $this->View('media');

        if(!in_array('allAdBook',$data['userOpera'])) {
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
        $modelArray['sqlTplFucName'] = 'bookList';
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
        $list['getResult']  = $this->AdvertModel->bookList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);

        foreach($list['getResult'] as $key=>$val) {
            $list['getResult'][$key]['flow'] = $this->PublicModel->getFlowList($val['sId'],$this->table);
        }
        
        $list['advert'] = $this->advertArray;
        $data['content'] = $this->load->view('media/bookListView',$list,true);
        $this->load->view('index/index',$data);
    }

    public function bookAdd(){
    	$data = $this->View('media');
    	if($this->input->post('submitCreate') != FALSE){
    	    $offer1 = trim($this->input->post('offer1'));
    		$offer2 = trim($this->input->post('offer2'));
    		$offer3 = trim($this->input->post('offer3'));
    		$offer4 = trim($this->input->post('offer4'));
    		$offer5 = trim($this->input->post('offer5'));
    		$offer6 = trim($this->input->post('offer6'));
    		
    		$content = $offer1."##".$offer2."##".$offer3."##".$offer4."##".$offer5."##".$offer6;
    		
    		$customerName = trim($this->input->post('name'));
    		$customerInfo = $this->PublicModel->selectSave('cId','crm_client',array('name'=>$customerName,'isDel'=>0,'isStop'=>0),1);
    		if(empty($customerInfo)){
    			$this->showMsg(2,'该客户不存在，请核对客户名称或创建新客户！'); exit;
    		}
    		
    	    $result = array(
    	        'cId' => $customerInfo['cId'],
    	        'nature' => $this->input->post('nature'),
    	        'studioId' => $this->input->post('studioId'),
    	        'film_type' => $this->input->post('film_type'),
    	        'film_name' => $this->input->post('film_name'),
	    	    'hallNumber' => $this->input->post('hallNumber'),
	    	    'follow_date' => strtotime($this->input->post('follow_date')),
	    	    'person_num' => $this->input->post('person_num'),
	    	    'film_price' => $this->input->post('film_price'),
	    	    'demand_price' => $this->input->post('demand_price'),
	    	    'demand_num' => $this->input->post('demand_num'),
	    	    'remark' => $this->input->post('remark'),
	    	    'content' => $content,
    	        'operator' => $this->session->userdata('uId'),
	    	    'createTime' => time(),
    	    );
    	    
    	    if(in_array($result['nature'],array(1,2))){
    	    	$result['contractId'] = $this->input->post('dNumber');
    	    }

    	    $signal = $this->PublicModel->insertSave($this->table,$result);
    	    if($signal != FALSE){
    	    	$this->PublicModel->controlProcess($this->table,$signal,1);
    	    	$this->showMsg(1,'提交成功，已经进入活动执行审核程序',self::MENU_LIST);
    	    }else{
    	    	$this->showMsg(2,'提交失败！');
    	    }
    	}
    	
    	$dVal['putName'] = 'name';
        $dVal['idName'] = 'cId';
        $list['public_view_js'] = $this->load->view('index/public_view_js',$dVal,true);
        $list['advert'] = $this->advertArray;
        $list['studio'] = $this->PublicModel->selectSave('sId,name','crm_studio',array('isDel'=>0),2);
    	$data['content'] = $this->load->view('media/bookAddView',$list,true);
        $this->load->view('index/index',$data);
    }
    
    public function bookEdit($editId){
    	$data = $this->View('media');
    	if($this->input->post('submitCreate') != FALSE){
    		$offer1 = trim($this->input->post('offer1'));
            $offer2 = trim($this->input->post('offer2'));
            $offer3 = trim($this->input->post('offer3'));
            $offer4 = trim($this->input->post('offer4'));
            $offer5 = trim($this->input->post('offer5'));
            $offer6 = trim($this->input->post('offer6'));
            
            $content = $offer1."##".$offer2."##".$offer3."##".$offer4."##".$offer5."##".$offer6;
            
    	    $result = array(
                'studioId' => $this->input->post('studioId'),
                'film_type' => $this->input->post('film_type'),
                'film_name' => $this->input->post('film_name'),
                'hallNumber' => $this->input->post('hallNumber'),
                'follow_date' => strtotime($this->input->post('follow_date')),
                'person_num' => $this->input->post('person_num'),
                'film_price' => $this->input->post('film_price'),
                'demand_price' => $this->input->post('demand_price'),
                'demand_num' => $this->input->post('demand_num'),
                'remark' => $this->input->post('remark'),
                'content' => $content,
    	    );

    	    $signal = $this->PublicModel->updateSave($this->table,array('sId'=>$editId),$result);
    	    if($signal != FALSE){
    	    	$this->showMsg(1,'包场活动执行修改成功',self::MENU_LIST);
    	    }else{
    	    	$this->showMsg(2,'提交失败！');
    	    }
    	}
    	
        $list = $this->AdvertModel->getBookInfo($editId);
    	if(!empty($list['content'])){
    		$list['contentList'] = explode('##',$list['content']);
    		$list['total'] = $this->bookTotalPrice($list['content']);
    	}
    	
    	$list['advert'] = $this->advertArray;
        $list['studio'] = $this->PublicModel->selectSave('sId,name','crm_studio',array('isDel'=>0),2);
    	$data['content'] = $this->load->view('media/bookEditView',$list,true);
        $this->load->view('index/index',$data);
    }
    
    public function bookTotalPrice($content){
    	$result = 0;
    	$book_content = explode('##',$content);
    	if(!empty($book_content)){
    		foreach($book_content as $value){
    			$result += $value;
    		}
    	}
    	return $result;
    }
    
    public function bookDetail($detailId){
    	$data = $this->View('media');
    	$parameter = $this->AdvertModel->getBookInfo($detailId);
        if(!empty($parameter['content'])){
    		$parameter['contentList'] = explode('##',$parameter['content']);
            $parameter['total'] = $this->bookTotalPrice($parameter['content']);
    	}
    	$getFlowList = $this->PublicModel->getFlowList($detailId,$this->table);
        $parameter['flowlist'] = $getFlowList;
        $parameter['studioList'] = $this->getStudioInfoArray();
        $parameter['advert'] = $this->advertArray;
        
        if(!empty($parameter['contractId'])){
        	$this->load->model('business/ContractModel','',true);
        	$parameter['contractList'] = $this->ContractModel->getContractInfo($parameter['contractId']);
        }

        if($this->input->post('submitCreate') != FALSE){
        	$app_type = $this->input->post('app_type');     //审批结果
            $app_con  = $this->input->post('app_con');      //审批意见
            $flowid   = $this->input->post('flowid');

            $this->PublicModel->controlProcess($this->table,$detailId,2,0,$app_type,$app_con,$flowid);
            $this->showMsg(1,'提交成功','panel/PanelController/panelList');
        }
        $data['directory']  = $this->PublicModel->getProDirectory($getFlowList[0]['fromName'],$getFlowList[0]['fromUid'],$getFlowList[0]['createTime']);
        $data['content'] = $this->load->view('media/bookDetailView',$parameter,true);
        $this->load->view('index/index',$data);
    }
    
    public function bookDel($delId) {
        $signal = $this->PublicModel->updateSave($this->table,array('sId'=>$delId),array('isDel'=>1));
        if($signal != FALSE) {
            $this->PublicModel->updateSave('crm_pending',array('tableId'=>$delId,'proTable'=>$this->table),array('isDel'=>1));
            $this->showMsg(1,'信息删除成功',self::MENU_LIST);
        }else {
            $this->showMsg(2,'信息删除失败！');
        }
    }
    

}
?>
