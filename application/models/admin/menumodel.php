<?php
/**
 * Description of MenuModel
 * 菜单管理模型
 * @author xiaoping
 */

class MenuModel extends CI_Model {

    public $menuSql = array(
            'checkMenu'   => "select comCode,level from crm_competence where comCode = '?' and isDel <> 1",
            'getMenuList' => "select a.*,b.comeName as parentName from crm_competence as a
	    		          left join crm_competence as b on a.parent = b.comCode where ? limit ?,?",
            'MenuDetail'  => "select comCode,comeName,description,codeUrl,parent,level,weight,createTime,isDel from crm_competence where comCode = '?'",
            'childMenu'   => "select comCode,comeName,level from crm_competence where level = ? and isDel = ? order by weight",
    );

    public function checkMenu($comCode) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->menuSql['checkMenu'],array($comCode)));
        return $getResult->num_rows();
    }

    public function getMenuList($limitS='',$limitE='',$whereStr) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->menuSql['getMenuList'],array($whereStr,$limitS,$limitE)));
        return $getResult->result_array();
    }

    public function getMenuDetail($comCode) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->menuSql['MenuDetail'],array($comCode)));
        return $getResult->row_array();
    }

    public function getChildMenu($level,$isDel) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->menuSql['childMenu'],array($level,$isDel)));
        return $getResult->result_array();
    }

    public function getLevel($comCode,$isDel) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->menuSql['checkMenu'],array($comCode,$isDel)));
        $data = $getResult->row_array();
        return $data['level'];
    }

}

?>
