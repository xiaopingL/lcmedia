<?php
/**
 * @desc 影城管理控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-12-26
 */
class StudioController extends MY_Controller {
	
    protected $table = 'crm_studio';
    const MENU_LIST  = "media/StudioController/studioList";

    public function  __construct() {
        parent::__construct();
        $this->load->model('admin/UserModel','',true);
        $this->load->model('admin/SiteModel','',true);
        $this->load->model('media/StudioModel','',true);
    }

    public function studioList() {
        $where = $urlArray = array();
        $urlStr = $whereStr = '';
        $data = $this->View('media');

        $name = trim($this->input->get_post('name',true));             //获取影城名称
        //影城名称搜索
        if(!empty($name)) {
            $list['name'] = $name;
            $where[] = ' a.name like '."'%".$name."%'";
            $urlArray[] = 'name='.$name;
        }

        //拼接查询条件
        if(!empty($urlArray)) {
            $urlStr = '/?'.implode('&', $urlArray);
        }
        if(!empty($where)) {
            $whereStr = ' and '.implode(" and ",$where);
        }
        $modelArray['modelPath'] = 'media';
        $modelArray['modelName'] = 'StudioModel';
        $modelArray['sqlTplName'] = 'publicSql';
        $modelArray['sqlTplFucName'] = 'studioList';
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
        $list['getResult']  = $this->StudioModel->studioList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);

        $siteId = $this->SiteModel->getSiteList(0,100,'');
        foreach($siteId as $vs) {
            $siteIdArray[$vs['siteId']] = $vs['name'];
        }
        $list['siteId'] = $siteIdArray;
        $data['content'] = $this->load->view('media/studioListView',$list,true);
        $this->load->view('index/index',$data);
    }

    public function studioAddView() {
    	$data = $this->View('media');
        $parameter['siteId'] = $this->SiteModel->getSiteList(0,100,'');
        $parameter['siteIdArray'] = explode(',', $this->session->userdata['siteId']);
        
        if($this->input->post('submitCreate') != FALSE){
        	$result = array(
        	    'name' => trim($this->input->post('name')),
        	    'room_num' => trim($this->input->post('room_num')),
        	    'seat_num' => $this->input->post('seat_num'),
        	    'month_market_num' => $this->input->post('month_market_num'),
        	    'siteId' => $this->input->post('siteId'),
        	    'month_person_num' => $this->input->post('month_person_num'),
	        	'publish_price_fifteen' => trim($this->input->post('publish_price_fifteen')),
	        	'publish_price_thirty' => $this->input->post('publish_price_thirty'),
        		'situation' => $this->input->post('situation'),
        	    'chain' => $this->input->post('chain'),
	            'address' => $this->input->post('address'),
        	    'createTime' => time(),
        	    'operator' => $this->session->userdata('uId'),
        	    'isDel' => 0
        	);
            $checkCustomer = $this->PublicModel->selectSave('*',$this->table,array('name'=>$result['name'],'isDel'=>0),1);
            if(!empty($checkCustomer)){
                $this->showMsg(2,'该影城名称已经存在，请勿重复创建！'); exit;
            }
            $sId = $this->PublicModel->insertSave($this->table,$result);
            if(!empty($sId)){
                $this->showMsg(1,'影城新增成功',self::MENU_LIST);
            }else {
                $this->showMsg(2,'新增失败！');
            }
        }

        $data['content'] = $this->load->view('media/studioAddView',$parameter,true);
        $this->load->view('index/index',$data);
    }

    public function studioEditView($sId) {
        $data = $this->View('media');
        $parameter['siteId'] = $this->SiteModel->getSiteList(0,100,'');
        $parameter['siteIdArray'] = explode(',', $this->session->userdata['siteId']);
        $parameter['detail'] = $this->PublicModel->selectSave('*',$this->table,array('sId'=>$sId),1);
        
        if($this->input->post('submitCreate') != FALSE){
            $result = array(
        	    'name' => trim($this->input->post('name')),
        	    'room_num' => trim($this->input->post('room_num')),
        	    'seat_num' => $this->input->post('seat_num'),
        	    'month_market_num' => $this->input->post('month_market_num'),
        	    'siteId' => $this->input->post('siteId'),
        	    'month_person_num' => $this->input->post('month_person_num'),
	        	'publish_price_fifteen' => trim($this->input->post('publish_price_fifteen')),
	        	'publish_price_thirty' => $this->input->post('publish_price_thirty'),
        		'situation' => $this->input->post('situation'),
        	    'chain' => $this->input->post('chain'),
	            'address' => $this->input->post('address'),
            );
            $checkCustomer = $this->PublicModel->selectSave('*',$this->table,array('name'=>$result['name'],'isDel'=>0,'sId <>'=>$sId),1);
            if(!empty($checkCustomer)){
                $this->showMsg(2,'该影城名称已经存在，请勿重复创建！'); exit;
            }
            $cId = $this->PublicModel->updateSave($this->table,array('sId'=>$sId),$result);
            if(!empty($cId)){
                $this->showMsg(1,'影城编辑成功',self::MENU_LIST);
            }else {
                $this->showMsg(2,'编辑失败！');
            }
        }

        $data['content'] = $this->load->view('media/studioEditView',$parameter,true);
        $this->load->view('index/index',$data);
    }

    public function studioDel($sId){
        $signal = $this->PublicModel->updateSave($this->table,array('sId'=>$sId),array('isDel'=>1));
        if($signal != FALSE) {
            $this->showMsg(1,'信息删除成功',self::MENU_LIST);
        }else {
            $this->showMsg(2,'信息删除失败！');
        }
    }
    
    public function studioDetail($sId){
    	$data = $this->View('media');
        $siteId = $this->SiteModel->getSiteList(0,100,'');
        foreach($siteId as $vs) {
            $siteIdArray[$vs['siteId']] = $vs['name'];
        }
        $list['siteId'] = $siteIdArray;
    	$list['userInfo'] = $this->getAllUserInfo();
    	$list['client'] = $this->PublicModel->selectSave('*',$this->table,array('sId'=>$sId),1);
    	
    	//影城联系人
    	$list['contact'] = $this->PublicModel->selectSave('*','crm_studio_contact',array('sId'=>$sId),2);

    	$data['content'] = $this->load->view('media/studioDetailView',$list,true);
        $this->load->view('index/index',$data);
    }
    
    public function getStudioInfo() {
        $developersInfo = array();
        $developersStr = '';
        $where[] = "siteId in (".$this->session->userdata('siteId').")";
        $dName = $this->_clearSpace($this->input->post('value',true),true);
        $where[] = "name like '%$dName%'";
        $client = $this->StudioModel->studioListResult($where);
        if(!empty($client)) {
            foreach($client as $value) {
                $developersInfo[] = $value;
            }
        }
        if(!empty($developersInfo)) {
            foreach($developersInfo as $v) {
                if(!empty($v['sId'])) {
                    $developersStr .= $v['sId'].'#'.$v['name'].'|';
                }
            }
        }
        echo $developersStr;
    }
    
    

}
?>