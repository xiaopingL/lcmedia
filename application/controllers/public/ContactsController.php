<?php
/**
 * @desc 内部通讯控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-07-13
 */
class ContactsController extends MY_Controller {
    const VIEW_LIST  = "public/contList";
    const CONT_LIST = "/public/ContactsController/contList";

    public function  __construct() {
        parent::__construct();
        $this->load->model('public/ContModel','',true);
        $this->load->model('admin/UserModel','',true);
        $this->load->model('admin/OrgModel','',true);
        $this->config->load('personnel',true);
    }
    public function contList() {
        $data = $this->View('panel');
        $whereStr = '';
        $uId = $this->session->userdata['uId'];
        $sId = $this->input->get_post('sId',true);
        if(!empty($sId)) {
            $urlArray[] = 'sId='.$sId;
            $sIdArray = $this->PublicModel->getAllOrgSublevel($arrayList=array(),$sId,0);
            if(!empty($sIdArray)) {
                $sIdStr = implode(',', $sIdArray);
                $uIdArray = $this->PublicModel->getContactAllUid($sIdStr,0);
                $uIdAssemble = $this->converArr($uIdArray,'uId');
                if(!empty($uIdAssemble)) {
                    $where[] = ' a.uId in ('.implode(',', $uIdAssemble).')';
                }else {
                    $where[] = "a.uId in".$this->uIdDispose();
                }
            }
        }

        $userName = $this->input->get_post('userName',true);
        $phone    = $this->input->get_post('phone',true);
        if(!empty($userName)) {
            $where[] = "a.userName like '%".$userName."%'";
            $urlArray[] = 'userName='.$userName;
        }

        if(!empty($phone)) {
            $where[] = "b.phone like '%".$phone."%'";
            $urlArray[] = 'phone='.$phone;
        }
        if(!empty($urlArray)) {
            $urlStr = '/?'.implode('&', $urlArray);
        }
        if(!empty($where)) {
            $data['userName'] = $userName;
            $data['phone'] = $phone;
            $data['sId'] = $sId;
            $whereStr = ' and '.implode(" and ",$where);
        }
        $modelArray['modelPath'] = 'public';
        $modelArray['modelName'] = 'ContModel';
        $modelArray['sqlTplName'] = 'contSql';
        $modelArray['sqlTplFucName'] = 'contList';
        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);

        $argument	= array(
                'base_url'      => self::CONT_LIST,
                'per_page'		=> 12,
                'num_links'		=> 3,
                'uri_segment'	=> 4,
                'total_rows'	=> $rows
        );
        $getPaginDatas		= $this->createPagination($argument,$urlStr);
        $data['pagination']	= $getPaginDatas['pagination'];
        $data['rows']       = $rows;
        $data['org'] = $this->PublicModel->getDepList($arrayList=array(),0,0);

        $data['arr']  = $this->ContModel->contList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        foreach($data['arr'] as $key=>$val) {
            $data['arr'][$key]['photoImg'] = $this->UserModel->getUserPhoto($val['uId']);
            $data['arr'][$key]['siteName'] = implode(',',$this->converArr($this->PublicModel->getContactAllSiteid($val['uId'],0),'name'));
            $detail = $this->UserModel->getUserQuarter($val['uId']);
            $data['arr'][$key]['name']     = $detail['name'];
        }

        $data['content'] = $this->load->View(self::VIEW_LIST,$data,true);
        $this->load->View('index/index',$data);
    }



}

?>
