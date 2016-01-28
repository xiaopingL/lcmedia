<?php
/**
 * @desc 工作周/月报控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-12-15
 */
class ReportController extends MY_Controller {
    const MENU_ADD  = "public/ReportController/reportAddView";
    const MENU_LIST = "public/ReportController/reportListView";
    protected $table = 'crm_report';

    public function  __construct(){
        parent::__construct();
        $this->load->model('public/JournaModel','',true);
        $this->config->load('journal',true);
    }

    public function reportListView(){
        $data = $this->View('panel');
        $username = $this->input->get_post('username',true);
        $btime    = $this->input->get_post('btime',true);
        $etime    = $this->input->get_post('etime',true);
        $where[] = "a.operator in ".$this->uIdDispose();
        
        $type = $this->input->get('type');  //报表类型  week、周报  month、月报
        if(!empty($type)){
        	$where[] = "a.type='".$type."'";
        	$data['type'] = $type;
        	$urlArray[] = 'type='.$type;
        }else{
        	$this->showMsg(2,'参数错误，拒绝访问！'); exit;
        }
        
        if(!empty($username)) {
            $where[] = "b.userName like '%".$username."%'";
            $data['username'] = $username;
            $urlArray[] = 'username='.$username;
        }
        $sId = $this->input->get_post('sId',true);
        if(!empty($sId)) {
            $urlArray[] = 'sId='.$sId;
            $sIdArray = $this->PublicModel->getAllOrgSublevel($arrayList=array(),$sId,0);
            if(!empty($sIdArray)) {
                $sIdStr = implode(',', $sIdArray);
                $uIdArray = $this->PublicModel->getContactAllUid($sIdStr,0);
                $uIdAssemble = $this->converArr($uIdArray,'uId');
                if(!empty($uIdAssemble)) {
                    if(!empty($uId) && !in_array('allJournal',$data['userOpera'])) {
                        $where[] = "a.operator in".$this->uIdDispose();
                    }
                    $where[] = ' a.operator in ('.implode(',', $uIdAssemble).')';
                }else {
                    if(!empty($uId) && !in_array('allJournal',$data['userOpera'])) {
                        $where[] = "a.operator in".$this->uIdDispose();
                    }
                }
            }
        }else {
                $where[] = "a.operator in".$this->uIdDispose();
        }
        
        if(!empty($btime)) {
            $data['btime'] = $btime;
            $urlArray[] = 'btime='.$btime;
            $btimeS = strtotime($btime.' 00:00:00');
            $where[] = ' a.createTime>='.$btimeS;
        }
        if(!empty($etime)) {
            $data['etime'] = $etime;
            $urlArray[] = 'etime='.$etime;
            $btimeE = strtotime($etime.' 23:59:59');
            $where[] = ' a.createTime<='.$btimeE;
        }
        if(!empty($where)) {
            $data['sId'] = $sId;
            $whereStr = ' and '.implode(" and ",$where);
        }
        if(!empty($urlArray)) {
            $urlStr = '/?'.implode('&', $urlArray);
        }
        $modelArray['modelPath'] = 'public';
        $modelArray['modelName'] = 'JournaModel';
        $modelArray['sqlTplName'] = 'journaSql';
        $modelArray['sqlTplFucName'] = 'getReportList';
        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);
        $argument = array(
                'base_url'      => self::MENU_LIST,
                'per_page'		=> 12,
                'num_links'		=> 3,
                'uri_segment'   => 4,
                'total_rows'    => $rows
        );
        $getPaginDatas		= $this->createPagination($argument,$urlStr);
        $data['pagination']	= $getPaginDatas['pagination'];
        $data['rows']       = $rows;
        $data['result']  = $this->JournaModel->getReportList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        foreach($data['result'] as $key=>$val){
        	$fileData = $this->PublicModel->getFile($val['fId']);
            $data['result'][$key]['origName']  = $fileData['origName'];
        }
        $data['journalType'] = $this->config->item('journalType','journal');
        $data['org'] = $this->PublicModel->getDepList($arrayList=array(),0,0);
        $data['carname'] = $type=='week'?'工作周报':'工作月报';
        $data['content'] = $this->load->view('public/reportListView',$data,true);
        $this->load->view('index/index',$data);
    }
    
    public function getReportTitle($type){
    	if($type == 'week'){
    	    $getWeek  = $this->getWeek();
    	}else{
    	    $getWeek  = date('Y')."年".date('m')."月份月";
    	}
    	return $getWeek;
    }

    public function reportAddView() {
        $data = $this->View('panel');
        $data['type'] = $this->input->get('type');
        $data['getWeek'] = $this->getReportTitle($data['type']);
        if($this->input->post('submitCreate') != FALSE){
        	$result = array(
        	   'title' => $this->input->post('title',true),
        	   'type' => $data['type'],
        	   'fId' => $this->input->post('include',true),
        	   'remark' => $this->input->post('remark'),
        	   'createTime' => time(),
        	   'operator' => $this->session->userdata['uId'],
        	   'isDel' => 0
        	);
        	
        	$reportInfo = $this->PublicModel->selectSave('rId',$this->table,array('operator'=>$result['operator'],'title'=>$result['title'],'isDel'=>0));
        	if(count($reportInfo)>0){
        		$this->showMsg(2,'该标题已经存在。请重新填写！');  exit;
        	}
        	
        	$rId = $this->PublicModel->insertSave($this->table,$result);
        	if($rId){
        		$this->showMsg(1,'提交成功','public/ReportController/reportListView/?type='.$data['type']);
        	}else {
                $this->showMsg(2,'提交失败！');  exit;
            }
        }
        $data['content'] = $this->load->view('public/reportAddView',$data,true);
        $this->load->view('index/index',$data);
    }

    public function reportDel($rId) {
        if(is_numeric($rId)) {
        	$reportInfo = $this->PublicModel->selectSave('type',$this->table,array('rId'=>$rId),1);
            $signal = $this->PublicModel->updateSave($this->table,array('rId'=>$rId),array('isDel'=>1));
            if($signal != FALSE) {
                $this->showMsg(1,'删除成功','public/ReportController/reportListView/?type='.$reportInfo['type']);
            }
        }else {
            exit;
        }
    }


}

?>
