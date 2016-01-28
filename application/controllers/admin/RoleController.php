<?php
/**
 * @desc 角色控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-07-09
 */
class RoleController extends MY_Controller {

    const ROLE_ADD  = "admin/RoleController/roleAdd";
    const ROLE_LIST = "admin/RoleController/roleList";

    public function  __construct() {
        parent::__construct();
        $this->load->model('admin/RoleModel');
        $this->load->model('admin/UserModel');
    }

    public function roleAdd() {
        $data = $this->View('system');
        if($this->input->post('submitCreate') != FALSE) {
            $result = array(
                    'roleName'    => $this->_clearSpace($this->input->post('roleName',true),true),
                    'description' => $this->input->post('description'),
                    'createTime'  => time()
            );
            $checkRole = $this->RoleModel->checkRole($result['roleName'],0);
            if($checkRole > 0) {
                $this->showMsg(2,'该角色已经存在');
                exit;
            }
            $signal = $this->PublicModel->insertSave('crm_user_role',$result);
            if($signal != FALSE) {
                $this->showMsg(1,'添加成功',self::ROLE_ADD);
            }else {
                $this->showMsg(2,'添加失败，请重新操作');
                exit;
            }

        }else {
            $data['content'] = $this->load->view('admin/roleAddView',null,true);
        }
        $this->load->view('index/index',$data);
    }

    public function roleList() {
        $data = $this->View('system');
        $whereStr = '';
        $roleName = $this->input->post('roleName',true);
        if(!empty($roleName)) {
            $where[] = "roleName like '%".$roleName."%'";
        }
        if(!empty($where)) {
            $whereStr = ' and '.implode(" and ",$where);
        }

        $modelArray['modelPath'] = 'admin';
        $modelArray['modelName'] = 'rolemodel';
        $modelArray['sqlTplName'] = 'roleSql';
        $modelArray['sqlTplFucName'] = 'getRoleList';

        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);
        $argument	= array(
                'base_url'      => self::ROLE_LIST,
                'per_page'		=> 12,
                'num_links'		=> 3,
                'uri_segment'	=> 4,
                'total_rows'	=> $rows
        );
        $getPaginDatas		= $this->createPagination($argument);
        $list['pagination']	= $getPaginDatas['pagination'];
        $list['rows']       = $rows;
        $list['getResult']  = $this->RoleModel->getRoleList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        $list['roleName'] = $roleName;
        $data['content'] = $this->load->view('admin/roleListView',$list,true);
        $this->load->view('index/index',$data);
    }

    public function roleEdit($editid) {
        $data = $this->View('system');
        if(is_numeric($editid)) {
            $getResult = $this->RoleModel->getRoleDetail($editid,0);
            $list = $getResult;
            if($this->input->post('submitCreate') != FALSE) {
                $result = array(
                        'roleName'    => $this->_clearSpace($this->input->post('roleName',true),true),
                        'description' => $this->input->post('description'),
                );
                $checkRole = $this->RoleModel->checkEditRole($result['roleName'],$editid,0);
                if($checkRole > 0) {
                    $this->showMsg(2,'该角色已经存在');
                    exit;
                }
                $signal = $this->PublicModel->updateSave('crm_user_role',array('roreId'=>$editid),$result);
                if($signal != FALSE) {
                    $this->showMsg(1,'修改成功',self::ROLE_LIST);
                }else {
                    $this->showMsg(2,'修改失败，请重新操作');
                    exit;
                }
            }else {
                $data['content'] = $this->load->view('admin/roleEditView',$list,true);
                $this->load->view('index/index',$data);
            }

        }else {
            $this->roleList();
        }
    }

    public function roleDel($delid) {
        if(is_numeric($delid)) {
            $signal = $this->PublicModel->updateSave('crm_user_role',array('roreId'=>$delid),array('isDel'=>1));
            if($signal != FALSE) {
                $this->showMsg(2,'删除成功',self::ROLE_LIST);
            }
        }else {
            exit;
        }
    }

    public function roleBind($editid) {
        $data = $this->View('system');
        if(is_numeric($editid)) {
            $getResult   = $this->RoleModel->getRoleDetail($editid,0);
            $getMenuList = $this->RoleModel->getChildList($arrayList=array(),'',0);
            $getUserRole = $this->RoleModel->getUserRole($editid,0,0);
            $getUserOpera = $this->RoleModel->getUserRole($editid,0,2);
            $getOperaList= $this->UserModel->getChildList($arrayList=array(),'',2);

            $list = $getResult;
            $list['menuList']  = $getMenuList;
            $list['operaList'] = $getOperaList;
            $list['userRole']  = $this->converArr($getUserRole,'comCode');
            $list['userOpera'] = $this->converArr($getUserOpera,'comCode');
            if(!empty($list['operaList'])) {
                $opera_arr = array();
                foreach($list['operaList'] as $key=>$val) {
                    if($val['level'] == 2 && !in_array($val['parent'],$opera_arr)) {
                        $opera_arr[] = $val['parent'];
                    }
                }
                foreach($list['operaList'] as $k=>$v) {
                    if($v['level'] == 1 && !in_array($v['comCode'],$opera_arr)) {
                        unset($list['operaList'][$k]);
                    }
                }
                $list['operaList'] = array_values($list['operaList']);
            }
            
            if($this->input->post('submitCreate') != FALSE) {
            	$signal_a = $signal_b  = '';
                /*-------------------------菜单权限分配开始--------------------------*/
                $comCode = $this->input->post('comCode');
                if(count($comCode)>0 && $comCode[0] != '') {
                    $this->db->delete('crm_user_contact',array('uId'=>$editid,'type'=>0,'isDel'=>0));
                }
                foreach((array)$comCode as $key=>$value) {
                    if(!empty($value)) {
                        $result = array(
                                'comCode'    => $value,
                                'uId'        => $editid,
                                'createTime' => time()
                        );
                        $signal_a = $this->PublicModel->insertSave('crm_user_contact',$result);
                    }
                }
                /*-------------------------菜单权限分配结束--------------------------*/
                
                /*-------------------------操作权限分配开始--------------------------*/
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
                    $this->db->delete('crm_user_contact',array('uId'=>$editid,'type'=>0,'isDel'=>2));
                }
                foreach((array)$operaArr as $key=>$val) {
                    if(!empty($val)) {
                        $opera_arr = array('comCode' => $val, 'uId' => $editid, 'createTime' => time(), 'isDel' => 2);
                        $signal_b = $this->PublicModel->insertSave('crm_user_contact',$opera_arr);
                    }
                }
                /*-------------------------操作权限分配结束--------------------------*/
                $this->showMsg(1,'权限分配成功',self::ROLE_LIST);
            }else {
                $data['content'] = $this->load->view('admin/roleBindView',$list,true);
                $this->load->view('index/index',$data);
            }
        }else {
            $this->roleList();
        }
    }


}
?>