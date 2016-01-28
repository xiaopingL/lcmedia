<?php
/**
 * @desc 部门控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-07-09
 */
class OrgController extends MY_Controller {

    const ORG_ADD  = "admin/OrgController/orgAdd";
    const ORG_LIST = "admin/OrgController/orgList";

    public function  __construct() {
        parent::__construct();
        $this->load->model('admin/OrgModel');
    }

    public function orgAdd() {
        $data = $this->View('system');
        if($this->input->post('submitCreate') != FALSE) {
            $level = $this->input->post('parentId') != 0?$this->OrgModel->getLevel($this->input->post('parentId'),0):'0';
            $result = array(
                    'name'        => $this->_clearSpace($this->input->post('name',true),true),
                    'parentId'    => $this->input->post('parentId'),
                    'level'       => intval($level+1),
                    'phoneNumber' => $this->input->post('phoneNumber'),
                    'weight'      => $this->input->post('weight'),
                    'createTime'  => time()
            );
            $signal = $this->PublicModel->insertSave('crm_structrue',$result);
            if($signal != FALSE) {
                $this->showMsg(1,'添加成功',self::ORG_ADD);
            }else {
                $this->showMsg(2,'添加失败，请重新操作');
                exit;
            }

        }else {
            $list['org'] = $this->OrgModel->getChildList($arrayList=array(),0,0);
            $data['content'] = $this->load->view('admin/orgAddView',$list,true);
        }
        $this->load->view('index/index',$data);
    }

    public function orgList() {
        $data = $this->View('system');
        $whereStr = '';
        $orgName = $this->input->post('orgName',true);
        if(!empty($orgName)) {
            $where[] = "a.name like '%".$orgName."%'";
        }
        if(!empty($where)) {
            $whereStr = ' and '.implode(" and ",$where);
        }

        $modelArray['modelPath'] = 'admin';
        $modelArray['modelName'] = 'orgmodel';
        $modelArray['sqlTplName'] = 'orgSql';
        $modelArray['sqlTplFucName'] = 'getOrgList';

        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);

        $argument	= array(
                'base_url'        => self::ORG_LIST,
                'per_page'		=> 12,
                'num_links'		=> 3,
                'uri_segment'	    => 4,
                'total_rows'	    => $rows
        );
        $getPaginDatas		= $this->createPagination($argument);
        $list['pagination']	= $getPaginDatas['pagination'];
        $list['rows']       = $rows;
        $list['getResult']  = $this->OrgModel->getOrgList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        $list['orgName'] = $orgName;
        $data['content'] = $this->load->view('admin/orgListView',$list,true);
        $this->load->view('index/index',$data);
    }

    public function orgEdit($editid) {
        $data = $this->View('system');
        if(is_numeric($editid)) {
            $getResult = $this->OrgModel->getOrgDetail($editid,0);
            $list = $getResult;
            if($this->input->post('submitCreate') != FALSE) {
                $level = $this->input->post('parentId') != 0?$this->OrgModel->getLevel($this->input->post('parentId'),0):'0';
                $result = array(
                        'name'        => $this->_clearSpace($this->input->post('name',true),true),
                        'parentId'    => $this->input->post('parentId'),
                        'level'       => intval($level+1),
                        'phoneNumber' => $this->input->post('phoneNumber'),
                        'weight'      => $this->input->post('weight'),
                        'createTime'  => time()
                );
                $signal = $this->PublicModel->updateSave('crm_structrue',array('sId'=>$editid),$result);
                if($signal != FALSE) {
                    $this->showMsg(1,'修改成功',self::ORG_LIST);
                }else {
                    $this->showMsg(2,'修改失败，请重新操作');
                    exit;
                }
            }else {
                $list['org'] = $this->OrgModel->getChildList($arrayList=array(),0,0);
                $data['content'] = $this->load->view('admin/orgEditView',$list,true);
                $this->load->view('index/index',$data);
            }

        }else {
            $this->orgList();
        }
    }

    public function orgDel($delid) {
        if(is_numeric($delid)) {
            $signal = $this->PublicModel->updateSave('crm_structrue',array('sId'=>$delid),array('isDel'=>1));
            if($signal != FALSE) {
                $this->showMsg(1,'删除成功',self::ORG_LIST);
            }
        }else {
            exit;
        }
    }


}



?>
