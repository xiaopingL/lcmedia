<?php

class ContractModel extends CI_Model{

    public $publicSql = array(
         'contractList'=>"select a.*,b.userName,c.name,c.industry from crm_contract as a
                          left join crm_user as b on a.operator=b.uId
                          left join crm_client as c on a.cId=c.cId where a.isDel=0 ? order by a.createTime desc limit ?,?",
         'getNumber'=>"select contractNumber from crm_contract where isDel=0 and contractNumber like '%?%' order by contractId desc",
         'getContractInfo'=>"select a.*,b.name from crm_contract as a
                          left join crm_client as b on a.cId=b.cId where a.contractId=?",
         'contractFileArray'=>"select a.*,b.fileName,b.filePath,b.origName from crm_contract_file as a left join crm_file as b on a.fId = b.fId where a.isDel = 0 and a.contractId = '?'",
         'getMoneyNum'=>"select sum(a.money) as totalMoney from crm_contract as a
                          left join crm_user as b on a.operator=b.uId
                          left join crm_client as c on a.cId=c.cId where a.isDel=0 ?",
    );

    public function contractList($limitS='',$limitE='',$whereStr) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['contractList'],array($whereStr,$limitS,$limitE)));
        return $query->result_array();
    }

    public function getNumber($htPrefixion){
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['getNumber'],array($htPrefixion)));
        return $query->row_array();
    }
    
    public function getContractInfo($contractId){
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['getContractInfo'],array($contractId)));
        return $query->row_array();
    }
    
    public function contractFileArray($contractId) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['contractFileArray'],array($contractId)));
        return $query->result_array();
    }
    
    public function getMoneyNum($whereStr){
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['getMoneyNum'],array($whereStr)));
        return $query->row_array();
    }

}
?>
