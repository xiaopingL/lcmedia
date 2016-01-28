<?php

class JournaModel extends CI_Model{

	public $journaSql = array(
              'getJournaList'=> "select a.*,b.userName from crm_public_journal as a left join crm_user as b on a.operator=b.uId where a.isDel = 0 ? order by a.startDate DESC limit ?,?",
		      'checkLog'=> "select pId from  crm_public_journal where operator = ? and startDate = '?' and isDel = 0",
              'journalEditNews'=>"select pId,journalTitle,startDate,operator,journalExperience,journalSugges,score,journalRemarks,uId,evaTime,createTime from crm_public_journal where isDel = 0 and pId = ?",
              'journalInfo' =>"select logId,pId,type,logDescription,timeConsuming,completion,noComplete,improvementMeasures,deadline from crm_public_logdetail where isDel = 0 and pId = ? and type = ? order by logId asc",
	          'getDailyList'=> "select a.*,b.userName from crm_daily as a left join crm_user as b on a.operator=b.uId where a.isDel = 0 ? order by a.startDate DESC limit ?,?",
	          'checkDaily'=> "select pId from crm_daily where operator = ? and startDate = '?' and isDel = 0",
	          'dailyEditNews'=>"select * from crm_daily where isDel = 0 and pId = ?",
	          'dailyInfo' =>"select * from crm_daily_detail where isDel = 0 and pId = ? and type = ? order by logId asc",
	          'getVisitList'=>"select a.*,b.name,c.userName as username from crm_daily_detail as a
	                            left join crm_client as b on a.clientName=b.cId
	                            left join crm_user as c on a.operator=c.uId where a.isDel=0 and a.type=1 ? order by a.createTime DESC limit ?,?",
	          'getReportList'=> "select a.*,b.userName from crm_report as a left join crm_user as b on a.operator=b.uId where a.isDel = 0 ? order by a.createTime DESC limit ?,?",
       );
        public function getJournaList($limitS='',$limitE='',$whereStr) {
            $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->journaSql['getJournaList'],array($whereStr,$limitS,$limitE)));
            return $getResult->result_array();
        }
        
        public function checkLog($uId,$date) {
            $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->journaSql['checkLog'],array($uId,$date)));
            return $getResult->num_rows();
        }
        
        public function journalEditNews($pId) {
            $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->journaSql['journalEditNews'],array($pId)));
            return $getResult->row_array();
        }
        
        public function journalInfo($pId,$type) {
            $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->journaSql['journalInfo'],array($pId,$type)));
            return $getResult->result_array();
        }
        
        public function getDailyList($limitS='',$limitE='',$whereStr) {
            $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->journaSql['getDailyList'],array($whereStr,$limitS,$limitE)));
            return $getResult->result_array();
        }
        
        public function checkDaily($uId,$date) {
            $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->journaSql['checkDaily'],array($uId,$date)));
            return $getResult->num_rows();
        }
        
        public function dailyEditNews($pId) {
            $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->journaSql['dailyEditNews'],array($pId)));
            return $getResult->row_array();
        }
        
        public function dailyInfo($pId,$type) {
            $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->journaSql['dailyInfo'],array($pId,$type)));
            return $getResult->result_array();
        }
        
        public function getVisitList($limitS='',$limitE='',$whereStr) {
            $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->journaSql['getVisitList'],array($whereStr,$limitS,$limitE)));
            return $getResult->result_array();
        }
        
        public function getReportList($limitS='',$limitE='',$whereStr) {
            $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->journaSql['getReportList'],array($whereStr,$limitS,$limitE)));
            return $getResult->result_array();
        }

}

?>
