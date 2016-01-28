<?php
/**
 * @desc 库存管理控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-08-17
 */
class ToolsController extends MY_Controller {
	
    protected $table = 'crm_office_tools';
    
    const MENU_LIST  = "office/ToolsController/toolsList";
    
    public function  __construct() {
        parent::__construct();
        $this->load->model('office/ToolsModel','',true);
    }
    
    public function toolsList() {
    	$this->operaControl('allTools');
        $data = $this->View('office');
        $whereStr = '';
        $toolsName = $this->input->get_post('toolsName',true);
        if(!empty($toolsName)) {
            $where[] = "name like '%".$toolsName."%'";
            $urlArray[] = 'name='.$toolsName;
            $data['toolsName'] = $toolsName;
        }

        if(!empty($urlArray)) {
            $urlStr = '/?'.implode('&', $urlArray);
        }
        if(!empty($where)) {
            $whereStr = ' and '.implode(" and ",$where);
        }
        
        $modelArray['modelPath'] = 'office';
        $modelArray['modelName'] = 'ToolsModel';
        $modelArray['sqlTplName'] = 'publicSql';
        $modelArray['sqlTplFucName'] = 'toolsList';
        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);
        $argument	= array(
                'base_url'      => self::MENU_LIST,
                'per_page'		=> 12,
                'num_links'		=> 3,
                'uri_segment'	=> 4,
                'total_rows'	=> $rows
        );
        $getPaginDatas		= $this->createPagination($argument,$urlStr);
        $data['pagination']	= $getPaginDatas['pagination'];
        $data['rows']       = $rows;
        $data['arr']  = $this->ToolsModel->toolsList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        foreach($data['arr'] as $key=>$val){
        	$data['arr'][$key]['stockNum'] = $this->ToolsModel->getToolStock($val['tId']);
        }
        $data['userInfoArray'] = $this->getAllUserInfo();
        $data['content'] = $this->load->view('office/toolsListView',$data,true);
        $this->load->view('index/index',$data);
    }

    public function toolsAddView() {
        $data = $this->View('office');
        if($this->input->post('submitCreate') != FALSE){
	        $result = array(
	              'name'=> trim($this->input->post('name')),
	              'type' => $this->input->post('type'),
	              'unit' => trim($this->input->post('unit')),
	              'num' => trim($this->input->post('num')),
	              'price' => trim($this->input->post('price')),
	              'remark' => $this->input->post('remark'),
	              'operator' => $this->session->userdata('uId'),
	              'createTime'=>time(),
	        );
	        $checkTools = $this->PublicModel->selectSave('tId',$this->table,array('name'=>$result['name'],'isDel'=>0),1);
	        if(!empty($checkTools)){
	        	$this->showMsg(2,'该物料名称已经存在，不需要再次入库！'); exit;
	        }
	        
	        $tId = $this->PublicModel->insertSave($this->table,$result);
            if(!empty($tId)){
                $this->showMsg(1,'填写成功',self::MENU_LIST);
	        }else {
	            $this->showMsg(2,'填写失败！');
	        }
        }

        $data['content'] = $this->load->view('office/toolsAddView',$data,true);
        $this->load->view('index/index',$data);
    }
    
    public function toolsEdit($tId) {
        $data = $this->View('office');
        $data['arr'] = $this->PublicModel->selectSave('*',$this->table,array('tId'=>$tId,'isDel'=>0),1);
        if($this->input->post('submitCreate') != FALSE){
            $result = array(
                  'name' => trim($this->input->post('name')),
                  'type' => $this->input->post('type'),
                  'unit' => trim($this->input->post('unit')),
                  'price' => trim($this->input->post('price')),
                  'remark' => $this->input->post('remark')
            );
            $checkTools = $this->PublicModel->selectSave('tId',$this->table,array('name'=>$result['name'],'isDel'=>0,'tId <>'=>$tId),1);
            if(!empty($checkTools)){
                $this->showMsg(2,'该物料名称已经存在'); exit;
            }
            
            $tId = $this->PublicModel->updateSave($this->table,array('tId'=>$tId),$result);
            if(!empty($tId)){
                $this->showMsg(1,'编辑成功',self::MENU_LIST);
            }else {
                $this->showMsg(2,'编辑失败！');
            }
        }

        $data['content'] = $this->load->view('office/toolsEditView',$data,true);
        $this->load->view('index/index',$data);
    }

    public function toolsStock($tId) {
        $data = $this->View('office');
        $num = 0;
        $data['arr'] = $this->PublicModel->selectSave('*',$this->table,array('tId'=>$tId,'isDel'=>0),1);
        if($this->input->post('submitCreate') != FALSE){
            $num = trim($this->input->post('num'));
            $result['num'] = $data['arr']['num']+$num;
            $tId = $this->PublicModel->updateSave($this->table,array('tId'=>$tId),$result);
            if(!empty($tId)){
                $this->showMsg(1,'物料入库成功',self::MENU_LIST);
            }else {
                $this->showMsg(2,'入库失败！');
            }
        }

        $data['content'] = $this->load->view('office/toolsStockView',$data,true);
        $this->load->view('index/index',$data);
    }

    
    

}


?>
