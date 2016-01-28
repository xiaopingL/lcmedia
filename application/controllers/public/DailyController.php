<?php
/**
 * @desc 业务日志控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-11-05
 */
class DailyController extends MY_Controller {
    const MENU_ADD  = "public/DailyController/dailyAddView";
    const MENU_LIST = "public/DailyController/dailyListView";
    const VIEW_LIST  = "public/dailyListView";
    const VIEW_ADD  = "public/dailyAddView";
    const VIEW_EDIT  = "public/dailyEditView";
    const VIEW_DETAIL  = "public/dailyDetailView";
    protected $table = 'crm_daily';
    protected $tableDetail = 'crm_daily_detail';

    public function  __construct(){
        parent::__construct();
        $this->load->model('public/JournaModel','',true);
        $this->load->model('business/CustomerModel','',true);
        $this->config->load('journal',true);
    }

    public function dailyListView(){
        $data = $this->View('panel');
        $username = $this->input->get_post('username',true);
        $btime    = $this->input->get_post('btime',true);
        $etime    = $this->input->get_post('etime',true);
        $where[] = "a.operator in ".$this->uIdDispose();
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
            $where[] = ' a.startDate>='.$btimeS;
        }
        if(!empty($etime)) {
            $data['etime'] = $etime;
            $urlArray[] = 'etime='.$etime;
            $btimeE = strtotime($etime.' 23:59:59');
            $where[] = ' a.endDate<='.$btimeE;
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
        $modelArray['sqlTplFucName'] = 'getDailyList';
        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);
        $argument = array(
                'base_url' => self::MENU_LIST,
                'per_page'		=> 12,
                'num_links'		=> 3,
                'uri_segment'       => 4,
                'total_rows'        => $rows
        );
        $getPaginDatas		= $this->createPagination($argument,$urlStr);
        $data['pagination']	= $getPaginDatas['pagination'];
        $data['rows']       = $rows;
        $data['arr_month']	= array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
        $data['result']  = $this->JournaModel->getDailyList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        $data['journalType'] = $this->config->item('journalType','journal');
        $data['org'] = $this->PublicModel->getDepList($arrayList=array(),0,0);
        $data['carname'] = "业务工作日志";
        $data['userArray'] = $this->getAllUserInfo();
        $data['content'] = $this->load->view('public/dailyListView',$data,true);
        $this->load->view('index/index',$data);
    }

    public function dailyAddView() {
        $data = $this->View('panel');
        $data['shape'] = $this->config->item('dailyShape','journal');
        $data['client'] = $this->CustomerModel->getMyClientInfo();
        if(empty($data['client'])){
        	$this->showMsg(2,'抱歉，由于您没有客户，拒绝访问！'); exit;
        }
        $data['content'] = $this->load->view(self::VIEW_ADD,$data,true);
        $this->load->view('index/index',$data);
    }
    
    public function dailyInsertView() {
        $data = $this->View('panel');
        $logDate = strtotime($this->input->post('logDate',true));
        $dateTime = time();
        if($logDate>time()) {
            $this->showMsg(2,'日期选择有误！');
            exit;
        }
        $result = array(
                'dailyTitle'   => "工作日志 ".$this->input->post('logDate',true),
                'startDate'    => strtotime($this->input->post('logDate')." 00:00:00"),
                'endDate'      => strtotime($this->input->post('logDate')." 23:59:59"),
                'createTime'   => $dateTime,
                'operator'     => $this->session->userdata('uId'),
                'other'        => $this->input->post('other',true),
        );
        
        $checkLog = $this->JournaModel->checkDaily($result['operator'],$logDate);
        if($checkLog > 0) {
            $this->showMsg(2,'对不起，您选择的日期日志已存在，请重新操作！');
            exit;
        }
        $pId = $this->PublicModel->insertSave($this->table,$result);

        $clientName  = $this->input->post('clientName',true);
        $userName  = $this->input->post('userName',true);
        $shape  = $this->input->post('shape',true);
        $content  = $this->input->post('content',true);
        $plan  = $this->input->post('plan',true);
        foreach($clientName as $key=>$val) {
            if($val != '') {
                $planResult = array(
                        'pId'        => $pId,
                        'type'       => 1,
                        'clientName' => $val,
                        'userName'   => $userName[$key],
                        'shape'       => $shape[$key],
                        'content'    => $content[$key],
                        'plan'       => $plan[$key],
                        'createTime' => $dateTime,
                        'operator'   => $this->session->userdata('uId')
                );
                $this->PublicModel->insertSave($this->tableDetail,$planResult);
            }
        }
        $morning  = $this->input->post('morning',true);
        $mTarget  = $this->input->post('mTarget',true);
        $afternoon  = $this->input->post('afternoon',true);
        $aTarget  = $this->input->post('aTarget',true);
        foreach($morning as $key=>$val) {
            if($val != '') {
                $planResult = array(
                        'pId'        => $pId,
                        'type'       => 2,
                        'morning'    => $val,
                        'mTarget'    => $mTarget[$key],
                        'afternoon'  => $afternoon[$key],
                        'aTarget'    => $aTarget[$key],
                        'createTime' => $dateTime,
                        'operator'   => $this->session->userdata('uId')
                );
                $this->PublicModel->insertSave($this->tableDetail,$planResult);
            }
        }

        if($pId) {
            $this->showMsg(1,'保存成功',self::MENU_LIST);
        }else {
            $this->showMsg(2,'提交失败！');
            exit;
        }
    }

    public function dailyDel($pId) {
        if(is_numeric($pId)) {
            $signal = $this->PublicModel->updateSave($this->table,array('pId'=>$pId),array('isDel'=>1));
            $this->db->delete($this->tableDetail,array('pId'=>$pId));    //删除工作记录
            if($signal != FALSE) {
                $this->showMsg(1,'删除成功',self::MENU_LIST);
            }
        }else {
            exit;
        }
    }

    public function dailyEditView($pId) {
        $data = $this->View('panel');
        $data['arr'] = $this->JournaModel->dailyEditNews($pId);
        $data['result'] = $this->JournaModel->dailyInfo($pId,1);   //拜访情况
        $data['rows'] = $this->JournaModel->dailyInfo($pId,2);     //明日计划
        
        $data['shape'] = $this->config->item('dailyShape','journal');
        $data['client'] = $this->CustomerModel->getMyClientInfo();
        $data['content'] = $this->load->view(self::VIEW_EDIT,$data,true);
        $this->load->view('index/index',$data);
    }

    public function dailyModify() {
        $data = $this->View('panel');
        $pId = $this->input->post('pId',true);
        $operator = $this->input->post('operator',true);
        $dateTime = time();
        $this->db->delete($this->tableDetail,array('pId'=>$pId));
        //新增拜访情况
        $clientName  = $this->input->post('clientName',true);
        $userName  = $this->input->post('userName',true);
        $shape  = $this->input->post('shape',true);
        $content  = $this->input->post('content',true);
        $plan  = $this->input->post('plan',true);
        
        foreach($clientName as $key=>$val) {
            if($val != '') {
                $planResult = array(
                        'pId'        => $pId,
                        'type'       => 1,
                        'clientName' => $val,
                        'userName'   => $userName[$key],
                        'shape'       => $shape[$key],
                        'content'    => $content[$key],
                        'plan'       => $plan[$key],
                        'createTime' => $dateTime,
                        'operator'   => $operator,
                );
                $this->PublicModel->insertSave($this->tableDetail,$planResult);
            }
        }
        $morning  = $this->input->post('morning',true);
        $mTarget  = $this->input->post('mTarget',true);
        $afternoon  = $this->input->post('afternoon',true);
        $aTarget  = $this->input->post('aTarget',true);
        foreach($morning as $key=>$val) {
            if($val != '') {
                $planResult = array(
                        'pId'        => $pId,
                        'type'       => 2,
                        'morning'    => $val,
                        'mTarget'    => $mTarget[$key],
                        'afternoon'  => $afternoon[$key],
                        'aTarget'    => $aTarget[$key],
                        'createTime' => $dateTime,
                        'operator'   => $operator,
                );
                $this->PublicModel->insertSave($this->tableDetail,$planResult);
            }
        }

        $rel = array(
                'other' => $this->input->post('other',true),
                'updateTime' => time()
        );
        $funId = $this->PublicModel->updateSave($this->table,array('pId'=>$pId),$rel);
        if($funId) {
            $this->showMsg(1,'修改成功',self::MENU_LIST);
        }else {
            $this->showMsg(2,'修改失败！');
            exit;
        }
    }

    public function dailyDetailView($pId){
        $data = $this->View('panel');
        $data['arr'] = $this->JournaModel->dailyEditNews($pId);
        $data['result'] = $this->JournaModel->dailyInfo($pId,1);  //拜访情况
        $data['rows'] = $this->JournaModel->dailyInfo($pId,2);    //明日计划
        if($this->input->post('submitCreate') != FALSE) {
            $pId = $this->input->post('pId',true);
            $result = array(
                'remarks'=>$this->input->post('remarks',true),
                'evaTime'=>time(),
            );
            $signal = $this->PublicModel->updateSave($this->table,array('pId'=>$pId),$result);
            if($signal != FALSE) {
                $this->showMsg(1,'点评日志成功',self::MENU_LIST);
            }
        }
        $data['userArray'] = $this->getAllUserInfo();
        $data['clientArray'] = $this->getClientInfoArray();
        $data['shape'] = $this->config->item('dailyShape','journal');
        $data['content'] = $this->load->view(self::VIEW_DETAIL,$data,true);
        $this->load->view('index/index',$data);
    }
    
    public function setScore() {
        $score = $this->input->post('score',true);
        $pId   = $this->input->post('pId',true);
        $getResult = $this->JournaModel->dailyEditNews($pId);
        
        if(!empty($score) && empty($getResult['score'])) {
            $jobId = $this->session->userdata['jobId'];
            $uId   = $this->session->userdata['uId'];
            if($jobId == 5 || $getResult['operator'] == $uId) {
                echo 'N';
                exit;
            }else {
                $this->PublicModel->updateSave($this->table,array('pId'=>$pId),array('score'=>$score,'uId'=>$this->session->userdata('uId')));
                echo "Y";
            }
        }
    }


}

?>
