<?php

class StudioModel extends CI_Model {

    public $publicSql = array(
         'studioList'=>"select a.*,b.userName from crm_studio as a
                          left join crm_user as b on a.operator=b.uId where a.isDel=0 ? order by a.createTime desc limit ?,?",
         'YwlxrDetail'=>"select a.*,b.name from crm_studio_contact as a,crm_studio as b where a.isDel = 0 and a.sId='?' and a.sId=b.sId order by id desc",
         'getClientNews'=>"select telName,telNumber,telPosition from crm_studio_contact where isDel = 0 ?",
         'studioContactList'=>"select a.id,a.telName,a.telNumber,a.telPosition,a.operator,a.createTime,a.updateTime,b.name,b.siteId,c.userName from crm_studio_contact as a,crm_studio as b,crm_user as c where a.isDel=0 and a.sId=b.sId and a.operator=c.uId ? order by a.id desc limit ?,?",
         'customerDetail'=>"select a.*,b.name from crm_studio_contact as a,crm_studio as b where a.id='?' and a.sId=b.sId limit 1",
         'studioListResult'=>"select * from crm_studio where ? and isDel=0 order by createTime desc",
         'getAllStudioInfo'=>"select sId,name from crm_studio where isDel=0",
    );

    public function studioList($limitS='',$limitE='',$whereStr) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['studioList'],array($whereStr,$limitS,$limitE)));
        return $query->result_array();
    }

    public function YwlxrDetail($getId) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['YwlxrDetail'],array($getId)));
        return $query->result_array();
    }
    
    public function getClientNews($where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['getClientNews'],array($where)));
        return $query->row_array();
    }
    
    public function studioContactList($limitS='',$limitE='',$whereStr='') {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['studioContactList'],array($whereStr,$limitS,$limitE)));
        return $query->result_array();
    }
    
    public function customerDetail($id) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['customerDetail'],array($id)));
        return $query->row_array();
    }
    
    public function studioListResult($where) {
        if(!empty($where)) {
            $whereStr = implode(" and ",$where);
        }
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['studioListResult'],array($whereStr)));
        return $query->result_array();
    }
    
    public function getAllStudioInfo(){
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['getAllStudioInfo'],array()));
        return $query->result_array();
    }
    

}
?>
