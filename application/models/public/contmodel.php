<?php
class ContModel extends CI_Model {

    public $contSql = array(
            'contList'=>"select a.*,b.phone,b.sex,b.workqq from crm_user as a
            		     left join crm_personnel_expand as b on a.uId=b.uId where a.isDel = 0 ? limit ?,?",
    );

    public  function contList($limitS='',$limitE='',$where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->contSql['contList'],array($where,$limitS,$limitE)));
        return $query->result_array();
    }


}
?>