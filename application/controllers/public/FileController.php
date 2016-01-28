<?php
/**
 * @desc 系统附件控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-07-10
 */
class FileController extends MY_Controller {
    protected $table = 'crm_public_email';
    protected $table_pms = 'crm_pms';
    public function  __construct() {
        parent::__construct();
        $this->load->model('public/EmailModel','',true);
    }

    public function downloadApp($fid,$emailId) {
        //附件下载
        header("Content-type:text/html;charset=utf-8");
        $this->load->helper('download');
        if(!empty($emailId)) {
            $this->getEmailId($emailId);
        }
        $getResult	= $this->PublicModel->getFile($fid);
        $name = iconv('utf-8','gb2312',$getResult['origName']);
        $name = str_replace(" ","",$name);

          $file_name = $getResult['fileName'];
          $file_dir  = $getResult['filePath'];
          if(empty($getResult['fileSize'])){
          	 echo "图片本身有错无法显示，请重新上传";  exit;
          }

          if(strstr($file_dir,'http')){
              $url = $file_dir.$file_name;
              header("Location:$url");
          }else{
	          $file = @ fopen($file_dir.$file_name,"r");
	          $fileSize = $getResult['fileSize'] * 1024 *2;
	          if (!$file) {
	             echo "找不到该文件";  exit;
	          }else{
	             header("content-type: application/octet-stream");
	             header("content-disposition:attachment;filename=".$name);
	             while (!feof ($file)) {
	                echo fread($file,$fileSize);
	             }
	             fclose ($file);
	          }
          }
    }

    public function emailLoad($fid,$emailId) {
        header("Content-type:text/html;charset=utf-8");
        $this->load->helper('download');
        if(!empty($emailId)) {
            $this->getEmailId($emailId);
        }
        $getResult	= $this->PublicModel->getFile($fid);
        $name = iconv('utf-8','gb2312',$getResult['origName']);

        $name = str_replace(" ","",$name);
        $file_name = $getResult['fileName'];
        $file_dir = $getResult['filePath'];
        if(empty($getResult['fileSize'])){
          	echo "图片本身有错无法显示，请重新上传";  exit;
        }

        if(strstr($file_dir,'http')){
        	$url = $file_dir.$file_name;
            header("Location:$url");
         }else{
	        $file = @ fopen($file_dir.$file_name,"r");
	        $fileSize = $getResult['fileSize'] * 1024 *2;
	        if (!$file) {
	            echo "找不到该文件";  exit;
	        } else {
	        	header("content-type: application/octet-stream");
	            header("content-disposition:attachment;filename=".$name);
	            while (!feof ($file)) {
	                echo fread($file,$fileSize);
	            }
	            fclose ($file);
	        }
        }
    }

    public function getEmailId($emailId) {
        $uId = $this->session->userdata['uId'];
        $arr = $this->EmailModel->emailDetail($emailId);
        if($arr['to_uid'] == $uId) {
            $rr = array(
                    'status'=>'1',
            );
            $this->PublicModel->updateSave($this->table,array('id'=>$emailId),$rr);
            $this->db->delete($this->table_pms,array('msgId'=>$emailId,'folder'=>'mail','msgtoUid'=>$arr['to_uid']));
        }
    }



}



?>
