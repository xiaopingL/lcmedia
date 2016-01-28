<?php
/**
 * @desc 影城联系人管理控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-12-26
 */
class StudioContactController extends MY_Controller {

    public function  __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->config->load('customer', TRUE);
        $this->CustomerArray['zodiac'] = $this->config->item('zodiac','customer');
        $this->CustomerArray['bloodType'] = $this->config->item('bloodType','customer');
        $this->CustomerArray['constellatory'] = $this->config->item('constellatory','customer');
        $this->load->model('media/StudioModel','',true);
        $this->load->model('admin/SiteModel','',true);
    }

    public function studioContactAddView($cIdStr='') {
    	$data = $this->View('media');
    	if(empty($cIdStr)){
    		$this->showMsg(2,'参数错误！');  exit;
    	}
    	
    	$clientInfo = $this->PublicModel->selectSave('name','crm_studio',array('sId'=>$cIdStr),1);
        $parameter['name'] = $clientInfo['name'];
        $parameter['cIdStr'] = $cIdStr;
        
        $parameter['CustomerArray'] = $this->CustomerArray;
        $parameter['status'] = 1;
        $info = $this->StudioModel->YwlxrDetail($cIdStr);
        for($i=0;$i<count($info);$i++) {
            $info[$i]['CustomerArray'] = $parameter['CustomerArray'];
        }

        $parameter['info'] = $info;
        $parameter['act'] = site_url('/media/StudioContactController/studioContactAdd');
        $dVal['putName'] = 'name';
        $dVal['idName'] = 'cId';
        $parameter['public_view_js']  = $this->load->view('index/public_view_js',$dVal,true);
        $data['content'] = $this->load->view('business/customerContactAddView',$parameter,true);
        $this->load->view('index/index',$data);
    }


    public function studioContactAdd() {
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
                    $where[] = "sId = '".$cId."'";
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
                $aa = $this->StudioModel->getClientNews($whereStr);
                if(!empty($aa)) {
                    $resName = '';
                    $resPhone = '';
                    $resName = $aa['telName'];
                    $resPhone = $aa['telNumber'];
                }else {
                    $result = array(
                            'sId' => $cId,
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
                        $fundsId = $this->PublicModel->insertSave('crm_studio_contact',$result);
                    }
                }
            }
            
            if(empty($resName)) {
                $this->showMsg(1,"影城联系人信息添加成功！","media/StudioContactController/studioContactListView");
            }else {
                $this->showMsg(1,"影城联系人添加成功！".$resName."：联系方式".$resPhone."已存在，已被过滤！","media/StudioContactController/studioContactListView");
            }

        }else {
            $this->showMsg(2,'影城联系人信息添加失败！');
            exit;
        }
    }


    public function studioContactListView() {
        $whereStr = '';
        $data = $this->View('media');
        $name = $this->input->get_post('name',true);
        $userName = $this->input->get_post('userName',true);
      
        if(!empty($name)) {
            $where[] = " b.name like '%".$name."%'";
            $urlArray[] = 'name='.$name;
        }
        if(!empty($userName)) {
            $list['userName'] = $userName;
            $where[] = ' a.telName like '."'%".$userName."%'";
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

        $modelArray['sqlTplFucName'] = 'studioContactList';
        $modelArray['modelPath'] = 'media';
        $modelArray['modelName'] = 'studiomodel';
        $modelArray['sqlTplName'] = 'publicSql';
        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);
        $argument	= array(
                'base_url'        => '/media/StudioContactController/studioContactListView',
                'per_page'		  => 12,
                'num_links'		  => 3,
                'uri_segment'	  => 4,
                'total_rows'	  => $rows
        );
        $getPaginDatas		= $this->createPagination($argument,$urlStr);
        $list['pagination']	= $getPaginDatas['pagination'];
        $list['rows']       = $rows;
        $list['getResult']  = $this->StudioModel->studioContactList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        $siteId = $this->SiteModel->getSiteList(0,100,'');
        foreach($siteId as $vs) {
            $siteIdArray[$vs['siteId']] = $vs['name'];
        }
        $list['siteId'] = $siteIdArray;
        $data['content'] = $this->load->view('media/studioContactListView',$list,true);
        $this->load->view('index/index',$data);
    }

    public function studioContactDel($id) {
        $Id = $this->PublicModel->updateSave('crm_studio_contact',array('id'=>$id),array('isDel'=>1));
        if($Id == TRUE) {
            $this->showMsg(1,'影城联系人信息删除成功','/media/StudioContactController/studioContactListView');
        }else {
            $this->showMsg(2,'影城联系人信息删除失败！');
        }
    }

    public function studioDetail($id) {
    	$data = $this->View('media');
        $parameter['CustomerArray'] = $this->CustomerArray;
        $parameter['info'] = $this->StudioModel->customerDetail($id);
        $parameter['status'] = 1;
        $data['content'] = $this->load->view('business/customerDetail',$parameter,true);
        $this->load->view('index/index',$data);
    }

    public function studioContactEditView($id) {
        $data = $this->View('media');
        $parameter['CustomerArray'] = $this->CustomerArray;
        $mCid = $this->PublicModel->selectSave('sId','crm_studio_contact',array('id'=>$id),1);
        $strName = $this->PublicModel->selectSave('name','crm_studio',array('sId'=>$mCid['sId']),1);
        $parameter['info'] = $this->StudioModel->customerDetail($id);
        $parameter['name'] = $strName;
        $parameter['status'] = 1;
        $parameter['info']['cId'] = $mCid['sId'];
        $parameter['act'] = site_url('/media/StudioContactController/studioContactUpdateView');
        $data['content'] = $this->load->view('business/customerContactEditView',$parameter,true);
        $this->load->view('index/index',$data);
    }

    public function studioContactUpdateView() {
        $name = $this->input->post('name',true);
        $cId = $this->input->post('cId',true);
        $id = $this->input->post('id',true);
        $result = array(
                'id' => $id,
                'sId' => $cId,
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
        $fundsId = $this->PublicModel->updateSave('crm_studio_contact',array('id'=>$id),$result);
        if($fundsId == TRUE){
        	$this->showMsg(1,'信息修改成功！','media/StudioContactController/studioContactListView');
        }else {
            $this->showMsg(2,'信息修改失败！');
        }
    }


}
