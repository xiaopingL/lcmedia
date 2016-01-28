<?php
class ToolsModel extends CI_Model {

    public $publicSql = array(
            'toolsList'=>"select * from crm_office_tools where isDel = 0 ? order by createTime desc limit ?,?",
            'goodsList'=>"select a.*,b.userName,c.name,c.unit from crm_office_goods as a left join crm_user as b on a.operator=b.uId
                          left join crm_office_tools as c on a.tId=c.tId where a.isDel=0 ? order by a.createTime desc limit ?,?",
            'getGoodsDetail'=>"select a.*,b.userName,c.name,c.unit,c.price from crm_office_goods as a left join crm_user as b on a.operator=b.uId
                          left join crm_office_tools as c on a.tId=c.tId where a.gId=?",
            'callbackList'=>"select a.*,b.userName,c.name,d.name as clientName from crm_office_callback as a left join crm_user as b on a.operator=b.uId
                          left join crm_office_tools as c on a.tId=c.tId
                          left join crm_studio as d on a.cId=d.sId where a.isDel=0 ? order by a.createTime desc limit ?,?",
            'madeList'=>"select a.*,b.userName,c.name,d.name as clientName from crm_office_made as a left join crm_user as b on a.operator=b.uId
                          left join crm_office_tools as c on a.tId=c.tId
                          left join crm_client as d on a.cId=d.cId where a.isDel=0 ? order by a.createTime desc limit ?,?",
            'getMadeDetail'=>"select a.*,b.userName,c.name,d.name as clientName from crm_office_made as a left join crm_user as b on a.operator=b.uId
                          left join crm_office_tools as c on a.tId=c.tId
                          left join crm_client as d on a.cId=d.cId where a.mId=?",
    );

    public  function toolsList($limitS='',$limitE='',$where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['toolsList'],array($where,$limitS,$limitE)));
        return $query->result_array();
    }

    public  function goodsList($limitS='',$limitE='',$where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['goodsList'],array($where,$limitS,$limitE)));
        return $query->result_array();
    }
    
    public  function callbackList($limitS='',$limitE='',$where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['callbackList'],array($where,$limitS,$limitE)));
        return $query->result_array();
    }
    
    public  function madeList($limitS='',$limitE='',$where) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['madeList'],array($where,$limitS,$limitE)));
        return $query->result_array();
    }
    
    public function getGoodsDetail($gId) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['getGoodsDetail'],array($gId)));
        return $query->row_array();
    }
    
    public  function getMadeDetail($mId) {
        $query = $this->db->query($this->PublicModel->exSqlTemplate($this->publicSql['getMadeDetail'],array($mId)));
        return $query->row_array();
    }
    
    public function getToolStock($tId){
    	$actNum = 0;
    	$toolsInfo = $this->PublicModel->selectSave('*','crm_office_tools',array('tId'=>$tId),1);
    	$goodsInfo = $this->PublicModel->selectSave('*','crm_office_goods',array('tId'=>$tId,'state <>'=>2,'isDel'=>0),2);
    	if(!empty($goodsInfo)){
    		foreach($goodsInfo as $value){
    			$num = 0;
    			if($value['state'] == 1){
    				$num = $value['actNum'];
    			}else{
    				$num = $value['num'];
    			}
    			$actNum += $num;
    		}
    	}
    	return $toolsInfo['num']-$actNum;
    }

}
?>