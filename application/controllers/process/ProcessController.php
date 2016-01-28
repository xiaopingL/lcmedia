<?php
/**
 * @desc 系统流程管理控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-07-24
 */
 class ProcessController extends MY_Controller{

 	const PROCESS_ADD  = "process/ProcessController/processAdd";
 	const PROCESS_LIST = "process/ProcessController/processList";
 	const EXTENSION_LIST = "process/ProcessController/extensionList";

 	public function  __construct(){
        parent::__construct();
        $this->load->model('process/ProcessModel');
        $this->load->model('admin/OrgModel');
        $this->load->model('admin/UserModel');
    }

    public function processAdd(){
    	$data = $this->View('process');
    	if($this->input->post('submitCreate') != FALSE){

    	   $level_num = $this->input->post('level_num');
    	   $jobId     = $this->input->post('jobId');
    	   $numType   = $this->input->post('numType');
           if($level_num <2){
           	  //$this->showMsg(2,'流程级别设置不能少于2级，请重新操作'); exit;
           }

    	   for($i=1;$i<=$level_num;$i++){
              $level = $this->input->post('level'.$i)!=''?$this->input->post('level'.$i):0;
              $sid   = $this->input->post('sid'.$i)!=''?$this->input->post('sid'.$i):0;
              $price = $this->input->post('price'.$i)!=''?$this->input->post('price'.$i):'';
              $username = $this->input->post('username'.$i);
              if(!empty($username)){
              	 $nameArr = $this->UserModel->getUserFirst($username);
              	 if(empty($nameArr)){
                    $this->showMsg(2,'用户名填写有误');  exit;
           	   	 }
              	 $uId  = $nameArr[0]['uId'];
              }else{
              	 $uId  = '';
              }
              $arr[] = array('level'=>$level, 'sid'=>$sid, 'price'=>$price, 'name'=>$uId);
    	   }

    	   if($jobId != '' && $numType != ''){
              $this->showMsg(2,'多流程扩展只能选择一个条件');  exit;
    	   }

    	   if($jobId != ''){
    	   	  $processExtension = json_encode(array('jobId'=>$jobId));
    	   }elseif($numType != ''){
    	   	  $processExtension = json_encode(array('numType'=>$numType));
    	   }else{
    	   	  $processExtension = '';
    	   }

           $result = array(
              'processName'      => $this->_clearSpace($this->input->post('processName',true),true),
              'processStructrue' => json_encode($arr),
              'processExtension' => $processExtension,
              'createTime'       => time()
           );

           $signal = $this->PublicModel->insertSave('crm_process',$result);

           //新增单流程扩展信息
           $approve  = $this->input->post('approve');
           $orgId    = $this->input->post('orgId');
           $position = $this->input->post('position');
           $limits   = $this->input->post('limits');
           if($approve[0] != ''){
           	   foreach($approve as $key=>$value){
           	   	   $uIdArr = $this->UserModel->getUserFirst($approve[$key]);
           	   	   if(empty($uIdArr)){
                       $this->showMsg(2,'用户名填写有误，请重新操作');  exit;
           	   	   }
           	   	   $extension = array(
           	   	        'pNumber'     =>  $signal,
           	   	        'level'       =>  $position,
           	   	        'uId'         =>  $uIdArr[0]['uId'],
           	   	        'sId'         =>  $orgId[$key],
           	   	        'limits'      =>  $limits[$key],
           	   	        'createTime'  =>  time()
           	   	   );
           	   	   $this->PublicModel->insertSave('crm_process_extension',$extension);
           	   }
           }

            if($signal != FALSE) {
                $this->showMsg(1,'流程添加成功',self::PROCESS_ADD);
            }else {
                $this->showMsg(2,'流程添加失败，请重新操作');  exit;
            }

    	}else{
    	   $list['position'] = $data['position'];
    	   $list['org'] = $this->OrgModel->getChildList($arrayList=array(),0,0);
    	   $list['orgs']= $this->PublicModel->getDepList($arrayList=array(),0,0);
    	   foreach($list['orgs'] as $key=>$val){
    	   	 if(!in_array($val['parentId'],array(20,36,110,114,41))){
    	   	 	//unset($list['orgs'][$key]);
    	   	 }
    	   }
    	   $data['content'] = $this->load->view('process/processAddView',$list,true);
    	}
    	$this->load->view('index/index',$data);
    }

    public function processList() {
        $data = $this->View('process');
        $whereStr = '';
        $processName = $this->input->post('processName',true);
        if(!empty($processName)){
           $where[] = "processName like '%".$processName."%'";
        }
        if(!empty($where)){
          $whereStr = ' and '.implode(" and ",$where);
        }

        $modelArray['modelPath'] = 'process';
        $modelArray['modelName'] = 'processmodel';
        $modelArray['sqlTplName'] = 'proSql';
        $modelArray['sqlTplFucName'] = 'getProList';

        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);
        $argument	= array(
                'base_url'        => self::PROCESS_LIST,
                'per_page'		  => 12,
                'num_links'		  => 3,
                'uri_segment'	  => 4,
                'total_rows'	  => $rows
        );
        $getPaginDatas		= $this->createPagination($argument);
        $list['pagination']	= $getPaginDatas['pagination'];
        $list['rows']       = $rows;
        $list['getResult']  = $this->ProcessModel->getProList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        foreach($list['getResult'] as $k=>$v){
        	$pExtension = $this->ProcessModel->getExtDetail($v['pNumber'],0);
        	if(!empty($pExtension)){
        		$list['getResult'][$k]['level'] = $pExtension[0]['level'];
        	}else{
        		$list['getResult'][$k]['level'] = '9999';
        	}
        }

        foreach($list['getResult'] as $key=>$value){
           $pro_arr = json_decode($value['processStructrue'],true);
           $stru_str = "";
           foreach($pro_arr as $k=>$val){
           	  $sidName = $level = $structrue = $price = '';
              $sidName = $val['sid']!=0?$this->ProcessModel->getSidList($val['sid'],0):'';
              $price   = (!empty($val['price']))?"/".$val['price']:'';
              if(!empty($pro_arr[$k+1]['name'])){
                 $userInfo = $this->UserModel->getUserDetail($pro_arr[$k+1]['name'],0);
                 $username = $userInfo['userName'];
              }else{
              	 $username = '';
              }

              foreach($data['position'] as $ke=>$v){
              	if($k<count($pro_arr)-1 && $ke == $pro_arr[$k+1]['level']){
              		$level = $v;
              	}
              }

              if($level != ''){
              	$position = (!empty($username))?$username:$level;
                if($sidName == '' && $level != ''){
                  $structrue = "部门(".$position.$price.")";
                }else{
                  $structrue = $sidName."(".$position.$price.")";
                }
              }
              if((is_numeric($value['level'])) && $value['level'] == $k+1){
              	$structrue .= "=>分管(审批)";
              }elseif($value['level']==0 && $value['level'] == $k){
              	$structrue =  "分管(审批)=>".$structrue;
              }
              $stru_str .= ($structrue != '')?$structrue."=>":'';
              $list['getResult'][$key]['processStructrue'] = rtrim($stru_str,"=>");
           }
        }
        //print_r($list['getResult']);
        $list['processName'] = $processName;
        $data['content'] = $this->load->view('process/processListView',$list,true);
        $this->load->view('index/index',$data);
    }

    public function processEdit($editid){
    	$data = $this->View('process');
    	if(isset($editid)){
            $getResult = $this->ProcessModel->getProDetail($editid,0);
            $getExtension = $this->ProcessModel->getExtDetail($editid,0);
            foreach($getExtension as $key=>$val){
            	$userInfo = $this->UserModel->getUserDetail($val['uId'],0);
            	$getExtension[$key]['uId'] = $userInfo['userName'];
            }
            $list = $getResult;
            $list['extension'] = $getExtension;
            $list['level']     = (!empty($getExtension))?$getExtension[0]['level']:'9999';
            $process   = (!empty($list['processExtension']))?json_decode($list['processExtension'],true):array('noKey'=>0);
            $process_key = array_keys($process);
            $list['jobId'] = $list['numType'] = '';
            switch($process_key[0]){
            	case 'jobId':
            	  $list['jobId']  = (!empty($process))?$process['jobId']:'';
            	  break;
            	case 'numType':
            	  $list['numType']  = (!empty($process))?$process['numType']:'';
            	  break;
            }

            if($this->input->post('submitCreate') != FALSE)
			{
    	       $level_num = $this->input->post('level_num');
    	       $jobId     = $this->input->post('jobId');
    	       $numType   = $this->input->post('numType');
               if(!empty($level_num)){
    	           for($i=1;$i<=$level_num;$i++){
                       $level = $this->input->post('level'.$i)!=''?$this->input->post('level'.$i):0;
                       $sid   = $this->input->post('sid'.$i)!=''?$this->input->post('sid'.$i):0;
                       $price = $this->input->post('price'.$i)!=''?$this->input->post('price'.$i):'';
                       $username = $this->input->post('username'.$i);
                    if(!empty($username)){
              	       $nameArr = $this->UserModel->getUserFirst($username);
              	       if(empty($nameArr)){
                          $this->showMsg(2,'用户名填写有误');  exit;
           	   	       }
              	       $uId  = $nameArr[0]['uId'];
                    }else{
              	       $uId  = '';
                    }
                       $arr[] = array('level'=>$level, 'sid'=>$sid, 'price'=>$price, 'name'=>$uId);
    	           }

                   $result = array(
                       'processName'      => $this->_clearSpace($this->input->post('processName',true),true),
                       'processStructrue' => json_encode($arr),
                       'createTime'       => time()
                   );
                   $signal_a = $this->PublicModel->updateSave('crm_process',array('pNumber'=>$editid),$result);
               }

    	       if($jobId != '' && $numType != ''){
                  $this->showMsg(2,'多流程扩展只能选择一个条件');  exit;
    	       }

    	       if($jobId != ''){
    	   	      $processExtension = json_encode(array('jobId'=>$jobId));
    	       }elseif($numType != ''){
    	   	      $processExtension = json_encode(array('numType'=>$numType));
    	       }else{
    	   	      $processExtension = '';
    	       }
               $signal_b = $this->PublicModel->updateSave('crm_process',array('pNumber'=>$editid),array('processExtension'=>$processExtension));

               //删除原流程扩展信息
               $this->db->delete('crm_process_extension',array('pNumber'=>$editid));

               //新增新的流程扩展信息
               $approve  = $this->input->post('approve');
               $orgId    = $this->input->post('orgId');
               $position = $this->input->post('position');
               $limits   = $this->input->post('limits');
               if($approve[0] != ''){
           	      foreach($approve as $key=>$value){
           	   	     $uIdArr = $this->UserModel->getUserFirst($approve[$key]);
           	   	     if(empty($uIdArr)){
                         $this->showMsg(2,'用户名填写有误，请重新操作');  exit;
           	   	     }
           	   	     $extension = array(
           	   	        'pNumber'     =>  $editid,
           	   	        'level'       =>  $position,
           	   	        'uId'         =>  $uIdArr[0]['uId'],
           	   	        'sId'         =>  $orgId[$key],
           	   	        'limits'      =>  $limits[$key],
           	   	        'createTime'  =>  time()
           	   	     );
           	   	     $signal_c = $this->PublicModel->insertSave('crm_process_extension',$extension);
           	      }
               }

               if($signal_a != FALSE || $signal_b != FALSE || $signal_c != FALSE){
               	  $this->showMsg(1,'流程修改成功',self::PROCESS_LIST);
               }else{
               	  $this->showMsg(2,'流程修改失败，请重新操作');  exit;
               }
			}else{
    	        $list['position'] = $data['position'];
    	        $list['org'] = $this->OrgModel->getChildList($arrayList=array(),0,0);
    	        $list['orgs']= $this->PublicModel->getDepList($arrayList=array(),0,0);
    	        foreach($list['orgs'] as $key=>$val){
    	   	       if(!in_array($val['parentId'],array(20,36,110,114,41))){
    	   	 	       //unset($list['orgs'][$key]);
    	   	       }
    	        }
				$data['content'] = $this->load->view('process/processEditView',$list,true);
				$this->load->view('index/index',$data);
			}

    	}else{
    		$this->processList();
    	}
    }

    public function processDel($delid){
        if(isset($delid)){
            $signal = $this->PublicModel->updateSave('crm_process',array('pNumber'=>$delid),array('isDel'=>1));
            if($signal != FALSE){
            	$this->showMsg(1,'流程删除成功',self::PROCESS_LIST);
            }
        }else{
        	exit;
        }
    }

    function extensionList(){
        $data = $this->View('process');
        $rows = $this->PublicModel->getCount('crm_process_extension','eId',array('isDel='=>0));
        $argument	= array(
                'base_url'        => self::EXTENSION_LIST,
                'per_page'		  => 13,
                'num_links'		  => 3,
                'uri_segment'	  => 4,
                'total_rows'	  => $rows
        );
        $getPaginDatas		= $this->createPagination($argument);
        $list['pagination']	= $getPaginDatas['pagination'];
        $list['rows']       = $rows;
        $list['getResult']  = $this->ProcessModel->getExtensionList($getPaginDatas['start'],$getPaginDatas['offset']);
        foreach($list['getResult'] as $key=>$value){
        	switch($value['level']){
        		case '0':  $level = '第一级审批前';  break;
                case '1':  $level = '第二级审批前';  break;
                case '2':  $level = '第三级审批前';  break;
                case '3':  $level = '第四级审批前';  break;
                case '4':  $level = '第五级审批前';  break;
                case '5':  $level = '第六级审批前';  break;
                case '6':  $level = '第七级审批前';  break;
                case '7':  $level = '第八级审批前';  break;

        	}
        	$userInfo = $this->UserModel->getUserDetail($value['uId'],0);
        	$orgInfo  = $this->ProcessModel->getSidList($value['sId'],0);
        	$list['getResult'][$key]['pNumber'] = $this->ProcessModel->converPnumber($value['pNumber'],0);
        	$list['getResult'][$key]['uId']     = $userInfo['userName'];
        	$list['getResult'][$key]['sId']     = $orgInfo;
        	$list['getResult'][$key]['level']   = $level;
        }
        //print_r($list['getResult']);
        $data['content'] = $this->load->view('process/extensionListView',$list,true);
        $this->load->view('index/index',$data);
    }

    public function extensionEdit($editid){
    	$data = $this->View('process');
    	if(isset($editid)){
            $getResult = $this->ProcessModel->getExtensionDetail($editid,0);
            $list = $getResult;
            $userInfo = $this->UserModel->getUserDetail($getResult['uId'],0);
            $list['pNumber'] = $this->ProcessModel->converPnumber($getResult['pNumber'],0);
            $list['uId']     = $userInfo['userName'];
            if($this->input->post('submitCreate') != FALSE)
			{
               $uIdArr = $this->UserModel->getUserFirst($this->input->post('approve'));
               if(empty($uIdArr)){
                       $this->showMsg(2,'用户名填写有误，请重新操作');  exit;
           	   }
               $result = array(
           	   	        'level'       =>  $this->input->post('position'),
           	   	        'uId'         =>  $uIdArr[0]['uId'],
           	   	        'sId'         =>  $this->input->post('orgId'),
           	   	        'limits'      =>  $this->input->post('limits'),
           	   	        'createTime'  =>  time()
               );
               //节点位置保持一致，统一更新
               $this->PublicModel->updateSave('crm_process_extension',array('pNumber'=>$getResult['pNumber'],'isDel'=>0),array('level'=>$result['level']));
               $signal = $this->PublicModel->updateSave('crm_process_extension',array('eId'=>$editid),$result);
               if($signal != FALSE){
               	  $this->showMsg(1,'修改成功',self::EXTENSION_LIST);
               }else{
               	  $this->showMsg(2,'修改失败，请重新操作');  exit;
               }
			}else{
    	        $list['orgs']= $this->PublicModel->getDepList($arrayList=array(),0,0);
    	        foreach($list['orgs'] as $key=>$val){
    	   	       if(!in_array($val['parentId'],array(20,36,110,114,41))){
    	   	 	       //unset($list['orgs'][$key]);
    	   	       }
    	        }
				$data['content'] = $this->load->view('process/extensionEditView',$list,true);
				$this->load->view('index/index',$data);
			}

    	}else{
    		$this->extensionList();
    	}
    }

    public function extensionDel($delid){
        if(isset($delid)){
            $signal = $this->PublicModel->updateSave('crm_process_extension',array('eId'=>$delid),array('isDel'=>1));
            if($signal != FALSE){
            	$this->showMsg(1,'删除成功',self::EXTENSION_LIST);
            }
        }else{
        	exit;
        }
    }


 }



?>
