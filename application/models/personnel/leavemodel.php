<?php
class LeaveModel extends CI_Model {

    public $leaveSql = array(
            'leaveList'=>"select a.*,b.uId,b.userName,c.origName, c.filePath from crm_personnel_leave as a left join crm_file as c on a.annex = c.fid left join crm_user as b on a.operator = b.uId where a.isDel = 0 ? order by a.leaveId desc limit ?,?",
            'getLeaveList'=>"select createTime from crm_personnel_leave where state != 2 and isDel = 0 ?",
            'getTimeNews'=>"select hId,setDate,setStatus from crm_personnel_holiday where isDel = 0 and setDate = ? and setStatus = ? ",
            'leaveEdit'=>"select a.leaveId,a.type,a.pLeavetype,a.cause,a.annex,a.startDate,a.endDate,a.allDay,a.operator,a.createTime,b.origName,b.filePath,b.fileName from crm_personnel_leave as a left join crm_file as b on a.annex = b.fid where a.isDel = 0 and a.leaveId = ?",
            'getTypeNews'=>"select leaveId,type,pLeavetype,startDate,endDate,allDay ,createTime from crm_personnel_leave where state != 2 and isDel = 0 ? ?",
        );

    public  function leaveList($limitS='',$limitE='',$where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->leaveSql['leaveList'],array($where,$limitS,$limitE)));
        return $query->result_array();
    }

    public  function leaveEdit($leaveId) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->leaveSql['leaveEdit'],array($leaveId)));
        return $query->row_array();
    }

    public function getLeaveList($where){
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->leaveSql['getLeaveList'],array($where)));
        return $query->result_array();
    }

    public function getTimeNews($val,$status){
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->leaveSql['getTimeNews'],array($val,$status)));
        if($status == 1){
            return $query->row_array();
        }else{
            return $query->result_array();
        }
    }

    public function getTypeNews($whereStype,$where){
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->leaveSql['getTypeNews'],array($whereStype,$where)));
        return $query->result_array();
    }
    
}
?>