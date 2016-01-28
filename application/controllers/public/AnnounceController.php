<?php
/**
 * @desc 公告通知控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-07-13
 */
class AnnounceController extends MY_Controller {
    const MENU_ADD  = "public/AnnounceController/announceAdd";
    const MENU_LIST = "public/AnnounceController/announceList";
    protected $table="crm_office_news";
    public function  __construct() {
        parent::__construct();
        $this->config->load('journal', TRUE);
        $this->load->model('public/AnnounceModel');
        $this->load->library('form_validation');
        $this->load->model('admin/UserModel','',true);
        $this->load->model('admin/SiteModel','',true);
        $this->_validation=array(
                array('field'   => 'content', 'label'   => '内容', 'rules'=>'required'),
                array('field'   => 'title', 'label'   => '标题', 'rules'=>'required'),
                array('field'   => 'type', 'label'   => '类型', 'rules'=>'required'),
        );
        $this->config_new=array('1'=>'公告','2'=>'通知');

    }
    public function announceList($typeModel='') {
        $data = $this->View('panel');
        $urlArray = array();
        $urlStr   = $whereStr = '';
        $list['uId'] = $this->session->userdata['uId'];
        $type = $this->input->get('type');
        $title1 = $this->input->get_post('title1',true);
        $cTime = $this->input->get_post('cTime',true);
        $eTime = $this->input->get_post('eTime',true);
        $sId = $this->input->get_post('department',true);
        if(!empty($sId)) {
            $where[] = "a.sId=".$sId;
            $urlArray[] = 'sId ='.$sId;
        }
        $where[] = "a.type=".$type;
        $urlArray[] = 'type='.$type;

        if(!empty($cTime)) {
            $where[] = " a.createTime >='".strtotime($cTime)."'";
            $urlArray[] = 'cTime='.$cTime;
            $list['cTime']=$cTime;
        }

        if(!empty($eTime)) {
            $where[] = " a.createTime <='".strtotime($eTime)."'";
            $urlArray[] = 'eTime='.$eTime;
            $list['eTime']=$eTime;
        }
        if(!empty($title1)) {
            $where[] = " a.title like '%".$title1."%'";
            $urlArray[] = 'title1='.$title1;
            $list['title1']=$title1;
        }

        if(!empty($urlArray)) {
            $urlStr = '/?'.implode('&', $urlArray);
        }
        if(!empty($where)) {
            $list['sId'] = $sId;
            $whereStr = ' and '.implode(" and ",$where);
        }

        $modelArray['modelPath'] = 'public';
        $modelArray['modelName'] = 'AnnounceModel';
        $modelArray['sqlTplName'] = 'modelSql';
        $modelArray['sqlTplFucName'] = 'announceList';
        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);
        $argument	= array(
                'base_url'      => self::MENU_LIST,
                'per_page'		=> 12,
                'num_links'		=> 3,
                'uri_segment'	=> 4,
                'total_rows'	=> $rows
        );
        $list['config_new']=$this->config_new;
        $getPaginDatas		= $this->createPagination($argument,$urlStr);
        $list['pagination']	= $getPaginDatas['pagination'];
        $list['rows']       = $rows;
        $list['org'] = $this->PublicModel->getDepList($arrayList=array(),0,0);
        foreach($list['org'] as $key=>$value) {
            $dep[$value['sId']]=$value['name'];
        }
        $list['dep']=$dep;
        $list['userInfo']=$this->getAllUserInfo();
        $list['getResult']  = $this->AnnounceModel->announceList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);

        foreach($list['getResult'] as $key=>$val) {
            $list['getResult'][$key]['flow'] = $this->PublicModel->getFlowList($list['getResult'][$key]['id'],$this->table);
            $remove = $this->UserModel->getUserQuarter($val['operator']);
            $list['getResult'][$key]['orgName']  = $remove['name'];
        }
        $list['attendance'] = $this->config->item('attendance','journal');
        if($type == 1) {
            $list['carname'] = "公告";
        }elseif($type == 2) {
            $list['carname'] = "通知";
        }

        $data['content'] = $this->load->view('public/announceListView.php',$list,true);
        $this->load->view('index/index',$data);
    }
    public function announceAdd() {
        $data = $this->View('panel');
        $this->form_validation->set_rules($this->_validation);
        $type = $_POST['type'];
        if($this->input->post('submitCreate') != FALSE) {
            if($this->input->post('isUserfile')) {
                $sId= $this->uploadFile();
            }else {
                $sId = 0;
            }
            $dId=$this->PublicModel->getContactAllSid($this->session->userdata('uId'),0);
            $result=array(
                    'title'=>$this->input->post('title'),
                    'content'	=>$this->input->post('content'),
                    'type'		=>$type,
                    'createTime'=>time(),
                    'sId'=>$dId[0]['sId'],
                    'annex'=>$sId,
                    'operator'  =>$this->session->userdata('uId'),
                    'approve'  =>$this->input->post('receiveId'),
            );
            $funId=$this->PublicModel->insertSave('crm_office_news',$result);
            if($funId) {
                $this->PublicModel->controlProcess('crm_office_news',$funId,1);
                $this->showMsg(1,'录入成功！',"public/AnnounceController/announceList?type=".$type);
            }else {
                $this->showMsg(2,'录入失败！');
                exit;
            }
        }else {
            $list['config_new']=$this->config_new;
            $list['title']='';
            $list['type']=1;
            $list['org'] = $this->PublicModel->getDepList($arrayList=array(),0,0);
            $data['content'] = $this->load->view('public/announceAddView',$list,true);
            $this->load->view('index/index',$data);
        }

    }
    public function announceEdit($id) {
        $data = $this->View('panel');
        $getResult= $this->AnnounceModel->announceOne($id);
        $list = $getResult;
        $type = $_POST['type'];
        $this->form_validation->set_rules($this->_validation);
        if($this->input->post('submitCreate') != FALSE) {
            if($this->input->post('isUserfile')) {
                $sId= $this->uploadFile();
            }else {
                $sId = $list['annex'];
            }
            $result=array(
                    'title'=>$this->input->post('title'),
                    'content'	=>$this->input->post('content'),
                    'type'	=>$type,
                    'annex'=>$sId,
            );
            $signal = $this->PublicModel->updateSave('crm_office_news',array('id'=>$id),$result);
            if($signal != FALSE) {
                $this->showMsg(1,'修改成功',"public/AnnounceController/announceList?type=".$type);
            }else {
                $this->showMsg(2,'修改败，请重新操作');
                exit;
            }
        }

        $list['config_new']=$this->config_new;
        $list['id'] = $id;
        $data['content'] = $this->load->view('public/announceAddView',$list,true);
        $this->load->view('index/index',$data);
    }
    public function announceDetail($tId) {
        $data = $this->View('panel');
        $uId = $this->session->userdata['uId'];
        $getResult= $this->AnnounceModel->announceOne($tId);
        $list = $getResult;
        if($list['state'] == 1) {
            $listClick = explode(';', $list['click_name']);
            if(!empty($list['click_name'])) {
                if(!in_array($uId,$listClick)) {
                    $list['click_name'].= $uId.';';
                }
            }else {
                $list['click_name'].= $uId.';';
            }
            $result['click_name'] = $list['click_name'];
            $result['count']=$list['count']+1;
            $signal = $this->PublicModel->updateSave('crm_office_news',array('id'=>$tId),$result);
        }else {
            $result['count']=$list['count'];
        }

        $userInfo=$this->getAllUserInfo();
        $list['approve'] = $getResult['approve'];
        $list['info']=$userInfo;
        $list['count']=$result['count'];
        $list['uId'] = $uId;
        $list['config_new']=$this->config_new;

        $data['content'] = $this->load->view('public/announceDetailView',$list,true);
        $this->load->view('index/index',$data);
    }
    public function announceOne($tId) {
        $data = $this->View('panel');
        $getResult= $this->AnnounceModel->announceOne($tId);
        $list = $getResult;
        $getFlowList = $this->PublicModel->getFlowList($tId,$this->table);
        $list['flowlist']	= $getFlowList;
        if($this->input->post('submitCreate') != FALSE) {
            $app_type = $this->input->post('app_type');     //审批结果
            $app_con  = $this->input->post('app_con');      //审批意见
            $flowid   = $this->input->post('flowid');

            $this->PublicModel->controlProcess($this->table,$tId,2,0,$app_type,$app_con,$flowid);
            $this->showMsg(1,'提交成功','panel/PanelController/panelList');
           
        }
        if(!empty($list['flowlist'])) {
            $list['directory']  = $this->PublicModel->getProDirectory($getFlowList[0]['fromName'],$getFlowList[0]['fromUid'],$getFlowList[0]['createTime']);
        }
        $userInfo=$this->getAllUserInfo();
        $list['info']=$userInfo;
        $list['config_new']=$this->config_new;
        $data['content'] = $this->load->view('public/announceOneView',$list,true);
        $this->load->view('index/index',$data);
    }
    public function announceDel($delid,$type) {
        $data = $this->View('panel');
        if(!empty($delid)) {
            $signal = $this->PublicModel->updateSave('crm_office_news',array('id'=>$delid),array('isDel'=>1));
            $this->PublicModel->updateSave('crm_pending',array('tableId'=>$delid,'proTable'=>$this->table),array('isDel'=>1));  //软删除待处理事项提醒
            if($signal != FALSE) {
                $this->showMsg(1,'删除成功',"public/AnnounceController/announceList?type=".$type);
            }else {
                $this->showMsg(2,'删除失败');
                exit;
            }
        }
    }


}
?>
