<?php
/**
 * Description of UserModel
 * 用户管理模型
 * @author xiaoping
 */

class UserModel extends CI_Model {

    public $userSql = array(
            'checkRegName' => "select uId from crm_user where userName = '?' and isDel = ?",
            'checkLogin'   => "select * from crm_user where userName = '?' and password = '?' and isDel = ?",
            'checkEditName'=> "select uId from crm_user where userName = '?' and uId <> ? and isDel = ?",
            'getUserList'  => "select * from crm_user where isDel = 0 ? order by createTime DESC limit ?,?",
            'getSiteList'  => "select siteId,name,createTime from crm_site where isDel = ?",
            'getRoleList'  => "select roreId,roleName from crm_user_role where isDel = ?",
            'getUserDetail'=> "select * from crm_user where uId = ? and isDel = ?",
            'gerUserOrg'   => "select sId from crm_structrue_contact where uId = ? and isDel = ?",
            'getUserSite'  => "select siteId from crm_user_site where uId = ? and isDel = ?",
            'getUserMenu'  => "select comCode from crm_user_contact where uId = ? and type = ? and isDel = ?",
            'getChild'     => "select comCode,comeName,parent,level from crm_competence where parent = '?' and isDel = ?",
            'getUserInfo'  => "select uId,userName,jobId,status,createTime from crm_user where uId in (?)",
            'getUserFirst' => "select uId,userName,password from crm_user where userName='?' and isDel=0 limit 1",
            'getAllUserInfo'=>"select uId,userName from crm_user",
            'getOnUserInfo'=>"select uId,userName from crm_user where isDel=0",
            'getAllUserJobIdSiteId'=>"select siteId,uId from crm_user_site where isDel=0",
            'getStructrueContactSid'=>"select a.sId,a.uId,b.siteId from crm_structrue_contact as a,crm_user_site as b where a.sId in (?) and a.uId=b.uId and a.isDel=0 ",
            'getuIdInfo'=>"select uId from crm_user_site where siteId='?' and isDel=0 ",
            'getsIdInfo'=>"select uId from crm_structrue_contact where sId='?' and isDel=0",
            'getSendInfo'=>"select userName from crm_user where isDel=0 and userName like '?%'",
            'userExport'=>"select uId,userName from crm_user where isDel = 0 ? order by uId asc",
            'getUsersiteId'=>"select siteId from crm_user_site where uId='?' and isDel=0 limit 1",
            'getUserMobile'=>"select phone,photo from crm_personnel_expand where uId='?' limit 1",
            'getUserPanel'  => "select uId,userName from crm_user where uId = '?' and isDel=0",
            'getUserId'=>"select uId from crm_user where userName='?' order by lastTime DESC limit 1",
    );

