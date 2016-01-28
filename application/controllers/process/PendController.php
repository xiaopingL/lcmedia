<?php
/**
 * @desc 处理事项管理控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-07-24
 */
 class PendController extends MY_Controller{

 	const PEND_ADD  = "process/PendController/pendAdd";
 	const PEND_LIST = "process/PendController/pendList";
 	protected $table = 'crm_pending_contact';

 	public function  __construct(){
        parent::__construct();
        $this->load->model('process/ProcessModel');
    }

    public function pendAdd(){
    	$data = $this->View('process');
    	if($this->input->post('submitCreate') != FALSE){

    	   $pNumber_arr = $this->input->post('pNumber');
    	   if(count($pNumber_arr) > 1){
              foreach($pNumber_arr as $value){
              	 $extensionArr = $this->ProcessModel->getProDetail($value,0);
              	 if(empty($extensionArr['processExtension'])){
              	 	$this->showMsg(2,'缺少流程扩展信息');  exit;
              	 }
              	 $extension    = json_decode($extensionArr['processExtension'],true);
              	 $extension_key = array_keys($extension);
              	 switch($extension_key[0]){
              	 	case 'jobId':
              	 	     $p_arr[] = array('number'=>$value,'jobId'=>$extension['jobId']);
              	 	     break;
              	 	case 'numType':
              	 	     $p_arr[] = array('number'=>$value,'numType'=>$extension['numType']);
              	 	     break;
              	 }
              }
              $pNumber = json_encode($p_arr);
    	   }else{
    	   	  $pNumber = $pNumber_arr[0];
    	   }

           $result = array(
              'proTable'      => $this->_clearSpace($this->input->post('proTable',true),true),
              'pendingType'   => $this->_clearSpace($this->input->post('pendingType',true),true),
              'urlAdress'     => $this->_clearSpace($this->input->post('urlAdress',true),true),
              'pNumber'       => $pNumber,
              'createTime'    => time()
           );

           $signal = $this->PublicModel->insertSave('crm_pending_contact',$result);

            if($signal != FALSE) {
                $this->showMsg(1,'添加成功',self::PEND_ADD);
            }else {
                $this->showMsg(2,'添加失败，请重新操作');  exit;
            }

    	}else{
    	   $list['process'] = $this->ProcessModel->getPnumber(0);
    	   $data['content'] = $this->load->view('process/pendAddView',$list,true);
    	}
    	$this->load->view('index/index',$data);
    }

    public function pendList() {
        $data = $this->View('process');
        $whereStr = '';
        $pendingType = $this->input->post('pendingType',true);
        if(!empty($pendingType)){
           $where[] = "pendingType like '%".$pendingType."%'";
        }
        if(!empty($where)){
          $whereStr = ' and '.implode(" and ",$where);
        }

        $modelArray['modelPath'] = 'process';
        $modelArray['modelName'] = 'processmodel';
        $modelArray['sqlTplName'] = 'proSql';
        $modelArray['sqlTplFucName'] = 'getPendList';

        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);
        $argument	= array(
                'base_url'        => self::PEND_LIST,
                'per_page'		  => 12,
                'num_links'		  => 3,
                'uri_segment'	  => 4,
                'total_rows'	  => $rows
        );
        $getPaginDatas		= $this->createPagination($argument);
        $list['pagination']	= $getPaginDatas['pagination'];
        $list['rows']       = $rows;
        $list['getResult']  = $this->ProcessModel->getPendList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        foreach($list['getResult'] as $key=>$value){
        	$number_arr = array();
        	if(is_numeric($value['pNumber'])){
               $list['getResult'][$key]['processName'] = $this->ProcessModel->converPnumber($value['pNumber'],0);
        	}else{
        	   $pNumber = json_decode($value['pNumber'],true);
        	   foreach($pNumber as $k=>$v){
        	   	  $number_arr[] = $this->ProcessModel->converPnumber($v['number'],0);
        	   }
        	   $list['getResult'][$key]['processName'] = implode(',',$number_arr);
        	}
        }

        $list['pendingType'] = $pendingType;
        $data['content'] = $this->load->view('process/pendListView',$list,true);
        $this->load->view('index/index',$data);
    }

    public function pendEdit($editid){
    	$data = $this->View('process');
    	if(isset($editid)){
            $getResult = $this->ProcessModel->getPendDetail($editid,0);
            $list = $getResult;

    	   $pNumber_arr = $this->input->post('pNumber');
    	   if(count($pNumber_arr) > 1){
              foreach($pNumber_arr as $value){
              	 $extensionArr = $this->ProcessModel->getProDetail($value,0);
              	 if(empty($extensionArr['processExtension'])){
              	 	$this->showMsg(2,'缺少流程扩展信息');  exit;
              	 }
              	 $extension    = json_decode($extensionArr['processExtension'],true);
              	 $extension_key = array_keys($extension);
              	 switch($extension_key[0]){
              	 	case 'jobId':
              	 	     $p_arr[] = array('number'=>$value,'jobId'=>$extension['jobId']);
              	 	     break;
              	 	case 'numType':
              	 	     $p_arr[] = array('number'=>$value,'numType'=>$extension['numType']);
              	 	     break;
              	 }
              }
              $pNumber = json_encode($p_arr);
    	   }else{
    	   	  $pNumber = $pNumber_arr[0];
    	   }

            if($this->input->post('submitCreate') != FALSE)
			{
               $result = array(
                 'proTable'      => $this->_clearSpace($this->input->post('proTable',true),true),
                 'pendingType'   => $this->_clearSpace($this->input->post('pendingType',true),true),
                 'urlAdress'     => $this->_clearSpace($this->input->post('urlAdress',true),true),
                 'pNumber'       => $pNumber,
                 'createTime'    => time()
               );
               $signal = $this->PublicModel->updateSave('crm_pending_contact',array('pId'=>$editid),$result);
               if($signal != FALSE){
               	  $this->showMsg(1,'修改成功',self::PEND_LIST);
               }else{
               	  $this->showMsg(2,'修改失败，请重新操作');  exit;
               }
			}else{
				$list['process'] = $this->ProcessModel->getPnumber(0);

				foreach($list['process'] as $key=>$val){
                   if(!is_numeric($list['pNumber'])){
                   	  $pNumberArr = json_decode($list['pNumber'],true);
                      foreach($pNumberArr as $k=>$v){
                      	$list['process'][$key]['number'] = (in_array($val['pNumber'],$this->converArr($pNumberArr,'number')))?$val['pNumber']:'';
                      }
                   }else{
                   	  $list['process'][$key]['number'] = ($val['pNumber'] == $list['pNumber'])?$val['pNumber']:'';
                   }
				}

				$data['content'] = $this->load->view('process/pendEditView',$list,true);
				$this->load->view('index/index',$data);
			}

    	}else{
    		$this->pendList();
    	}
    }

    public function pendDel($delid){
        if(isset($delid)){
            $signal = $this->PublicModel->updateSave('crm_pending_contact',array('pId'=>$delid),array('isDel'=>1));
            if($signal != FALSE){
            	$this->showMsg(1,'删除成功',self::PEND_LIST);
            }
        }else{
        	exit;
        }
    }

 }



?>
