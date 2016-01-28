<?php
/**
 * @desc 映前广告执行控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-12-28
 */
class ShowController extends MY_Controller {
	
    protected $table = 'crm_ad_show';
    const MENU_LIST  = "media/ShowController/showList";

    public function  __construct() {
        parent::__construct();
        $this->load->model('media/AdvertModel','',true);
    }

    public function showList() {
        $where = $urlArray = array();
        $urlStr = $whereStr = '';
        $data = $this->View('media');

        if(!in_array('allAdShow',$data['userOpera'])) {
            $where[] = "a.operator in".$this->uIdDispose();
        }

        $username = trim($this->input->get_post('username',true));      //获取姓名
        $sId = $this->input->get_post('sId',true);
        $sTime = $this->input->get_post('sTime',true);
        $eTime = $this->input->get_post('eTime',true);
        $sTime1 = strtotime($sTime);
        $eTime1 = strtotime($eTime);
        
        if(!empty($sId)) {
            $urlArray[] = 'sId='.$sId;
            $sIdArray = $this->PublicModel->getAllOrgSublevel($arrayList=array(),$sId,0);
            if(!empty($sIdArray)) {
                $sIdStr = implode(',', $sIdArray);
                $uIdArray = $this->PublicModel->getContactAllUid($sIdStr,0);
                $uIdAssemble = $this->converArr($uIdArray,'uId');
                if(!empty($uIdAssemble)) {
                    if(!in_array('allAdShow',$data['userOpera'])) {
                        $where[] = "a.operator in".$this->uIdDispose();
                    }
                    $where[] = ' a.operator in ('.implode(',', $uIdAssemble).')';
                }else {
                    if(!in_array('allAdShow',$data['userOpera'])) {
                        $where[] = "a.operator in".$this->uIdDispose();
                    }
                }
            }
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
        $modelArray['sqlTplFucName'] = 'showList';
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
        $list['getResult']  = $this->AdvertModel->showList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);

        foreach($list['getResult'] as $key=>$val) {
            $list['getResult'][$key]['flow'] = $this->PublicModel->getFlowList($val['sId'],$this->table);
        }
        
        $list['org'] = $this->PublicModel->getDepList($arrayList=array(),0,0);
        $data['content'] = $this->load->view('media/showListView',$list,true);
        $this->load->view('index/index',$data);
    }

    public function showAdd(){
    	$data = $this->View('media');
    	if($this->input->post('submitCreate') != FALSE){
    	    $title = $this->input->post('title');
    		$startDate = $this->input->post('startDate');
    		$endDate = $this->input->post('endDate');
    		$weekNum = $this->input->post('weekNum');
    		$content = '';
    		if(count($title)>0){
    			foreach($title as $key=>$val){
    				if(!empty($val)){
	    				$content .= $val."##".$startDate[$key]."##".$endDate[$key]."##".$weekNum[$key]."||";
    				}
    			}
    		}

    	    $result = array(
    	        'contractId' => $this->input->post('dNumber'),
    	        'duration' => $this->input->post('duration'),
    	        'supplier' => $this->input->post('supplier'),
    	        'position' => $this->input->post('position'),
	    	    'monitor' => $this->input->post('monitor'),
	    	    'content' => $content,
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
        $list['studio'] = $this->PublicModel->selectSave('sId,name','crm_studio',array('isDel'=>0),2);
    	$data['content'] = $this->load->view('media/showAddView',$list,true);
        $this->load->view('index/index',$data);
    }
    
    public function showEdit($editId){
    	$data = $this->View('media');
    	if($this->input->post('submitCreate') != FALSE){
    	    $title = $this->input->post('title');
    		$startDate = $this->input->post('startDate');
    		$endDate = $this->input->post('endDate');
    		$weekNum = $this->input->post('weekNum');
    		$content = '';
    		if(count($title)>0){
    			foreach($title as $key=>$val){
    				if(!empty($val)){
	    				$content .= $val."##".$startDate[$key]."##".$endDate[$key]."##".$weekNum[$key]."||";
    				}
    			}
    		}
    		
    	    $result = array(
    	        'duration' => $this->input->post('duration'),
    	        'supplier' => $this->input->post('supplier'),
    	        'position' => $this->input->post('position'),
	    	    'monitor' => $this->input->post('monitor'),
	    	    'content' => $content,
    	    );

    	    $signal = $this->PublicModel->updateSave($this->table,array('sId'=>$editId),$result);
    	    if($signal != FALSE){
    	    	$this->showMsg(1,'映前广告执行修改成功',self::MENU_LIST);
    	    }else{
    	    	$this->showMsg(2,'提交失败！');
    	    }
    	}
    	
        $list = $this->AdvertModel->getShowInfo($editId);
    	if(!empty($list['content'])){
    		$contentSum = explode('||',$list['content']);
    	    foreach($contentSum as $key=>$value) {
            if(!empty($value)) {
	                $contentDet = explode('##',$value);
	                $contentList[$key]['title']     = $contentDet[0];
	                $contentList[$key]['startDate'] = $contentDet[1];
	                $contentList[$key]['endDate']   = $contentDet[2];
	                $contentList[$key]['weekNum']   = $contentDet[3];
	            }
	        }
	        $list['contentList'] = $contentList;
    	}
    	
        $list['studio'] = $this->PublicModel->selectSave('sId,name','crm_studio',array('isDel'=>0),2);
    	$data['content'] = $this->load->view('media/showEditView',$list,true);
        $this->load->view('index/index',$data);
    }
    
    public function showDetail($detailId){
    	$data = $this->View('media');
    	$parameter = $this->AdvertModel->getShowInfo($detailId);
        if(!empty($parameter['content'])){
    		$contentSum = explode('||',$parameter['content']);
    	    foreach($contentSum as $key=>$value) {
            if(!empty($value)) {
	                $contentDet = explode('##',$value);
	                $contentList[$key]['title']     = $contentDet[0];
	                $contentList[$key]['startDate'] = $contentDet[1];
	                $contentList[$key]['endDate']   = $contentDet[2];
	                $contentList[$key]['weekNum']   = $contentDet[3];
	            }
	        }
	        $parameter['contentList'] = $contentList;
    	}
    	$getFlowList = $this->PublicModel->getFlowList($detailId,$this->table);
        $parameter['flowlist'] = $getFlowList;
        $parameter['studioList'] = $this->getStudioInfoArray();

        if($this->input->post('submitCreate') != FALSE){
        	$app_type = $this->input->post('app_type');     //审批结果
            $app_con  = $this->input->post('app_con');      //审批意见
            $flowid   = $this->input->post('flowid');

            $this->PublicModel->controlProcess($this->table,$detailId,2,0,$app_type,$app_con,$flowid);
            $this->showMsg(1,'提交成功','panel/PanelController/panelList');
        }
        $data['directory']  = $this->PublicModel->getProDirectory($getFlowList[0]['fromName'],$getFlowList[0]['fromUid'],$getFlowList[0]['createTime']);
        $data['content'] = $this->load->view('media/showDetailView',$parameter,true);
        $this->load->view('index/index',$data);
    }
    
    public function showDel($delId) {
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
