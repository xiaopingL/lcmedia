<?php
class FalsesignModel extends CI_Model {

    public $falsesignSql = array(
            'falsesignList'=>"select a.fId,a.cause,a.address,a.startDate,a.type,a.num,a.operator,a.createTime,a.state,b.userName from crm_personnel_falsesign as a,crm_user as b where a.operator = b.uId and a.isDel = 0 ? order by a.fId desc limit ?,?",
            'lookFalseNews'=>"select startDate from crm_personnel_falsesign where state != 2 and isDel = 0 ?",
            'falsesignEdit'=>"select fId,cause,address,startDate,type,operator,num,createTime from crm_personnel_falsesign where isDel = 0 and fId = ?",
        );

    public  function falsesignList($limitS='',$limitE='',$where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->falsesignSql['falsesignList'],array($where,$limitS,$limitE)));
        return $query->result_array();
    }

    public  function falsesignEdit($fId) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->falsesignSql['falsesignEdit'],array($fId)));
        return $query->row_array();
    }

    public  function lookFalseNews($where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->falsesignSql['lookFalseNews'],array($where)));
        return $query->result_array();
    }


}
?>