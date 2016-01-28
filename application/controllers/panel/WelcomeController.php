<?php
/**
 * @desc 系统首页控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-07-08
 */
class WelcomeController extends MY_Controller {
    public function  __construct() {
        parent::__construct();
        $this->load->model('panel/PanelModel');
        $this->load->model('office/ForumArtModel');
        $this->load->model('public/EmailModel');
        $this->load->model('public/AnnounceModel');
        $this->load->model('personnel/AttendModel');
        $this->load->model('admin/UserModel');
    }

    public function welcome() {
        $data = $this->View('panel');
        $myUid  = $this->session->userdata('uId');
        $list['forumClass'] = $forum = $this->PublicModel->selectSave('id,className','crm_forum_area',array('flag'=>0),2);
        $list['forumList']   = $this->ForumArtModel->getForumList(0,8);          //讨论区最新帖子
        foreach($list['forumClass'] as $key=>$val) {
            $list['forumArea'][] =  $this->ForumArtModel->getForumArea($val['id'],0,9); //讨论区分版块帖子
        }
        /*-------------------------个人办公--------------------------*/
        $list['panelNum']  = $this->PanelModel->getPanelNum($myUid);             //我的待处理事项总条数
        $list['panelList'] = $this->PanelModel->getPanelList($myUid,0,6);        //我的待处理事项列表
        $list['applyList'] = $this->PanelModel->getApplyList($myUid,0,5);        //我的申请单，状态审批中
        if(!empty($list['applyList'])) {
            foreach($list['applyList'] as $key=>$value) {
                $flowList = $this->PublicModel->getFlowList($value['tableId'],$value['proTable']);
                $list['applyList'][$key]['flowNode'] = count($flowList);
            }
        }

        $list['numberLeave'] = $this->AttendModel->getCountNumbers('crm_personnel_leave');  //本月请假次数
        $list['numberFaslesign'] = $this->AttendModel->getFalsesignCount();                 //本月误打卡次数

        $list['newsListGg']  = $this->AnnounceModel->getNewsListGg();              //公告
        $list['voiceListTz'] = $this->AnnounceModel->getVoiceListTz();             //通知
        $list['emailNum']    = $this->EmailModel->nreadCount($myUid);              //未读邮件统计
        $list['emailNews']   = $this->EmailModel->emailNreadNews($myUid);          //最新邮件
        $list['birthday']    = $this->PanelModel->getBirthday($myUid);             //生日提醒
        $list['nowDate']     = $this->PanelModel->getNowDate();                    //当前日期
        $list['deviceType']  = $this->PanelModel->deviceType();                    //访问入口
        $list['dailyInfo']   = $this->PanelModel->getVisitInfo($myUid,30);         //未拜访客户提醒
        $list['userArray']   = $this->getAllUserInfo();
        $list['userInfo']    = $this->PublicModel->selectSave('*','crm_user',array('uId'=>$myUid),1);

        $data['content'] = $this->load->view('index/welcome',$list,true);
        $this->load->view('index/index',$data);
    }

   /*
    * 个人首页弹窗数据调用
    */
    public function newMsg() {
        $data = '';
        $uId  = $this->session->userdata('uId');
        $arr_info  = $this->PanelModel->getMsgList($uId);
        if(!empty($arr_info)) {
            switch($arr_info['folder']) {
                case 'forum':
                    $data	= "讨论区||".$arr_info['subject']."||".$arr_info['msgUrl']."||".$arr_info['pmsId']."||".date('Y-m-d H:i:s',$arr_info['createTime']);
                    break;
                case 'mail':
                    $data	= "内部邮件||".$arr_info['subject']."||".$arr_info['msgUrl']."||".$arr_info['pmsId']."||".date('Y-m-d H:i:s',$arr_info['createTime']);
                    break;
                case 'process':
                    $data	= "待处理事项||".$arr_info['subject']."||".$arr_info['msgUrl']."||".$arr_info['pmsId']."||".date('Y-m-d H:i:s',$arr_info['createTime']);
                    break;
                default:
                    $data	= "";
            }

        }
        echo $data;
    }

    public function delMsgInfo() {
        $delid	= $this->input->post('delid');
        if(!empty($delid)) {
            $this->db->delete('crm_pms',array('pmsId'=>$delid));
        }
    }

    public function delMsgAll() {
        $this->db->delete('crm_pms',array('msgtoUid'=>$this->session->userdata('uId')));
    }


}
?>