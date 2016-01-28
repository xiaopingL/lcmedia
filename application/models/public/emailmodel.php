<?php
/**
 * Description of ProcessModel
 * 个人面板模型
 * @author xiaoping
 */

class EmailModel extends CI_Model{

	public $emailSql = array(
                'emailList'=>"select a.id,a.from_uid,a.post_date,a.title,a.include,a.content,a.status from crm_public_email as a where a.del_r = 0 ? order by a.post_date desc limit ?,?",
                'fileWord'=>"select origName,fileExt,fileSize from crm_file where fid = '?'",
                'getUser'=>"select uId from crm_user where userName like '%?%'",
                'getEmailType'=>"select id,del_r,del_s from crm_public_email where id = '?'",
                'emailSent'=>"select a.id,a.from_uid,a.post_date,a.title,a.include,a.content,a.status,b.origName,b.fileExt,b.fileSize from crm_public_email as a left join crm_file as b on a.include = b.fid where a.del_s = 0 ? group by a.post_date,a.title order by a.post_date desc limit ?,?",
                'getEmailNews'=>"select to_uid as uId,title,post_date,status as state from crm_public_email where title = '?' and post_date = '?' and to_uid <>'' and from_uid ='?'",
                'getEmailInfo'=>"select id,title,post_date from crm_public_email where id = '?'",
                'getEmail'=>"select id,del_r,del_s,status as state from crm_public_email where title = '?' and post_date = '?' and from_uid ='?'",
                'emailDel'=>"select a.id,a.from_uid,a.to_uid,a.status,a.title,a.content,a.include,a.del_r,a.del_s,a.post_date,b.fid,b.filePath,b.origName,b.fileExt,b.fileSize from crm_public_email as a left join crm_file as b on a.include = b.fid where a.del_r = 2 ? order by a.post_date desc limit ?,?",
                'emailRead'=>"select a.id,a.from_uid,a.to_uid,a.status,a.title,a.content,a.include,a.del_r,a.del_s,a.post_date,b.fid,b.origName,b.fileExt,b.fileSize from crm_public_email as a left join crm_file as b on a.include = b.fid where a.del_r = 0 and a.status = 0 ? order by a.post_date desc limit ?,?",
                'recipientCount'=>"select id,to_uid,from_uid from crm_public_email where del_r = 0 and to_uid = '?' order by post_date desc",
                'sentCount'=>"select id,to_uid,from_uid from crm_public_email where del_s = 0 and from_uid = '?' group by post_date,title order by post_date desc",
                'delCount'=>"select id,from_uid,to_uid from crm_public_email where del_r = 2 and to_uid = '?' order by status asc,post_date desc",
                'nreadCount'=>"select id,from_uid,to_uid,status from crm_public_email where del_r = 0 and status = 0 and to_uid = '?' order by status asc,post_date desc",
                'emailDetail'=>"select a.* from crm_public_email as a  where a.id = '?'",
                'getProNews'=>"select id,from_uid,status,title from crm_public_email where id > '?' and to_uid = '?' order by id asc limit 0,1",
                'getNextNews'=>"select id,from_uid,status,title from crm_public_email where id < '?' and to_uid = '?' order by id desc limit 0,1",
                'groupList'=>"select group_id,grouptitle,groupcontent from crm_public_group where isDel = 0 ? order by group_id desc limit ?,?",
                'groupEditNews'=>"select group_id,grouptitle,groupcontent from crm_public_group where isDel = 0 and group_id = '?'",
                'getGroupArray'=>"select group_id,grouptitle,groupcontent from crm_public_group where isDel = 0 and operator = '?'",
                'getGroupInfo'=>"select group_id,grouptitle,groupcontent from crm_public_group where isDel = 0 and group_id = '?'",
                'emailPhoneNews'=>"select phone from crm_personnel_expand where uId in(?)",
                'emailNreadNews'=>"select id,from_uid,to_uid,status,title,post_date from crm_public_email where del_r = 0 and status = 0 and to_uid = '?' order by post_date desc limit 0,6",
                'getEmailUser'=>"select userName from crm_user where isDel = 0 and userName = '?'",
       );

