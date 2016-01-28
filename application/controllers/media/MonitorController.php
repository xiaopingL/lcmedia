<?php
/**
 * @desc 广告监测（日/周）控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2016-1-27
 */
class MonitorController extends MY_Controller {
    const MENU_ADD  = "public/MonitorController/monitorAddView";
    const MENU_LIST = "public/MonitorController/monitorListView";
    protected $table = 'crm_ad_monitor';

    public function  __construct(){
        parent::__construct();
        $this->load->model('media/AdvertModel','',true);
        $this->config->load('advert',true);
    }

    public function monitorListView(){
        $data = $this->View('media');
        $username = $this->input->get_post('username',true);
        $btime    = $this->input->get_post('btime',true);
        $etime    = $this->input->get_post('etime',true);
        $where[] = "a.operator in ".$this->uIdDispose();
        
        $type = $this->input->get('type');  //报表类型  day、媒体  week、全国
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
            $whereStr = ' and '.implode(" and ",$where);
        }
        if(!empty($urlArray)) {
            $urlStr = '/?'.implode('&', $urlArray);
        }
        $modelArray['modelPath'] = 'public';
        $modelArray['modelName'] = 'AdvertModel';
        $modelArray['sqlTplName'] = 'publicSql';
        $modelArray['sqlTplFucName'] = 'getMonitorList';
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
        $data['result']  = $this->AdvertModel->getMonitorList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        foreach($data['result'] as $key=>$val){
        	$fileData = $this->PublicModel->getFile($val['fId']);
            $data['result'][$key]['origName']  = $fileData['origName'];
        }
        $data['monitorType'] = $this->config->item('monitorType','advert');
        $data['carname'] = $type=='day'?'媒体广告监测':'全国广告监测';
        $data['content'] = $this->load->view('media/monitorListView',$data,true);
        $this->load->view('index/index',$data);
    }
    
    public function getMonitorTitle($type){
    	if($type == 'day'){
    	    $getTitle = "媒体广告监测 ".date('Y-m-d');
    	}else{
    	    $getTitle = "全国广告监测 ".date('Y-m-d');
    	}
    	return $getTitle;
    }

    public function monitorAddView() {
        $data = $this->View('media');
        $data['type'] = $this->input->get('type');
        $data['getWeek'] = $this->getMonitorTitle($data['type']);
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
        		$this->showMsg(1,'提交成功','media/MonitorController/monitorListView/?type='.$data['type']);
        	}else {
                $this->showMsg(2,'提交失败！');  exit;
            }
        }
        $data['content'] = $this->load->view('media/monitorAddView',$data,true);
        $this->load->view('index/index',$data);
    }

    public function monitorDel($rId) {
        if(is_numeric($rId)) {
        	$monitorInfo = $this->PublicModel->selectSave('type',$this->table,array('rId'=>$rId),1);
            $signal = $this->PublicModel->updateSave($this->table,array('rId'=>$rId),array('isDel'=>1));
            if($signal != FALSE) {
                $this->showMsg(1,'删除成功','media/MonitorController/monitorListView/?type='.$monitorInfo['type']);
            }
        }else {
            exit;
        }
    }


}

?>
