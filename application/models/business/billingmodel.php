<?php

class BillingModel extends CI_Model{

    public $publicSql = array(
         'billingList'=>"select a.*,b.userName,c.title,c.contractNumber,d.name from crm_billing as a
                          left join crm_user as b on a.operator=b.uId
                          left join crm_contract as c on a.contractId=c.contractId
                          left join crm_client as d on c.cId=d.cId where a.isDel=0 ? order by a.createTime desc limit ?,?",
         'getBillingInfo'=>"select a.*,b.title,b.contractNumber,b.money as contractMoney,c.name from crm_billing as a
                          left join crm_contract as b on a.contractId=b.contractId
                          left join crm_client as c on b.cId=c.cId where a.billingId=?",
         'getNumber'=>"select number from crm_billing where isDel=0 and number like '%?%' order by billingId desc",
         'paymentList'=>"select a.*,b.userName,d.title,d.contractNumber,e.name from crm_payment as a
                          left join crm_user as b on a.operator=b.uId
                          left join crm_billing as c on a.billingId=c.billingId
                          left join crm_contract as d on c.contractId=d.contractId
                          left join crm_client as e on d.cId=e.cId where a.isDel=0 ? order by a.createTime desc limit ?,?",
         'getMoneyNum'=>"select sum(a.money) as totalMoney from crm_billing as a
                          left join crm_user as b on a.operator=b.uId
                          left join crm_contract as c on a.contractId=c.contractId
                          left join crm_client as d on c.cId=d.cId where a.isDel=0 ?",
         'getBillingId'=>"select a.billingId from crm_billing as a
                          left join crm_user as b on a.operator=b.uId
                          left join crm_contract as c on a.contractId=c.contractId
                          left join crm_client as d on c.cId=d.cId where a.isDel=0 ?",
         'getRetrieveMoney'=>"select sum(retrieveMoney) as retrieveMoney from crm_payment where billingId in(?) and isDel=0",
         'getPamentMoneyNum'=>"select sum(a.retrieveMoney) as totalMoney from crm_payment as a
                          left join crm_user as b on a.operator=b.uId
                          left join crm_billing as c on a.billingId=c.billingId
                          left join crm_contract as d on c.contractId=d.contractId
                          left join crm_client as e on d.cId=e.cId where a.isDel=0 ?",
    );

    public function billingList($limitS='',$limitE='',$whereStr) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['billingList'],array($whereStr,$limitS,$limitE)));
        return $query->result_array();
    }
    
    public function getBillingInfo($detailId){
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['getBillingInfo'],array($detailId)));
        return $query->row_array();
    }
    
    public function getNumber($htPrefixion){
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['getNumber'],array($htPrefixion)));
        return $query->row_array();
    }
    
    public function paymentList($limitS='',$limitE='',$whereStr) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['paymentList'],array($whereStr,$limitS,$limitE)));
        return $query->result_array();
    }
    
    public function getMoneyNum($whereStr){
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['getMoneyNum'],array($whereStr)));
        $data = $query->row_array();
        
        if(!empty($data['totalMoney'])){
        	$billingQuery = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['getBillingId'],array($whereStr)));
            $billingArr = $billingQuery->result_array();
        	$billingStr = conventArr($billingArr,'billingId');
        	$retrieveQuery = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['getRetrieveMoney'],array(implode(',',$billingStr))));
        	$retrieveResult = $retrieveQuery->row_array();
        	$data['retrieveMoney'] = !empty($retrieveResult['retrieveMoney'])?$retrieveResult['retrieveMoney']:0;
        }
        return $data;
    }
    
    public function getPamentMoneyNum($whereStr){
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['getPamentMoneyNum'],array($whereStr)));
        return $query->row_array();
    }

}
?>
