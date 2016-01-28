<?php
/**
 * @desc 个人日志控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-11-05
 */
class JournalController extends MY_Controller {
    const MENU_ADD  = "public/JournalController/journalAddView";
    const MENU_LIST = "public/JournalController/journalListView";
    const VIEW_LIST  = "public/journalListView";
    const VIEW_ADD  = "public/journalAddView";
    const VIEW_EDIT  = "public/journalEditView";
    const VIEW_DETAIL  = "public/journalDetailView";
    protected $table = 'crm_public_journal';
    protected $tableDetail = 'crm_public_logdetail';

    public function  __construct() {
        parent::__construct();
        $this->load->model('public/JournaModel','',true);
        $this->config->load('journal',true);
    }

    public function journalListView() {
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
        $modelArray['sqlTplFucName'] = 'getJournaList';
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
        $data['result']  = $this->JournaModel->getJournaList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        $data['journalType'] = $this->config->item('journalType','journal');
        $data['org'] = $this->PublicModel->getDepList($arrayList=array(),0,0);
        $data['carname'] = "个人工作日志";
        $data['userArray'] = $this->getAllUserInfo();
        $data['content'] = $this->load->view('public/journalListView',$data,true);
        $this->load->view('index/index',$data);
    }

    public function journalAddView() {
        $data = $this->View('panel');
        $data['content'] = $this->load->view(self::VIEW_ADD,$data,true);
        $this->load->view('index/index',$data);
    }
    public function journalInsertView() {
        $data = $this->View('panel');
        $logDate = strtotime($this->input->post('logDate',true));
        $dateTime = time();
        if($logDate>time()) {
            $this->showMsg(2,'日期选择有误！');
            exit;
        }
        $result = array(
                'journalTitle' => "工作日志 ".$this->input->post('logDate',true),
                'startDate'    => strtotime($this->input->post('logDate')." 00:00:00"),
                'endDate'      => strtotime($this->input->post('logDate')." 23:59:59"),
                'createTime'   => $dateTime,
                'operator'     => $this->session->userdata('uId'),
                'journalExperience' => $this->input->post('journalExperience',true),
                'journalSugges' => $this->input->post('journalSugges',true),
        );
        
        $checkLog = $this->JournaModel->checkLog($result['operator'],$logDate);
        if($checkLog > 0) {
            $this->showMsg(2,'对不起，您选择的日期日志已存在，请重新操作！');
            exit;
        }
        $pId = $this->PublicModel->insertSave($this->table,$result);

        $logDescription  = $this->input->post('logDescription',true);
        $timeConsuming  = $this->input->post('timeConsuming',true);
        $completion  = $this->input->post('completion',true);
        $noComplete  = $this->input->post('noComplete',true);
        $improvementMeasures  = $this->input->post('improvementMeasures',true);
        $deadline  = $this->input->post('deadline',true);
        foreach($logDescription as $key=>$val) {
            if($val != '') {
                $planResult = array(
                        'pId'        => $pId,
                        'type'       => 1,
                        'logDescription' => $val,
                        'timeConsuming'    => $timeConsuming[$key],
                        'completion'       => $completion[$key],
                        'noComplete'         => $noComplete[$key],
                        'improvementMeasures'  => $improvementMeasures[$key],
                        'deadline'             => $deadline[$key],
                        'createTime'       => $dateTime,
                        'operator'         => $this->session->userdata('uId')
                );
                $this->PublicModel->insertSave($this->tableDetail,$planResult);
            }
        }
        $logDescription_ls  = $this->input->post('logDescription_ls',true);
        $timeConsuming_ls  = $this->input->post('timeConsuming_ls',true);
        $completion_ls  = $this->input->post('completion_ls',true);
        $noComplete_ls  = $this->input->post('noComplete_ls',true);
        $improvementMeasures_ls  = $this->input->post('improvementMeasures_ls',true);
        $deadline_ls  = $this->input->post('deadline_ls',true);
        foreach($logDescription_ls as $key=>$val) {
            if($val != '') {
                $planResult = array(
                        'pId'        => $pId,
                        'type'       => 2,
                        'logDescription' => $val,
                        'timeConsuming'    => $timeConsuming_ls[$key],
                        'completion'       => $completion_ls[$key],
                        'noComplete'         => $noComplete_ls[$key],
                        'improvementMeasures'  => $improvementMeasures_ls[$key],
                        'deadline'             => $deadline_ls[$key],
                        'createTime'       => $dateTime,
                        'operator'         => $this->session->userdata('uId')
                );
                $this->PublicModel->insertSave($this->tableDetail,$planResult);
            }
        }
        $logDescription_mrjh  = $this->input->post('logDescription_mrjh',true);
        $timeConsuming_ls_mrjh  = $this->input->post('timeConsuming_ls_mrjh',true);
        $cxwt_mrjh = $this->input->post('cxwt_mrjh',true);
        $ydcs_mrjh = $this->input->post('ydcs_mrjh',true);
        $gjcs_mrjh = $this->input->post('gjcs_mrjh',true);
        foreach($logDescription_mrjh as $key=>$val) {
            if($val != '') {
                $planResult = array(
                        'pId'        => $pId,
                        'type'       => 3,
                        'logDescription' => $val,
                        'timeConsuming'    => $timeConsuming_ls_mrjh[$key],
                        'completion'       => $cxwt_mrjh[$key],
                        'noComplete'         => $ydcs_mrjh[$key],
                        'improvementMeasures'  => $gjcs_mrjh[$key],
                        'createTime'       => $logDate,
                        'operator'         => $this->session->userdata('uId')
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

    public function journalDel($pId) {
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

    public function journalEditView($pId) {
        $data = $this->View('panel');
        $data['arr'] = $this->JournaModel->journalEditNews($pId);
        $data['result'] = $this->JournaModel->journalInfo($pId,1);  //今日工作总结
        $data['rows'] = $this->JournaModel->journalInfo($pId,2);    //临时工作计划
        $data['getArray'] = $this->JournaModel->journalInfo($pId,3);//明日工作计划
        $data['content'] = $this->load->view(self::VIEW_EDIT,$data,true);
        $this->load->view('index/index',$data);
    }

    public function journalModify() {
        $data = $this->View('panel');
        $pId = $this->input->post('pId',true);
        $operator = $this->input->post('operator',true);
        $dateTime = time();
        $this->db->delete($this->tableDetail,array('pId'=>$pId));
        //新增任务计划
        $logDescription  = $this->input->post('logDescription',true);
        $timeConsuming  = $this->input->post('timeConsuming',true);
        $completion  = $this->input->post('completion',true);
        $noComplete  = $this->input->post('noComplete',true);
        $improvementMeasures  = $this->input->post('improvementMeasures',true);
        $deadline  = $this->input->post('deadline',true);
        foreach($logDescription as $key=>$val) {
            if($val != '') {
                $planResult = array(
                        'pId'        => $pId,
                        'type'       => 1,
                        'logDescription' => $val,
                        'timeConsuming'    => $timeConsuming[$key],
                        'completion'       => $completion[$key],
                        'noComplete'         => $noComplete[$key],
                        'improvementMeasures'  => $improvementMeasures[$key],
                        'deadline'             => $deadline[$key],
                        'createTime'       => $dateTime,
                        'operator'         => $operator,
                );
                $this->PublicModel->insertSave($this->tableDetail,$planResult);
            }
        }
        $logDescription_ls  = $this->input->post('logDescription_ls',true);
        $timeConsuming_ls  = $this->input->post('timeConsuming_ls',true);
        $completion_ls  = $this->input->post('completion_ls',true);
        $noComplete_ls  = $this->input->post('noComplete_ls',true);
        $improvementMeasures_ls  = $this->input->post('improvementMeasures_ls',true);
        $deadline_ls  = $this->input->post('deadline_ls',true);
        foreach($logDescription_ls as $key=>$val) {
            if($val != '') {
                $planResult = array(
                        'pId'        => $pId,
                        'type'       => 2,
                        'logDescription' => $val,
                        'timeConsuming'    => $timeConsuming_ls[$key],
                        'completion'       => $completion_ls[$key],
                        'noComplete'         => $noComplete_ls[$key],
                        'improvementMeasures'  => $improvementMeasures_ls[$key],
                        'deadline'             => $deadline_ls[$key],
                        'createTime'       => $dateTime,
                        'operator'         => $operator,
                );
                $this->PublicModel->insertSave($this->tableDetail,$planResult);
            }
        }
        $logDescription_mrjh  = $this->input->post('logDescription_mrjh',true);
        $timeConsuming_ls_mrjh  = $this->input->post('timeConsuming_ls_mrjh',true);
        $cxwt_mrjh = $this->input->post('cxwt_mrjh',true);
        $ydcs_mrjh = $this->input->post('ydcs_mrjh',true);
        $gjcs_mrjh = $this->input->post('gjcs_mrjh',true);
        foreach($logDescription_mrjh as $key=>$val) {
            if($val != '') {
                $planResult = array(
                        'pId'        => $pId,
                        'type'       => 3,
                        'logDescription' => $val,
                        'timeConsuming'    => $timeConsuming_ls_mrjh[$key],
                        'completion'       => $cxwt_mrjh[$key],
                        'noComplete'         => $ydcs_mrjh[$key],
                        'improvementMeasures'  => $gjcs_mrjh[$key],
                        'createTime'       => $dateTime,
                        'operator'         => $operator,
                );
                $this->PublicModel->insertSave($this->tableDetail,$planResult);
            }
        }
        $journalExperience  = $this->input->post('journalExperience',true);
        $journalSugges  = $this->input->post('journalSugges',true);
        $rel = array(
                'journalExperience'=>$journalExperience,
                'journalSugges'=>$journalSugges,
                'updateTime'=>time()
        );
        $funId = $this->PublicModel->updateSave($this->table,array('pId'=>$pId),$rel);
        if($funId) {
            $this->showMsg(1,'修改成功',self::MENU_LIST);
        }else {
            $this->showMsg(2,'修改失败！');
            exit;
        }
    }

    public function journalDetailView($pId) {
        $data = $this->View('panel');
        $data['arr'] = $this->JournaModel->journalEditNews($pId);
        $data['result'] = $this->JournaModel->journalInfo($pId,1);  //今日工作总结
        $data['rows'] = $this->JournaModel->journalInfo($pId,2);    //临时工作计划
        $data['getArray'] = $this->JournaModel->journalInfo($pId,3);//明日工作计划
        if($this->input->post('submitCreate') != FALSE) {
            $pId = $this->input->post('pId',true);
            $result = array(
                'journalRemarks'=>$this->input->post('journalRemarks',true),
                'evaTime'=>time(),
            );
            $signal = $this->PublicModel->updateSave($this->table,array('pId'=>$pId),$result);
            if($signal != FALSE) {
                $this->showMsg(1,'点评日志成功',self::MENU_LIST);
            }
        }
        $data['userArray'] = $this->getAllUserInfo();
        $data['content'] = $this->load->view(self::VIEW_DETAIL,$data,true);
        $this->load->view('index/index',$data);
    }
    public function setScore() {
        $score = $this->input->post('score',true);
        $pId   = $this->input->post('pId',true);
        $getResult = $this->JournaModel->journalEditNews($pId);
        
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
