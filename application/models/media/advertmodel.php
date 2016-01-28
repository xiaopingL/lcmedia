<?php

class AdvertModel extends CI_Model {

    public $publicSql = array(
         'showList'=>"select a.*,b.userName,c.title,d.name from crm_ad_show as a
                          left join crm_user as b on a.operator=b.uId
                          left join crm_contract as c on a.contractId=c.contractId
                          left join crm_client as d on c.cId=d.cId where a.isDel=0 ? order by a.createTime desc limit ?,?",
         'getShowInfo'=>"select a.*,b.userName,c.title,c.cId,d.name from crm_ad_show as a
                          left join crm_user as b on a.operator=b.uId
                          left join crm_contract as c on a.contractId=c.contractId
                          left join crm_client as d on c.cId=d.cId where a.sId=?",
         'positionList'=>"select a.*,b.userName,c.title,d.name from crm_ad_position as a
                          left join crm_user as b on a.operator=b.uId
                          left join crm_contract as c on a.contractId=c.contractId
                          left join crm_client as d on c.cId=d.cId where a.isDel=0 ? order by a.createTime desc limit ?,?",
         'getPositionInfo'=>"select a.*,b.userName,c.title,c.cId,d.name from crm_ad_position as a
                          left join crm_user as b on a.operator=b.uId
                          left join crm_contract as c on a.contractId=c.contractId
                          left join crm_client as d on c.cId=d.cId where a.sId=?",
         'bookList'=>"select a.*,b.userName,c.name,d.name as studioName from crm_ad_book as a
                          left join crm_user as b on a.operator=b.uId
                          left join crm_client as c on a.cId=c.cId
                          left join crm_studio as d on a.studioId=d.sId where a.isDel=0 ? order by a.createTime desc limit ?,?",
         'getBookInfo'=>"select a.*,b.userName,c.name,d.name as studioName from crm_ad_book as a
                          left join crm_user as b on a.operator=b.uId
                          left join crm_client as c on a.cId=c.cId
                          left join crm_studio as d on a.studioId=d.sId where a.sId=?",
         'filmList'=>"select a.*,b.userName,c.name from crm_ad_film as a
                          left join crm_user as b on a.operator=b.uId
                          left join crm_client as c on a.cId=c.cId where a.isDel=0 ? order by a.createTime desc limit ?,?",
         'getFilmInfo'=>"select a.*,b.userName,c.name from crm_ad_film as a
                          left join crm_user as b on a.operator=b.uId
                          left join crm_client as c on a.cId=c.cId where a.sId=?",
         'linedList'=>"select a.*,b.userName,c.name from crm_ad_lined as a
                          left join crm_user as b on a.operator=b.uId
                          left join crm_studio as c on a.studioId=c.sId where a.isDel=0 ? order by a.createTime desc limit ?,?",
         'getLinedInfo'=>"select a.*,b.userName,c.name from crm_ad_lined as a
                          left join crm_user as b on a.operator=b.uId
                          left join crm_studio as c on a.studioId=c.sId where a.sId=?",
         'getMonitorList'=> "select a.*,b.userName from crm_ad_monitor as a left join crm_user as b on a.operator=b.uId where a.isDel = 0 ? order by a.createTime DESC limit ?,?",
         'countList'=>"select a.*,b.userName,c.name from crm_ad_count as a
                          left join crm_user as b on a.operator=b.uId
                          left join crm_studio as c on a.studioId=c.sId where a.isDel=0 ? order by a.createTime desc limit ?,?",
         'getCountInfo'=>"select a.*,b.userName,c.name from crm_ad_count as a
                          left join crm_user as b on a.operator=b.uId
                          left join crm_studio as c on a.studioId=c.sId where a.sId=?",
    );

    public function showList($limitS='',$limitE='',$whereStr) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['showList'],array($whereStr,$limitS,$limitE)));
        return $query->result_array();
    }

    public function getShowInfo($detailId) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['getShowInfo'],array($detailId)));
        return $query->row_array();
    }
    
    public function positionList($limitS='',$limitE='',$whereStr) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['positionList'],array($whereStr,$limitS,$limitE)));
        return $query->result_array();
    }
    
    public function getPositionInfo($detailId) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['getPositionInfo'],array($detailId)));
        return $query->row_array();
    }
    
    public function bookList($limitS='',$limitE='',$whereStr) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['bookList'],array($whereStr,$limitS,$limitE)));
        return $query->result_array();
    }
    
    public function getBookInfo($detailId) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['getBookInfo'],array($detailId)));
        return $query->row_array();
    }
    
    public function filmList($limitS='',$limitE='',$whereStr) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['filmList'],array($whereStr,$limitS,$limitE)));
        return $query->result_array();
    }
    
    public function getFilmInfo($detailId) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['getFilmInfo'],array($detailId)));
        return $query->row_array();
    }
    
    public function linedList($limitS='',$limitE='',$whereStr) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['linedList'],array($whereStr,$limitS,$limitE)));
        return $query->result_array();
    }
    
    public function getLinedInfo($detailId) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['getLinedInfo'],array($detailId)));
        return $query->row_array();
    }
    
    public function getMonitorList($limitS='',$limitE='',$whereStr) {
    	$query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['getMonitorList'],array($whereStr,$limitS,$limitE)));
    	return $query->result_array();
    }
    
    public function countList($limitS='',$limitE='',$whereStr) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['countList'],array($whereStr,$limitS,$limitE)));
        return $query->result_array();
    }

}
?>
