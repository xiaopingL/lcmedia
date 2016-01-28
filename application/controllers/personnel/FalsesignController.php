<?php
/**
 * @desc 误打卡单控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-07-24
 */
class FalsesignController extends MY_Controller {
    protected $table = 'crm_personnel_falsesign';
    const VIEW_LIST  = "personnel/falsesignListView";
    const VIEW_EDIT  = "personnel/falsesignEditView";
    const VIEW_ADD  = "personnel/falsesignAddView";
    const VIEW_LOOK  = "personnel/falsesignLookView";
    const FALSESIGN_LIST = "/personnel/FalsesignController/falsesignListView/";

    public function  __construct() {
        parent::__construct();
        $this->config->load('personnel', TRUE);
        $this->load->model('admin/UserModel','',true);
        $this->load->model('personnel/FalsesignModel','',true);
    }
    public function falsesignListView() {
        $data = $this->View('personnel');
        $whereStr = '';
        //获取填写人姓名
        $uId = $this->session->userdata['uId'];
        $userName = $this->input->get_post('userName',true);
        if(!empty($userName)) {
            $where[] = "b.userName like '%".$userName."%'";
            $urlArray[] = 'userName='.$userName;
        }
        //获取部门
        $sId = $this->input->get_post('sId',true);
        if(!empty($sId)) {
            $urlArray[] = 'sId='.$sId;
            $sIdArray = $this->PublicModel->getAllOrgSublevel($arrayList=array(),$sId,0);
            if(!empty($sIdArray)) {
                $sIdStr = implode(',', $sIdArray);
                $uIdArray = $this->PublicModel->getContactAllUid($sIdStr,0);
                $uIdAssemble = $this->converArr($uIdArray,'uId');
                if(!empty($uIdAssemble)) {
                    if(!empty($uId) && !in_array('allFalsesign',$data['userOpera'])) {
                        $where[] = "a.operator in".$this->uIdDispose();
                    }
                    $where[] = ' a.operator in ('.implode(',', $uIdAssemble).')';
                }else {
                    if(!empty($uId) && !in_array('allFalsesign',$data['userOpera'])) {
                        $where[] = "a.operator in".$this->uIdDispose();
                    }
                }
            }
        }else {
            if(!empty($uId) && !in_array('allFalsesign',$data['userOpera'])) {
                $where[] = "a.operator in".$this->uIdDispose();
            }
        }

        $sTime = $this->input->get_post('sTime',true);
        $eTime = $this->input->get_post('eTime',true);
        $sTime1 = strtotime($sTime);
        $eTime1 = strtotime($eTime);
        if(!empty($sTime1)) {
            $where[] = ' a.createTime >='.$sTime1;
            $urlArray[] = 'sTime='.$sTime;
        }
        if(!empty($eTime1)) {
            $where[] = ' a.createTime <='.$eTime1;
            $urlArray[] = 'eTime='.$eTime;
        }

        //分页所用到的拼接代码
        if(!empty($urlArray)) {
            $urlStr = '/?'.implode('&', $urlArray);
        }
        //条件用来查询岗位名称 合成字符串
        if(!empty($where)) {
            $data['userName'] = $userName;
            $data['sId'] = $sId;
            $data['sTime'] = $sTime;
            $data['eTime'] = $eTime;
            $whereStr = ' and '.implode(" and ",$where);
        }

        $modelArray['modelPath'] = 'personnel';
        $modelArray['modelName'] = 'FalsesignModel';
        $modelArray['sqlTplName'] = 'falsesignSql';
        $modelArray['sqlTplFucName'] = 'falsesignList';
        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);
        $argument	= array(
                'base_url'      => self::FALSESIGN_LIST,
                'per_page'		=> 12,
                'num_links'		=> 3,
                'uri_segment'	=> 4,
                'total_rows'	=> $rows
        );
        $getPaginDatas		= $this->createPagination($argument,$urlStr);
        $data['pagination']	= $getPaginDatas['pagination'];
        $data['rows']       = $rows;
        $data['arr']  = $this->FalsesignModel->falsesignList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        foreach($data['arr'] as $key=>$val) {
            $sidArr   = $this->PublicModel->getContactAllSid($val['operator'],0);
            $data['arr'][$key]['orgName']  = $sidArr[0]['name'];
            $data['arr'][$key]['flow'] = $this->PublicModel->getFlowList($data['arr'][$key]['fId'],$this->table);
        }

