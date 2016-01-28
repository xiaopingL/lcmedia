<?php
/**
 * @desc 登录控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-07-08
 */
class Home extends CI_Controller {

    public function  __construct() {
        parent::__construct();
        $this->load->model('admin/UserModel');
    }

    public function index() {
        redirect('home/login');
    }

    public function register() {
        header("Content-type:text/html;charset=utf-8");
        $data['base_url'] = base_url();
        $this->config->load('personnel',true);
        if($this->input->post('submitCreate') != FALSE) {
            //保存用户基本信息
            $result = array(
                    'userName'  => trim($this->input->post('user',true)),
                    'password'  => md5(trim($this->input->post('pass',true))),
                    'isDisabled'=> 1,
                    'createTime'=> time(),
            );
            $checkUser = $this->UserModel->checkRegName($result['userName'],0);
            if($checkUser > 0) {
                echo "<script type='text/javascript'>alert('该用户已经存在！');history.go(-1);</script>";
                exit;
            }
            
            $signal = $this->PublicModel->insertSave('crm_user',$result);
            $siteList = $this->input->post('siteId');
            foreach((array)$siteList as $key=>$value) {
                if(!empty($value)) {
                    $site_arr = array('siteId' => $value, 'uId' => $signal, 'createTime' => time());
                    $this->PublicModel->insertSave('crm_user_site',$site_arr);
                }
            }

            $expandArr = array(
                    'uid'            => $signal,
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
                    'phone'          => $this->input->post('phone'),
                    'cardAddr'       => $this->input->post('cardAddr'),
                    'address'        => $this->input->post('address'),
                    'currentAddress' => $this->input->post('currentAddress'),
            );
            $this->PublicModel->insertSave('crm_personnel_expand',$expandArr);
            echo "<script type='text/javascript'>alert('帐号注册成功，请尽快联系管理员审核！');window.location.href='home/login'</script>";
        }
        $data['site']= $this->UserModel->getSiteList(0);
        $data['politicalType']= $this->config->item('political','personnel');
        $data['marriageType'] = $this->config->item('marriage','personnel');
        $data['bloodType']    = $this->config->item('blood','personnel');
        $data['educationType']= $this->config->item('education','personnel');
        $this->load->view('index/register',$data);
    }

    public function login() {
        $data['base_url'] = base_url();
        if($this->input->post('submitCreate') != FALSE) {
            $username = getSafeValue($this->input->post('username',true));
            $password = md5(getSafeValue($this->input->post('password',true)));
            $getDatas = $this->UserModel->checkLogin($username,$password);

            switch($getDatas['signal']) {
                case 'success':
                    $row = $getDatas['row'];
                    if($row->isDisabled == 1) {
                        $data['error'] = "帐号审核中,有疑问请联系管理员！";
                        break;
                    }
                    //更新登录信息
                    $result = array('lastTime' => time(), 'lastIp' => $this->input->ip_address());
                    $signal = $this->PublicModel->updateSave('crm_user',array('uId'=>$row->uId),$result);
                    //获取登录用户站点
                    $siteArr = $this->UserModel->getUserSite($row->uId,0);
                    //获取登录用户组织架构
                    $orgArr  = $this->UserModel->getUserOrg($row->uId,0);

                    $this->load->library('session');
                    $newSessionData = array(
                            'uId'       => $row->uId,
                            'userName'  => $row->userName,
                            'roleId'    => $row->roleId,
                            'jobId'     => $row->jobId,
                            'isInherit' => $row->isInherit,
                            'qSid' 		=> $row->qSid,
                            'siteId'    => implode(',',conventArr($siteArr,'siteId')),
                            'sId'       => implode(',',conventArr($orgArr,'sId'))
                    );
                    $this->session->set_userdata($newSessionData);
                    redirect('panel/WelcomeController/welcome');
                    break;
                case 'error':
                    $data['error'] = "用户名或密码有误！";
                    break;
                default:
                    break;
            }
        }
        $this->load->view('index/login',$data);
    }

    public function logOut() {
        $_SESSION = array();
        $this->session->sess_destroy();
        redirect('home/login');
    }
    
    public function checkUser() {
        $request = urldecode(trim($this->input->post('user')));
        $userInfo = $this->UserModel->getUserFirst($request);
        if(!empty($userInfo)) {
            echo 'false';
        }else {
            echo 'true';
        }
    }

    public function uploadFile($field = 'userfile') {
        if($_FILES[$field]['size'] > 1024*1024*10) {
            echo "<script language=javascript>alert('文件大小超过允许范围!');history.go(-1);</script>";
            die();
        }

        $upload_config	= $this->config->item('upload_config');
        $upload_config['upload_path'] = makeDir($this->config->item('upload_path'));
        $this->load->library('upload', $upload_config);
        if (!$this->upload->do_upload($field))
            $upload_data = $this->upload->display_errors();
        else
            $upload_data = $this->upload->data();
        if(!is_array($upload_data)) {
            echo "<script language=javascript>alert('$upload_data!');history.go(-1);</script>";
            die();
        }

        $result	= array(
                'fileName'		=> $upload_data['file_name'],
                'filePath'		=> $upload_data['file_path'],
                'origName'		=> $upload_data['orig_name'],
                'fileExt'		=> $upload_data['file_ext'],
                'fileSize'		=> $upload_data['file_size'],
        );
        $signal = $this->PublicModel->insertSave('crm_file',$result);
        return $signal;
    }

}



?>
