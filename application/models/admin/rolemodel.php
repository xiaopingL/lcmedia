<?php
/**
 * Description of RoleModel
 * 角色管理模型
 * @author xiaoping
 */

class RoleModel extends CI_Model{

	public $roleSql = array(
	    'checkRole'     => "select roreId from crm_user_role where roleName = '?' and isDel = ?",
	    'checkEditRole' => "select roreId from crm_user_role where roleName = '?' and roreId <> ? and isDel = ?",
	    'getRoleList'   => "select roreId,roleName,description,createTime from crm_user_role where isDel = 0 ? order by createTime DESC limit ?,?",
	    'roleDetail'    => "select roreId,roleName,description,createTime from crm_user_role where roreId = '?' and isDel = ?",
	    'getUserRole'   => "select comCode from crm_user_contact where uId = ? and type = ? and isDel = ?",
	    'getChild'      => "select comCode,comeName,parent,level from crm_competence where parent = '?' and isDel = ?",
	    'getAllRole'    => "select roreId,roleName from crm_user_role where isDel = ?",
	);

	public function checkRole($roleName,$isDel){
       $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->roleSql['checkRole'],array($roleName,$isDel)));
       return $getResult->num_rows();
	}

	public function checkEditRole($roleName,$editid,$isDel){
       $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->roleSql['checkEditRole'],array($roleName,$editid,$isDel)));
       return $getResult->num_rows();
	}

	public function getRoleList($limitS='',$limitE='',$where){
       $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->roleSql['getRoleList'],array($where,$limitS,$limitE)));
       return $getResult->result_array();
	}

	public function getRoleDetail($editid,$isDel){
       $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->roleSql['roleDetail'],array($editid,$isDel)));
       return $getResult->row_array();
	}

	public function getUserRole($editid,$type,$isDel){
       $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->roleSql['getUserRole'],array($editid,$type,$isDel)));
       return $getResult->result_array();
	}

	public function getAllRole($isDel){
       $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->roleSql['getAllRole'],array($isDel)));
       return $getResult->result_array();
	}

	public function getChildList(&$arrayList,$parent,$isDel){
		$getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->roleSql['getChild'],array($parent,$isDel)));
		$orgList   = $getResult->result_array();
		//print_r($departmentList);
		for($i=0;$i<count($orgList);$i++)
		{
			$arrayList[] = $orgList[$i];
			$this->getChildList($arrayList,$orgList[$i]['comCode'],0);
		}
		return $arrayList;
	}

}

?>
