<?php

class CustomerModel extends CI_Model {

    public $publicSql = array(
         'customerList'=>"select a.salesmanId,b.*,c.userName from crm_client_relation as a
                          left join crm_client as b on a.cId=b.cId
                          left join crm_user as c on a.salesmanId=c.uId where ? and a.isDel=0 and a.state=1 and b.isDel=0 and b.isStop=0 order by b.createTime desc limit ?,?",
         'customerListResult'=>"select * from crm_client where ? and isDel=0 and isStop=0 order by createTime desc",
         'getAllClientInfo'=>"select cId,name from crm_client where isDel=0 and isStop=0",
         'getRelationInfo'=>"select * from crm_client_relation where cId=? and state=1 and createTime<? order by createTime desc",
         'getMyClientInfo'=>"select a.relationId,a.cId,a.startDate,b.name from crm_client_relation as a left join crm_client as b on a.cId=b.cId where a.salesmanId=? and a.endDate>'?' and a.state=1 and a.isDel=0 and b.isDel=0",
         'getClientNews'=>"select telName,telNumber,telPosition from crm_customer_contact where isDel = 0 ?",
         'getClientInfo'=>"select cId,name from crm_client where cId in (?) and isDel=0",
    );

    public function customerList($limitS='',$limitE='',$whereStr) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['customerList'],array($whereStr,$limitS,$limitE)));
        return $query->result_array();
    }

    public function customerListResult($where) {
        if(!empty($where)) {
            $whereStr = implode(" and ",$where);
        }
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['customerListResult'],array($whereStr)));
        return $query->result_array();
    }
    
    public function getAllClientInfo(){
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['getAllClientInfo'],array()));
        return $query->result_array();
    }
    
    public function getRelationInfo($cId,$createTime){
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['getRelationInfo'],array($cId,$createTime)));
        return $query->row_array();
    }
    
    //我维护的客户
    public function getMyClientInfo(){
    	$uId = $this->session->userdata('uId');
    	$endDate = time();
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['getMyClientInfo'],array($uId,$endDate)));
        return $query->result_array();
    }
    
    public function getClientNews($where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['getClientNews'],array($where)));
        return $query->row_array();
    }
    
    public function getClientInfo($cId) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['getClientInfo'],array($cId)));
        return $query->result_array();
    }

}
?>
