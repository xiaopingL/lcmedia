<?php
/**
 * @desc 讨论区控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-07-14
 */
class ForumArtController extends MY_Controller {
    const ART_ADD  = "office/ForumArtController/forumArtAdd";
    const ART_LIST_VIEW = "office/forumArtList";
    const ART_LIST = "office/ForumArtController/forumArtList";

    public function  __construct() {
        parent::__construct();
        $this->load->model('office/ForumArtModel');
        $this->load->model('office/ForumModel');
        $this->load->model('admin/UserModel','',true);
    }
    
    public function forumClass(){
    	$forumClass = array();
    	$forum = $this->PublicModel->selectSave('id,className,areaAdmin as banZhu','crm_forum_area',array('flag'=>0),2);
        if(!empty($forum)){
        	foreach($forum as $key=>$val){
        		$forumClass[$val['id']] = $val;
        	}
        }
        return $forumClass;
    }
    
    public function forumArtList() {
    	$data = $this->View('panel');
    	$whereStr = '';
        $uId = $this->session->userdata['uId'];
        $userArray = $this->getAllUserInfo();
        $userName = $userArray[$uId];
        $cid = $this->input->get_post('cid',true);
        $subcid = $this->input->get_post('subcid',true);
        $data['cid'] = $cid;
        $data['subcid'] = $subcid;
        $forumClass = $this->forumClass();
        $banZhuArr = explode(';',$forumClass[$cid]['banZhu']);
		if(in_array($userName,$banZhuArr)) {
		    $data['isBanZhu'] = 1;
		}

        $inputs = $this->input->get_post('department');
        $title = $this->input->get_post('title');
        $modelArray['modelPath'] = 'office';
        $modelArray['modelName'] = 'ForumArtModel';
        $modelArray['sqlTplName'] = 'forumArtSql';
        $modelArray['sqlTplFucName'] = 'forumArtList';
        if(!empty($cid)) {
            $where[] = "(aid =".$cid." or type=3)";
            $urlArray[] = 'cid='.$cid;
        }
        if(!empty($subcid)) {
            $where[] = "(subcid =".$subcid.")";
            $urlArray[] = 'subcid='.$subcid;
        }

        if($inputs == 1) {
            $where[] = "title like '%".$title."%'";
            $urlArray[] = 'title='.$title;
            $urlArray[] = 'department='.$inputs;
        }elseif($inputs == 2) {
            $where[] = "real_name like '%".$title."%'";
            $urlArray[] = 'title='.$title;
            $urlArray[] = 'department='.$inputs;
        }elseif($inputs == 3) {
            $urlArray[] = 'department='.$inputs;
            $sTime = $this->input->get_post('sTime',true);
            $eTime = $this->input->get_post('eTime',true);
            if($sTime) {
                $sTime1 = strtotime($sTime.' 00:00:00');
            }
            if($eTime) {
                $eTime1 = strtotime($eTime.' 23:59:59');
            }

            if(!empty($sTime1)) {
                $where[] = ' post_date >='.$sTime1;
                $urlArray[] = 'sTime='.$sTime;
            }
            if(!empty($eTime1)) {
                $where[] = ' post_date <='.$eTime1;
                $urlArray[] = 'eTime='.$eTime;
            }
        }

        if(!empty($urlArray)) {
            $data['title1'] = $title;
            $data['sTime'] = $sTime;
            $data['eTime'] = $eTime;
            $data['inptype'] = $inputs;
            $urlStr = '/?'.implode('&', $urlArray);
        }

        if(!empty($where)) {
            $whereStr = ' and '.implode(" and ",$where);
            $this->session->set_userdata('searchWhere',$whereStr);
        }

        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);

        $argument	= array(
                'base_url'      => self::ART_LIST,
                'per_page'		=> 12,
                'num_links'		=> 3,
                'uri_segment'	=> 4,
                'total_rows'	=> $rows
        );

        $getPaginDatas		= $this->createPagination($argument,$urlStr);
        $data['pagination']	= $getPaginDatas['pagination'];
        $data['rows']       = $rows;
        $data['forumClass'] = $forumClass;
        $data['cid']  = $cid;
        $data['subcid']  = $subcid;
        if(!empty($subcid)) {
            $data['subClass'] = $this->ForumModel->claDet($subcid);
        }

