<?php
/**
 * @desc 拜访管理控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-11-06
 */
class VisitController extends MY_Controller {
	
	protected $billingArray = array();
    protected $table = 'crm_daily_detail';
    const MENU_LIST  = "business/VisitController/visitList";

    public function  __construct() {
        parent::__construct();
        $this->load->model('public/JournaModel','',true);
        $this->config->load('journal',true);
    }

    public function visitList() {
        $where = $urlArray = array();
        $urlStr = $whereStr = '';
        $data = $this->View('customer');

        if(!in_array('allVisit',$data['userOpera'])){
            $where[] = "a.operator in".$this->uIdDispose();
        }

        $clientname = trim($this->input->get_post('name',true));        //获取客户名称
        $username = trim($this->input->get_post('username',true));      //获取姓名
        $sTime = $this->input->get_post('sTime',true);
        $eTime = $this->input->get_post('eTime',true);
        $sTime1 = strtotime($sTime);
        $eTime1 = strtotime($eTime);
        
        if(!empty($sTime1)) {
        	$list['sTime'] = $sTime;
            $where[] = ' a.createTime >='.$sTime1;
            $urlArray[] = 'sTime='.$sTime;
        }
        if(!empty($eTime1)) {
        	$list['eTime'] = $eTime;
            $where[] = ' a.createTime <='.$eTime1;
            $urlArray[] = 'eTime='.$eTime;
        }
        //客户名称搜索
        if(!empty($clientname)) {
            $list['clientname'] = $clientname;
            $where[] = ' b.name like '."'%".$clientname."%'";
            $urlArray[] = 'clientname='.$clientname;
        }
        //搜索姓名
        if(!empty($username)) {
        	$list['username'] = $username;
            $urlArray[] = 'username='.$username;
            $where[] = ' c.userName like '."'%".$username."%'";
        }

        //拼接查询条件
        if(!empty($urlArray)) {
            $urlStr = '/?'.implode('&', $urlArray);
        }
        if(!empty($where)) {
            $whereStr = ' and '.implode(" and ",$where);
        }
        $modelArray['modelPath'] = 'public';
        $modelArray['modelName'] = 'JournaModel';
        $modelArray['sqlTplName'] = 'journaSql';
        $modelArray['sqlTplFucName'] = 'getVisitList';
        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);
        $argument	= array(
                'base_url'      => self::MENU_LIST,
                'per_page'		=> 12,
                'num_links'		=> 3,
                'uri_segment'	=> 4,
                'total_rows'    => $rows,
        );
        $getPaginDatas		= $this->createPagination($argument,$urlStr);
        $list['pagination']	= $getPaginDatas['pagination'];
        $list['rows']       = $rows;
        $list['arr_month']	= array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
        $list['getResult']  = $this->JournaModel->getVisitList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        $list['dailyShape'] = $this->config->item('dailyShape','journal');
        $data['content'] = $this->load->view('business/visitListView',$list,true);
        $this->load->view('index/index',$data);
    }
    
    

}
?>
