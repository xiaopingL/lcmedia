<?php
/**
 * @desc 权限控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-07-09
 */
class MenuController extends MY_Controller {

    const MENU_ADD  = "admin/MenuController/menuAdd";
    const MENU_LIST = "admin/MenuController/menuList";

    public function  __construct() {
        parent::__construct();
        $this->load->model('admin/MenuModel');
    }

    public function menuAdd() {
        $data = $this->View('system');
        if($this->input->post('submitCreate') != FALSE) {
            $type = $this->input->post('type');
            $level = $this->input->post('parent') != ''?$this->MenuModel->getLevel($this->input->post('parent'),0):'0';
            $result = array(
                    'comeName'    => $this->_clearSpace($this->input->post('comeName',true),true),
                    'comCode'     => $this->_clearSpace($this->input->post('comCode',true),true),
                    'description' => $this->input->post('description'),
                    'level'       => intval($level+1),
                    'parent'      => $this->input->post('parent'),
                    'createTime'  => time()
            );
            
            if($type == 1) {
                //添加菜单权限
                $result['codeUrl'] = $this->_clearSpace($this->input->post('codeUrl'),true);
                $result['weight']  = intval(trim($this->input->post('weight')));

            }else {
                //添加操作权限
                $result['isDel']   = 2;
            }

            $checkMenu = $this->MenuModel->checkMenu($result['comCode']);
            if($checkMenu > 0) {
                $this->showMsg(2,'已经存在该权限！');
                exit;
            }
            $this->PublicModel->insertSave('crm_competence',$result);
            $this->showMsg(1,'权限添加成功',self::MENU_ADD);

        }else {
            $list['menu'] = $this->MenuModel->getChildMenu(1,0);
            $data['content'] = $this->load->view('admin/menuAddView',$list,true);
        }
        $this->load->view('index/index',$data);
    }

    public function menuList() {
        $data = $this->View('system');
        $menuName = $this->input->post('menuName',true);
        $comCode  = $this->input->post('comCode',true);
        $modelArray['modelPath'] = 'admin';
        $modelArray['modelName'] = 'menumodel';
        $modelArray['sqlTplName'] = 'menuSql';
        $modelArray['sqlTplFucName'] = 'getMenuList';
        $whereStr = " a.isDel != 1";
        if(!empty($menuName)) {
            $whereStr .= " and a.comeName like '%".$menuName."%'";
            $list['menuName'] = $menuName;
        }
        if(!empty($comCode)) {
            $whereStr .= " and a.comCode like '%".$comCode."%'";
            $list['comCode'] = $comCode;
        }
        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);
        $argument	= array(
                'base_url'      => self::MENU_LIST,
                'per_page'		=> 12,
                'num_links'		=> 3,
                'uri_segment'	=> 4,
                'total_rows'	=> $rows
        );
        $getPaginDatas		= $this->createPagination($argument);
        $list['pagination']	= $getPaginDatas['pagination'];
        $list['rows']       = $rows;
        $list['getResult']  = $this->MenuModel->getMenuList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        $data['content'] = $this->load->view('admin/menuListView',$list,true);
        $this->load->view('index/index',$data);
    }

    public function menuEdit($editid) {
        $data = $this->View('system');
        if(isset($editid)) {
            $getResult = $this->MenuModel->getMenuDetail($editid);
            $list = $getResult;
            if($this->input->post('submitCreate') != FALSE) {
                $level = $this->input->post('parent') != ''?$this->MenuModel->getLevel($this->input->post('parent'),0):'0';
                $result = array(
                        'comeName'    => $this->_clearSpace($this->input->post('comeName',true),true),
                        'description' => $this->input->post('description'),
                        'level'       => intval($level+1),
                        'parent'      => $this->input->post('parent'),
                        'codeUrl'     => $this->_clearSpace($this->input->post('codeUrl'),true),
                        'weight'      => intval(trim($this->input->post('weight'))),
                );
                $signal = $this->PublicModel->updateSave('crm_competence',array('comCode'=>$editid),$result);
                if($signal != FALSE) {
                    $this->showMsg(1,'菜单权限修改成功',self::MENU_LIST);
                }else {
                    $this->showMsg(2,'菜单权限修改失败，请重新操作');
                    exit;
                }
            }else {
                $list['menu'] = $this->MenuModel->getChildMenu(1,0);
                $data['content'] = $this->load->view('admin/menuEditView',$list,true);
                $this->load->view('index/index',$data);
            }

        }else {
            $this->menuList();
        }
    }

    public function menuDel($delid) {
        if(isset($delid)) {
            $signal = $this->PublicModel->updateSave('crm_competence',array('comCode'=>$delid),array('isDel'=>1));
            if($signal != FALSE) {
                $this->showMsg(1,'菜单权限删除成功',self::MENU_LIST);
            }
        }else {
            exit;
        }
    }


}



?>
