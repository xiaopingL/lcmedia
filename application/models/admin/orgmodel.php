<?php
/**
 * Description of OrgModel
 * 组织架构管理模型
 * @author xiaoping
 */

class OrgModel extends CI_Model {

    public $orgSql = array(
            'getLevel'   => "select name,parentId,level,strNumber,phoneNumber,weight from crm_structrue where sId = ? and isDel = ?",
            'getChild'   => "select sId,name,parentId,level,strNumber,phoneNumber from crm_structrue where parentId = ? and isDel = ? order by weight",
            'getOrgList' => "select a.sId,a.name,a.level,a.strNumber,a.phoneNumber,b.name as parentName,a.createTime from crm_structrue as a
	    		        left join crm_structrue as b on a.parentId = b.sId where a.isDel = 0 ? limit ?,?",
            'getAllStructrue' => "select sId,name,strNumber,phoneNumber from crm_structrue where isDel=0",
            'getAllSidStructrue' => "select sId,uId from crm_structrue_contact where isDel=0",
            'getStrtuce'=>"select name,parentId,level,strNumber from crm_structrue where strNumber = '?' ? and isDel = 0",
    );

    public function getLevel($sId,$isDel) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->orgSql['getLevel'],array($sId,$isDel)));
        $data = $getResult->row_array();
        return $data['level'];
    }

    public function getChildList(&$arrayList,$parentId,$isDel) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->orgSql['getChild'],array($parentId,$isDel)));
        $orgList   = $getResult->result_array();
        //print_r($departmentList);
        for($i=0;$i<count($orgList);$i++) {
            $arrayList[] = $orgList[$i];
            $this->getChildList($arrayList,$orgList[$i]['sId'],0);
        }
        return $arrayList;
    }

    public function getOrgList($limitS='',$limitE='',$where) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->orgSql['getOrgList'],array($where,$limitS,$limitE)));
        $data = $getResult->result_array();
        return $data;
    }

    public function getOrgDetail($sId,$isDel) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->orgSql['getLevel'],array($sId,$isDel)));
        $data = $getResult->row_array();
        return $data;
    }

    public function getAllStructrue(){
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->orgSql['getAllStructrue'],array()));
        $data = $getResult->result_array();
        return $data;
    }

    public function getAllSidStructrue(){
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->orgSql['getAllSidStructrue'],array()));
        $data = $getResult->result_array();
        return $data;
    }
    public function getStrtuce($strNumber,$where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->orgSql['getStrtuce'],array($strNumber,$where)));
        return $query->row_array();
    }

}

?>
