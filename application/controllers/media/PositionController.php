<?php
/**
 * @desc 阵地广告执行控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-12-29
 */
class PositionController extends MY_Controller {
	
	protected $advertArray = array();
    protected $table = 'crm_ad_position';
    const MENU_LIST  = "media/PositionController/positionList";

    public function  __construct() {
        parent::__construct();
        $this->config->load('advert', TRUE);
        $this->load->model('media/AdvertModel','',true);
        $this->advertArray['ad_type'] = $this->config->item('ad_type','advert');  //广告形式
        $this->advertArray['pay_type'] = $this->config->item('pay_type','advert');   //支付方式
    }

    public function positionList() {
        $where = $urlArray = array();
        $urlStr = $whereStr = '';
        $data = $this->View('media');

        if(!in_array('allAdPosition',$data['userOpera'])) {
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
                    if(!in_array('allAdPosition',$data['userOpera'])) {
                        $where[] = "a.operator in".$this->uIdDispose();
                    }
                    $where[] = ' a.operator in ('.implode(',', $uIdAssemble).')';
                }else {
                    if(!in_array('allAdPosition',$data['userOpera'])) {
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
        $modelArray['sqlTplFucName'] = 'positionList';
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
        $list['getResult']  = $this->AdvertModel->positionList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);

        foreach($list['getResult'] as $key=>$val) {
            $list['getResult'][$key]['flow'] = $this->PublicModel->getFlowList($val['sId'],$this->table);
        }
        
        $list['advert'] = $this->advertArray;
        $list['org'] = $this->PublicModel->getDepList($arrayList=array(),0,0);
        $data['content'] = $this->load->view('media/positionListView',$list,true);
        $this->load->view('index/index',$data);
    }

    public function positionAdd(){
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
    	        'ad_type' => $this->input->post('ad_type'),
    	        'ad_other' => $this->input->post('ad_other'),
    	        'pay_type' => $this->input->post('pay_type'),
	    	    'remark' => $this->input->post('remark'),
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
        $list['advert'] = $this->advertArray;
        $list['studio'] = $this->PublicModel->selectSave('sId,name','crm_studio',array('isDel'=>0),2);
    	$data['content'] = $this->load->view('media/positionAddView',$list,true);
        $this->load->view('index/index',$data);
    }
    
    public function positionEdit($editId){
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
    	        'ad_type' => $this->input->post('ad_type'),
    	        'ad_other' => $this->input->post('ad_other'),
    	        'pay_type' => $this->input->post('pay_type'),
	    	    'remark' => $this->input->post('remark'),
	    	    'content' => $content,
    	    );

    	    $signal = $this->PublicModel->updateSave($this->table,array('sId'=>$editId),$result);
    	    if($signal != FALSE){
    	    	$this->showMsg(1,'阵地广告执行修改成功',self::MENU_LIST);
    	    }else{
    	    	$this->showMsg(2,'提交失败！');
    	    }
    	}
    	
        $list = $this->AdvertModel->getPositionInfo($editId);
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
    	
    	$list['advert'] = $this->advertArray;
        $list['studio'] = $this->PublicModel->selectSave('sId,name','crm_studio',array('isDel'=>0),2);
    	$data['content'] = $this->load->view('media/positionEditView',$list,true);
        $this->load->view('index/index',$data);
    }
    
    public function positionDetail($detailId){
    	$data = $this->View('media');
    	$parameter = $this->AdvertModel->getPositionInfo($detailId);
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
        $parameter['advert'] = $this->advertArray;

        if($this->input->post('submitCreate') != FALSE){
        	$app_type = $this->input->post('app_type');     //审批结果
            $app_con  = $this->input->post('app_con');      //审批意见
            $flowid   = $this->input->post('flowid');

            $this->PublicModel->controlProcess($this->table,$detailId,2,0,$app_type,$app_con,$flowid);
            $this->showMsg(1,'提交成功','panel/PanelController/panelList');
        }
        $data['directory']  = $this->PublicModel->getProDirectory($getFlowList[0]['fromName'],$getFlowList[0]['fromUid'],$getFlowList[0]['createTime']);
        $data['content'] = $this->load->view('media/positionDetailView',$parameter,true);
        $this->load->view('index/index',$data);
    }
    
    public function positionDel($delId) {
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
