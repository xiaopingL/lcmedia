<?php
/**
 * @desc 讨论区帖子类别控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-07-14
 */
class ForumController extends MY_Controller {

    const CLASS_ADD  = "office/ForumController/forumClassAdd";

    const CLASS_LIST_VIEW = "office/classListView";
    const MENU_LIST = "office/ForumController/classList";

    public function  __construct() {
        parent::__construct();
        $this->load->model('office/ForumModel');
        $this->load->library('form_validation');
    }
    public function classList(){
        $data = $this->View('panel');
        $whereStr = 'and pid =0';
		$modelArray['modelPath'] = 'office';
        $modelArray['modelName'] = 'ForumModel';
        $modelArray['sqlTplName'] = 'forumSql';
        $modelArray['sqlTplFucName'] = 'classList';

        $data['arr']  = $this->ForumModel->forumClassList(0,8,$whereStr);
        $data['content'] = $this->load->View(self::CLASS_LIST_VIEW,$data,true);
        $this->load->View('index/index',$data);
    }

    public function forumClassAdd(){
        $data = $this->View('panel');
        $this->form_validation->set_rules($this->_validation);
        if($_POST) {
            $result	= array(
				'className'	 	=> $this->input->post('className'),
                'areaAdmin'	    => $this->input->post('cc_staff'),
                'classMemo'	    => $this->input->post('classMemo'),
                'postDate'	 	=> time(),
			);
            $tId = $this->PublicModel->insertSave('crm_forum_area',$result);
            if($tId){
              $this->showMsg(1,'讨论区板块添加成功！',self::MENU_LIST);
            }else{
              $this->showMsg(2,'讨论区板块添加失败！'); exit;
            }
        }else {
			$data['directory']  = "导航 ->讨论区 -> 新增板块";
        	$data['org'] = $this->PublicModel->getDepList($arrayList=array(),0,0);
            $data['content'] = $this->load->view('office/forumClassAdd',$data,true);
        }

        $this->load->view('index/index',$data);
    }

    //删除讨论区分类
    public function classDel($id) {
    	if(empty($id))  exit('非法访问！');
		$signal = $this->db->query('update crm_forum_area set flag=1 where id ='.$id);
    	$this->showMsg(1,'删除成功！','/office/ForumController/forumSubjAdd');


    }

}

?>
