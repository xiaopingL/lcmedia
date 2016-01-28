<?php
/**
 * @desc 加班单控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-07-23
 */
class OverworkController extends MY_Controller {
    protected $table = 'crm_personnel_overtime';
    const VIEW_LIST  = "personnel/overworkListView";
    const VIEW_EDIT  = "personnel/overworkEditView";
    const VIEW_ADD  = "personnel/overworkAddView";
    const VIEW_LOOK  = "personnel/overworkLookView";
    const OVERWORK_LIST = "/personnel/OverworkController/overworkListView";

    public function  __construct() {
        parent::__construct();
        $this->config->load('personnel', TRUE);
        $this->config->load('time', TRUE);
        $this->load->model('personnel/OverworkModel','',true);
        $this->load->model('admin/UserModel','',true);
    }
    public function overworkListView() {
        $data = $this->View('personnel');
        $whereStr = '';

        $uId = $this->session->userdata['uId'];
        $userName = $this->input->get_post('userName',true);
        if(!empty($userName)) {
            $where[] = "b.userName like '%".$userName."%'";
            $urlArray[] = 'userName='.$userName;
        }
        //获取部门
        $sId = $this->input->get_post('sId',true);
        if(!empty($sId)){
            $urlArray[] = 'sId='.$sId;
            $sIdArray = $this->PublicModel->getAllOrgSublevel($arrayList=array(),$sId,0);
            if(!empty($sIdArray)) {
                $sIdStr = implode(',', $sIdArray);
                $uIdArray = $this->PublicModel->getContactAllUid($sIdStr,0);
                $uIdAssemble = $this->converArr($uIdArray,'uId');
                if(!empty($uIdAssemble)){
                    if(!empty($uId) && !in_array('allOverTime',$data['userOpera'])) {
                        $where[] = "a.operator in".$this->uIdDispose();
                    }
                    $where[] = ' a.operator in ('.implode(',', $uIdAssemble).')';
                }else{
                    if(!empty($uId) && !in_array('allOverTime',$data['userOpera'])) {
                        $where[] = "a.operator in".$this->uIdDispose();
                    }
                }
            }
        }else{
            if(!empty($uId) && !in_array('allOverTime',$data['userOpera'])) {
                $where[] = "a.operator in".$this->uIdDispose();
                $where[] = "a.state = 0";
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
        $modelArray['modelName'] = 'OverworkModel';
        $modelArray['sqlTplName'] = 'overworkSql';
        $modelArray['sqlTplFucName'] = 'overworkList';
        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);
        $argument	= array(
                'base_url'      => self::OVERWORK_LIST,
                'per_page'		=> 12,
                'num_links'		=> 3,
                'uri_segment'	=> 4,
                'total_rows'	=> $rows
        );
        $getPaginDatas		= $this->createPagination($argument,$urlStr);
        $data['pagination']	= $getPaginDatas['pagination'];
        $data['rows']       = $rows;
        $data['arr']  = $this->OverworkModel->overworkList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        foreach($data['arr'] as $key=>$val) {
            $data['arr'][$key]['flow'] = $this->PublicModel->getFlowList($data['arr'][$key]['oId'],$this->table);
        }
        
        $data['userInfoArray'] = $this->getAllUserInfo();
        $data['attendance'] = $this->config->item('attendance','personnel');
        $data['carname'] = "加班单";
        $data['org'] = $this->PublicModel->getDepList($arrayList=array(),0,0);
        $data['content'] = $this->load->view(self::VIEW_LIST,$data,true);
        $this->load->view('index/index',$data);
    }

    public function overworkAddView() {
        $data = $this->View('personnel');
        $uId = $this->session->userdata['uId'];
        $userInfoArray = $this->getAllUserInfo();
        $data['uId'] = $uId;
        $data['userInfoArray'] = $userInfoArray;
        $data['getHours'] = $this->config->item('hour','time');
        $data['content'] = $this->load->view(self::VIEW_ADD,$data,true);
        $this->load->view('index/index',$data);
    }

    public function overworkInsert() {
        $data = $this->View('personnel');
        $uId = $this->session->userdata['uId'];
        $start_time = strtotime($this->input->post('sTime').' '.$this->input->post('start_hour').':00:00');
        $end_time = strtotime($this->input->post('eTime').' '.$this->input->post('end_hour').':00:00');
        if(!empty($uId)) {
            $where[] = "operator = ".$uId;
        }
        if(!empty($start_time)) {
            $where[] = "endDate >=".$start_time;
        }
        if(!empty($end_time)) {
            $where[] = "startDate <=".$end_time;
        }
        if(!empty($where)) {
            $whereStr = ' and '.implode(" and ",$where);
        }
        if(($end_time-$start_time) <= 0) {
            $this->showMsg(2,'加班时间选择错误！');
            die();
        }
        if($end_time>time()) {
            $this->showMsg(2,'抱歉，加班单不能提前申请！');
            die();
        }

        $getOvertimeList = $this->OverworkModel->getOvertimeList($whereStr);
        if(!empty($getOvertimeList)) {
            $this->showMsg(2,'该时间段已经存在加班单申请记录，请不要重复填写');
            die();
        }
        $overtime_total = intval(($end_time - $start_time)/3600);
        if($overtime_total >= 8) {
            $allDay  = 1;
            $allHour = 0;
        }else {
            $allDay  = 0;
            $allHour = $overtime_total;
        }
        $result	= array(
                'operator'		=> $uId,
                'addr' => $this->input->post('addr',true),
                'content' => $this->input->post('over_content',true),
                'startDate' => $start_time,
                'endDate' => $end_time,
                'allDay' => $allDay,
                'allHour' => $allHour,
                'overContent' => $this->input->post('overContent',true),
                'createTime'=>time(),
        );
        $fundsId = $this->PublicModel->insertSave($this->table,$result);
        if(!empty($fundsId)) {
            $this->PublicModel->controlProcess($this->table,$fundsId,1);
            $this->showMsg(1,'添加成功',self::OVERWORK_LIST);
            exit;
        }else {
            $this->showMsg(2,'添加失败！');
        }
    }

    public function overworkEditView($oId) {
        $data = $this->View('personnel');
        $data['arr'] = $this->OverworkModel->overworkEdit($oId);
        $data['arr']['sTime'] = date("Y-m-d",$data['arr']['startDate']);
        $data['arr']['start_hour'] = date("H",$data['arr']['startDate']);
        $data['arr']['eTime'] = date("Y-m-d",$data['arr']['endDate']);
        $data['arr']['end_hour'] = date("H",$data['arr']['endDate']);
        $data['userInfoArray'] = $this->getAllUserInfo();
        $data['getHours'] = $this->config->item('hour','time');
        $data['content'] = $this->load->view(self::VIEW_EDIT,$data,true);
        $this->load->view('index/index',$data);
    }

    public function overworkModifyView() {
        $data = $this->View('personnel');
        $oId   = $this->input->post('oId');
        $operator   = $this->input->post('operator');
        $arr = $this->OverworkModel->overworkEdit($oId);
        $start_time = strtotime($this->input->post('sTime').' '.$this->input->post('start_hour').':00:00');
        $end_time = strtotime($this->input->post('eTime').' '.$this->input->post('end_hour').':00:00');
        if(!empty($oId)) {
            $where[] = "oId != ".$oId;
        }
        if(!empty($operator)) {
            $where[] = "operator = ".$operator;
        }
        if(!empty($start_time)) {

            $where[] = "endDate >=".$start_time;
        }
        if(!empty($end_time)) {
            $where[] = "startDate <=".$end_time;
        }
        if(!empty($where)) {
            $whereStr = ' and '.implode(" and ",$where);
        }
        if(($end_time-$start_time) < 0) {
            $this->showMsg(2,'加班时间选择错误！');
            die();
        }
        if($end_time>time()) {
            $this->showMsg(2,'抱歉，加班单不能提前申请！');
            die();
        }
        if($arr['startDate'] == $start_time && $arr['endDate'] == $end_time) {

        }else {
            $getOvertimeList = $this->OverworkModel->getOvertimeList($whereStr);
            if(!empty($getOvertimeList)) {
                $this->showMsg(2,'该时间段已经存在加班申请记录，请不要重复填写');
                die();
            }
        }

        $overtime_total = intval(($end_time - $start_time)/3600);
        if($overtime_total >= 8) {
            $allDay  = 1;
            $allHour = 0;
        }else {
            $allDay  = 0;
            $allHour = $overtime_total;
        }
        $result	= array(
                'addr' => $this->input->post('addr',true),
                'content' => $this->input->post('over_content',true),
                'startDate' => $start_time,
                'endDate' => $end_time,
                'allDay' => $allDay,
                'allHour' => $allHour,
                'overContent' => $this->input->post('overContent',true),
        );
        $fundsId = $this->PublicModel->updateSave($this->table,array('oId'=>$oId),$result);
        if(!empty($fundsId)) {
            $this->showMsg(1,"信息修改成功！",self::OVERWORK_LIST);
        }else {
            $this->showMsg(2,"信息修改失败！");
        }
    }

    public function overworkLookView($oId) {
        $data = $this->View('personnel');
        $data['arr'] = $this->OverworkModel->overworkEdit($oId);
        $data['arr']['sTime'] = date("Y-m-d",$data['arr']['startDate']);
        $data['arr']['start_hour'] = date("H",$data['arr']['startDate']);
        $data['arr']['eTime'] = date("Y-m-d",$data['arr']['endDate']);
        $data['arr']['end_hour'] = date("H",$data['arr']['endDate']);
        $data['userInfoArray'] = $this->getAllUserInfo();
        $getFlowList = $this->PublicModel->getFlowList($oId,$this->table);
        $data['flowlist']	= $getFlowList;
        if($this->input->post('submitCreate') != FALSE) {
            $app_type = $this->input->post('app_type');     //审批结果
            $app_con  = $this->input->post('app_con');      //审批意见
            $flowid   = $this->input->post('flowid');

            $this->PublicModel->controlProcess($this->table,$oId,2,$type,$app_type,$app_con,$flowid);
            $this->showMsg(1,'提交成功','panel/PanelController/panelList');
        }

        if(!empty($data['flowlist'])) {
            $data['directory']  = $this->PublicModel->getProDirectory($getFlowList[0]['fromName'],$getFlowList[0]['fromUid'],$getFlowList[0]['createTime']);
        }
        $data['content'] = $this->load->view(self::VIEW_LOOK,$data,true);
        $this->load->view('index/index',$data);
    }
    
    public function overworkUdelView($oId) {
        $signal = $this->PublicModel->updateSave($this->table,array('oId'=>$oId),array('isDel'=>1));
        if($signal != FALSE) {
            $this->PublicModel->updateSave('crm_pending',array('tableId'=>$oId,'proTable'=>$this->table),array('isDel'=>1));  //软删除待处理事项提醒
            $this->showMsg(1,'信息删除成功',self::OVERWORK_LIST);
        }else {
            $this->showMsg(2,'信息删除失败！');
        }
    }


}


?>
