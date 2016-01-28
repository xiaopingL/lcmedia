<?php
/**
 * @desc 公休日管理控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-07-24
 */
class AttendController extends MY_Controller {

    const MENU_LIST_HOLIDAY = "personnel/AttendController/holidayList";
    protected $table = 'crm_personnel_holiday';

    public function  __construct() {
        parent::__construct();
        $this->load->model('personnel/AttendModel','',true);
        $this->config->load('personnel',true);
    }


    public function holidayList() {
        $data = $this->View('personnel');
        $this->operaControl('allHoliday');
        $whereStr = $urlStr = '';
        $btime    = $this->input->get_post('btime',true);
        $etime    = $this->input->get_post('etime',true);

        if(!empty($btime)) {
            $list['btime'] = $btime;
            $urlArray[] = 'btime='.$btime;
            $btimeS = strtotime($btime.' 00:00:00');
            $where[] = ' a.setDate>='.$btimeS;
        }
        if(!empty($etime)) {
            $list['etime'] = $etime;
            $urlArray[] = 'etime='.$etime;
            $btimeE = strtotime($etime.' 23:59:59');
            $where[] = ' a.setDate<='.$btimeE;
        }
        if(!empty($where)) {
            $whereStr = ' and '.implode(" and ",$where);
        }
        if(!empty($urlArray)) {
            $urlStr = '/?'.implode('&', $urlArray);
        }

        $modelArray['modelPath'] = 'personnel';
        $modelArray['modelName'] = 'attendmodel';
        $modelArray['sqlTplName'] = 'attendSql';
        $modelArray['sqlTplFucName'] = 'getHolidayList';

        $rows = $this->PublicModel->getCounts($modelArray,$whereStr);

        $argument	= array(
                'base_url'      => self::MENU_LIST_HOLIDAY,
                'per_page'		=> 12,
                'num_links'		=> 3,
                'uri_segment'	=> 4,
                'total_rows'    => $rows
        );
        $getPaginDatas		= $this->createPagination($argument,$urlStr);
        $list['pagination']	= $getPaginDatas['pagination'];
        $list['rows']       = $rows;
        $list['getResult']  = $this->AttendModel->getHolidayList($getPaginDatas['start'],$getPaginDatas['offset'],$whereStr);
        $list['attendance'] = $this->config->item('attendance','personnel');
        $list['carname'] = "公休日设置";
        $data['content'] = $this->load->view('personnel/holidayListView',$list,true);
        $this->load->view('index/index',$data);
    }

    public function holidayAdd() {
        $data = $this->View('personnel');
        if($this->input->post('submitCreate') != FALSE) {
            $result = array(
                    'setDate'    => strtotime($this->input->post('setDate',true)),
                    'setStatus'  => $this->input->post('setStatus',true),
                    'setType'  => $this->input->post('setType',true),
                    'createTime' => time(),
                    'operator'   => $this->session->userdata('uId')
            );
            $checkHoliday = $this->AttendModel->checkHoliday($result['setDate']);
            if($checkHoliday>0) {
                $this->showMsg(2,'该日期已经被设置了，请重新选择！');
                exit;
            }

            $holidayId = $this->PublicModel->insertSave($this->table,$result);
            if($holidayId) {
                $this->showMsg(1,'日期设置成功',self::MENU_LIST_HOLIDAY);
            }else {
                $this->showMsg(2,'设置失败！');
                exit;
            }
        }else {
            $data['content'] = $this->load->view('personnel/holidayAddView',null,true);
        }
        $this->load->view('index/index',$data);
    }

    public function holidayDel($delid) {
        if(is_numeric($delid)) {
            $signal = $this->PublicModel->updateSave($this->table,array('hId'=>$delid),array('isDel'=>1));
            if($signal != FALSE) {
                $this->showMsg(1,'删除成功',self::MENU_LIST_HOLIDAY);
            }
        }else {
            exit;
        }
    }



}

?>
