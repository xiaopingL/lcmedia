<?php
class ForumModel extends CI_Model {

    public $forumSql = array(
            'forumClassList'=>"select * from crm_forum_area where flag != 1 ? order by id asc limit ?,?",
            'forumSubjList'=>"select * from crm_forum_area where flag != 1 and pid !=0 ? order by id asc limit ?,?",
            'claDet'=>"select * from crm_forum_area where id = '?'",
            'subClass'=>"select * from crm_forum_area where pid != 0 and flag!=1",
    );

    public  function forumClassList($limitS='',$limitE='',$where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->forumSql['forumClassList'],array($where,$limitS,$limitE)));
        return $query->result_array();
    }

    public  function forumSubjList($limitS='',$limitE='',$where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->forumSql['forumSubjList'],array($where,$limitS,$limitE)));
        return $query->result_array();
    }
    public  function claDet($id) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->forumSql['claDet'],array($id)));
        return $getResult->row_array();
    }
    public  function subClass() {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->forumSql['subClass'],array()));
        return $query->result_array();
    }

}
?>