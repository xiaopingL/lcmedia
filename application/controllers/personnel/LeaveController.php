<?php
/**
 * @desc 请假单控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-07-23
 */
class LeaveController extends MY_Controller {
    protected $table = 'crm_personnel_leave';
    const VIEW_LIST  = "personnel/leaveListView";
    const VIEW_EDIT  = "personnel/leaveEditView";
    const VIEW_ADD  = "personnel/leaveAddView";
    const VIEW_LOOK  = "personnel/leaveLookView";
    const LEAVE_LIST = "/personnel/LeaveController/leaveListView";

    public function  __construct() {
        parent::__construct();
        $this->config->load('personnel', TRUE);
        $this->load->model('personnel/LeaveModel','',true);
    }
    public function leaveListView() {
        $data = $this->View('personnel');
        $whereStr = '';
        //获取填写人
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
                    if(!empty($uId) && !in_array('allLeave',$data['userOpera'])) {
                        $where[] = "a.operator in".$this->uIdDispose();
                    }
                    $where[] = ' a.operator in ('.implode(',', $uIdAssemble).')';
                }else {
                    if(!empty($uId) && !in_array('allLeave',$data['userOpera'])) {
                        $where[] = "a.operator in".$this->uIdDispose();
                    }
                }
            }
        }else {
            if(!empty($uId) && !in_array('allLeave',$data['userOpera'])) {
                $where[] = "a.operator in".$this->uIdDispose();
            }
        }

        $type = $this->input->get_post('type',true);
        if(!empty($type)) {
            $where[] = "a.type = ".$type;
            $urlArray[] = 'type='.$type;
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
            $data['sTime'] = $sTime;
            $data['eTime'] = $eTime;
            $data['type'] = $type;
            $data['sId'] = $sId;
            $whereStr = ' and '.implode(" and ",$where);
        }

        $modelArray['modelPath'] = 'personnel';
        $modelArray['modelName'] = 'LeaveModel';
        $modelArray['sqlTplName'] = 'leaveSql';
        $modelArray['sqlTplFucName'] = 'leaveList';
        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);
        $argument	= array(
                'base_url'      => self::LEAVE_LIST,
                'per_page'		=> 12,
                'num_links'		=> 3,
                'uri_segment'	=> 4,
                'total_rows'	=> $rows
        );
        $getPaginDatas		= $this->createPagination($argument,$urlStr);
        $data['pagination']	= $getPaginDatas['pagination'];
        $data['rows']       = $rows;
        $data['arr']  = $this->LeaveModel->leaveList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        foreach($data['arr'] as $key=>$val) {
            $data['arr'][$key]['flow'] = $this->PublicModel->getFlowList($data['arr'][$key]['leaveId'],$this->table);
        }
        $data['userInfoArray'] = $this->getAllUserInfo();
        $data['attendance'] = $this->config->item('attendance','personnel');
        $data['carname'] = "请假单";
        $data['org'] = $this->PublicModel->getDepList($arrayList=array(),0,0);
        $data['leaveType'] = $this->config->item('leaveType','personnel');
        $data['content'] = $this->load->view(self::VIEW_LIST,$data,true);
        $this->load->view('index/index',$data);
    }

    public function leaveUdelView($leaveId) {
        $signal = $this->PublicModel->updateSave($this->table,array('leaveId'=>$leaveId),array('isDel'=>1));
        if($signal != FALSE) {
            $this->PublicModel->updateSave('crm_pending',array('tableId'=>$leaveId,'proTable'=>$this->table),array('isDel'=>1));  //软删除待处理事项提醒
            $this->showMsg(1,'信息删除成功',self::LEAVE_LIST);
        }else {
            $this->showMsg(2,'信息删除失败！');
        }
    }

    public function leaveAddView() {
        $data = $this->View('personnel');
        $uId = $this->session->userdata['uId'];
        $userInfoArray = $this->getAllUserInfo();
        $data['uId'] = $uId;
        $data['userInfoArray'] = $userInfoArray;
        $data['leaveType'] = $this->config->item('leaveType','personnel');
        $data['content'] = $this->load->view(self::VIEW_ADD,$data,true);
        $this->load->view('index/index',$data);
    }

    public function leaveInsert() {
        $data = $this->View('personnel');
        $uId = $this->session->userdata['uId'];
        $start_time = strtotime($this->input->post('sTimet').' '.$this->input->post('start_hour').':00');
        $end_time = strtotime($this->input->post('eTimet').' '.$this->input->post('end_hour').':00');
        $type = $this->input->post('type',true);
        if(($end_time-$start_time) < 0) {
            $this->showMsg(2,'请假时间选择错误！');
            die();
        }
        if(!empty($uId)) {
            $where[] = "operator = ".$uId;
        }
        if(!empty($start_time)) {
            $where[] = "endDate >".$start_time;
        }
        if(!empty($end_time)) {
            $where[] = "startDate <".$end_time;
        }
        if(!empty($where)) {
            $whereStr = ' and '.implode(" and ",$where);
        }
        $getOvertimeList = $this->LeaveModel->getLeaveList($whereStr);
        if(!empty($getOvertimeList)) {
            $this->showMsg(2,'该时间段已经存在请假申请记录，请不要重复填写');
            die();
        }

        $start_date = strtotime($this->input->post('sTimet'));
        $end_date   = strtotime($this->input->post('eTimet'));
        $date_arr = array();
        while($start_date<=$end_date) {
            $date_arr[] = date('Y-m-d',$start_date);
            $start_date = strtotime('+1 day',$start_date);
        }
        foreach($date_arr as $key=>$val) {
            $get_arr = $this->LeaveModel->getTimeNews(strtotime($val),2);
            $number = count($get_arr);
            if((date('w',strtotime($val))==0 || date('w',strtotime($val))==6) && $number==0) {
                unset($date_arr[$key]);
            }
        
            $get_arrStr = $this->LeaveModel->getTimeNews(strtotime($val),1);
            if($get_arrStr['setStatus'] == 1 && !in_array(date('w',$val),array(0,6))){
                unset($date_arr[$key]);
            }
        }
        $interval = count($date_arr) - 2;
        if((strtotime($this->input->post('start_hour'))-strtotime('12:00')) < 0) {
            $interval_left = 1;
        }else {
            $interval_left = 0.5;
        }

        if((strtotime($this->input->post('end_hour'))-strtotime('18:00')) < 0) {
            $interval_right = 0.5;
        }else {
            $interval_right = 1;
        }
        if(count($date_arr) == 0) {              //如果是周末或者公休，则不统计请假天数
            $allDay = 0;
        }else {
            $allDay = $interval + $interval_left + $interval_right;
        }

        $annex = ($this->input->post('isUserfile'))?$this->uploadFile():'0';
        $result	= array(
                'operator'=> $uId,
                'type' => $type,
                'pLeavetype' => 0,
                'cause' => $this->input->post('cause',true),
                'startDate' => $start_time,
                'endDate' => $end_time,
                'allDay' => $allDay,
                'annex' => $annex,
                'createTime'=>time(),
        );


        $fundsId = $this->PublicModel->insertSave($this->table,$result);
        
        if(!empty($fundsId)) {
            $this->PublicModel->controlProcess($this->table,$fundsId,1,0,1,'','',$allDay);
            $this->showMsg(1,'填写成功',self::LEAVE_LIST);
            exit;
        }else {
            $this->showMsg(2,'填写失败！');
        }
    }
    
    public function leaveEditView($leaveId) {
        $data = $this->View('personnel');
        $data['arr'] = $this->LeaveModel->leaveEdit($leaveId);
        $userInfoArray = $this->getAllUserInfo();
        $data['userInfoArray'] = $userInfoArray;
        $data['leaveType'] = $this->config->item('leaveType','personnel');
        $data['content'] = $this->load->view(self::VIEW_EDIT,$data,true);
        $this->load->view('index/index',$data);
    }

    public function leaveModifyView() {
        $data = $this->View('personnel');
        $leaveId   = $this->input->post('leaveId');
        $operator   = $this->input->post('operator');
        $type = $this->input->post('type',true);
        $start_time = strtotime($this->input->post('sTimet').' '.$this->input->post('start_hour').':00');
        $end_time = strtotime($this->input->post('eTimet').' '.$this->input->post('end_hour').':00');
        $type = $this->input->post('type',true);
        if(($end_time-$start_time) < 0) {
            $this->showMsg(2,'请假时间选择错误！');
            die();
        }
        $whereRell = " and leaveId != ".$leaveId;
        $arr = $this->LeaveModel->leaveEdit($leaveId);
        if($arr['startDate'] == $start_time && $arr['endDate'] == $end_time) {
        }else {
                if(!empty($leaveId)) {
                    $where[] = "leaveId != ".$leaveId;
                }
                if(!empty($operator)) {
                    $where[] = "operator = ".$operator;
                }
                if(!empty($start_time)) {
                    $where[] = "endDate >".$start_time;
                }
                if(!empty($end_time)) {
                    $where[] = "startDate <".$end_time;
                }
                if(!empty($where)) {
                    $whereStr = ' and '.implode(" and ",$where);
                }
                $getOvertimeList = $this->LeaveModel->getLeaveList($whereStr);
                if(!empty($getOvertimeList)) {
                    $this->showMsg(2,'该时间段已经存在请假申请记录，请不要重复填写');
                    die();
                }
        }
        $start_date = strtotime($this->input->post('sTimet'));
        $end_date   = strtotime($this->input->post('eTimet'));
        $date_arr = array();
        while($start_date<=$end_date) {
            $date_arr[] = date('Y-m-d',$start_date);
            $start_date = strtotime('+1 day',$start_date);
        }
        foreach($date_arr as $key=>$val) {
            $get_arr = $this->LeaveModel->getTimeNews(strtotime($val),2);
            $number = count($get_arr);
            if((date('w',strtotime($val))==0 || date('w',strtotime($val))==6) && $number==0) {
                unset($date_arr[$key]);
            }
            $get_arrStr = $this->LeaveModel->getTimeNews(strtotime($val),1);
            if($get_arrStr['setStatus'] == 1 && !in_array(date('w',$val),array(0,6))){
                unset($date_arr[$key]);
            }
        }
        $interval = count($date_arr) - 2;
        if((strtotime($this->input->post('start_hour'))-strtotime('12:00')) < 0) {
            $interval_left = 1;
        }else {
            $interval_left = 0.5;
        }

        if((strtotime($this->input->post('end_hour'))-strtotime('18:00')) < 0) {
            $interval_right = 0.5;
        }else {
            $interval_right = 1;
        }
        if(count($date_arr) == 0) {              //如果是周末或者公休，则不统计请假天数
            $allDay = 0;
        }else {
            $allDay = $interval + $interval_left + $interval_right;
        }

        $annex = ($this->input->post('isUserfile'))?$this->uploadFile():'0';
        $result	= array(
                'type' => $type,
                'pLeavetype' => $pLeavetype,
                'cause' => $this->input->post('cause',true),
                'startDate' => $start_time,
                'endDate' => $end_time,
                'allDay' => $allDay,
        );
        if(!empty($annex)) {
            $result['annex'] = $annex;
        }

        $fundsId = $this->PublicModel->updateSave($this->table,array('leaveId'=>$leaveId),$result);
        $this->showMsg(1,"修改成功！",self::LEAVE_LIST);
        exit;
    }
    
    public function leaveLookView($leaveId) {
        $data = $this->View('personnel');
        $data['arr'] = $this->LeaveModel->leaveEdit($leaveId);
        $getFlowList = $this->PublicModel->getFlowList($leaveId,$this->table);
        $data['flowlist']	= $getFlowList;
        if($this->input->post('submitCreate') != FALSE) {
            $app_type = $this->input->post('app_type');     //审批结果
            $app_con  = $this->input->post('app_con');      //审批意见
            $flowid   = $this->input->post('flowid');

            $this->PublicModel->controlProcess($this->table,$leaveId,2,0,$app_type,$app_con,$flowid,$data['arr']['allDay']);
            $this->showMsg(1,'提交成功','panel/PanelController/panelList');
        }

        if(!empty($data['flowlist'])) {
            $data['directory']  = $this->PublicModel->getProDirectory($getFlowList[0]['fromName'],$getFlowList[0]['fromUid'],$getFlowList[0]['createTime']);
        }

        $userInfoArray = $this->getAllUserInfo();
        $data['userInfoArray'] = $userInfoArray;
        $data['leaveType'] = $this->config->item('leaveType','personnel');
        $data['content'] = $this->load->view(self::VIEW_LOOK,$data,true);
        $this->load->view('index/index',$data);
    }
    
    public function downloadApp($leaveId) {
        //附件下载
        $this->load->helper('download');
        $getResult	= $this->LeaveModel->leaveEdit($leaveId);
        $data = file_get_contents($getResult['filePath'].$getResult['fileName']); // 读文件内容
        $name = $getResult['origName'];
        force_download($name, $data);

    }
}


?>
