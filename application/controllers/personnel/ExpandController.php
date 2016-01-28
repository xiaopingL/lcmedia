<?php
/**
 * @desc 档案管理控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-07-19
 */
class ExpandController extends MY_Controller {
    const MENU_LIST = "personnel/ExpandController/expandList";
    const MENU_EDIT = "personnel/ExpandController/expandEdit";
    protected $table = 'crm_personnel_expand';

    public function  __construct() {
        parent::__construct();
        $this->load->model('personnel/AttendModel','',true);
        $this->load->model('admin/UserModel','',true);
        $this->config->load('personnel',true);
    }

    public function expandList() {
        $data = $this->View('personnel');
        $whereStr = $urlStr = '';
        $this->session->unset_userdata('searchSid');
        $this->session->unset_userdata('searchDel');
        $username = $this->input->get_post('userName',true);
        $sId      = $this->input->get_post('sId',true);
        $status   = $this->input->get_post('status',true);
        $status   = empty($status)?0:1;

        if(!empty($sId)) {
            $list['sId'] = $sId;
            $urlArray[] = 'sId='.$sId;
            $sIdArray = $this->PublicModel->getAllOrgSublevel($arrayList=array(),$sId,0);
            if(!empty($sIdArray)) {
                $sIdStr = implode(',', $sIdArray);
                $uIdArray = $this->PublicModel->getContactAllUid($sIdStr,0);
                $uIdAssemble = $this->converArr($uIdArray,'uId');
                if(!empty($uIdAssemble)) {
                    $where[] = 'a.uId in ('.implode(',', $uIdAssemble).')';
                }
                $this->session->set_userdata('searchSid',$sId);
            }
        }else {
            if(!in_array('allExpand',$data['userOpera'])) {
                $where[] = "a.uId =".$this->session->userdata('uId');
            }
        }

        $list['status'] = $status;
        $urlArray[] = 'status='.$status;
        $where[] = "a.isDel = ".$status;
        $this->session->set_userdata('searchDel',$status);

        if(!empty($username)) {
            $where[] = "a.userName like '%".$username."%'";
            $list['userName'] = $username;
            $urlArray[] = 'userName='.$username;
        }

        if(!empty($where)) {
            $whereStr = implode(" and ",$where);
        }
        if(!empty($urlArray)) {
            $urlStr = '/?'.implode('&', $urlArray);
        }

        $modelArray['modelPath'] = 'personnel';
        $modelArray['modelName'] = 'attendmodel';
        $modelArray['sqlTplName'] = 'attendSql';
        $modelArray['sqlTplFucName'] = 'getAllUserList';

        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);

