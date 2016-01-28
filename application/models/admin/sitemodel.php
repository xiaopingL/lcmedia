<?php
/**
 * Description of SiteModel
 * 站点管理模型
 * @author xiaoping
 */

class SiteModel extends CI_Model {

    public $siteSql = array(
            'checkSite'     => "select siteId from crm_site where name = '?' and isDel = ?",
            'checkEditSite' => "select siteId from crm_site where name = '?' and siteId <> ? and isDel = ?",
            'getSiteList'   => "select siteId,name,createTime from crm_site where isDel = 0 ? order by createTime DESC limit ?,?",
            'SiteDetail'    => "select siteId,name,createTime from crm_site where siteId = '?' and isDel = ?",
            'getSiteIdList' => "select siteId,name from crm_site where siteId in (?) ",
    );

    public function checkSite($name,$isDel) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->siteSql['checkSite'],array($name,$isDel)));
        return $getResult->num_rows();
    }

    public function checkEditSite($name,$editid,$isDel) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->siteSql['checkEditSite'],array($name,$editid,$isDel)));
        return $getResult->num_rows();
    }

    public function getSiteList($limitS='',$limitE='',$where) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->siteSql['getSiteList'],array($where,$limitS,$limitE)));
        return $getResult->result_array();
    }

    public function getSiteDetail($editid,$isDel) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->siteSql['SiteDetail'],array($editid,$isDel)));
        return $getResult->row_array();
    }

    public function getSiteIdList($siteId) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->siteSql['getSiteIdList'],array($siteId)));
        return $getResult->result_array();
    }

}

?>
