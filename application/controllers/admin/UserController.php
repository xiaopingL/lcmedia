<?php
/**
 * @desc 用户控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-07-09
 */
class UserController extends MY_Controller {

    const USER_ADD  = "admin/UserController/userAdd";
    const USER_LIST = "admin/UserController/userList";

    public function  __construct() {
        parent::__construct();
        $this->load->model('admin/UserModel');
        $this->load->model('admin/OrgModel');
        $this->load->model('admin/RoleModel');
    }
    
    public function userList() {
        $data = $this->View('system');
        $urlArray = array();
        $urlStr   = $whereStr = '';
        $username = $this->input->get_post('username',true);
        $sId      = $this->input->get_post('sId',true);
        $jobId    = $this->input->get_post('jobId',true);
        $roleId   = $this->input->get_post('roleId',true);
        if(!empty($username)) {
            $list['username'] = $username;
            $where[] = "userName like '%".$username."%'";
            $urlArray[] = 'username='.$username;
        }
        if(!empty($sId)) {
            $list['sId'] = $sId;
            $urlArray[] = 'sId='.$sId;
            $sIdArray = $this->PublicModel->getAllOrgSublevel($arrayList=array(),$sId,0);
            if(!empty($sIdArray)) {
                $sIdStr = implode(',', $sIdArray);
                $uIdArray = $this->PublicModel->getContactAllUid($sIdStr,0);
                $uIdArray[]['uId'] = $this->session->userdata['uId'];
                $uIdAssemble = $this->converArr($uIdArray,'uId');
                $where[] = ' uId in ('.implode(',', $uIdAssemble).')';
                $this->session->set_userdata('searchSid',$uIdAssemble);
            }
        }
        if(!empty($jobId)) {
            $list['jobId'] = $jobId;
            $where[] = "jobId = ".$jobId;
            $urlArray[] = 'jobId='.$jobId;
        }
        if(!empty($roleId)) {
            $list['roleId'] = $roleId;
            $where[] = "roleId = ".$roleId;
            $urlArray[] = 'roleId='.$roleId;
        }
        if(!empty($where)) {
            $whereStr = ' and '.implode(" and ",$where);
        }
        if(!empty($urlArray)) {
            $urlStr = '/?'.implode('&', $urlArray);
        }
        $modelArray['modelPath'] = 'admin';
        $modelArray['modelName'] = 'usermodel';
        $modelArray['sqlTplName'] = 'userSql';
        $modelArray['sqlTplFucName'] = 'getUserList';

        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);
        $argument	= array(
                'base_url'        => self::USER_LIST,
                'per_page'		  => 13,
                'num_links'		  => 3,
                'uri_segment'	  => 4,
                'total_rows'	  => $rows
        );
        $getPaginDatas		= $this->createPagination($argument,$urlStr);
        $list['pagination']	= $getPaginDatas['pagination'];
        $list['rows']       = $rows;
        $list['getResult']  = $this->UserModel->getUserList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        foreach($list['getResult'] as $key=>$val) {
            foreach($data['position'] as $k=>$v) {
                if($val['jobId'] == $k) {
                    $list['getResult'][$key]['position'] = $v;
                }
            }
            $sidArr   = $this->PublicModel->getContactAllSid($val['uId'],0);
            $list['getResult'][$key]['siteName']= implode(',',$this->converArr($this->PublicModel->getContactAllSiteid($val['uId'],0),'name'));
            $list['getResult'][$key]['name']  = $sidArr[0]['name'];          //部门
        }
        $list['allUser'] = $this->getAllUserInfo();
        $list['org'] = $this->PublicModel->getDepList($arrayList=array(),0,0);
        $list['role']= $this->RoleModel->getAllRole(0);
        $data['content'] = $this->load->view('admin/userListView',$list,true);
        $this->load->view('index/index',$data);
    }

    public function userEdit($editid) {
        $data = $this->View('system');
        if(is_numeric($editid)) {
            $getResult = $this->UserModel->getUserDetail($editid,0);
            $list = $getResult;
            if($this->input->post('submitCreate') != FALSE) {
                $result = array(
                        'userName'    => $this->_clearSpace($this->input->post('userName',true),true),
                        'isDisabled'  => $this->input->post('isDisabled'),
                        'jobId'       => $this->input->post('jobId'),
                        'isInherit'   => $this->input->post('isInherit'),
                );
                if($this->input->post('pwd') && strlen($this->input->post('pwd'))>5) {
                    $result['password'] = md5($this->_clearSpace($this->input->post('pwd',true),true));
                }
                if($result['isInherit'] == 1 && $this->input->post('roreId')) {
                    $result['roleId'] = $this->input->post('roreId');
                }

                $checkUser = $this->UserModel->checkEditName($result['userName'],$editid,0);
                if($checkUser > 0) {
                    $this->showMsg(2,'该用户已经存在');
                    exit;
                }

                $signal = $this->PublicModel->updateSave('crm_user',array('uId'=>$editid),$result);
                
                $signal_a = $signal_b = $signal_c = $signal_d = '';
                /*-------------------------编辑组织架构开始--------------------------*/
                $orgArr  = $this->input->post('sId');
                if(count($orgArr)>0 && $orgArr[0] != '') {
                    //删除之前该用户组织架构
                    $this->db->delete('crm_structrue_contact',array('uId'=>$editid));
                }
                foreach((array)$orgArr as $key=>$val) {
                    if(!empty($val)) {
                        //新增该用户组织架构
                        $org_arr = array('sId' => $val, 'uId' => $editid, 'createTime' => time());
                        $signal_a = $this->PublicModel->insertSave('crm_structrue_contact',$org_arr);
                        $this->PublicModel->getContactAllUid($val,0,1);
                    }
                }
                /*-------------------------编辑组织架构结束--------------------------*/

                /*-------------------------编辑所属站点开始--------------------------*/
                $siteArr = $this->input->post('siteId');
                if(count($siteArr)>0 && $siteArr[0] != '') {
                    $this->db->delete('crm_user_site',array('uId'=>$editid));
                }
                foreach((array)$siteArr as $key=>$val) {
                    if(!empty($val)) {
                        $site_arr = array('siteId' => $val, 'uId' => $editid, 'createTime' => time());
                        $signal_b = $this->PublicModel->insertSave('crm_user_site',$site_arr);
                    }
                }
                /*-------------------------编辑所属站点结束--------------------------*/

                /*-------------------------编辑菜单权限分配开始--------------------------*/
                $codeArr = $this->input->post('comCode');
                if(count($codeArr)>0 && $codeArr[0] != '') {
                    $this->db->delete('crm_user_contact',array('uId'=>$editid,'type'=>1,'isDel'=>0));
                }
                foreach((array)$codeArr as $key=>$val) {
                    if(!empty($val)) {
                        $role_arr = array('comCode' => $val, 'uId' => $editid, 'type' => 1, 'createTime' => time(), 'isDel' => 0);
                        $signal_c = $this->PublicModel->insertSave('crm_user_contact',$role_arr);
                    }
                }
                /*-------------------------编辑菜单权限分配结束--------------------------*/
                
                /*-------------------------编辑操作权限分配开始--------------------------*/
                $operaArr = $this->input->post('operaid');
                if(count($operaArr)>0 && $operaArr[0] != '') {
                    //过滤顶级分类权限代码
                    $getCompetence = $this->converArr($this->UserModel->getCompetence('',0),'comCode');
                    foreach($operaArr as $k=>$v) {
                        if(in_array($v,$getCompetence)) {
                            unset($operaArr[$k]);
                        }
                    }
                    sort($operaArr);
                    $this->db->delete('crm_user_contact',array('uId'=>$editid,'type'=>1,'isDel'=>2));
                }
                foreach((array)$operaArr as $key=>$val) {
                    if(!empty($val)) {
                        $opera_arr = array('comCode' => $val, 'uId' => $editid, 'type' => 1, 'createTime' => time(), 'isDel' => 2);
                        $signal_d = $this->PublicModel->insertSave('crm_user_contact',$opera_arr);
                    }
                }
                /*-------------------------编辑操作权限分配结束--------------------------*/
                if($signal != FALSE || $signal_a != FALSE || $signal_b != FALSE || $signal_c != FALSE || $signal_d != FALSE) {
                    $this->showMsg(1,'用户修改成功',self::USER_LIST);
                }else {
                    $this->showMsg(2,'修改失败，请重新操作');
                    exit;
                }
            }else {
                $userOrg  = $this->UserModel->getUserOrg($editid,0);                    //获取组织架构
                $userSite = $this->UserModel->getUserSite($editid,0);                   //获取站点
                $userMenu = $this->UserModel->getUserMenu($editid,1,0);                 //权限代码 菜单权限
                $userOpera = $this->UserModel->getUserMenu($editid,1,2);                //权限代码 操作权限
                $list['org'] = $this->OrgModel->getChildList($arrayList=array(),0,0);   //获取组织架构
                $list['site']= $this->UserModel->getSiteList(0);                        //获取所有站点
                $list['role']= $this->UserModel->getRoleList(0);                        //获取用户角色
                $list['menu']= $this->UserModel->getChildList($arrayList=array(),'',0);
                $list['opera']= $this->UserModel->getChildList($arrayList=array(),'',2);
                $list['userOrg'] = $userOrg;
                foreach($list['org'] as $value) {
                    $list['orgStr'][$value['sId']] = $value['name'];
                }
                
                if(!empty($list['opera'])) {
                    $opera_arr = array();
                    foreach($list['opera'] as $key=>$val) {
                        if($val['level'] == 2 && !in_array($val['parent'],$opera_arr)) {
                            $opera_arr[] = $val['parent'];
                        }
                    }
                    foreach($list['opera'] as $k=>$v) {
                        if($v['level'] == 1 && !in_array($v['comCode'],$opera_arr)) {
                            unset($list['opera'][$k]);
                        }
                    }
                    $list['opera'] = array_values($list['opera']);
                }
                
                //组织架构数组匹配
                foreach($list['org'] as $key=>$value) {
                    $list['org'][$key]['orgId'] = (in_array($value['sId'],$this->converArr($userOrg,'sId')))?$value['sId']:'';
                }
                //所属站点数组匹配
                foreach($list['site'] as $key=>$value) {
                    $list['site'][$key]['sitd'] = (in_array($value['siteId'],$this->converArr($userSite,'siteId')))?$value['siteId']:'';
                }
                //所属菜单权限数组匹配
                foreach($list['menu'] as $key=>$value) {
                    $list['menu'][$key]['codeId'] = (in_array($value['comCode'],$this->converArr($userMenu,'comCode')))?$value['comCode']:'';
                }
                //所属操作权限数组匹配
                foreach($list['opera'] as $key=>$value) {
                    $list['opera'][$key]['operaid'] = (in_array($value['comCode'],$this->converArr($userOpera,'comCode')))?$value['comCode']:'';
                }

                $data['content'] = $this->load->view('admin/userEditView',$list,true);
                $this->load->view('index/index',$data);
            }

        }else {
            $this->userList();
        }
    }

    public function userDel($delid) {
        if(is_numeric($delid)) {
            $userInfo = $this->PublicModel->selectSave('userName','crm_user',array('uId'=>$delid),1);

            $signal = $this->PublicModel->updateSave('crm_user',array('uId'=>$delid),array('isDel'=>1));
            if($signal != FALSE) {
                //删除该用户的菜单和操作权限
                $this->db->delete('crm_user_contact',array('uId'=>$delid,'type'=>1));
                $this->showMsg(1,'帐号关闭成功',self::USER_LIST);
            }
        }else {
            exit;
        }
    }

    public function getCompetence($isDel) {
        $comCodeList = '';
        $parent = $this->input->post('parent',true);
        $getResult = $this->UserModel->getCompetence($parent,$isDel);
        foreach($getResult as $key=>$value) {
            $comCodeList .= $value['comCode']."#";
        }
        echo $comCodeList;
    }

    public function getDepUser() {
        $data = array();
        $returnVal  = '';
        $orgid	= $this->input->post('orgid',true);
        $data = $this->PublicModel->getAllOrgSublevel($arrayList=array(),$orgid,0);
        $data[] = $orgid;
        if(!empty($data)) {
            $orgStr = ($orgid == 1)?$orgid:implode(',', $data);
            $uIdArray = $this->remove_duplicate($this->PublicModel->getContactAllUid($orgStr,0));
            $allUserInfo = $this->getOnUserInfo();
            if(!empty($uIdArray)) {
                foreach($uIdArray as $key=>$val) {
                    if(!empty($allUserInfo[$val['uId']])) {
                        $returnVal .= "<option value='".$val['uId']."'>".$allUserInfo[$val['uId']]."</option>";
                    }
                }
            }
        }
        echo $returnVal;
    }

    public function getSendInfo() {
        $send_name = urldecode(trim($this->input->post('value')));
        $getSendInfo = $this->UserModel->getSendInfo($send_name);
        if(!empty($getSendInfo)) {
            $developersStr = '';
            foreach($getSendInfo as $v) {
                $developersStr .= $v['userName'].'#';
            }
        }
        echo $developersStr;
    }


}



?>
