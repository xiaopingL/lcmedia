<?php
/**
 * Description of ProcessModel
 * 个人面板模型
 * @author xiaoping
 */

class PanelModel extends CI_Model {

    public $panelSql = array(
            'getPanelNum'    => "select pendId from crm_pending where toUid = ? and status = 0 and isDel = 0",
            'getPanelList'   => "select c.username,a.pendId,a.tableId,a.createTime,b.pendingType,b.urlAdress,b.proTable from crm_pending as a
	    		             left join crm_pending_contact as b on a.proTable = b.proTable
	    		             left join crm_user as c on a.fromUid = c.uId
	    		             where a.toUid = ? and a.status = ? and a.isDel = ? and b.isDel = ? order by a.createTime DESC,a.proTable DESC limit ?,?",
            'getApplyList'   => "select c.username,c.jobId,a.tableId,a.proTable,a.createTime,b.pendingType,b.urlAdress from crm_pending as a
	    		             left join crm_pending_contact as b on a.proTable = b.proTable
	    		             left join crm_user as c on a.toUid = c.uId
	    		             where a.fromUid = ? and a.status = ? and a.isDel = ? and b.isDel = ? order by a.createTime DESC,a.proTable DESC limit ?,?",
            'getMsgCount'	 => "select pmsId,folder,isRead,subject,msgUrl from crm_pms where isRead = 0 and msgtoUid = ?",
            'getMsgList'	 => "select pmsId,folder,isRead,subject,msgUrl,createTime from crm_pms where isRead = 0 and msgtoUid = ? order by createTime asc limit 1",
            'getAttends'     => "select * from ?",
    );

    public function getPanelNum($toUid) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->panelSql['getPanelNum'],array($toUid)));
        return $getResult->num_rows();
    }

    public function getPanelList($toUid,$limitS='',$limitE='') {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->panelSql['getPanelList'],array($toUid,0,0,0,$limitS,$limitE)));
        return $getResult->result_array();
    }

    public function getApplyList($fromUid,$limitS='',$limitE='') {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->panelSql['getApplyList'],array($fromUid,0,0,0,$limitS,$limitE)));
        return $getResult->result_array();
    }

    public function getMsgCount($uId) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->panelSql['getMsgCount'],array($uId)));
        return $getResult->num_rows();
    }

    public function getMsgList($uId) {
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->panelSql['getMsgList'],array($uId)));
        return $getResult->row_array();
    }

    function getAttends($uId,$table,$num) {
        if($table == 'crm_personnel_leave') {
            $whereStr = "$table as a where a.isDel = 0 and a.state = 1 and a.operator = '$uId' order by a.createTime desc limit 3";
        }elseif($table == 'crm_personnel_falsesign'){
            $whereStr = "$table as a where a.isDel = 0 and a.state = 1 and DATEDIFF(CURDATE(),from_unixtime(a.startDate,'%Y-%m-%d')) = $num and a.operator = '$uId' order by a.createTime desc limit 3";
        }
        $getResult = $this->db->query($this->PublicModel->exSqlTemplate($this->panelSql['getAttends'],array($whereStr)));
        return $getResult->result_array();
    }
    
    public function getBirthday($myUid) {
        $nl = date('m-d');
         $result = $this->PublicModel->selectSave('birthday','crm_personnel_expand',array('uId'=>$myUid),1);
         $birthday = date('m-d',$result['birthday']);
        if($birthday == $nl) {
            return $nl;
        }else {
            return 0;
        }
    }

    public function getNowDate() {
        $this->load->library('lunar');
        $lunar = new Lunar();
        $month = $lunar->convertSolarToLunar(date('Y'),date('m'),date('d'));
        $weekArr = array("日","一","二","三","四","五","六");
        $week = "星期".$weekArr[date("w")];
        return date('Y').'年'.date('m').'月'.date('d').'日'.' '.$week.' '.$month[3].'年 '.$month[1].$month[2];
    }

    public function deviceType() {
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        $type = '';
        if(strpos($agent, 'iphone')) {
            $type = 'ios';
        }
        if(strpos($agent, 'android')) {
            $type = 'android';
        }
        return $type;
    }
    
    //超过30天的客户未拜访 系统提示
    public function getVisitInfo($uId,$num){
    	$dayNum = 24*3600*30;
    	$result = array();
    	$this->load->model('business/CustomerModel','',true);
    	$client = $this->CustomerModel->getMyClientInfo();
    	if(!empty($client)){
    		foreach($client as $value){
    			$daily = $this->PublicModel->selectSave('createTime','crm_daily_detail',array('clientName'=>$value['cId'],'operator'=>$uId,'type'=>1,'isDel'=>0),1);
    			if(!empty($daily)){
    				$startDate = $daily['createTime'];
    			}else{
    				$startDate = $value['startDate'];
    			}
    			
    			if((time()-$startDate)>$dayNum){
    				$result[] = $value['name'];
    			}
    		}
    	}
    	return $result;
    }
    

}

?>