        $argument	= array(
                'base_url'        => self::MENU_LIST,
                'per_page'		=> 12,
                'num_links'		=> 3,
                'uri_segment'	    => 4,
                'total_rows'	    => $rows
        );
        $getPaginDatas		= $this->createPagination($argument,$urlStr);
        $list['pagination']	= $getPaginDatas['pagination'];
        $list['rows']       = $rows;
        $list['getResult']  = $this->AttendModel->getAllUserList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        foreach($list['getResult'] as $key=>$val) {
            $getExpand     = $this->AttendModel->getExpandDetail($val['uId']);
            $quarter   = $this->UserModel->getUserQuarter($val['uId']);
            
            $list['getResult'][$key]['orgName']  = $quarter['name'];
            $list['getResult'][$key]['sex'] = $getExpand['sex'];
            $list['getResult'][$key]['birthday'] = $getExpand['birthday'];
            $list['getResult'][$key]['graduateFrom'] = $getExpand['graduateFrom'];
            $list['getResult'][$key]['education'] = $getExpand['education'];
            $list['getResult'][$key]['phone'] = $getExpand['phone'];
            $list['getResult'][$key]['photoImg'] = $this->UserModel->getUserPhoto($val['uId']);
        }
        $list['org'] = $this->PublicModel->getDepList($arrayList=array(),0,0);
        $list['educationType'] = $this->config->item('education','personnel');
        $data['content'] = $this->load->view('personnel/expandListView',$list,true);
        $this->load->view('index/index',$data);
    }

    public function expandEdit($uId) {
        $data = $this->View('personnel');
        if(!is_numeric($uId)) $this->expandList();
        $getResult = $this->AttendModel->getExpandDetail($uId);
        $list = $getResult;
        $workSum    = explode('||',$list['workSum']);
        $contactSum = explode('||',$list['contactSum']);
        foreach($workSum as $key=>$value) {
            if(!empty($value)) {
                $workDet = explode('##',$value);
                $workList[$key]['danwei']   = $workDet[0];
                $workList[$key]['position'] = $workDet[1];
                $workList[$key]['workDate'] = $workDet[2];
            }
        }
        foreach($contactSum as $key=>$value) {
            if(!empty($value)) {
                $sumDet = explode('##',$value);
                $sumList[$key]['conName']  = $sumDet[0];
                $sumList[$key]['contract'] = $sumDet[1];
                $sumList[$key]['conTel']   = $sumDet[2];
            }
        }
        $list['workList']   = $workList;
        $list['sumList']    = $sumList;
        $list['userDetail'] = $this->UserModel->getUserInfo($uId);
        if($this->input->post('submitCreate') != FALSE) {
        	$photo = ($this->input->post('isUserfile1'))?$this->uploadFile('userfile1'):$getResult['photo'];
            $expandArr = array(
                    'sex'            => $this->input->post('sex'),
                    'birthday'       => strtotime($this->input->post('birthday')),
                    'idcard'         => $this->input->post('idcard'),
                    'political'      => $this->input->post('political'),
                    'nativePlace'    => $this->input->post('nativePlace'),
                    'isMarriage'     => $this->input->post('isMarriage'),
                    'vision'         => $this->input->post('vision'),
                    'bloodType'      => $this->input->post('bloodType'),
                    'height'         => $this->input->post('height'),
                    'weight'         => $this->input->post('weight'),
                    'graduateFrom'   => $this->input->post('graduateFrom'),
                    'professional'   => $this->input->post('professional'),
                    'graduateTime'   => strtotime($this->input->post('graduateTime')),
                    'education'      => $this->input->post('education'),
                    'phone'          => $this->input->post('telphone'),
                    'cardAddr'       => $this->input->post('cardAddr'),
                    'address'        => $this->input->post('family'),
                    'currentAddress' => $this->input->post('currentAddress'),
		            'photo'          => $photo,
            );
            $expandId = $this->PublicModel->updateSave($this->table,array('uId'=>$uId),$expandArr);
            if($expandId) {
                $this->showMsg(1,'档案编辑成功',self::MENU_LIST);
            }else {
                $this->showMsg(2,'编辑失败！');
                exit;
            }
        }else {
            $list['politicalType'] = $this->config->item('political','personnel');
            $list['marriageType']  = $this->config->item('marriage','personnel');
            $list['bloodsType']    = $this->config->item('blood','personnel');
            $list['educationType'] = $this->config->item('education','personnel');
            $data['content'] = $this->load->view('personnel/expandEditView',$list,true);
        }
        $this->load->view('index/index',$data);
    }

    public function expandDetail($uId) {
        $data = $this->View('personnel');
        $list['uId'] = $uId;
        if(!is_numeric($uId)) $this->expandList();
        $getResult = $this->AttendModel->getExpandDetail($uId);
        $list = $getResult;
        if(strstr($list['filePath'],'application')) {
            $filePath = explode('application',$list['filePath']);
            $list['photoImg'] = $data['base_url'].'application'.$filePath[1].$list['fileName'];
        }else {
            $list['photoImg'] = $list['filePath'].$list['fileName'];
        }

        $workSum    = explode('||',$list['workSum']);
        $contactSum = explode('||',$list['contactSum']);
        foreach($workSum as $key=>$value) {
            if(!empty($value)) {
                $workDet = explode('##',$value);
                $workList[$key]['danwei']   = $workDet[0];
                $workList[$key]['position'] = $workDet[1];
                $workList[$key]['workDate'] = $workDet[2];
            }
        }
        foreach($contactSum as $key=>$value) {
            if(!empty($value)) {
                $sumDet = explode('##',$value);
                $sumList[$key]['conName']  = $sumDet[0];
                $sumList[$key]['contract'] = $sumDet[1];
                $sumList[$key]['conTel']   = $sumDet[2];
            }
        }
        $list['workList']   = $workList;
        $list['sumList']    = $sumList;
        $list['userDetail'] = $this->UserModel->getUserInfo($uId);
        $list['politicalType'] = $this->config->item('political','personnel');
        $list['marriageType']  = $this->config->item('marriage','personnel');
        $list['bloodsType']    = $this->config->item('blood','personnel');
        $list['educationType'] = $this->config->item('education','personnel');
        $data['content'] = $this->load->view('personnel/expandDetailView',$list,true);
        $this->load->view('index/index',$data);
    }

    

}

?>

