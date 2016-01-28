<?php
/**
 * @desc 客户联系人管理控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-12-16
 */
class CustomerContactController extends MY_Controller {

    public function  __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->config->load('customer', TRUE);
        $this->CustomerArray['zodiac'] = $this->config->item('zodiac','customer');
        $this->CustomerArray['bloodType'] = $this->config->item('bloodType','customer');
        $this->CustomerArray['constellatory'] = $this->config->item('constellatory','customer');
        $this->load->model('business/CustomerModel','',true);
        $this->load->model('business/ContractModel','',true);
        $this->load->model('business/CustomerContactModel','',true);
        $this->load->model('admin/SiteModel','',true);
    }

    public function customerContactAddView($cIdStr='') {
    	$data = $this->View('customer');
    	if(empty($cIdStr)){
    		$this->showMsg(2,'参数错误！');  exit;
    	}
    	
    	$clientInfo = $this->PublicModel->selectSave('name','crm_client',array('cId'=>$cIdStr),1);
        $parameter['name'] = $clientInfo['name'];
        $parameter['cIdStr'] = $cIdStr;
        $parameter['CustomerArray'] = $this->CustomerArray;

        $info = $this->CustomerContactModel->YwlxrDetail($cIdStr);
        for($i=0;$i<count($info);$i++) {
            $info[$i]['CustomerArray'] = $parameter['CustomerArray'];
        }

        $parameter['info'] = $info;
        $parameter['act'] = site_url('/business/CustomerContactController/customerContactAdd');
        $dVal['putName'] = 'name';
        $dVal['idName'] = 'cId';
        $parameter['public_view_js']  = $this->load->view('index/public_view_js',$dVal,true);
        $data['content'] = $this->load->view('business/customerContactAddView',$parameter,true);
        $this->load->view('index/index',$data);
    }


    public function customerContactAdd() {
        $cId = $this->input->post('cId',true);
        $sex = $this->input->post('sex',true);
        $hobby = $this->input->post('hobby',true);
        $zodiac = $this->input->post('zodiac',true);
        $telName = $this->input->post('telName',true);
        $academy = $this->input->post('academy',true);
        $birthday = $this->input->post('birthday',true);
        $telNumber = $this->input->post('telNumber',true);
        $bloodType = $this->input->post('bloodType',true);
        $telPosition = $this->input->post('telPosition',true);
        $nativePlace = $this->input->post('nativePlace',true);
        $constellatory = $this->input->post('constellatory',true);
        foreach($telName as $value){
            if(!empty($value)) {
                $telNameArray[] = $value;
            }
        }
        if(!empty($telNameArray)) {
            foreach($telNameArray as $key=>$v) {
                $where = array();
                $aa = '';
                if(!empty($cId)) {
                    $where[] = "cId = '".$cId."'";
                }
                if(!empty ($v)) {
                    $where[] = "telName = '".$v."'";
                }
                if(!empty ($telNumber[$key])) {
                    $where[] = "telNumber = '".$telNumber[$key]."'";
                }
                if(!empty($where)) {
                    $whereStr = ' and '.implode(" and ",$where);
                }
                $aa = $this->CustomerModel->getClientNews($whereStr);
                if(!empty($aa)) {
                    $resName = '';
                    $resPhone = '';
                    $resName = $aa['telName'];
                    $resPhone = $aa['telNumber'];
                }else {
                    $result = array(
                            'cId' => $cId,
                            'sex' => $sex[$key],
                            'telName' => $v,
                            'telNumber' => $telNumber[$key],
                            'telPosition' => $telPosition[$key],
                            'operator'=>$this->session->userdata['uId'],
                            'birthday' => $birthday[$key],
                            'zodiac' => $zodiac[$key],
                            'constellatory' => $constellatory[$key],
                            'bloodType' => $bloodType[$key],
                            'nativePlace' => $nativePlace[$key],
                            'academy' => $academy[$key],
                            'hobby' => $hobby[$key],
                            'createTime'=>time(),
                    );
                    if(!empty($v) && !empty($cId)) {
                        $fundsId = $this->PublicModel->insertSave('crm_customer_contact',$result);
                    }
                }
            }
            
            if(empty($resName)) {
                $this->showMsg(1,"客户联系人信息添加成功！","business/CustomerContactController/customerContactListView");
            }else {
                $this->showMsg(1,"客户联系人添加成功！".$resName."：联系方式".$resPhone."已存在，已被过滤！","business/CustomerContactController/customerContactListView");
            }

        }else {
            $this->showMsg(2,'客户联系人信息添加失败！');
            exit;
        }
    }


    public function customerContactListView() {
        $whereStr = '';
        $data = $this->View('customer');
        $name = $this->input->get_post('name',true);
        $type = $this->input->get_post('type',true);                            //类型
        if(!in_array('allCustomer',$data['userOpera'])) {
            $where[] = "c.salesmanId in".$this->uIdDispose();
        }
        
        $where[] = " c.endDate >= ".time();
        if(!empty($name)) {
            $where[] = " b.name like '%".$name."%'";
            $urlArray[] = 'name='.$name;
        }

        $userName = $this->input->get_post('userName',true);
        if(!empty($userName)) {
            $list['userName'] = $userName;
            $where[] = ' d.userName like '."'%".$userName."%'";
            $urlArray[] = 'userName='.$userName;
        }

        $sTime = $this->input->get_post('sTime',true);    //开始时间
        $eTime = $this->input->get_post('eTime',true);    //结束时间
        if($sTime) {
            $sTimeStr = strtotime($sTime.' 00:00:00');
            $list['sTime'] = $sTime;
            $urlArray[] = 'sTime='.$sTime;
            $where[] = " a.createTime >= ".$sTimeStr;
        }
        
        if($eTime) {
            $eTimeStr = strtotime($eTime.' 23:59:59');
            $list['eTime'] = $eTime;
            $urlArray[] = 'eTime='.$eTime;
            $where[] = " a.createTime <= ".$eTimeStr;
        }

        if(!empty($urlArray)) {
            $urlStr = '/?'.implode('&', $urlArray);
        }
        if(!empty($where)) {
            $list['name'] = $name;
            $list['userName'] = $userName;
            $whereStr = ' and '.implode(" and ",$where);
        }

        $modelArray['sqlTplFucName'] = 'customerContactList';
        $modelArray['modelPath'] = 'business';
        $modelArray['modelName'] = 'customercontactmodel';
        $modelArray['sqlTplName'] = 'customerContactSql';
        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);
        $argument	= array(
                'base_url'        => '/business/CustomerContactController/customerContactListView',
                'per_page'		  => 12,
                'num_links'		  => 3,
                'uri_segment'	  => 4,
                'total_rows'	  => $rows
        );
        $getPaginDatas		= $this->createPagination($argument,$urlStr);
        $list['pagination']	= $getPaginDatas['pagination'];
        $list['rows']       = $rows;
        $list['getResult']  = $this->CustomerContactModel->customerContactList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        $list['customerIndustry'] = $this->config->item('industry','customer');
        $data['content'] = $this->load->view('business/customerContactListView',$list,true);
        $this->load->view('index/index',$data);
    }

    public function customerContactDel($id) {
        $Id = $this->PublicModel->updateSave('crm_customer_contact',array('id'=>$id),array('isDel'=>1));
        if($Id == TRUE) {
            $this->showMsg(1,'客户联系人信息删除成功','/business/CustomerContactController/customerContactListView');
        }else {
            $this->showMsg(2,'客户联系人信息删除失败！');
        }
    }

    public function customerDetail($id) {
    	$data = $this->View('customer');
        $parameter['CustomerArray'] = $this->CustomerArray;
        $parameter['info'] = $this->CustomerContactModel->customerDetail($id);
        $data['content'] = $this->load->view('business/customerDetail',$parameter,true);
        $this->load->view('index/index',$data);
    }

    public function customerContactEditView($id) {
        $data = $this->View('customer');
        $parameter['CustomerArray'] = $this->CustomerArray;
        $mCid = $this->PublicModel->selectSave('cId','crm_customer_contact',array('id'=>$id),1);
        $strName = $this->CustomerModel->getClientInfo($mCid['cId']);
        $parameter['info'] = $this->CustomerContactModel->customerDetail($id);
        $parameter['name'] = $strName['0'];
        $parameter['act'] = site_url('/business/CustomerContactController/customerContactUpdateView');
        $data['content'] = $this->load->view('business/customerContactEditView',$parameter,true);
        $this->load->view('index/index',$data);
    }

    public function customerContactUpdateView() {
        $name = $this->input->post('name',true);
        $cId = $this->input->post('cId',true);
        $id = $this->input->post('id',true);
        $result = array(
                'id' => $id,
                'cId' => $cId,
                'telName' => $this->input->post('telName',true),
                'telNumber' => $this->input->post('telNumber',true),
                'telPosition' => $this->input->post('telPosition',true),
                'sex' => $this->input->post('sex',true),
                'birthday' => $this->input->post('birthday',true),
                'zodiac' => $this->input->post('zodiac',true),
                'constellatory' => $this->input->post('constellatory',true),
                'bloodType' => $this->input->post('bloodType',true),
                'nativePlace' => $this->input->post('nativePlace',true),
                'academy' => $this->input->post('academy',true),
                'hobby' => $this->input->post('hobby',true),
                'updateTime'=>time(),
        );
        $fundsId = $this->PublicModel->updateSave('crm_customer_contact',array('id'=>$id),$result);
        if($fundsId == TRUE){
        	$this->showMsg(1,'信息修改成功！','business/CustomerContactController/customerContactListView');
        }else {
            $this->showMsg(2,'信息修改失败！');
        }
    }


}