        //print_r($data['arr']);exit;
        $data['userInfoArray'] = $this->getAllUserInfo();
        $data['attendance'] = $this->config->item('attendance','personnel');
        $data['carname'] = "误打卡单";
        $data['org'] = $this->PublicModel->getDepList($arrayList=array(),0,0);
        $data['falsesignType'] = $this->config->item('falsesignType','personnel');
        $data['content'] = $this->load->view(self::VIEW_LIST,$data,true);
        $this->load->view('index/index',$data);
    }

    public function falsesignUdelView($fId) {
        $signal = $this->PublicModel->updateSave($this->table,array('fId'=>$fId),array('isDel'=>1));
        if($signal != FALSE) {
            $this->PublicModel->updateSave('crm_pending',array('tableId'=>$fId,'proTable'=>$this->table),array('isDel'=>1));  //软删除待处理事项提醒
            $this->showMsg(1,'信息删除成功',self::FALSESIGN_LIST);
        }else {
            $this->showMsg(2,'信息删除失败！');
        }
    }

    public function falsesignAddView() {
        $data = $this->View('personnel');
        $uId = $this->session->userdata['uId'];
        $userInfoArray = $this->getAllUserInfo();
        $data['uId'] = $uId;
        $data['userInfoArray'] = $userInfoArray;
        $data['falsesignType'] = $this->config->item('falsesignType','personnel');
        $data['content'] = $this->load->view(self::VIEW_ADD,$data,true);
        $this->load->view('index/index',$data);
    }

    public function falsesignInsert() {
        $data = $this->View('personnel');
        $uId = $this->session->userdata['uId'];
        $start_time = strtotime($this->input->post('startDatet'));
        $typef = $this->input->post('typef');
        if(!empty($uId)) {
            $where[] = "operator = ".$uId;
        }
        if(!empty($typef)) {
            $where[] = "type =".$typef;
        }
        if($start_time) {
            $where[] = "startDate =".$start_time;
        }
        if(!empty($where)) {
            $whereStr = ' and '.implode(" and ",$where);
        }
        
        $numberFaslesign = $this->AttendModel->getFalsesignCount();
        if($numberFaslesign > 8){
            $this->showMsg(2,'该月申请误打卡次数已经超过8次，本次申请不予执行。');
            die();
        }

        $arr = $this->FalsesignModel->lookFalseNews($whereStr);
        if(!empty($arr)) {
            $this->showMsg(2,'该时间段已经存在误打卡申请记录，请不要重复填写');
            die();
        }

        if((strtotime(date('Y-m-d'))-$start_time) > (24*60*60*3) or ($start_time-strtotime(date('Y-m-d'))) > (24*60*60)) {
            $this->showMsg(2,'由于您未遵守误打卡制度，超出时间范围，本次申请不予执行。');
            die();
        }
        
        //判断是否请假
        $leaveWhere = array(
                'operator'      => $uId,
                'startDate <='  => $start_time,
                'endDate >='    => $start_time,
                'isDel'         => 0,
                'state <>'      => 2
        );
        $leaveInfo = $this->PublicModel->selectSave('leaveId','crm_personnel_leave',$leaveWhere,3);
        if($leaveInfo>0) {
            $this->showMsg(2,'抱歉，您在申请时间里已经有请假记录了，不需要再申请误打卡单了');
            exit;
        }

        if($typef == 3) {
            $num = 2;
        }else {
            $num = 1;
        }
        $result	= array(
                'operator'=> $uId,
                'cause' => $this->input->post('causef',true),
                'startDate' => $start_time,
                'type' => $typef,
                'num' => $num,
                'createTime'=>time(),
        );
        $fundsId = $this->PublicModel->insertSave($this->table,$result);
        if(!empty($fundsId)) {
            $this->PublicModel->controlProcess($this->table,$fundsId,1);
            $this->showMsg(1,'添加成功',self::FALSESIGN_LIST);
        }else {
            $this->showMsg(2,'添加失败！');
        }
    }

    public function falsesignEditView($fId) {
        $data = $this->View('personnel');
        $data['arr'] = $this->FalsesignModel->falsesignEdit($fId);
        $data['userInfoArray'] = $this->getAllUserInfo();
        $data['falsesignType'] = $this->config->item('falsesignType','personnel');
        $data['content'] = $this->load->view(self::VIEW_EDIT,$data,true);
        $this->load->view('index/index',$data);
    }

    public function falsesignModifyView() {
        $data = $this->View('personnel');
        $fId   = $this->input->post('fId');
        $start_time = strtotime($this->input->post('startDatet'));
        $operator   = $this->input->post('operator');
        $typef = $this->input->post('typef');
        $vv = $this->FalsesignModel->falsesignEdit($fId);

        if(!empty($operator)) {
            $where[] = "operator = ".$operator;
        }
        if(!empty($typef)) {
            $where[] = "type =".$typef;
        }
        if($start_time) {
            $where[] = "startDate =".$start_time;
        }
        if(!empty($where)) {
            $whereStr = ' and '.implode(" and ",$where);
        }
        if($vv['startDate'] == $start_time) {
        }else {
            $arr = $this->FalsesignModel->lookFalseNews($whereStr);
            if(!empty($arr)) {
                $this->showMsg(2,'该时间段已经存在误打卡申请记录，请不要重复填写');
                die();
            }
        }

        if((strtotime(date('Y-m-d'))-$start_time) > (24*60*60*3) or ($start_time-strtotime(date('Y-m-d'))) > (24*60*60)) {
            $this->showMsg(2,'由于您未遵守误打卡制度，超出时间范围，本次申请不予执行。');
            die();
        }
        
        //判断是否请假
        $leaveWhere = array(
                'operator'      => $operator,
                'startDate <='  => $start_time,
                'endDate >='    => $start_time,
                'isDel'         => 0,
                'state <>'      => 2
        );
        $leaveInfo = $this->PublicModel->selectSave('leaveId','crm_personnel_leave',$leaveWhere,3);
        if($leaveInfo>0) {
            $this->showMsg(2,'抱歉，您在申请时间里已经有请假记录了，不需要再申请误打卡单了');
            exit;
        }

        if($typef == 3) {
            $num = 2;
        }else {
            $num = 1;
        }
        $result	= array(
                'cause' => $this->input->post('causef',true),
                'startDate' => $start_time,
                'type' => $typef,
                'num' => $num,
        );
        $fundsId = $this->PublicModel->updateSave($this->table,array('fId'=>$fId),$result);
        if(!empty($fundsId)) {
            $this->showMsg(1,"信息修改成功！",self::FALSESIGN_LIST);
        }else {
            $this->showMsg(2,"信息修改失败！");
        }
    }

    public function falsesignLookView($fId) {
        $data = $this->View('personnel');
        $data['arr'] = $this->FalsesignModel->falsesignEdit($fId);
        $data['falsesignType'] = $this->config->item('falsesignType','personnel');
        $getFlowList = $this->PublicModel->getFlowList($fId,$this->table);
        $data['flowlist']	= $getFlowList;
        if($this->input->post('submitCreate') != FALSE) {
            $app_type = $this->input->post('app_type');     //审批结果
            $app_con  = $this->input->post('app_con');      //审批意见
            $flowid   = $this->input->post('flowid');

            $this->PublicModel->controlProcess($this->table,$fId,2,0,$app_type,$app_con,$flowid);
            $this->showMsg(1,'提交成功','panel/PanelController/panelList');
        }

        if(!empty($data['flowlist'])) {
            $data['directory']  = $this->PublicModel->getProDirectory($getFlowList[0]['fromName'],$getFlowList[0]['fromUid'],$getFlowList[0]['createTime']);
        }
        $data['content'] = $this->load->view(self::VIEW_LOOK,$data,true);
        $this->load->view('index/index',$data);
    }




}


?>
