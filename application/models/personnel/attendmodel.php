<?php
/**
 * Description of AttendModel
 * 考勤板块公用模型
 * @author xiaoping
 */
class AttendModel extends CI_Model {

    public $attendSql = array(
        'getAllUserList'=>"select a.uId,a.userName,a.status,a.createTime from crm_user as a where ? order by a.uId desc limit ?,?",
        'getHolidayList'=>"select a.*,b.userName from crm_personnel_holiday as a
        		            left join crm_user as b on a.operator = b.uId where a.isDel = 0 ? order by a.setDate DESC limit ?,?",
        'checkHoliday'=>"select hId from crm_personnel_holiday where setDate = '?' and isDel = 0",
        'getHolidays'=>"select setDate,setStatus from crm_personnel_holiday where isDel = 0",
        'getCountNumbers'=>"select * from ? where ?",
        'getFalsesignCount'=>"select * from crm_personnel_falsesign where ?",
        'getExpandDetail'=> "select a.*,b.*,c.fileName as fileName2,c.filePath as filePath2,c.origName as origName2,
        		             d.fileName as fileName3,d.filePath as filePath3,d.origName as origName3,e.fileName as fileName4,e.filePath as filePath4,e.origName as origName4 from crm_personnel_expand as a
        		             left join crm_file as b on a.photo=b.fid
        		             left join crm_file as c on a.idCardPhoto=c.fid
        		             left join crm_file as d on a.eduPhoto=d.fid
        		             left join crm_file as e on a.certPhoto=e.fid where a.uId = '?'",
    );

    public function getAllUserList($limitS='',$limitE='',$whereStr){
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->attendSql['getAllUserList'],array($whereStr,$limitS,$limitE)));
        return $getResult->result_array();
    }

    public function getHolidayList($limitS='',$limitE='',$whereStr){
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->attendSql['getHolidayList'],array($whereStr,$limitS,$limitE)));
        return $getResult->result_array();
    }

    public function checkHoliday($setDate){
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->attendSql['checkHoliday'],array($setDate)));
        return $getResult->num_rows();
    }

    /*
     * @param 获取公休日和正常上班的日期
     */
    public function getHolidays(){
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->attendSql['getHolidays'],array()));
        $holidays = $getResult->result_array();
        return $holidays;
    }

    public function getCountNumbers($table,$where=''){
        $uId = $this->session->userdata['uId'];
        $firstday = strtotime(date('Y-m-01 00:00:00'));     //当月第一天
        $lastday  = strtotime(date('Y-m-t 23:59:59'));      //当月最后一天
	    if($table == 'crm_personnel_leave'){
	        $where  = "startDate >= '$firstday' and endDate <= '$lastday' and operator = '$uId' and isDel = 0 and state = 1";
	    }
	    $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->attendSql['getCountNumbers'],array($table,$where)));
        $getCountNumber = $getResult->num_rows();
        return $getCountNumber;
     }

     public function getFalsesignCount($operator){
        if(!empty($operator)){
            $uId = $operator;
        }else{
            $uId = $this->session->userdata['uId'];
        }
        $firstday = strtotime(date('Y-m-01 00:00:00'));     //当月第一天
        $lastday  = strtotime(date('Y-m-t 23:59:59'));      //当月最后一天
	    $where  = "startDate >= '$firstday' and startDate <= '$lastday' and operator = '$uId' and isDel = 0 and state = 1";
	    $query = $this->db->query($this->PublicModel->exSqlTemplate($this->attendSql['getFalsesignCount'],array($where)));
	    $getResult = $query->result_array();
	    foreach($getResult as $value){
	        $getFalsesignNum += $value['num'];
	    }
        return $getFalsesignNum;
     }
     
    public function getExpandDetail($uId) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->attendSql['getExpandDetail'],array($uId)));
        return $getResult->row_array();
    }

	function get_weekend_days($start_date,$end_date){
        if (strtotime($start_date) > strtotime($end_date)) list($start_date, $end_date) = array($end_date, $start_date);
        $start_reduce = $end_add = 0;
        $start_N = date('N',strtotime($start_date));
        $start_reduce = ($start_N == 7) ? 1 : 0;
        $end_N = date('N',strtotime($end_date));
        in_array($end_N,array(6,7)) && $end_add = ($end_N == 7) ? 2 : 1;
        $days = abs(strtotime($end_date) - strtotime($start_date))/86400 + 1;
        return floor(($days + $start_N - 1 - $end_N) / 7) * 2 - $start_reduce + $end_add;
    }


}
?>