    public function checkRegName($userName,$isDel) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['checkRegName'],array($userName,$isDel)));
        return $getResult->num_rows();
    }

    public function checkEditName($userName,$editid,$isDel) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['checkEditName'],array($userName,$editid,$isDel)));
        return $getResult->num_rows();
    }

    public function getUserList($limitS='',$limitE='',$where) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['getUserList'],array($where,$limitS,$limitE)));
        return $getResult->result_array();
    }

    public function getUserFirst($userName) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['getUserFirst'],array($userName)));
        return $getResult->result_array();
    }

    public function getSiteList($isDel) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['getSiteList'],array($isDel)));
        return $getResult->result_array();
    }

    public function getRoleList($isDel) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['getRoleList'],array($isDel)));
        return $getResult->result_array();
    }

    public function getUserDetail($uId,$isDel) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['getUserDetail'],array($uId,$isDel)));
        $data = $getResult->row_array();
        return $data;
    }

    public function getUserOrg($uId,$isDel) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['gerUserOrg'],array($uId,$isDel)));
        $data = $getResult->result_array();
        return $data;
    }

    public function getUserSite($uId,$isDel) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['getUserSite'],array($uId,$isDel)));
        $data = $getResult->result_array();
        return $data;
    }

    public function getUserMenu($uId,$type,$isDel) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['getUserMenu'],array($uId,$type,$isDel)));
        $data = $getResult->result_array();
        return $data;
    }

    public function getUserInfo($uId) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['getUserInfo'],array($uId)));
        return $getResult->result_array();
    }

    public function getChildList(&$arrayList,$parent,$isDel) {
    	if(empty($parent)){
    		$getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['getChild'],array($parent,0)));
    	}else{
            $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['getChild'],array($parent,$isDel)));
    	}
        $orgList   = $getResult->result_array();
        for($i=0;$i<count($orgList);$i++) {
            $arrayList[] = $orgList[$i];
            $this->getChildList($arrayList,$orgList[$i]['comCode'],$isDel);
        }
        return $arrayList;
    }

    public function checkLogin($username,$password) {
        $datas = array();
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['checkLogin'],array($username,$password,0)));
        $recordnum		= $getResult->num_rows();
        if($recordnum == 1) {
            $getRow	    = $getResult->row();
            $datas		= array('signal' => 'success','row' => $getRow);
        }else {
            $datas		= array('signal' => 'error');
        }
        return $datas;
    }


    public function getAllUserInfo(){
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['getAllUserInfo'],array()));
        return $getResult->result_array();
    }

    public function getOnUserInfo(){
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['getOnUserInfo'],array()));
        return $getResult->result_array();
    }

    public function getAllUserJobIdSiteId(){
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['getAllUserJobIdSiteId'],array()));
        return $getResult->result_array();
    }

    public function getCompetence($parent,$isDel){
    	$getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['getChild'],array($parent,$isDel)));
    	return $getResult->result_array();
    }

    public function getStructrueContactSid($sId){
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['getStructrueContactSid'],array($sId)));
    	return $getResult->result_array();
    }

    public function getuIdInfo($siteId){
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['getuIdInfo'],array($siteId)));
    	return $getResult->result_array();
    }

    public function getsIdInfo($sId){
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['getsIdInfo'],array($sId)));
    	return $getResult->result_array();
    }

    public function getSendInfo($userName){
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['getSendInfo'],array($userName)));
    	return $getResult->result_array();
    }
    public function userExport($where){
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['userExport'],array($where)));
        return $query->result_array();
    }

    //获取用户所在的部门
    public function getUserQuarter($uId,$isDel){
    	$row = array();
        if(empty($isDel))  $isDel = 0;
        
        $department = $this->PublicModel->selectSave('sId','crm_structrue_contact',array('uId'=>$uId,'isDel'=>$isDel),1);
        if(!empty($department)){
           $structName = $this->PublicModel->selectSave('name','crm_structrue',array('sId'=>$department['sId']),1);
        }
        $row['sId']   = $department['sId'];
        $row['name']  = $structName['name'];
        return $row;
    }

    public function getUsersiteId($uId){
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['getUsersiteId'],array($uId)));
        return $query->row_array();
    }

    public function getUserMobile($uId){
	    $query = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['getUserMobile'],array($uId)));
	    $mobileList= $query->row_array();
    	return $mobileList;
    }

    public function getUserPanel($uId){
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->userSql['getUserPanel'],array($uId)));
        return $query->row_array();
    }

    /*获取用户的个人照片 */
    public function getUserPhoto($uId){
	    $expand = $this->getUserMobile($uId);
       if(!empty($expand['photo'])){
            $fileInfo = $this->PublicModel->getFile($expand['photo']);
            if(strstr($fileInfo['filePath'],'application')) {
                $filePath = explode('application',$fileInfo['filePath']);
                $photoImg = base_url().'application'.$filePath[1].$fileInfo['fileName'];
            }else {
                $photoImg = $fileInfo['filePath'].$fileInfo['fileName'];
            }
        }else{
        	$photoImg = base_url().'img/nopic.gif';
        }
        return $photoImg;
    }




}

?>
