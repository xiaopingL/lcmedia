<?php
/**
 * Description of ProcessModel
 * 流程管理模型
 * @author xiaoping
 */

class ProcessModel extends CI_Model{

	public $proSql = array(
	    'getProList'   => "select pNumber,processName,processStructrue,createTime from crm_process where isDel = 0 ? order by createTime DESC limit ?,?",
        'getSidList'   => "select name from crm_structrue where sId = ? and isDel = ?",
        'proDetail'    => "select processName,processStructrue,processExtension from crm_process where pNumber = ? and isDel = ?",
        'getPnumber'   => "select pNumber,processName from crm_process where isDel = ?",
	    'getPendList'  => "select pId,proTable,pendingType,urlAdress,pNumber,createTime from crm_pending_contact where isDel = 0 ? order by createTime DESC limit ?,?",
	    'pendDetail'   => "select proTable,pendingType,urlAdress,pNumber from crm_pending_contact where pId = ? and isDel = ?",
	    'getOrgsList'  => "select sId,name from crm_structrue where level = ? and isDel = ?",
	    'getExtension' => "select pNumber,eId,level,uId,sId,createTime from crm_process_extension where isDel = 0 order by pNumber DESC,createTime DESC limit ?,?",
	    'extenDetail'  => "select pNumber,level,uId,sId,limits from crm_process_extension where eId = ? and isDel = ?",
	    'extDetail'    => "select pNumber,level,uId,sId,limits from crm_process_extension where pNumber = ? and isDel = ?",
	);

	public function getProList($limitS='',$limitE='',$where){
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->proSql['getProList'],array($where,$limitS,$limitE)));
        return $getResult->result_array();
	}

	public function getSidList($sId,$isDel){
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->proSql['getSidList'],array($sId,$isDel)));
        $data = $getResult->row_array();
        return $data['name'];
	}

	public function getProDetail($pNumber,$isDel){
       $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->proSql['proDetail'],array($pNumber,$isDel)));
       $data = $getResult->row_array();
       return $data;
	}

	public function getPnumber($isDel){
       $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->proSql['getPnumber'],array($isDel)));
       $data = $getResult->result_array();
       return $data;
	}

	public function getPendList($limitS='',$limitE='',$where){
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->proSql['getPendList'],array($where,$limitS,$limitE)));
        return $getResult->result_array();
	}

	public function converPnumber($pNumber,$isDel){
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->proSql['proDetail'],array($pNumber,$isDel)));
        $data = $getResult->row_array();
        return $data['processName'];
	}

	public function getPendDetail($pId,$isDel){
       $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->proSql['pendDetail'],array($pId,$isDel)));
       $data = $getResult->row_array();
       return $data;
	}

	public function getOrgsList($level,$isDel){
       $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->proSql['getOrgsList'],array($level,$isDel)));
       $data = $getResult->result_array();
       return $data;
	}

	public function getExtensionList($limitS='',$limitE=''){
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->proSql['getExtension'],array($limitS,$limitE)));
        return $getResult->result_array();
	}

	public function getExtensionDetail($eId,$isDel){
       $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->proSql['extenDetail'],array($eId,$isDel)));
       $data = $getResult->row_array();
       return $data;
	}

	public function getExtDetail($pNumber,$isDel){
       $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->proSql['extDetail'],array($pNumber,$isDel)));
       $data = $getResult->result_array();
       return $data;
	}

}

?>
