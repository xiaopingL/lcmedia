<?php
/**
 * @desc 邮件控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-07-10
 */
class EmailController extends MY_Controller {
    protected $table = 'crm_public_email';
    protected $table_pms = 'crm_pms';
    protected $table_file = 'crm_file';
    protected $table_group = 'crm_public_group';
    const EMAIL_LIST = "/public/EmailController/emailListView/";
    const EMAIL_SENT = "/public/EmailController/emailSentView/";
    const EMAIL_DEL = "/public/EmailController/emailDelView/";
    const EMAIL_READ = "/public/EmailController/emailNreadView/";
    const GROUP_LIST = "/public/EmailController/emailGroupList/";
    const VIEW_LIST  = "public/emailListView";
    const VIEW_SENT  = "public/emailSentView";
    const VIEW_DEL  = "public/emailDelView";
    const VIEW_READ  = "public/emailNreadView";
    const VIEW_ADD  = "public/emailAddView";
    const VIEW_REPLY  = "public/emailReplyView";
    const VIEW_DETAIL  = "public/emailDetailView";
    const VIEW_TURNLIST  = "public/emailTurnlistView";
    const VIEW_GROUP  = "public/emailGroupList";
    const GROUP_ADD  = "public/emailGroupAdd";
    const GROUP_EDIT  = "public/emailGroupEdit";

    public function  __construct() {
        parent::__construct();
        $this->load->model('public/EmailModel','',true);
        $this->load->model('admin/UserModel','',true);
    }

