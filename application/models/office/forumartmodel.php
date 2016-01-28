<?php
class ForumArtModel extends CI_Model {

    public $forumArtSql = array(
        'forumArtList'=>"select * from crm_forum_topic where flag != 1 and pid=0 ? order by type desc,lastTime DESC limit ?,?",
        'forumJhList'=>"select * from crm_forum_topic where flag != 1 and type=3 ? order by id DESC",
        'artDet'=>"select * from crm_forum_topic where id = '?'",
        'artComments'=>"select * from crm_forum_topic where pid = '?' and flag=0 order by id desc",
        'classSubCounts'=>"select count(*) as count from crm_forum_topic where aid= ?",
        'getForumList'=>"select * from crm_forum_topic where flag =0 and pid=0 and type!=2 order by lastTime DESC limit ?,?",
        'getJh'=>"select * from crm_forum_topic where flag != 1 and type=2 ? order by lastTime DESC limit ?,?",
        'getAllNews'=>"select a.uId,a.userName,b.bId,b.fId from crm_user as a left join crm_personnel_entry as b on a.uId = b.operator where a.isDel = 0 and b.isDel = 0 order by b.fId DESC,b.bId desc",
        'getForumExport'=>"select title,post_date from crm_forum_topic where flag != 1 and pid = 0 and staff_id = '?' ? order by type desc,id DESC",
        'getForumUpdate'=>"select id,post_date,lastTime from crm_forum_topic where flag = 0 and pid = 0 and lastTime = 0 ",
        'getForumArea'=>"select * from crm_forum_topic where flag=0 and pid=0 and type!=2 and aid='?' order by lastTime DESC limit ?,?",
    );

    public  function forumArtList($limitS='',$limitE='',$where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->forumArtSql['forumArtList'],array($where,$limitS,$limitE)));
        return $query->result_array();
    }

    public  function getForumExport($uId,$where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->forumArtSql['getForumExport'],array($uId,$where)));
        $arr = $query->result_array();
        foreach($arr as $value){
            $result['title'] .= $value['title'].',';
            $result['post_date'] .= date("Y-m-d H:i:s",$value['post_date']).',';
        }
        return $result;
    }

    public  function getAllNews() {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->forumArtSql['getAllNews'],array()));
        return $query->result_array();
    }

    public  function getForumUpdate() {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->forumArtSql['getForumUpdate'],array()));
        return $query->result_array();
    }

    public  function artDet($id) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->forumArtSql['artDet'],array($id)));
        return $getResult->row_array();
    }
    public  function artMod($id) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->forumArtSql['artDet'],array($id)));
        return $getResult->row_array();
    }
    public function classSubCounts($id) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->forumArtSql['classSubCounts'],array($id)));
        return $getResult->row_array();
    }
    public function artComments($id) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->forumArtSql['artComments'],array($id)));
        return $getResult->result_array();
    }
    
    //列表页精华 排列在上头部分的
    public function forumJhList($limitS,$limitE,$where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->forumArtSql['forumJhList'],array($where,$limitS,$limitE)));
        return $query->result_array();
    }

    public function getJh($limitS='0',$limitE='1',$where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->forumArtSql['getJh'],array($where,$limitS,$limitE)));
        return $query->result_array();
    }

    public function getForumList($limitS='',$limitE='') {
        $queryJh = $this->getJh();
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->forumArtSql['getForumList'],array($limitS,$limitE)));
        $queryList = $query->result_array();
        $forumList = array_merge_recursive($queryJh,$queryList);
        return $forumList;
    }

    public function getForumArea($aId,$limitS='',$limitE='') {
        $query  = $this->db->query($this->PublicModel->exSqlTemplate($this->forumArtSql['getForumArea'],array($aId,$limitS,$limitE)));
        $forumArea = $query->result_array();
        return $forumArea;
    }

}
?>