        $data['directory']  = "帖子列表";
        $data['arr']  = $this->ForumArtModel->forumArtList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        foreach($data['arr'] as $key=>$val) {
            $remove = $this->UserModel->getUserQuarter($val['staff_id']);
            if(strpos($val['click_name'],$userName.';')) {
                $data['arr'][$key]['isClick']  = 1;
            }else {
                $data['arr'][$key]['isClick']  = 0;
            }
            $data['arr'][$key]['orgName']  = $remove['name'];
        }
        $data['content'] = $this->load->View(self::ART_LIST_VIEW,$data,true);
        $this->load->View('index/index',$data);
    }

    public function artDet($id,$cid) {
        $forumClass = $this->forumClass();
        $data = $this->View('panel');
        $whereStr = '';
        $uId = $this->session->userdata['uId'];
        $userArray = $this->getAllUserInfo();
        $userName = $userArray[$uId];
        $id = $id;
        $department = $this->input->get_post('department');
        $title = $this->input->get_post('title');
        $signal = $this->db->query('update crm_forum_topic set click_num=click_num+1 where id='.$id);
        $modelArray['modelPath'] = 'office';
        $modelArray['modelName'] = 'ForumArtModel';
        $modelArray['sqlTplName'] = 'artDet';
        $modelArray['sqlTplFucName'] = 'artDet';
        $data['arr']  = $this->ForumArtModel->artDet($id);
        $clickNameArr = explode(';',$data['arr']['click_name']);
        if(!in_array($userName,$clickNameArr) && ($userName !=$data['arr']['real_name'])) {
            $data['arr']['click_name'] .= $userName.';';
            $signal = $this->db->query('update crm_forum_topic set click_name="'.$data['arr']['click_name'].'" where id='.$id);
        }
        $remove = $this->UserModel->getUserQuarter($data['arr']['staff_id']);
        $data['depa']  = $remove['name'];
        $data['comments'] = $this->ForumArtModel->artComments($id);
        $data['forumClass']       = $forumClass;
        $className = $forumClass[$data['arr']['aid']]['className'];
        $data['directory']  = "导航 ->讨论区 ->".$className."-> 帖子浏览";
        $data['userName'] = $this->session->userdata('userName');
        $data['content'] = $this->load->View('office/artDet',$data,true);
        $this->load->View('index/index',$data);
    }

    public function forumArtAdd($cid) {
        $data = $this->View('panel');
        $cid  = $cid;
        $aid  = $this->input->post('cid');
        $subcid = $this->input->get_post('subcid');
        if(empty($subcid)) {
            $subcid = $this->input->get_post('subcid2');
        }
        if(!empty($subcid)) {
            $aid = $aid;
            if(empty($aid)) {
                $aid = 1;
            }
        }else {
            $subcid = 0;
        }
        $uId = $this->session->userdata('uId');
        $remove = $this->UserModel->getUserQuarter($uId);
        $orgName  = $remove['name'];

        $msg = $this->input->post('msg',true);
        $userArray = $this->getOnUserInfo();
        foreach($userArray as $key=>$val) {
            $userInfo[$val] = $key;
        }
        $time = time();
        if($_POST) {
            $result	= array(
                    'staff_id'	 	=> $uId,
                    'real_name'	    => $this->session->userdata('userName'),
                    'staff_name'	=> $this->session->userdata('userName'),
                    'title'		=> $this->input->post('title'),
                    'content'	=> $this->input->post('content'),
                    'include'	=> '0',//附件ID
                    'aid'	=> $aid,
                    'subcid' => $subcid,
                    'post_date'		=> $time,
                    'lastTime'=>$time,

            );

            $tId = $this->PublicModel->insertSave('crm_forum_topic',$result);
            $signal='';
            $areaSignal = $this->db->query('update crm_forum_area set topicNum =topicNum +1, lasttopicStaff  = \''.$result['staff_name'].'\', lasttopicDate=\''.$result['post_date'].'\' where id='.$result['aid']);

            if($tId) {
                if($msg == '1') {
                    foreach($userInfo as $value) {
                        $rel = array(
                                'msgId'=>$tId,
                                'msgtoUid'=>$value,
                                'folder'=>'forum',
                                'isRead'=>'0',
                                'subject'=>$orgName."　".$userArray[$uId]."  发表了新帖子：《".$this->input->post('title')."》",
                                'createTime'=>$time,
                                'msgUrl'=>site_url('/office/ForumArtController/artDet/'.$tId),
                        );
                        $this->PublicModel->insertSave('crm_pms',$rel);

                    }

                }

                $this->showMsg(1,'帖子发布成功！','/office/ForumArtController/forumArtList/?cid='.$result['aid']);
            }else {
                $this->showMsg(2,'帖子发布失败！');
                exit;
            }
        }else {
            $data['act'] = site_url('/office/ForumArtController/forumArtAdd/');
            $forumClass = $this->forumClass();
            $data['forumClass'] = $forumClass;
            $data['cid'] = $cid;
            $className = $forumClass[$cid]['className'];
            if(!empty($subcid)) {
                $data[subClass] = $this->ForumModel->claDet($subcid);
                $data['directory']  = "导航 ->讨论区 ->".$data['subClass']['className']."-> 发表新帖";
            }else {
                $data['directory']  = "导航 ->讨论区 ->".$className."-> 发表新帖";
            }

            $data['content'] = $this->load->view('office/forumArtAddView',$data,true);

            $this->load->view('index/index',$data);
        }
    }
    //评论添加
    public function forumComAdd($id,$cid) {

        $data = $this->View('panel');
        $id  = $id;

        if($_POST) {
            $result	= array(
                    'staff_id'	 	=> $this->session->userdata('uId'),
                    'real_name'	    => $this->session->userdata('userName'),
                    'staff_name'	=> $this->session->userdata('userName'),
                    'pid'			=> $id,
                    'aid'			=> $this->input->post('aid'),
                    'content'	=> $this->input->post('content'),
                    'post_date'		=> time(),

            );
            if(empty($result['content'])) {
                $this->showMsg(1,'评论不能为空！','/office/ForumArtController/artDet/'.$id.'/'.$cid);
                exit;
            }
            $tId = $this->PublicModel->insertSave('crm_forum_topic',$result);
            if($tId) {
                $lastReser =$this->session->userdata('userName');
                $lastTime = time();
                $signal = $this->db->query('update crm_forum_topic set lastTime='.$lastTime.', lastReser = \''.$lastReser.'\', comments_num=comments_num+1 where id='.$id);
                $areaSignal = $this->db->query('update crm_forum_area set commentNum=commentNum+1, lastcommentStaff  = \''.$result['staff_name'].'\', lastcommentDate=\''.$result['post_date'].'\' where id='.$result['aid']);

                $this->showMsg(1,'评论成功！','/office/ForumArtController/artDet/'.$id.'/'.$cid);
            }else {
                $this->showMsg(2,'评论失败！');
                exit;
            }
        }

    }
    public function forumArtMod($id,$cid) {
        $id = $id;
        $forumClass = $this->forumClass();
        $data = $this->View('panel');
        if($_POST) {
            $result	= array(
                    'title'	 	=> $this->input->post('title'),
                    'content'	=> $this->input->post('content'),
            );
            $signal = $this->PublicModel->updateSave('crm_forum_topic',array('id'=>$id),$result);
            if($signal != FALSE) {
                $this->showMsg(1,'修改成功','/office/ForumArtController/forumArtList/?cid='.$cid);
            }else {
                $this->showMsg(2,'修改失败，请重新操作');
                exit;
            }
        }else {
            $whereStr = '';
            $uId = $this->session->userdata['uId'];
            $department = $this->input->get_post('department');
            $title = $this->input->get_post('title');
            $data['arr']  = $this->ForumArtModel->artMod($id);
            $data['forumClass']       = $forumClass;
            $className = $forumClass[$data['arr']['aid']]['className'];
            $data['directory']  = "导航 ->讨论区 ->".$className."-> 修改帖子";
            $data['content'] = $this->load->view('office/forumArtModView',$data,true);
            $this->load->view('index/index',$data);
        }

    }
    public function forumArtSetPro($proId,$topicId,$cid=1) {
        $forumClass = $this->forumClass();
        $data = $this->View('office');
        if(!empty($topicId)) {
            $idArray = explode('-',$topicId);
            $counts = count($idArray);

            for($i=0;$i<$counts-1;$i++) {
                if($i < $counts -2) {
                    $idStr .= $idArray[$i].',';
                }else {
                    $idStr .= $idArray[$i];
                }

            }
        }else {
            exit('非法访问！');
        }
        if($proId == 1) {
            $signal = $this->db->query('update crm_forum_topic set type=1 where id in('.$idStr.')');
            $this->showMsg(1,'成功设置版内置顶！','/office/ForumArtController/forumArtList/?cid='.$cid);
        }elseif($proId == 3) {
            $signal = $this->db->query('update crm_forum_topic set type=3 where id in('.$idStr.')');
            $this->showMsg(1,'成功设置全局置顶！','/office/ForumArtController/forumArtList/?cid='.$cid);
        }elseif($proId == 2) {
            $signal = $this->db->query('update crm_forum_topic set type=2,lastTime='.time().' where id in('.$idStr.')');
            $this->showMsg(1,'设置精华成功！','/office/ForumArtController/forumArtList/?cid='.$cid);
        }else {
            $signal = $this->db->query('update crm_forum_topic set type=0 where id in('.$idStr.')');
            $this->showMsg(1,'取消属性成功！','/office/ForumArtController/forumArtList/?cid='.$cid);
        }


    }
    public function forumArtDelete($topicId,$cid=1) {

        if(!empty($topicId)) {

            $idArray = explode('-',$topicId);
            $counts = count($idArray);
            for($i=0;$i<$counts-1;$i++) {
                if($i < $counts -2) {
                    $idStr .= $idArray[$i].',';
                }else {
                    $idStr .= $idArray[$i];
                }

            }
            $signal = $this->db->query('update crm_forum_topic set flag=1 where id in('.$idStr.')');
            $this->showMsg(1,'成功删除帖子！','/office/ForumArtController/forumArtList/?cid='.$cid);
        }else {
            exit('非法访问！');
        }

    }
    //评论删除
    public function forumCommDel($id,$aid) {

        if(!empty($id)) {
            $signal = $this->db->query('update crm_forum_topic set flag=1 where id in('.$id.')');
            $this->showMsg(1,'成功删除帖子评论！','/office/ForumArtController/artDet/'.$aid);
        }else {
            exit('非法访问！');
        }

    }

    // 读取ClassName
    public function classSubCounts($id) {
        $data  = $this->ForumArtModel->classSubCounts($id);
        if(!empty($data)) {
            echo $data['count'];
        }else {
            echo '暂无主题';
        }

    }
    //设置最新回复时间，最新回复人姓名
    public function updateLastInfo() {
        mysql_query("set names 'utf8'");
        set_time_limit(0);
        ini_set("memory_limit","2024M");

        $fromuidQuery = $this->PublicModel->selectSave('id,pid','crm_forum_topic','pid = 0');
        foreach($fromuidQuery as $key=>$val) {
            $commsSet = $this->PublicModel->selectSave('id,pid,staff_name,post_date','crm_forum_topic','pid ='.$val['id'],2,'id desc',1);
            if(!empty($commsSet)) {
                $this->db->query('update crm_forum_topic set lastTime='.$commsSet[0]['post_date'].', lastReser = \''.$commsSet[0]['staff_name'].'\' where id='.$val['id']);
            }
        }
    }

    //设置最新点评人数字
    public function updateCommsNum() {
        mysql_query("set names 'utf8'");
        set_time_limit(0);
        ini_set("memory_limit","2024M");
        $fromuidArray = "select * from crm_forum_topic where pid = 0 and lastReser='' and lastTime='' order by id desc";

        echo $fromuidArray;
        $fromuidArray = $this->PublicModel->selectSave("*","crm_forum_topic","pid = 0 and lastReser='' and lastTime=''");


        foreach($fromuidArray as $key=>$val) {
            if(!empty($key)) {
                $arr = array(
                        lastReser=>$val['staff_name'],
                        lastTime=>$val['post_date'],
                );
                $this->PublicModel->updateSave('crm_forum_topic',array('id'=>$val['id']),$arr);
            }
        }
    }
    
    //设置讨论区类别的相关数字
    public function updateClassNum() {
        mysql_query("set names 'utf8'");
        set_time_limit(0);
        ini_set("memory_limit","2024M");
        $areaArray = array(
                1,
                2,
                16,
                18,
                19,
                20,
        );

        foreach($areaArray as $key=>$val) {
            $fromuidQuery = $this->PublicModel->selectSave('id,pid','crm_forum_topic',"pid = 0 and aid={$val}");
            if(!empty($commsSet)) {
                $arr = array(
                        lastReser=>$commsSet[0]['staff_name'],
                        lastTime=>$commsSet[0]['post_date'],
                );
                $this->PublicModel->updateSave('crm_forum_area',array('id'=>$val['id']),$arr);
            }
        }
    }

    public function forumUpdateTime(){
       $result = $this->ForumArtModel->getForumUpdate();
       foreach($result as $value){
           $this->PublicModel->updateSave('crm_forum_topic',array('id'=>$value['id']),array('lastTime'=>$value['post_date']));
       }
       $this->showMsg(1,'更新成功！',self::ART_LIST);
    }

}

?>