    public function emailListView() {
        $data = $this->View('panel');
        $to_uid = $this->session->userdata['uId'];
        $data['to_uid'] = $to_uid;
        if(!empty($to_uid)) {
            $where[] = "a.to_uid = $to_uid";
        }
        $searchType = $this->input->get_post('searchType',true);
        if(!empty($searchType)) {
            $urlArray[] = 'searchType='.$searchType;
        }

        $searchTitle = $this->input->get_post('searchTitle',true);
        //主题
        if($searchType == 1) {
            if(!empty($searchTitle)) {
                $where[] = "a.title like '%".$searchTitle."%'";
                $urlArray[] = 'searchTitle='.$searchTitle;
            }
        }
        //发件人
        if($searchType == 2) {
            if(!empty($searchTitle)) {
                $result = $this->EmailModel->getUser($searchTitle);
                foreach($result as $key=>$value) {
                    $re.=$value['uId'].',';
                }
                $len = strlen($re);
                $re = substr($re,0,$len-1);
                if(!empty($result)) {
                    $where[] = "a.from_uid in($re) ";
                }else {
                    $where[] = "a.from_uid in(0) ";
                }
                $urlArray[] = 'searchTitle='.$searchTitle;
            }
        }
        $searchSdate = $this->input->get_post('searchSdate',true);
        $searchEdate = $this->input->get_post('searchEdate',true);
        $sTime1 = strtotime($searchSdate);
        $eTime1 = strtotime($searchEdate);
        //时间
        if($searchType == 3) {
            if(!empty($sTime1)) {
                $where[] = ' a.post_date >='.$sTime1;
                $urlArray[] = 'searchSdate='.$searchSdate;
            }
            if(!empty($eTime1)) {
                $where[] = ' a.post_date <='.$eTime1;
                $urlArray[] = 'searchEdate='.$searchEdate;
            }
        }
        //内容
        if($searchType == 4) {
            if(!empty($searchTitle)) {
                $where[] = "a.content like '%".$searchTitle."%'";
                $urlArray[] = 'searchTitle='.$searchTitle;
            }
        }
        if(!empty($urlArray)) {
            $urlStr = '/?'.implode('&', $urlArray);
        }
        if(!empty($where)) {
            $data['searchType'] = $searchType;
            $data['searchTitle'] = $searchTitle;
            $data['searchSdate'] = $searchSdate;
            $data['searchEdate'] = $searchEdate;
            $data['searchType'] = $searchType;
            $whereStr = ' and '.implode(" and ",$where);
        }
        $modelArray['modelPath'] = 'public';
        $modelArray['modelName'] = 'EmailModel';
        $modelArray['sqlTplName'] = 'emailSql';
        $modelArray['sqlTplFucName'] = 'emailList';
        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);
        $argument	= array(
                'base_url'      => self::EMAIL_LIST,
                'per_page'		=> 10,
                'num_links'		=> 3,
                'uri_segment'	=> 4,
                'total_rows'	=> $rows
        );
        $getPaginDatas		= $this->createPagination($argument,$urlStr);
        $data['pagination']	= $getPaginDatas['pagination'];
        $data['rows']       = $rows;
        $data['userArray'] = $this->getAllUserInfo();
        $data['arr']  = $this->EmailModel->emailList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        foreach($data['arr'] as $key=>$val) {
            $getFileWord = $this->EmailModel->fileWord($val['include']);
            $data['arr'][$key]['origName'] = $getFileWord['origName'];
            $data['arr'][$key]['fileExt'] = $getFileWord['fileExt'];
            $data['arr'][$key]['fileSize'] = $getFileWord['fileSize'];
            $data['arr'][$key]['photoImg'] = $this->UserModel->getUserPhoto($val['from_uid']);
        }
        $data['emailRecipient'] = $this->recipientEmail();
        $data['emailSent'] = $this->sentEmail();
        $data['emailDel'] = $this->delEmail();
        $data['emailNoread'] = $this->nreadEmail();
        $data['content'] = $this->load->view(self::VIEW_LIST,$data,true);
        $this->load->view('index/index',$data);
    }
    //获取收件人姓名
    public function emailUser() {
        $username = $this->input->get_post('username',true);
        $result = $this->EmailModel->getEmailUser($username);
        echo $result['userName'].';';

    }
    //收件箱 + 未读邮件删除
    public function emailDelete($id) {
        $len = strlen($id);
        $re = substr($id,0,$len-1);
        $re = explode("-", $re);
        foreach($re as $value) {
            $rr = array(
                    'del_r'=>'2',
            );
            $this->PublicModel->updateSave($this->table,array('id'=>$value),$rr);
        }
        $this->showMsg(1,'邮件删除成功',self::EMAIL_LIST);
    }
    //收件箱 + 未读邮件永久删除
    public function emailPermanentDelete($id) {
        $len = strlen($id);
        $re = substr($id,0,$len-1);
        $re = explode("-", $re);
        foreach($re as $value) {
            $arr = $this->EmailModel->getEmailType($value);
            if($arr['del_s'] == '1') {
                $this->db->delete($this->table,array('id'=>$value));
            }else {
                $rr = array(
                        'del_r'=>'1',
                );
                $this->PublicModel->updateSave($this->table,array('id'=>$value),$rr);
            }
        }
        $this->showMsg(1,'邮件删除成功',self::EMAIL_LIST);
    }

    //写信添加视图页面
    public function emailAddView() {
        $data = $this->View('panel');
        $data['emailRecipient'] = $this->recipientEmail();
        $data['emailSent'] = $this->sentEmail();
        $data['emailDel'] = $this->delEmail();
        $data['emailNoread'] = $this->nreadEmail();
        $uId = $this->session->userdata['uId'];
        $data['group'] = $this->EmailModel->getGroupArray($uId);
        $data['org'] = $this->PublicModel->getDepList($arrayList=array(),0,0);
        $data['content'] = $this->load->view(self::VIEW_ADD,$data,true);
        $this->load->view('index/index',$data);
    }
    function emailGroupNews() {
        $groupid = $this->input->get_post('groupid',true);
        $result = $this->EmailModel->getGroupInfo($groupid);
        echo $result['groupcontent'];
    }
    //插入邮件信息 + 进行邮件发送 提示
    public function emailInsert() {
        $data = $this->View('panel');
        $annex = $this->input->post('include',true);
        set_time_limit(0);
        ini_set("memory_limit","2024M");
        $from_uid = $this->session->userdata['uId'];
        $cc_staff = $this->input->post('cc_staff',true);
        $title = $this->input->post('title_email',true);
        $content = html_entity_decode($this->input->post('content'),ENT_QUOTES,'utf-8');
        $email_type = $this->input->post('email_type',true);
        $sms = $this->input->post('sms',true);
        $time = time();
        $userArray = $this->getOnUserInfo();
        foreach($userArray as $key=>$val) {
            $userInfo[$val] = $key;
        }
        $cc_staff = rtrim($cc_staff['0'],";");
        $cc_staff = explode(";", $cc_staff);
        foreach($cc_staff as $value) {
            $arr_staff[] = $userInfo[$value];
        }

        foreach($arr_staff as $key=>$value) {
            $result[]=array(
                    'from_uid'=>$from_uid,
                    'to_uid'=>$value,
                    'title'=>$title,
                    'include'=>$annex,
                    'del_r'=> '0',
                    'del_s'=> '0',
                    'post_date'=>$time,
                    'content'=>$content,
            );
        }
        if($result) {
            $fundsId = $this->db->insert_batch($this->table,$result);
        }
        $sIdArray = $this->getAllStructrue();
        $sId = $this->session->userdata['sId'];
        if($sms == '1') {
            $str_uid = join(",",$arr_staff);
            $str_uid = explode(',', $str_uid);

            foreach($str_uid as $val) {
                $str .= $val.'-';
            }
            $str = base64_encode(rtrim($str,'-'));
            $email_content = base64_encode($sIdArray[$sId]." ".$userArray[$from_uid]."  给您发了新邮件:《".$title."》请登录CRM系统查收 【领程传媒】");
        }

        if($fundsId) {
            if($sms == 1) {
                $this->showMsg(1,'邮件发送成功','/public/EmailController/emailDuanView/?uId='.$str.'&content='.$email_content.'&cconet='.$cconet);
            }else {
                $this->showMsg(1,"邮件发送成功！",self::EMAIL_LIST);
                exit;
            }
        }else {
            $this->showMsg(2,"邮件发送失败！");
            exit;
        }
    }


    //已发送邮件列表
    public function emailSentView() {
        $data = $this->View('panel');
        $from_uid = $this->session->userdata['uId'];
        if(!empty($from_uid)) {
            $where[] = "a.from_uid = $from_uid";
        }
        $searchType = $this->input->get_post('searchType',true);
        if(!empty($searchType)) {
            $urlArray[] = 'searchType='.$searchType;
        }

        $searchTitle = $this->input->get_post('searchTitle',true);
        //主题
        if($searchType == 1) {
            if(!empty($searchTitle)) {
                $where[] = "a.title like '%".$searchTitle."%'";
                $urlArray[] = 'searchTitle='.$searchTitle;
            }
        }
        //发件人
        if($searchType == 2) {
            if(!empty($searchTitle)) {
                $result = $this->EmailModel->getUser($searchTitle);
                foreach($result as $key=>$value) {
                    $re.=$value['uId'].',';
                }
                $len = strlen($re);
                $re = substr($re,0,$len-1);
                if(!empty($result)) {
                    $where[] = "a.to_uid in($re) ";
                }else {
                    $where[] = "a.to_uid in(0) ";
                }
                $urlArray[] = 'searchTitle='.$searchTitle;
            }
        }
        $searchSdate = $this->input->get_post('searchSdate',true);
        $searchEdate = $this->input->get_post('searchEdate',true);
        $sTime1 = strtotime($searchSdate);
        $eTime1 = strtotime($searchEdate);
        //时间
        if($searchType == 3) {
            if(!empty($sTime1)) {
                $where[] = ' a.post_date >='.$sTime1;
                $urlArray[] = 'searchSdate='.$searchSdate;
            }
            if(!empty($eTime1)) {
                $where[] = ' a.post_date <='.$eTime1;
                $urlArray[] = 'searchEdate='.$searchEdate;
            }
        }
        //内容
        if($searchType == 4) {
            if(!empty($searchTitle)) {
                $where[] = "a.content like '%".$searchTitle."%'";
                $urlArray[] = 'searchTitle='.$searchTitle;
            }
        }
        if(!empty($urlArray)) {
            $urlStr = '/?'.implode('&', $urlArray);
        }
        if(!empty($where)) {
            $data['searchType'] = $searchType;
            $data['searchTitle'] = $searchTitle;
            $data['searchSdate'] = $searchSdate;
            $data['searchEdate'] = $searchEdate;
            $data['searchType'] = $searchType;
            $whereStr = ' and '.implode(" and ",$where);
        }
        $modelArray['modelPath'] = 'public';
        $modelArray['modelName'] = 'EmailModel';
        $modelArray['sqlTplName'] = 'emailSql';
        $modelArray['sqlTplFucName'] = 'emailSent';
        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);
        $argument	= array(
                'base_url'      => self::EMAIL_SENT,
                'per_page'		=> 10,
                'num_links'		=> 3,
                'uri_segment'	=> 4,
                'total_rows'	=> $rows
        );
        $getPaginDatas		= $this->createPagination($argument,$urlStr);
        $data['pagination']	= $getPaginDatas['pagination'];
        $data['rows']       = $rows;
        $data['userArray'] = $this->getAllUserInfo();
        $data['arr']  = $this->EmailModel->emailSent($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        foreach($data['arr'] as $key=> $value) {
            $res = $this->EmailModel->getEmailNews($value['title'],$value['post_date'],$value['from_uid']);
            $data['arr'][$key]['CHILD'] = $res;

        }
        $data['emailRecipient'] = $this->recipientEmail();
        $data['emailSent'] = $this->sentEmail();
        $data['emailDel'] = $this->delEmail();
        $data['emailNoread'] = $this->nreadEmail();
        $data['content'] = $this->load->view(self::VIEW_SENT,$data,true);
        $this->load->view('index/index',$data);
    }
    //已发送邮件删除功能
    public function getEmailDelte($id) {
        $from_uid = $this->session->userdata['uId'];
        $len = strlen($id);
        $re = substr($id,0,$len-1);
        $re = explode("-", $re);
        foreach($re as $value) {
            $arr[] = $this->EmailModel->getEmailInfo($value);

        }
        foreach($arr as $value) {
            $result[] = $this->EmailModel->getEmail($value['title'],$value['post_date'],$from_uid);
        }
        foreach($result as $value) {
            foreach($value as $val) {
                if($val['del_r'] == 1) {
                    $this->db->delete($this->table,array('id'=>$val['id']));
                }else {
                    $rr = array(
                            'del_s'=>'1',
                    );
                    $this->PublicModel->updateSave($this->table,array('id'=>$val['id']),$rr);
                }
            }
        }
        $this->showMsg(1,'邮件删除成功',self::EMAIL_SENT);
        exit;
    }

    //已删除邮件列表
    public function emailDelView() {
        $data = $this->View('panel');
        $to_uid = $this->session->userdata['uId'];
        if(!empty($to_uid)) {
            $where[] = "a.to_uid in($to_uid)";
            $urlArray[] = 'to_uid='.$to_uid;
        }
        if(!empty($urlArray)) {
            $urlStr = '/?'.implode('&', $urlArray);
        }
        if(!empty($where)) {
            $whereStr = ' and '.implode(" and ",$where);
        }
        $modelArray['modelPath'] = 'public';
        $modelArray['modelName'] = 'EmailModel';
        $modelArray['sqlTplName'] = 'emailSql';
        $modelArray['sqlTplFucName'] = 'emailDel';
        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);
        $argument	= array(
                'base_url'      => self::EMAIL_DEL,
                'per_page'		=> 10,
                'num_links'		=> 3,
                'uri_segment'	=> 4,
                'total_rows'	=> $rows
        );
        $getPaginDatas		= $this->createPagination($argument,$urlStr);
        $data['pagination']	= $getPaginDatas['pagination'];
        $data['rows']       = $rows;
        $data['userArray'] = $this->getAllUserInfo();
        $data['arr']  = $this->EmailModel->emailDel($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        $data['emailRecipient'] = $this->recipientEmail();
        $data['emailSent'] = $this->sentEmail();
        $data['emailDel'] = $this->delEmail();
        $data['emailNoread'] = $this->nreadEmail();
        $data['content'] = $this->load->view(self::VIEW_DEL,$data,true);
        $this->load->view('index/index',$data);
    }

    //已删除邮件恢复
    public function emailTrashUpdate($id) {
        $len = strlen($id);
        $re = substr($id,0,$len-1);
        $re = explode("-", $re);
        foreach($re as $value) {
            $rr = array(
                    'del_r'=>'0',
            );
            $this->PublicModel->updateSave($this->table,array('id'=>$value),$rr);
        }
        $this->showMsg(1,'邮件恢复成功',self::EMAIL_DEL);
        exit;
    }
    //已删除邮件全部清空过程
    public function emailDelTrash() {
        $to_uid = $this->session->userdata['uId'];
        $this->db->delete($this->table,array('del_r'=>2,'del_s'=>1,'to_uid'=>$to_uid));
        $rr = array(
                'del_r'=>'1',
        );
        $this->PublicModel->updateSave($this->table,array('del_r'=>2,'del_s'=>0,'to_uid'=>$to_uid),$rr);
        $this->showMsg(1,'操作成功',self::EMAIL_DEL);
    }
    //未读邮件列表
    public function emailNreadView() {
        $data = $this->View('panel');
        $to_uid = $this->session->userdata['uId'];
        if(!empty($to_uid)) {
            $where[] = "a.to_uid in($to_uid)";
            $urlArray[] = 'to_uid='.$to_uid;
        }
        if(!empty($urlArray)) {
            $urlStr = '/?'.implode('&', $urlArray);
        }
        if(!empty($where)) {
            $whereStr = ' and '.implode(" and ",$where);
        }
        $modelArray['modelPath'] = 'public';
        $modelArray['modelName'] = 'EmailModel';
        $modelArray['sqlTplName'] = 'emailSql';
        $modelArray['sqlTplFucName'] = 'emailRead';
        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);
        $argument	= array(
                'base_url'      => self::EMAIL_READ,
                'per_page'		=> 10,
                'num_links'		=> 3,
                'uri_segment'	=> 4,
                'total_rows'	=> $rows
        );
        $getPaginDatas		= $this->createPagination($argument,$urlStr);
        $data['pagination']	= $getPaginDatas['pagination'];
        $data['rows']       = $rows;
        $data['userArray'] = $this->getAllUserInfo();
        $data['arr']  = $this->EmailModel->emailRead($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        $data['emailRecipient'] = $this->recipientEmail();
        $data['emailSent'] = $this->sentEmail();
        $data['emailDel'] = $this->delEmail();
        $data['emailNoread'] = $this->nreadEmail();
        $data['content'] = $this->load->view(self::VIEW_READ,$data,true);
        $this->load->view('index/index',$data);
    }

    //未读邮件设置已读程序
    public function emailSetReaded($id) {
        $len = strlen($id);
        $re = substr($id,0,$len-1);
        $re = explode("-", $re);
        foreach($re as $value) {
            $rr = array(
                    'status'=>'1',
            );
            $this->PublicModel->updateSave($this->table,array('id'=>$value),$rr);
        }
        $this->showMsg(1,'设置成功',self::EMAIL_READ);
        exit;
    }
    //收件箱邮件统计
    function recipientEmail() {
        $uId = $this->session->userdata['uId'];
        $recipientNum = $this->EmailModel->recipientCount($uId);
        return $recipientNum;
    }
    //已发送统计
    function sentEmail($to_uid) {
        $uId = $this->session->userdata['uId'];
        $setNum = $this->EmailModel->sentCount($uId);
        return $setNum;
    }

    //已删除统计
    function delEmail() {
        $uId = $this->session->userdata['uId'];
        $delNum = $this->EmailModel->delCount($uId);
        return $delNum;
    }

    //未读邮件统计
    function nreadEmail() {
        $uId = $this->session->userdata['uId'];
        $delNum = $this->EmailModel->nreadCount($uId);
        return $delNum;
    }

    //查看邮件详情
    public function emailDetailView($id,$eNumber) {
        $data = $this->View('panel');
        $uId = $this->session->userdata['uId'];
        $data['arr'] = $this->EmailModel->emailDetail($id);
        if($data['arr']['to_uid'] == $uId) {
            $rr = array(
                    'status'=>'1',
            );
            $this->PublicModel->updateSave($this->table,array('id'=>$id),$rr);
            $this->db->delete($this->table_pms,array('msgId'=>$id,'folder'=>'mail','msgtoUid'=>$data['arr']['to_uid']));
        }
        $res = $this->EmailModel->getEmailNews($data['arr']['title'],$data['arr']['post_date'],$data['arr']['from_uid']);
        $data['arr']['photoImg'] = $this->UserModel->getUserPhoto($data['arr']['from_uid']);
        $data['arr']['CHILD'] = $res;
        $data['emailRecipient'] = $this->recipientEmail();
        $data['emailSent'] = $this->sentEmail();
        $data['emailDel'] = $this->delEmail();
        $data['emailNoread'] = $this->nreadEmail();
        $data['userArray'] = $this->getAllUserInfo();
        $data['result'] = $this->getPro($id);
        $data['rows'] = $this->getNext($id);
        $data['eNumber'] = $eNumber;
        $data['content'] = $this->load->view(self::VIEW_DETAIL,$data,true);
        $this->load->view('index/index',$data);
    }
    /**
     * getpro
     * 得到前一条
     */
    function getPro($id) {
        $uId = $this->session->userdata['uId'];
        $result = $this->EmailModel->getProNews($id,$uId);
        return $result;
    }
    /**
     * getNext
     * 得到后一条
     */
    function getNext($id) {
        $uId = $this->session->userdata['uId'];
        $rows = $this->EmailModel->getNextNews($id,$uId);
        return $rows;
    }
    //回复邮件功能
    public function emailReplyView($id) {
        $data = $this->View('panel');
        $data['emailRecipient'] = $this->recipientEmail();
        $data['emailSent'] = $this->sentEmail();
        $data['emailDel'] = $this->delEmail();
        $data['emailNoread'] = $this->nreadEmail();
        $data['userArray'] = $this->getAllUserInfo();
        $data['arr'] = $this->EmailModel->emailDetail($id);
        $data['org'] = $this->PublicModel->getDepList($arrayList=array(),0,0);
        $data['content'] = $this->load->view(self::VIEW_REPLY,$data,true);
        $this->load->view('index/index',$data);
    }
    //邮件转发功能
    public function emailTurnlistView($id) {
        $data = $this->View('panel');
        $data['emailRecipient'] = $this->recipientEmail();
        $data['emailSent'] = $this->sentEmail();
        $data['emailDel'] = $this->delEmail();
        $data['emailNoread'] = $this->nreadEmail();
        $data['userArray'] = $this->getAllUserInfo();
        $data['arr'] = $this->EmailModel->emailDetail($id);
        $data['org'] = $this->PublicModel->getDepList($arrayList=array(),0,0);
        $data['content'] = $this->load->view(self::VIEW_TURNLIST,$data,true);
        $this->load->view('index/index',$data);
    }

    //自定义分组功能emailGroupList列表
    public function emailGroupList() {
        $data = $this->View('panel');
        $uId = $this->session->userdata['uId'];
        if(!empty($uId)) {
            $where[] = "operator in($uId)";
            $urlArray[] = 'operator='.$uId;
        }
        if(!empty($urlArray)) {
            $urlStr = '/?'.implode('&', $urlArray);
        }
        if(!empty($where)) {
            $whereStr = ' and '.implode(" and ",$where);
        }
        $modelArray['modelPath'] = 'public';
        $modelArray['modelName'] = 'EmailModel';
        $modelArray['sqlTplName'] = 'emailSql';
        $modelArray['sqlTplFucName'] = 'groupList';
        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);
        $argument	= array(
                'base_url'      => self::GROUP_LIST,
                'per_page'		=> 10,
                'num_links'		=> 3,
                'uri_segment'	=> 4,
                'total_rows'	=> $rows
        );
        $getPaginDatas		= $this->createPagination($argument,$urlStr);
        $data['pagination']	= $getPaginDatas['pagination'];
        $data['rows']       = $rows;
        $data['arr']  = $this->EmailModel->groupList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        $data['emailRecipient'] = $this->recipientEmail();
        $data['emailSent'] = $this->sentEmail();
        $data['emailDel'] = $this->delEmail();
        $data['emailNoread'] = $this->nreadEmail();
        $data['userArray'] = $this->getAllUserInfo();
        $data['content'] = $this->load->view(self::VIEW_GROUP,$data,true);
        $this->load->view('index/index',$data);
    }
    //自定义分组添加
    public function emailGroupAdd() {
        $data = $this->View('panel');
        $data['emailRecipient'] = $this->recipientEmail();
        $data['emailSent'] = $this->sentEmail();
        $data['emailDel'] = $this->delEmail();
        $data['emailNoread'] = $this->nreadEmail();
        $data['userArray'] = $this->getAllUserInfo();
        $data['org'] = $this->PublicModel->getDepList($arrayList=array(),0,0);
        $data['content'] = $this->load->view(self::GROUP_ADD,$data,true);
        $this->load->view('index/index',$data);
    }
    //自定义分组收件人添加 数据插入
    public function emailGroupInsert() {
        $data = $this->View('panel');
        $uId = $this->session->userdata['uId'];
        $groupcontent = $this->input->post('cc_staff',true);
        $grouptitle = $this->input->post('title_email',true);
        $result=array(
                'operator'=>$uId,
                'grouptitle'=>$grouptitle,
                'groupcontent'=>$groupcontent['0'],
        );
        $fundsId = $this->PublicModel->insertSave($this->table_group,$result);
        if(!empty($fundsId)) {
            $this->showMsg(1,'添加分组成功',self::GROUP_LIST);
            exit;
        }else {
            $this->showMsg(2,'添加分组失败');
            exit;
        }
    }

    //自定义分数删除
    public function emailGroupDel($group_id) {
        $data = $this->View('panel');
        $signal = $this->PublicModel->updateSave($this->table_group,array('group_id'=>$group_id),array('isDel'=>1));
        if($signal != FALSE) {
            $this->showMsg(1,'删除成功');
            exit;
        }else {
            $this->showMsg(2,'删除失败！');
            exit;
        }
    }

    //自定义分组修改页面视图
    public function emailGroupEdit($group_id) {
        $data = $this->View('panel');
        $data['emailRecipient'] = $this->recipientEmail();
        $data['emailSent'] = $this->sentEmail();
        $data['emailDel'] = $this->delEmail();
        $data['emailNoread'] = $this->nreadEmail();
        $data['arr']  = $this->EmailModel->groupEditNews($group_id);
        $data['org'] = $this->PublicModel->getDepList($arrayList=array(),0,0);
        $data['content'] = $this->load->view(self::GROUP_EDIT,$data,true);
        $this->load->view('index/index',$data);
    }

    //自定义分组数据修改插入程序
    public function emailModify() {
        $data = $this->View('panel');
        $group_id = $this->input->post('group_id',true);
        $groupcontent = $this->input->post('cc_staff',true);
        $grouptitle = $this->input->post('title_email',true);
        $result=array(
                'grouptitle'=>$grouptitle,
                'groupcontent'=>$groupcontent['0'],
        );
        $fundsId = $this->PublicModel->updateSave($this->table_group,array('group_id'=>$group_id),$result);
        if($fundsId == TRUE) {
            $this->showMsg(1,'修改成功！',self::GROUP_LIST);
            exit;
        }else {
            $this->showMsg(2,'修改失败！');
            exit;
        }
    }

    public function upload() {
        error_reporting(0);
        $action = '';
        if(!empty($_GET['act'])) {
            $action = $_GET['act'];
        }
        if($action=='delimg') {
            $filename = $_POST['imagename'];
            if(!empty($filename)) {
                unlink('files/'.$filename);
                echo '1';
            }else {
                echo '删除失败。';
            }
        }else {
            $picname = $_FILES['mypic']['name'];
            $picsize = $_FILES['mypic']['size'];
            if ($picname != "") {
                if ($picsize > 10485760) {
                    echo '文件大小不能超过10M';
                    exit;
                }
                $upload_config	= $this->config->item('upload_config');
                $upload_config['upload_path'] = makeDir($this->config->item('upload_path'));
                $ext = pathinfo($picname);
                $type = $ext['extension'];
                $allow_types = explode("|",$upload_config['allowed_types']);
                if(!in_array($type,$allow_types)) {
                    echo "文件格式不正确";
                    exit;
                }
                $pics = md5(date('YmdHis')).'.'.$type;
                $path = $upload_config['upload_path'];
                //上传路径
                $pic_path = $path.$pics;
                move_uploaded_file($_FILES['mypic']['tmp_name'], $pic_path);
            }
            $size = round($picsize/1024,2);
            $arr	= array(
                    'fileName'		=> $pics,
                    'filePath'		=> $path,
                    'origName'		=> str_replace("—","-",$picname),
                    'fileExt'		=> '.'.$type,
                    'fileSize'		=> $size,
            );
            $nameTitle = basename($arr['origName'],$arr['fileExt']);
            $length = mb_strlen($nameTitle);
            $lengthArr = 25 - $length;
            if( $lengthArr == 0 ) {
                //echo "<b style=color:red;font-size:16px;>标题不能超过25个字!</b>";
                //exit;
            }
            $signal = $this->PublicModel->insertSave('crm_file',$arr);
            if(!empty($signal)) {
                $arr['fid'] = $signal;
                $arr['bfs'] = '100';
            }
            $arr['nameTitle'] = $nameTitle;
            $arr['length'] = $lengthArr;
            $result = json_encode($arr);
            $data['rows'] = $result;
            echo $data['rows'];
        }
    }

    public function emailDuanView() {
        $data = $this->View('public');
        $uId = $this->input->get_post('uId');
        $con = $this->input->get_post('content');

        $uIdArr = explode('-',base64_decode($uId));
        foreach($uIdArr as $value) {
            if(!empty($value)) {
                $str .= $value.'-';
            }
        }
        $data['str'] = base64_encode(rtrim($str,'-'));
        $data['content'] = $con;
        $data['content'] = $this->load->view('public/emailDuanView',$data,true);
        $this->load->view('index/index',$data);
    }

    public function duanxin() {
        $data = $this->View('public');
        $start = $this->input->get_post('start');
        $offset = $this->input->get_post('offset');
        $step = 1;
        if(empty($start)) {
            $start = '0';
            $offset = $step;
        }

        $uId = $this->input->get_post('str');
        $con = $this->input->get_post('content');
        $uIdArr = explode('-',base64_decode($uId));
        $countNum = count($uIdArr);
        $content = base64_decode(str_replace(" ","+",$con));
        $this->load->library('sms');
        foreach($uIdArr as $value) {
            $uIdStr .= $value.',';
        }
        $uIdStr = rtrim($uIdStr,',');
        $arr_phone = $this->EmailModel->emailPhoneNews($uIdStr);
        foreach($arr_phone as $key=>$val) {
            if($key>=$start && $key<$offset) {
                if(!empty($val["phone"])) {
                    $res = Sms::SendSms($val["phone"],$content);
                    if( strpos($res, 'Result=0') === false ) {
                        continue;
                    }
                }
            }
            $start  += $step;
            $offset += $step;
            if($offset > $countNum) {
                $this->showMsg(1,'短信发送成功','/public/EmailController/emailListView/');
                exit;
            }else {
                header("Location: http://erm.xkhouse.com/index.php/public/EmailController/duanxin/?start=$start&offset=$offset&str=$uId&content=$con");
            }
        }
    }


}




?>
