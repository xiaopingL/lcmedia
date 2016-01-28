<?php
/**
 * @desc 待处理事项控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-07-08
 */
 class PanelController extends MY_Controller{

 	const PANEL_LIST = "panel/PanelController/panelList";

 	public function  __construct(){
        parent::__construct();
        $this->load->model('panel/PanelModel');
        $this->load->model('admin/UserModel');
    }

    public function panelList() {
        $data = $this->View('panel');
        $toUid = $this->session->userdata('uId');
        $rows = $this->PublicModel->getCount('crm_pending','pendId',array('isDel='=>0,'status='=>0,'toUid='=>$toUid));
        $argument	= array(
                'base_url'        => self::PANEL_LIST,
                'per_page'		  => 13,
                'num_links'		  => 3,
                'uri_segment'	  => 4,
                'total_rows'	  => $rows
        );
        $getPaginDatas		= $this->createPagination($argument);
        $list['pagination']	= $getPaginDatas['pagination'];
        $list['rows']       = $rows;
        $list['getResult']  = $this->PanelModel->getPanelList($toUid,$getPaginDatas['start'],$getPaginDatas['offset']);
        $data['content'] = $this->load->view('panel/panelListView',$list,true);
        $this->load->view('index/index',$data);
    }

    public function panelDel($delid){
        if(isset($delid)){
            $signal = $this->PublicModel->updateSave('crm_pending',array('pendId'=>$delid),array('isDel'=>1));
            if($signal != FALSE){
            	$this->showMsg(1,'删除成功',self::PANEL_LIST);
            }
        }else{
        	exit;
        }
    }


 }



?>
