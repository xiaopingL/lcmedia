<?php
/**
 * @desc 站点控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-07-09
 */
 class SiteController extends MY_Controller{

 	const SITE_ADD  = "admin/SiteController/siteAdd";
 	const SITE_LIST = "admin/SiteController/siteList";

 	public function  __construct(){
        parent::__construct();
        $this->load->model('admin/SiteModel');
    }

    public function siteAdd(){
    	$data = $this->View('system');
    	if($this->input->post('submitCreate') != FALSE){
           $result = array(
              'name'        => $this->_clearSpace($this->input->post('name',true),true),
              'createTime'  => time()
           );

           $checkSite = $this->SiteModel->checkSite($result['name'],0);
           if($checkSite > 0){
           	  $this->showMsg(2,'已经存在该站点！');  exit;
           }
           $this->PublicModel->insertSave('crm_site',$result);
           $this->showMsg(1,'站点添加成功',self::SITE_ADD);

    	}else{
    	   $data['content'] = $this->load->view('admin/siteAddView',null,true);
    	}
    	$this->load->view('index/index',$data);
    }

    public function siteList(){
   	    $data = $this->View('system');
        $whereStr = '';
        $siteName = $this->input->post('siteName',true);
        if(!empty($siteName)){
           $where[] = "name like '%".$siteName."%'";
        }
        if(!empty($where)){
          $whereStr = ' and '.implode(" and ",$where);
        }

        $modelArray['modelPath'] = 'admin';
        $modelArray['modelName'] = 'sitemodel';
        $modelArray['sqlTplName'] = 'siteSql';
        $modelArray['sqlTplFucName'] = 'getSiteList';

        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);
   	    $argument	= array(
   	                          'base_url'        => self::SITE_LIST,
							  'per_page'		=> 12,
							  'num_links'		=> 3,
							  'uri_segment'	    => 4,
							  'total_rows'	    => $rows
							);
		$getPaginDatas		= $this->createPagination($argument);
		$list['pagination']	= $getPaginDatas['pagination'];
		$list['rows']       = $rows;
        $list['getResult']  = $this->SiteModel->getSiteList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        $list['siteName'] = $siteName;
        $data['content'] = $this->load->view('admin/siteListView',$list,true);
   	    $this->load->view('index/index',$data);
    }

    public function siteEdit($editid){
    	$data = $this->View('system');
    	if(isset($editid)){
            $getResult = $this->SiteModel->getSiteDetail($editid,0);
            $list = $getResult;
            if($this->input->post('submitCreate') != FALSE)
			{
               $result = array(
                  'name'        => $this->_clearSpace($this->input->post('name',true),true),
                  'createTime'  => time()
               );
               $checkSite = $this->SiteModel->checkEditSite($result['name'],$editid,0);
               if($checkSite > 0) {
                 $this->showMsg(2,'该站点已经存在');  exit;
               }
               $signal = $this->PublicModel->updateSave('crm_site',array('siteId'=>$editid),$result);
               if($signal != FALSE){
               	  $this->showMsg(1,'修改成功',self::SITE_LIST);
               }else{
               	  $this->showMsg(2,'修改失败，请重新操作');   exit;
               }
			}else{
				$data['content'] = $this->load->view('admin/siteEditView',$list,true);
				$this->load->view('index/index',$data);
			}

    	}else{
    		$this->menuList();
    	}
    }

    public function siteDel($delid){
        if(isset($delid)){
            $signal = $this->PublicModel->updateSave('crm_site',array('siteId'=>$delid),array('isDel'=>1));
            if($signal != FALSE){
            	$this->showMsg(1,'删除成功',self::SITE_LIST);
            }
        }else{
        	exit;
        }
    }


 }



?>
