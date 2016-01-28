<?php
class AnnounceModel extends CI_Model {

    public $modelSql = array(
            'announceList'=>"select a.*,b.fid,b.origName from crm_office_news as a left join crm_file as b on a.annex=b.fid where a.isDel = 0 ? order by id desc limit ?,?",
            'announceOne'=>"select a.*,b.fid,b.origName from crm_office_news as a left join crm_file as b on a.annex=b.fid where isDel = 0 and id = '?'",
            'announceListIndex'=>"select * from crm_office_news  where isDel = 0 and type = '?' order by id desc limit ?,?",
            'getSidArray'=>"select qSid from crm_user where uId = '?'",
            'getNewsListGg'=>"select id,title,createTime from crm_office_news where isDel = 0 and state = 1 and type = 1 order by createTime desc limit 0,4",
            'getVoiceListTz'=>"select id,title,createTime from crm_office_news where isDel = 0 and state = 1 and type = 2 order by createTime desc limit 0,4",
        );

    public  function announceList($limitS='',$limitE='',$where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->modelSql['announceList'],array($where,$limitS,$limitE)));
        return $query->result_array();
    }
	public  function announceListIndex($where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->modelSql['announceListIndex'],array($where,0,4)));
        return $query->result_array();
    }
    public  function announceOne($id) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->modelSql['announceOne'],array($id)));
        return $query->row_array();
    }

    public  function getSidArray($uId) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->modelSql['getSidArray'],array($uId)));
        return $query->row_array();
    }

    public  function getNewsListGg() {
        $query  = $this->db->query($this->PublicModel->exSqlTemplate($this->modelSql['getNewsListGg'],array()));
        $newsGg = $query->result_array();
        return $newsGg;
    }

    public  function getVoiceListTz() {
        $query  = $this->db->query($this->PublicModel->exSqlTemplate($this->modelSql['getVoiceListTz'],array()));
        $newsTz = $query->result_array();
    	return $newsTz;
    }



}
?>