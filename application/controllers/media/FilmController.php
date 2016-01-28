<?php
/**
 * @desc 影讯广告执行单
 * @author xiaoping <lxp_phper@163.com>
 * @date 2016-1-15
 */
class FilmController extends MY_Controller {
	
	protected $advertArray = array();
    protected $table = 'crm_ad_film';
    const MENU_LIST  = "media/FilmController/filmList";

    public function  __construct() {
        parent::__construct();
        $this->config->load('advert', TRUE);
        $this->load->model('media/AdvertModel','',true);
        $this->advertArray['position'] = $this->config->item('position','advert');   //位置要求
        $this->advertArray['pay_type'] = $this->config->item('pay_type','advert');   //支付形式
    }

    public function filmList() {
        $where = $urlArray = array();
        $urlStr = $whereStr = '';
        $data = $this->View('media');

        if(!in_array('allAdFilm',$data['userOpera'])) {
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
        $modelArray['sqlTplFucName'] = 'filmList';
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
        $list['getResult']  = $this->AdvertModel->filmList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);

        foreach($list['getResult'] as $key=>$val) {
            $list['getResult'][$key]['flow'] = $this->PublicModel->getFlowList($val['sId'],$this->table);
        }
        
        $list['advert'] = $this->advertArray;
        $data['content'] = $this->load->view('media/filmListView',$list,true);
        $this->load->view('index/index',$data);
    }

    public function filmAdd(){
    	$data = $this->View('media');
    	if($this->input->post('submitCreate') != FALSE){
    		$customerName = trim($this->input->post('name'));
    		$customerInfo = $this->PublicModel->selectSave('cId','crm_client',array('name'=>$customerName,'isDel'=>0,'isStop'=>0),1);
    		if(empty($customerInfo)){
    			$this->showMsg(2,'该客户不存在，请核对客户名称或创建新客户！'); exit;
    		}
    		
    	    $result = array(
    	        'cId' => $customerInfo['cId'],
    	        'position' => $this->input->post('position'),
    	        'contractNumber' => $this->input->post('contractNumber'),
    	        'pay_type' => $this->input->post('pay_type'),
    	        'issue' => $this->input->post('issue'),
	    	    'remark' => $this->input->post('remark'),
    	        'operator' => $this->session->userdata('uId'),
	    	    'createTime' => time(),
    	    );

    	    $signal = $this->PublicModel->insertSave($this->table,$result);
    	    if($signal != FALSE){
    	    	$this->PublicModel->controlProcess($this->table,$signal,1);
    	    	$this->showMsg(1,'提交成功，已经进入广告执行审核程序',self::MENU_LIST);
    	    }else{
    	    	$this->showMsg(2,'提交失败！');
    	    }
    	}
    	
    	$dVal['putName'] = 'name';
        $dVal['idName'] = 'cId';
        $list['public_view_js'] = $this->load->view('index/public_view_js',$dVal,true);
        $list['advert'] = $this->advertArray;
    	$data['content'] = $this->load->view('media/filmAddView',$list,true);
        $this->load->view('index/index',$data);
    }
    
    public function filmEdit($editId){
    	$data = $this->View('media');
    	if($this->input->post('submitCreate') != FALSE){
    	    $result = array(
                'position' => $this->input->post('position'),
                'contractNumber' => $this->input->post('contractNumber'),
                'pay_type' => $this->input->post('pay_type'),
                'issue' => $this->input->post('issue'),
                'remark' => $this->input->post('remark'),
    	    );

    	    $signal = $this->PublicModel->updateSave($this->table,array('sId'=>$editId),$result);
    	    if($signal != FALSE){
    	    	$this->showMsg(1,'影讯广告执行修改成功',self::MENU_LIST);
    	    }else{
    	    	$this->showMsg(2,'提交失败！');
    	    }
    	}
    	
        $list = $this->AdvertModel->getFilmInfo($editId);
    	$list['advert'] = $this->advertArray;
    	$data['content'] = $this->load->view('media/filmEditView',$list,true);
        $this->load->view('index/index',$data);
    }
    
    public function filmDetail($detailId){
    	$data = $this->View('media');
    	$parameter = $this->AdvertModel->getFilmInfo($detailId);
    	$getFlowList = $this->PublicModel->getFlowList($detailId,$this->table);
        $parameter['flowlist'] = $getFlowList;
        $parameter['advert'] = $this->advertArray;

        if($this->input->post('submitCreate') != FALSE){
        	$app_type = $this->input->post('app_type');     //审批结果
            $app_con  = $this->input->post('app_con');      //审批意见
            $flowid   = $this->input->post('flowid');

            $this->PublicModel->controlProcess($this->table,$detailId,2,0,$app_type,$app_con,$flowid);
            $this->showMsg(1,'提交成功','panel/PanelController/panelList');
        }
        $data['directory']  = $this->PublicModel->getProDirectory($getFlowList[0]['fromName'],$getFlowList[0]['fromUid'],$getFlowList[0]['createTime']);
        $data['content'] = $this->load->view('media/filmDetailView',$parameter,true);
        $this->load->view('index/index',$data);
    }
    
    public function filmDel($delId) {
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
