<?php
/**
 * @desc 通过部门查询员工控制器
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-07-10
 */
class TrainController extends MY_Controller {

    public function  __construct() {
        parent::__construct();
    }

    function ajaxGetDep() {
        $rows	= array();
        $val	= '';
        $ajax_cid	= $_POST['cid'];
        $list_sid=$this->PublicModel->getAllOrgSublevel($arrayList=array(),$ajax_cid,0);
        $sIdStr = ($ajax_cid == 1)?$ajax_cid:implode(',', $list_sid);
        $uid=$this->PublicModel->getContactAllUid($sIdStr,0);
        $uid = $this->remove_duplicate($uid);
        $userInfo=$this->getOnUserInfo();
        if($ajax_cid==0) {
            for($i=0;$i< count($uid);$i++) {
                if(!empty($userInfo[$uid[$i]['uId']])) {
                    $val .= $userInfo[$uid[$i]['uId']].";";
                }
            }
        }else {
            $val= "<option value=0 style=color:#F00>全部</option>";
            for($i=0;$i< count($uid);$i++) {
                if(!empty($userInfo[$uid[$i]['uId']])) {
                    $val .= "<option value=".$userInfo[$uid[$i]['uId']].">".$userInfo[$uid[$i]['uId']]."</option>";
                }
            }
        }
        echo $val;
    }

   
}

?>
