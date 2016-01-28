<?php
/**
 * @desc 个人设置控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-07-10
 */
class UpdatebaseController extends MY_Controller {
	
    protected $table = 'crm_user';
    const VIEW_EDIT  = "public/baseInfoEdit";

    public function  __construct() {
        parent::__construct();
        $this->load->model('admin/UserModel','',true);
        $this->user_id = $this->session->userdata['uId'];
    }

    public function baseInfoEdit() {
    	$data = $this->View('panel');
    	$uId = $this->user_id;
        $data['arr'] = $this->PublicModel->selectSave('eId,phone,uId,workqq','crm_personnel_expand',array('uId'=>$uId),1);
        $data['userList']  = $this->PublicModel->selectSave('*',$this->table,array('uId'=>$uId),1);
        $data['content'] = $this->load->view(self::VIEW_EDIT,$data,true);
        $this->load->view('index/index',$data);
    }

    public function baseInfoModify() {
        $uId = $this->user_id;
        $eId = $this->input->post('eId',true);
        $phone = $this->input->post('phone',true);
        $workqq = $this->input->post('workqq',true);
        $oldpassword = trim($this->input->post('oldpassword',true));
		$password    = trim($this->input->post('password',true));
        $isPms       = $this->input->post('isPms',true);

		if(!empty($phone)){
		   $fundsId1 = $this->PublicModel->updateSave('crm_personnel_expand',array('eId'=>$eId),array('phone'=>$phone));
		}
    	if(!empty($workqq)){
		   $fundsId2 = $this->PublicModel->updateSave('crm_personnel_expand',array('eId'=>$eId),array('workqq'=>$workqq));
		}
		
		if(!empty($password)){
           $userInfo = $this->PublicModel->selectSave('password,userName',$this->table,array('uId'=>$uId,'isDel'=>0),1);
           if($userInfo['password'] != md5($oldpassword)){
              $this->showMsg(2,'原密码输入有误！');  exit;
           }
		   $fundsId3 = $this->PublicModel->updateSave($this->table,array('uId'=>$uId),array('password'=>md5($password)));
		}

        $fundsId4 = $this->PublicModel->updateSave($this->table,array('uId'=>$uId),array('isPms'=>$isPms));

        if($fundsId1 || $fundsId2 || $fundsId3 || $fundsId4){
            $this->showMsg(2,'信息修改成功！');
        }else {
            $this->showMsg(2,'信息修改失败！');
        }
    }


}

?>
