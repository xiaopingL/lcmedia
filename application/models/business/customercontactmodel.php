<?php
/**
 * Description of CustomerContactModel
 * 客户联系人信息管理模型
 * @author zys
 */
class CustomerContactModel extends CI_Model {
    public $customerContactSql = array(
            'customerContactList'=>"select a.id,a.telName,a.telNumber,a.telPosition,a.operator,a.createTime,a.updateTime,b.name,b.industry,b.siteId,c.cId,d.userName from crm_customer_contact as a,crm_client as b,crm_client_relation as c,crm_user as d where a.isDel=0 and a.cId=b.cId and c.cId = b.cId and a.operator=d.uId ? order by a.id desc limit ?,?",
            'customerDetail'=>"select a.*,b.name from crm_customer_contact as a,crm_client as b where a.id='?' and a.cId=b.cId limit 1",
            'YwlxrDetail'=>"select a.*,b.name from crm_customer_contact as a,crm_client as b where a.isDel = 0 and a.cId='?' and a.cId=b.cId order by id desc",
    );

    public function customerContactList($limitS='',$limitE='',$whereStr='') {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->customerContactSql['customerContactList'],array($whereStr,$limitS,$limitE)));
        return $query->result_array();
    }

    public function customerDetail($id) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->customerContactSql['customerDetail'],array($id)));
        return $query->row_array();
    }

    public function YwlxrDetail($getId) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->customerContactSql['YwlxrDetail'],array($getId)));
        return $query->result_array();
    }


}
?>
