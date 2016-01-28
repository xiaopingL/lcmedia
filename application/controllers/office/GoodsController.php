<?php
/**
 * @desc 领料申请控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-08-18
 */
class GoodsController extends MY_Controller {
	
    protected $table = 'crm_office_goods';
    
    const MENU_LIST  = "office/GoodsController/goodsList";
    
    public function  __construct() {
        parent::__construct();
        $this->load->model('office/ToolsModel','',true);
    }
    
    public function goodsList() {
        $data = $this->View('office');
        $whereStr = '';
        $userName = trim($this->input->get_post('userName',true));
        $goodsName = trim($this->input->get_post('goodsName',true));
        $category = $this->input->get_post('category',true);
        if(!empty($userName)) {
            $where[] = "b.userName like '%".$userName."%'";
            $urlArray[] = 'userName='.$userName;
            $data['userName'] = $userName;
        }
        if(!empty($goodsName)) {
            $where[] = "c.name like '%".$goodsName."%'";
            $urlArray[] = 'name='.$goodsName;
            $data['goodsName'] = $goodsName;
        }
        if(!empty($category)){
            $where[] = "a.category = ".$category;
            $urlArray[] = 'category='.$category;
            $data['category'] = $category;
        }
        
        $sTime = $this->input->get_post('sTime',true);
        $eTime = $this->input->get_post('eTime',true);
        $sTime1 = strtotime($sTime);
        $eTime1 = strtotime($eTime);
        if(!empty($sTime1)) {
            $where[] = ' a.createTime >='.$sTime1;
            $urlArray[] = 'sTime='.$sTime;
            $data['sTime'] = $sTime;
        }
        if(!empty($eTime1)) {
            $where[] = ' a.createTime <='.$eTime1;
            $urlArray[] = 'eTime='.$eTime;
            $data['eTime'] = $eTime;
        }

        if(!empty($urlArray)) {
            $urlStr = '/?'.implode('&', $urlArray);
        }
        if(!empty($where)) {
            $whereStr = ' and '.implode(" and ",$where);
        }
        
        $modelArray['modelPath'] = 'office';
        $modelArray['modelName'] = 'ToolsModel';
        $modelArray['sqlTplName'] = 'publicSql';
        $modelArray['sqlTplFucName'] = 'goodsList';
        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);
        $argument	= array(
                'base_url'      => self::MENU_LIST,
                'per_page'		=> 12,
                'num_links'		=> 3,
                'uri_segment'	=> 4,
                'total_rows'	=> $rows
        );
        $getPaginDatas		= $this->createPagination($argument,$urlStr);
        $data['pagination']	= $getPaginDatas['pagination'];
        $data['rows']       = $rows;
        $data['arr']  = $this->ToolsModel->goodsList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        foreach($data['arr'] as $key=>$val){
            $sidArr   = $this->PublicModel->getContactAllSid($val['operator'],0);
            $data['arr'][$key]['orgName']  = $sidArr[0]['name'];
            $data['arr'][$key]['flow'] = $this->PublicModel->getFlowList($data['arr'][$key]['gId'],$this->table);
        }
        $data['content'] = $this->load->view('office/goodsListView',$data,true);
        $this->load->view('index/index',$data);
    }

    public function goodsAddView() {
        $data = $this->View('office');
        if($this->input->post('submitCreate') != FALSE){
	        $result = array(
	              'type'=> $this->input->post('type'),
	              'tId' => $this->input->post('tId'),
	              'num' => intval(trim($this->input->post('num'))),
	              'note' => $this->input->post('note'),
	              'operator' => $this->session->userdata('uId'),
	              'createTime'=>time(),
	        );
	        
	        if($result['type'] == 1){
	        	$result['category'] = $this->input->post('category');
	        	if(empty($result['category'])){
	        		$this->showMsg(2,'请选择票务类型！'); exit;
	        	}
	        	
	        	if(in_array($result['category'],array(1,2))){
	        		$customerName = trim($this->input->post('name'));
	        		$customerInfo = $this->PublicModel->selectSave('cId','crm_client',array('name'=>$customerName,'isDel'=>0,'isStop'=>0),1);
	                if(empty($customerInfo)){
	                    $this->showMsg(2,'该客户不存在，请核对客户名称或创建新客户！'); exit;
	                }
	                $result['cId'] = $customerInfo['cId'];
	                if($result['category'] == 1){
	                	$result['contractPrice'] = trim($this->input->post('contractPrice'));
	                	$result['contractDate']  = strtotime($this->input->post('contractDate'));
	                }
	        	}
	        	
	        	//生成票务编号
	        	$result['number'] = $this->getTicketNumber($result['tId'],$result['num']);
	        }

	        $stock = $this->ToolsModel->getToolStock($result['tId']);
	        if($result['num'] > $stock){
	        	$this->showMsg(2,'该物料库存量不足！'); exit;
	        }
	       
	        $gId = $this->PublicModel->insertSave($this->table,$result);
            if(!empty($gId)){
            	if(!empty($result['category'])){
	            	if($result['category'] == 1){
	                    $extension = 1;
	                }else{
	                	$extension = 3;
	                }
            	}else{
            		$extension = 2;
            	}
            	$this->PublicModel->controlProcess($this->table,$gId,1,0,1,'','','',$extension);
                $this->showMsg(1,'填写成功',self::MENU_LIST);
	        }else {
	            $this->showMsg(2,'填写失败！');
	        }
        }
        
        $dVal['putName'] = 'name';
        $dVal['idName'] = 'cId';
        $data['public_view_js'] = $this->load->view('index/public_view_js',$dVal,true);
        $data['toolsList'] = $this->PublicModel->selectSave('*','crm_office_tools',array('isDel'=>0),2);
        $data['content'] = $this->load->view('office/goodsAddView',$data,true);
        $this->load->view('index/index',$data);
    }
    
    //生成票务编号
    public function getTicketNumber($tId,$num){
    	$goodsInfo = $this->PublicModel->selectSave('number',$this->table,array('tId'=>$tId,'isDel'=>0,'state <>'=>2),1,'createTime desc');
    	if(empty($goodsInfo)){
    		$ticketNumber = 'LC00000000';
    	}else{
    		$ticketNumber = $goodsInfo['number'];
    	}
    	$getNumber = explode('LC', $ticketNumber);
    	$result = 'LC'.sprintf("%08d",$getNumber[1]+$num);
    	return $result;
    }
    
    //行政主管确认实领数量，重新生成票务编号
    public function actTicketNumber($gId,$num){
    	$goodsInfo = $this->PublicModel->selectSave('number,num',$this->table,array('gId'=>$gId),1);
    	$ticketNumber = $goodsInfo['number'];
    	$getNumber = explode('LC', $ticketNumber);
    	$result = 'LC'.sprintf("%08d",$getNumber[1]-$goodsInfo['num']+$num);
    	return $result;
    }
    
    public function goodsDetailView($gId) {
        $data = $this->View('office');
        $data['arr'] = $this->ToolsModel->getGoodsDetail($gId);
        $data['clientInfo'] = $this->getClientInfoArray();
        $data['sId'] = $this->session->userdata('sId');
        $getFlowList = $this->PublicModel->getFlowList($gId,$this->table);
        $data['flowlist'] = $getFlowList;
        $data['approver'] = $getFlowList[count($getFlowList)-1]['toUid'];
        if($this->input->post('submitCreate') != FALSE) {
            $app_type = $this->input->post('app_type');     //审批结果
            $app_con  = $this->input->post('app_con');      //审批意见
            $flowid   = $this->input->post('flowid');
            
            $actNum = intval(trim($this->input->post('actNum')));
            if($data['sId'] == 3 && empty($data['arr']['state'])){
            	//行政更新实际领取数量
	            if($app_type == 1 && !empty($actNum)){
	            	$this->PublicModel->updateSave($this->table,array('gId'=>$gId),array('actNum'=>$actNum));
	            	if($actNum != $data['arr']['num'] && $data['arr']['type'] == 1){
	            	    $number = $this->actTicketNumber($gId,$actNum);
	            	    $this->PublicModel->updateSave($this->table,array('gId'=>$gId),array('number'=>$number));
	            	}
	            }
            }
            
            if(!empty($data['arr']['category'])){
	            if($data['arr']['category'] == 1){
	                $extension = 1;
	            }else{
	            	$extension = 3;
	            }
            }else{
            	$extension = 2;
            }
            $this->PublicModel->controlProcess($this->table,$gId,2,$type,$app_type,$app_con,$flowid,'',$extension);
            $this->showMsg(1,'提交成功','panel/PanelController/panelList');
        }

        if(!empty($data['flowlist'])) {
            $data['directory']  = $this->PublicModel->getProDirectory($getFlowList[0]['fromName'],$getFlowList[0]['fromUid'],$getFlowList[0]['createTime']);
        }
        $data['content'] = $this->load->view('office/goodsDetailView',$data,true);
        $this->load->view('index/index',$data);
    }
    
    public function getTools(){
    	$result = '';
    	$type = $this->input->post('type');
    	if(!empty($type)){
    		$toolsList = $this->PublicModel->selectSave('*','crm_office_tools',array('isDel'=>0,'type'=>$type),2);
    		if(!empty($toolsList)){
    			$result = "<option value=''>-请选择-</option>";
    			foreach($toolsList as $val){
    				$result .= "<option value='".$val['tId']."'>".$val['name']."</option>";
    			}
    		}
    	}
    	echo $result;
    }
    
    //获取物料剩余数量
    public function getStock(){
    	$result = '';
    	$tId = $this->input->post('tId');
    	if(!empty($tId)){
    		$toolsInfo = $this->PublicModel->selectSave('*','crm_office_tools',array('tId'=>$tId),1);
    		$num = $this->ToolsModel->getToolStock($tId);
    		$result = '剩余'.$num.' '.$toolsInfo['unit'];
    		if($toolsInfo['type']==1){
	    	    $number = $this->getTicketNumber($tId,1);
	    	    $result .= '&nbsp;&nbsp;&nbsp;&nbsp;本次领取票务编号从'.$number.'开始';
    		}
    	}
    	echo $result;
    }
    
    public function getCategory(){
    	$result = '';
        $category = $this->input->post('category');
        if(!empty($category)){
        	$domain = base_url().'index.php';
        	$result .= '客户名称：<input type="text" name="name" id="name" autocomplete="off" class="span3" onKeyUp="getInfo(\''.$domain.'\',\'/business/CustomerController/getCustomerInfo\',\'name\')">';
        	if($category == 1){
        		$result .= "&nbsp;&nbsp;&nbsp;&nbsp;合同金额：<input type='text' name='contractPrice' class='span1'>元";
        		$result .= "&nbsp;&nbsp;&nbsp;&nbsp;合同上刊时间：<input type='text' name='contractDate' onClick='WdatePicker()' style='width:80px;'>";
        	}
        }
        echo $result;
    }
    
    public function goodsDel($gId){
        $signal = $this->PublicModel->updateSave($this->table,array('gId'=>$gId),array('isDel'=>1));
        if($signal != FALSE) {
            $this->PublicModel->updateSave('crm_pending',array('tableId'=>$gId,'proTable'=>$this->table),array('isDel'=>1));  //软删除待处理事项提醒
            $this->showMsg(1,'信息删除成功',self::MENU_LIST);
        }else {
            $this->showMsg(2,'信息删除失败！');
        }
    }

}


?>
