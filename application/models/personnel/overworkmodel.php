<?php
class OverworkModel extends CI_Model {

    public $overworkSql = array(
            'overworkList'=>"select a.*,b.userName from crm_personnel_overtime as a,crm_user as b where a.isDel = 0 ? and b.isDel = 0 and a.operator = b.uId order by a.oId desc limit ?,?",
            'overworkEdit'=> "select a.oId,a.content as oContent,a.operator,a.addr,a.allHour,a.allDay,a.startDate,a.endDate,a.overContent,a.createTime,a.state from crm_personnel_overtime as a where a.isDel = 0 and a.oId = ?",
            'getOvertimeList'=>"select createTime from crm_personnel_overtime where state != 2 and isDel = 0 ?",
        );

    public  function overworkList($limitS='',$limitE='',$where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->overworkSql['overworkList'],array($where,$limitS,$limitE)));
        return $query->result_array();
    }

    public  function overworkEdit($oId) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->overworkSql['overworkEdit'],array($oId)));
        return $query->row_array();
    }

    public  function getOvertimeList($where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->overworkSql['getOvertimeList'],array($where)));
        return $query->result_array();
    }

}
?>