    public function emailList($limitS='',$limitE='',$where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->emailSql['emailList'],array($where,$limitS,$limitE)));
        return $query->result_array();
    }

    public function fileWord($fid) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->emailSql['fileWord'],array($fid)));
        return $query->row_array();
    }

    public  function getUser($userName) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->emailSql['getUser'],array($userName)));
        return $query->result_array();
    }
    public  function getEmailType($id) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->emailSql['getEmailType'],array($id)));
        return $query->row_array();
    }

    public function emailSent($limitS='',$limitE='',$where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->emailSql['emailSent'],array($where,$limitS,$limitE)));
        return $query->result_array();
    }

    public  function getEmailNews($title,$post_date,$from_uid) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->emailSql['getEmailNews'],array($title,$post_date,$from_uid)));
        return $query->result_array();
    }
    public  function getEmail($title,$post_date,$from_uid) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->emailSql['getEmail'],array($title,$post_date,$from_uid)));
        return $query->result_array();
    }

    public  function getEmailInfo($id) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->emailSql['getEmailInfo'],array($id)));
        return $query->row_array();
    }

    public  function emailDel($limitS='',$limitE='',$where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->emailSql['emailDel'],array($where,$limitS,$limitE)));
        return $query->result_array();
    }

    public  function emailRead($limitS='',$limitE='',$where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->emailSql['emailRead'],array($where,$limitS,$limitE)));
        return $query->result_array();
    }

    public  function recipientCount($to_uid) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->emailSql['recipientCount'],array($to_uid)));
        return $query->num_rows();
    }
    public  function sentCount($from_uid) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->emailSql['sentCount'],array($from_uid)));
        return $query->num_rows();
    }
    public  function delCount($to_uid) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->emailSql['delCount'],array($to_uid)));
        return $query->num_rows();
    }
    public  function nreadCount($to_uid) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->emailSql['nreadCount'],array($to_uid)));
        return $query->num_rows();
    }
    public  function emailDetail($id) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->emailSql['emailDetail'],array($id)));
        $data['arr'] = $query->row_array();
        if(!empty($data['arr']['include'])){
            $getFileWord = $this->EmailModel->fileWord($data['arr']['include']);
            if(!empty($getFileWord)){
                $data['arr']['origName'] = $getFileWord['origName'];
                $data['arr']['fileExt'] = $getFileWord['fileExt'];
                $data['arr']['fileSize'] = $getFileWord['fileSize'];
            }
        }
        return $data['arr'];
    }
   
    public  function getProNews($id,$uId) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->emailSql['getProNews'],array($id,$uId)));
        return $query->row_array();
    }

    public  function getNextNews($id,$uId) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->emailSql['getNextNews'],array($id,$uId)));
        return $query->row_array();
    }
    public  function groupList($limitS='',$limitE='',$where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->emailSql['groupList'],array($where,$limitS,$limitE)));
        return $query->result_array();
    }
    public  function groupEditNews($group_id) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->emailSql['groupEditNews'],array($group_id)));
        return $query->row_array();
    }
    public  function getGroupArray($uId) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->emailSql['getGroupArray'],array($uId)));
        return $query->result_array();
    }
    public  function getGroupInfo($group_id) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->emailSql['getGroupInfo'],array($group_id)));
        return $query->row_array();
    }

    public  function emailPhoneNews($str_uid) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->emailSql['emailPhoneNews'],array($str_uid)));
        return $query->result_array();
    }

    public  function emailNreadNews($uId) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->emailSql['emailNreadNews'],array($uId)));
        return $query->result_array();
    }

    public  function getEmailUser($username) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->emailSql['getEmailUser'],array($username)));
        return $query->row_array();
    }

}

?>
