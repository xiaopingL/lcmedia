<?php
/**
 * @desc 核心模型
 * @author xiaoping <lxp_phper@163.com>
 * @date 2015-07-08
 */
class PublicModel extends CI_Model {

    protected $skip = 0;
    protected $publicSql = array(
            'sqlCountNum' => "select ? from  ? where ?",
            'getChildRole'=> "select comCode,comeName,codeUrl,parent from crm_competence where parent = '?' and isDel = ? order by weight asc,createTime asc",
            'getAllRole'  => "select comCode,comeName,codeUrl,parent from crm_competence where level = '?' and isDel = ? order by weight",
            'getDirectory'=> "select comeName from crm_competence where comCode = '?' and isDel = ?",
            'getUserRole' => "select comCode from crm_user_contact where uId = '?' and type = ? and isDel = ?",
            'getPending'  => "select pNumber,pendingType,urlAdress from crm_pending_contact where proTable = '?' and isDel = ?",
            'getProcess'  => "select processStructrue from crm_process where pNumber = '?' and isDel = ?",
            'getRecord'   => "select rId,node,isSkip,toUid from crm_process_record where proTable = '?' and tableId = ? and isDel = ? and isOver <> 0 order by createTime desc",
            'getSite'     => "select uId from crm_user_site where uId in(?) and siteId in(?) and isDel = ?",
            'getAllOrg'   => "select sId,parentId from crm_structrue where sId in (?) and isDel = ?",
            'getAllOrgSublevel' => "select sId from crm_structrue where parentId in(?) and isDel = 0",
            'getAllUid'   => "select uId,sId from crm_structrue_contact where sId in(?) and isDel = ?",
            'getAppUid'   => "select a.uId from crm_user as a left join crm_structrue_contact as b on a.uId=b.uId where a.uId in(?) and a.isDel=? and a.isDisabled=? and jobId = ?",
            'getAppPend'  => "select a.pendId,a.fromUid,a.toUid,b.jobId from crm_pending as a
            		          left join crm_user as b on a.fromUid = b.uId where a.proTable = '?' and a.tableId = ?",
            'getFollow'   => "select a.rId,a.fromUid,a.toUid,a.processIdea,a.isOver,a.createTime,a.updateTime,b.username as fromName,c.username as toName from crm_process_record as a
            		          left join crm_user as b on a.fromUid = b.uId
            		          left join crm_user as c on a.toUid = c.uId where a.tableId = ? and a.proTable = '?' and a.isDel = ? order by a.createTime asc",
            'getExtension'=> "select uId,sId,level,limits from crm_process_extension where pNumber = '?' and isDel = ?",
            'getSec'      => "select sId from crm_structrue where sId in(?) and level = ? and isDel = ?",
            'proRecord'   => "select isOver from crm_process_record where tableId = ? and proTable = '?' and isDel = ? and fromUid <> toUid order by createTime desc",
            'fromRecord'  => "select isOver from crm_process_record where tableId = ? and proTable = '?' and isDel = ? and fromUid = toUid order by createTime desc",
            'preRecord'   => "select toUid from crm_process_record where tableId = ? and proTable = '?' and isDel = ? and fromUid <> toUid order by createTime asc",
            'getSkip'     => "select a.rId,a.createTime from  crm_process_record as a
            		          left join crm_process_extension as b on a.toUid = b.uId where a.proTable = '?' and a.tableId = '?' and b.pNumber = '?' and a.isDel = 0 and b.isDel = 0",
            'getForword'  => "select rId,toUid from crm_process_record where proTable = '?' and tableId = '?' and createTime < '?' and isDel = 0",
            'getContactAllSid'=>"select a.sId,a.uId,b.name from crm_structrue_contact as a left join crm_structrue as b on a.sId=b.sId where a.uId in (?) and a.isDel=?",
            'getContactAllSiteid'=>"select a.siteId,a.uId,b.name from crm_user_site as a left join crm_site as b on a.siteId=b.siteId where a.uId in (?) and a.isDel=?",
            'provingIsExist' => "select ? from ? where ? = '?' and isDel=0 ",
            'getAppRecord'=> "select rId from crm_process_record where proTable = '?' and tableId = ? and fromUid = ? and toUid = ? and isOver = ? and isDel = ?",
            'customQuery'=>"select ? from ? where ? and isDel=0",
            'getSiteUserInfo'=>"select uId from crm_user_site where siteId in (?) and isDel=0 ",
            'getChild'   => "select sId,name,parentId,level from crm_structrue where parentId = ? and isDel = ? and level<7 order by weight",
            'getAllSid'=>"select pNumber,uId,sId from crm_process_extension  where ?",
            'getFile'=>"select fileName,filePath,origName,fileExt,fileSize from crm_file where fid = '?'",
            'getSidAll'=>"select sId from crm_structrue_contact where uId in(?) and isDel = 0",
    );

    public function exSqlTemplate($template,array $args) {
        $template=str_replace('%','%%',$template);
        $template=str_replace('?','%s',$template);
        $args = $this->db->escape_escape($args);
        $template=vsprintf($template,$args);
        $template=str_replace('%%','%',$template);
        return $template;
    }

    /**
     * @插入方法 xiaoping
     * @param $table  表名
     * @param $result 插入数据（数组形式）
     */
    public function insertSave($table,$result) {
        $this->db->insert($table,$result);
        if($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }else {
            return FALSE;
        }
    }

    /**
     * @更新方法 xiaoping
     * @param $table  表名
     * @param $where  条件（数组形式）
     * @param $result 更新数据（数组形式）
     */
    public function updateSave($table,$where,$result) {
        $this->db->where($where);
        $this->db->update($table,$result);
        if($this->db->affected_rows() > 0) {
            return TRUE;
        }else {
            return FALSE;
        }
    }

    /**
     * @查询方法 xiaoping
     * @param $field  字段
     * @param $table  表名
     * @param $where  条件（数组形式）
     * @param $type   类型 1、单条记录  2、多条记录（默认）  3、记录条数
     * @param $order  排序
     * @param $limit  结果数量
     */
    function selectSave($field,$table,$where='',$type=2,$order,$limit) {
        $this->db->select($field);
        $this->db->from($table);
        if(!empty($where)) {
            $this->db->where($where);
        }
        if(!empty($order)) {
            $this->db->order_by($order);
        }
        if(!empty($limit)) {
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        if($type == 1) {
            $result = $query->row_array();
        }elseif($type == 3) {
            $result = $query->num_rows();
        }else {
            $result = $query->result_array();
        }
        return $result;
    }

    /**
     * @param 对单一表进行信息总数查询
     */
    public function getCount($table,$fileid,$whereArray) {
        $sqlWhere = '';
        if(empty($whereArray)) {
            $where = 1;
        }else {
            foreach($whereArray as $key=>$val) {
                $sqlWhere .= $key."'".$val."'".' and ';
            }
            $where = substr($sqlWhere, 0, -4);
        }
        $query = $this->db->query($this->exSqlTemplate($this->publicSql['sqlCountNum'],array($fileid,$table,$where)));
        return $query->num_rows();
    }

    /**
     * @param 对多表或复杂条件进行信息总数查询
     */
    public function getCounts($modelArray,$whereArray='',$mArray='') {
        $matchStr = '';
        $mArrayNum = 0;
        if(!empty($modelArray['modelPath'])) {
            $Model = $modelArray['modelPath'].'/'.$modelArray['modelName'];
        }else {
            $Model = $modelArray['modelName'];
        }
        $this->load->model($Model,'',true);

        if(!empty($mArray) && !empty($mArray[0]) ) {
            $matchStr = implode(',',$mArray);
        }

        $sqlArray =  $this->$modelArray['modelName']->$modelArray['sqlTplName'];
        $Sql = explode('limit',$sqlArray[$modelArray['sqlTplFucName']]);
        @$query = $this->db->query($this->exSqlTemplate($Sql[0],array($whereArray,$matchStr)));
        return $query->num_rows();
    }
    /**
     * @param 登录系统判断
     */
    public function authenticate() {
        $uId		= $this->session->userdata('uId');
        $userName	= $this->session->userdata('userName');
        $jobId		= $this->session->userdata('jobId');
        if($uId && $userName && $jobId) {
            return TRUE;
        }
        else {
            $sessionData	= array('uId' => '','userName' => '','jobId' => '');
            $this->session->unset_userdata($sessionData);
            redirect('home/index');
        }
    }

    /**
     * @param 获取系统的所有菜单权限代码
     */
    public function getAllRole($isDel) {
        $getResult = $this->db->query($this->exSqlTemplate($this->publicSql['getAllRole'],array(1,$isDel)));
        $allRoleList  = $getResult->result_array();
        foreach($allRoleList as $key=>$value) {
            $getChild = $this->db->query($this->exSqlTemplate($this->publicSql['getChildRole'],array($value['comCode'],$isDel)));
            $allRoleList[$key]['child'] = $getChild->result_array();
        }
        return $allRoleList;
    }

    /**
     * @param 获取用户的菜单权限代码
     */
    public function getUserRole() {
        $uId       = $this->session->userdata('uId');
        $roleId    = $this->session->userdata('roleId');
        $siteId    = $this->session->userdata('siteId');
        $isInherit = $this->session->userdata('isInherit');
        if($isInherit == 0) {
            $getResult = $this->db->query($this->exSqlTemplate($this->publicSql['getUserRole'],array($uId,1,0)));
        }else {
            $getResult = $this->db->query($this->exSqlTemplate($this->publicSql['getUserRole'],array($roleId,0,0)));
        }
        $datas  = conventArr($getResult->result_array(),'comCode');
        //获取公共角色并继承
        $publicRole = $this->db->query($this->exSqlTemplate($this->publicSql['getUserRole'],array(2,0,0)));
        $publicData = conventArr($publicRole->result_array(),'comCode');
        $userRoleList = array_unique(array_merge($datas,$publicData));
        return $userRoleList;
    }
    
    /**
     * @获取用户的操作权限代码
     */
    public function getUserOpera() {
        $uId       = $this->session->userdata('uId');
        $roleId    = $this->session->userdata('roleId');
        $siteId    = $this->session->userdata('siteId');
        $isInherit = $this->session->userdata('isInherit');
        if($isInherit == 0) {
            $getResult = $this->db->query($this->exSqlTemplate($this->publicSql['getUserRole'],array($uId,1,2)));
        }else {
            $getResult = $this->db->query($this->exSqlTemplate($this->publicSql['getUserRole'],array($roleId,0,2)));
        }
        $datas  = conventArr($getResult->result_array(),'comCode');
        //获取公共角色并继承
        $publicRole = $this->db->query($this->exSqlTemplate($this->publicSql['getUserRole'],array(2,0,2)));
        $publicData = conventArr($publicRole->result_array(),'comCode');
        $userOperaList = array_unique(array_merge($datas,$publicData));
        return $userOperaList;
    }

    /**
     * @param 获取当前模块组合名称
     */
    public function getDirectory($inClass,$isDel) {
        $getResult = $this->db->query($this->exSqlTemplate($this->publicSql['getAllRole'],array(2,$isDel)));
        $dirList   = $getResult->result_array();
        $dirName = $parent = '';
        foreach($dirList as $value) {
            $url_arr = explode('/',$value['codeUrl']);
            if($url_arr[2] == $inClass) {
                $dirName = $value['comeName'];
                $parent  = $value['parent'];
            }
        }
        if($dirName && $parent) {
            $result = $this->db->query($this->exSqlTemplate($this->publicSql['getDirectory'],array($parent,$isDel)));
            $data   = $result->row_array();
            $message = $data['comeName']."--".$dirName;
            return $message;
        }else {
            return NULL;
        }
    }

    /**
     * @发起一个流程 xiaoping
     * @param $table  主表表名
     * @param $signal 主表ID
     * @param $flag   状态  1.创建  2.流转
     * @param $type   是否走扩展节点      0.不走  1.走
     * @param $app_type 流转审批处理结果  0.未处理  1.已处理  2.已拒绝
     * @param $app_con 审批意见
     * @param $flowid 流程记录表主键
     * @param $limit  审批额度
     * @param $extension  多流程扩展  jobId.岗位级别判断 条件数量判断 1,2,3
     */
    public function controlProcess($table,$signal,$flag,$type=0,$app_type=1,$app_con='',$flowid='',$limit='',$extension='') {
        $this->load->model('admin/UserModel');
        $CI = & get_instance();
        $fromUid = $this->session->userdata('uId');
        $jobId   = $this->session->userdata('jobId');
        $siteId  = $this->session->userdata('siteId');
        $usersId = $this->session->userdata('sId');

        $amount  = $position = $approve = $limits = $extenFlag = $managerFlag = 0;

        $getPending = $this->db->query($this->exSqlTemplate($this->publicSql['getPending'],array($table,0)));
        $pendingList = $getPending->row_array();
        if(empty($pendingList)) {
            die('The pending does not exist');
        }

        if($flag == 2) {
            $getFromUid = $this->db->query($this->exSqlTemplate($this->publicSql['getAppPend'],array($table,$signal)));
            $fromUidList = $getFromUid->row_array();
            $siteId = implode(',',conventArr($CI->UserModel->getUserSite($fromUidList['fromUid'],0),'siteId'));
            $orgId  = conventArr($CI->UserModel->getUserOrg($fromUidList['fromUid'],0),'sId');
            $fromJobId = conventArr($CI->UserModel->getUserInfo($fromUidList['fromUid']),'jobId');
        }
        
        if(!empty($extension)) {
            $pNumber_arr = json_decode($pendingList['pNumber'],true);
            if($extension == 'jobId') {
                $job_uid = ($flag == 1)?$jobId:$fromUidList['jobId'];
                $job_uid = ($job_uid == 4)?5:$job_uid;                               //员工、主管划分为一组
                $job_uid = ($job_uid == 2)?3:$job_uid;                               //经理、总监划分为一组
                foreach($pNumber_arr as $val) {
                    if($val['jobId'] == $job_uid) {
                        $pNumber = $val['number'];
                    }
                }
            }elseif(is_numeric($extension)) {
                foreach($pNumber_arr as $value) {
                    if($value['numType'] == $extension) {
                        $pNumber = $value['number'];                                // 3.条件数量三  2.条件数量二  1.条件数量一
                    }
                }
            }
        }else {
            $pNumber = $pendingList['pNumber'];
        }
        
        $getProcess =  $this->db->query($this->exSqlTemplate($this->publicSql['getProcess'],array($pNumber,0)));
        $processList = $getProcess->row_array();
        //判断是否存在流转结构
        if(empty($processList)) {
            die('The process does not exist');
        }
        
        if($flag == 2) {
            $this->updateFlow($table,$signal,$app_type,$app_con,$flowid);
        }
        
        $pro_arr = json_decode($processList['processStructrue'],true);
        
        $getRecord = $this->db->query($this->exSqlTemplate($this->publicSql['getRecord'],array($table,$signal,0)));
        $processRecord = $getRecord->row_array();                               //获取数据  一维数组取的是最后一条数据
        $processCount  = $getRecord->num_rows();                                //获取总的审批次数
        
        $recordCount = (!empty($processRecord))?($processCount+$processRecord['node']):$processCount;

        $extension = $this->db->query($this->exSqlTemplate($this->publicSql['getExtension'],array($pNumber,0)));
        $extenList = $extension->result_array();
        //判断是否有待处理事项提醒 crm_pending  不存在传发起人sId 存在
        if(empty($fromUidList)) {
            $fromSid = $usersId;
        }else {
            $fromSid = implode(',',$orgId);
        }
        $sid = $this->getSecStrutrue($fromSid,3);

        //统计流程流转结构 大于1 并且是流转
        if(count($pro_arr)>1 && $flag == 2) {
            $record  = $this->db->query($this->exSqlTemplate($this->publicSql['preRecord'],array($signal,$table,0)));
            $recordList = $record->row_array();
            if($fromJobId[0] <= $pro_arr[1]['level'] && $pro_arr[0]['sid'] == 0 && $pro_arr[1]['level'] == 3) {
                $recordCount += 1;
                $managerFlag = 1;
                //判断是否走扩展节点  并且 一级审批之前
                if(!empty($type) && $extenList[0]['level'] == 1) {
                    $extenUid = conventArr($extenList,'uId');
                    if(!in_array($recordList['toUid'],$extenUid) && !in_array($fromUidList['fromUid'],$extenUid)) {
                        $recordCount -= 1;
                        $managerFlag = 0;
                    }
                }
            }
        }

        if(!empty($type)) {
            //处理流程扩展节点
            if(empty($extenList))  die('The extension does not exist');
            foreach($extenList as $k=>$v) {
                if(!empty($v['sId'])) {
                    $extenSidArr[] = $v['sId'];
                }
            }

            foreach($extenList as $key=>$val) {
                //判断扩展节点组织架构是否存在
                if(!empty($val['sId'])) {
                    //查找发起人同一组织架构
                    if($val['sId'] == $sid) {
                        $approve  = $val['uId'];
                        $position = $val['level'];
                        $limits   = $val['limits'];
                    }
                }else {
                    //查找除分管审批组织架构的所有
                    if(!in_array($sid,$extenSidArr)) {
                        $approve  = $val['uId'];
                        $position = $val['level'];
                        $limits   = $val['limits'];
                    }
                }
            }
          
            if(!empty($approve) && $recordCount>$position) {
                $skipResult = $this->db->query($this->exSqlTemplate($this->publicSql['getSkip'],array($table,$signal,$pNumber)));
                $skipList   = $skipResult->row_array();
                if(!empty($skipList)) {
                    $forwordResult = $this->db->query($this->exSqlTemplate($this->publicSql['getForword'],array($table,$signal,$skipList['createTime'])));
                    $forwordList   = $forwordResult->result_array();
                    $forwordNum    = $forwordResult->num_rows();
                     
                    if($managerFlag == 1) $forwordNum += 1;
                    if($position == $forwordNum) {
                        $recordCount -= 1;
                    }
                }
                $approve   = 0;
                $extenFlag = 1;                                                 //走完扩展节点标志
            }
        }

        if($recordCount<count($pro_arr)-1) {
            $level = $pro_arr[$recordCount+1]['level'];
            if($level == 5) {
                if(!empty($pro_arr[$recordCount+1]['name'])) {
                    //如果该流程指定岗位级别是员工,并且存在具体用户id
                    $toUid = $pro_arr[$recordCount+1]['name'];
                }else {
                    //主表中指定了该员工的id，字段approve
                    $fieldArr = $this->db->list_fields($table);
                    $fieldKey = $fieldArr[0];
                    $getApproveInfo = $this->customQuery("approve",$table,"$fieldKey = $signal");
                    $toUid = $getApproveInfo[0]['approve'];
                }
            }else {
            	$toUidArr = $this->skipProcess($pro_arr,$recordCount,$fromUid,$siteId,$jobId,'',1,$table,$signal,$type,$sid,$extenList);
                $toUid = $toUidArr['uId'];
            }

            if($flag == 1 && !empty($type) && $toUid == $fromUid && $recordCount==0) {
                //$recordCount = $toUidArr['recordCount'];                        //发起跳过总经理，下一步走扩展节点
            }
        }elseif($recordCount>=count($pro_arr)) {
            $toUid = '';
        }else {
            $toUid = ($flag == 2)?$fromUidList['fromUid']:$fromUid;             //发起人确认结束
        }
        
        if(!empty($type) && $approve && $position == $recordCount && $approve != $fromUid)  $toUid = $approve;           //走扩展节点
        if($flag == 2 && $recordCount<count($pro_arr) && isset($limit) && $recordCount>0) {                              //审批限额
            if(!empty($limits) && $position <= $recordCount && $extenFlag == 1) {
                $amount = $limits;
            }elseif(!empty($pro_arr[$recordCount-1]['price'])) {
                $amount = $pro_arr[$recordCount-1]['price'];
            }
        }
        if($flag == 2 && $fromUid == $fromUidList['fromUid'] && empty($level))  $toUid = '';
        //流转 跳过节点
        if((!empty($amount) && $limit<=$amount && $flag == 2) || (!empty($processRecord) && $processRecord['isSkip'] == 1)) {
            //在审批额度内做特殊处理
            if($recordCount < count($pro_arr)-1) {
                //获取审批人
                $uidArr = $this->skipProcess($pro_arr,$recordCount,$fromUid,$siteId,$jobId,$fromUidList['fromUid'],2,$table,$signal,$type,$sid,$extenList);
                $skipWhere = array('proTable'=>$table,'tableId'=>$signal,'isDel'=>0);
                //跳过节点数 skip
                $nodeStr = (!empty($processRecord))?($uidArr['skip']+$processRecord['node']):$uidArr['skip'];
                $this->updateSave('crm_process_record',$skipWhere,array('node'=>$nodeStr,'isSkip'=>1));
                $toUid = $uidArr['uId'];
            }
        }

        if($toUid && $app_type == 1) {
            //插入流程流转记录详情表
            $process = $this->processFlow($toUid,$table,$signal,$flag);
            //插入到系统弹窗提示
            if($flag == 1 || $flag == 2 && $fromUidList['fromUid'] != $toUid) {
                $originator = ($flag==1)?$fromUid:$fromUidList['fromUid'];
                //系统提示弹框信息   crm_pms
                //$this->inMsgInfo($originator,$toUid,'process',$pendingList['pendingType'],$pendingList['urlAdress'],$signal);
            }
        }
        if($flag == 2) {
            //流转更新待处理事项信息
            $where = array(
                    'tableId'         => $signal,
                    'proTable'        => $table,
                    'toUid'           => $fromUid
            );
            //返回审批状态
            $processState = $this->processState($signal,$table);
            //更新主表审批状态
            $fieldArr = $this->db->list_fields($table);                         //获取主表的主键
            $fieldKey = $fieldArr[0];                                           //更新主表状态
            if($processState['status'] == 1) {
                $this->updateSave($table,array($fieldKey=>$signal),array('state'=>1));
            }elseif($processState['status'] == 2) {
                $this->updateSave($table,array($fieldKey=>$signal),array('state'=>2));
            }

            if(($app_type == 1 && $fromUid == $fromUidList['fromUid'] && $processState['status'] == 1) || $app_type == 2) {
                $this->updateSave('crm_pending',$where,array('status'=>1));
            }
        }
    }
    /*
     * @ $pro_arr           流程流转结构
     * @ $recordCount       流转节点数
     * @ $fromUid           流程审批接收人UID
     * @ $siteId            站点ID
     * @ $jobId             岗位级别ID
     * @ $applicant         审批人
     * @ 状态显示            1,2
     * @ $table             表名
     * @ $signal            审批流程表主键ID
     * @ $type              是否走扩展节点      0.不走  1.走
     * @ $sid               组织架构ID
     * @ $extenList         获取单流程扩展信息
    */
    public function skipProcess($pro_arr,$recordCount,$fromUid,$siteId,$jobId,$applicant,$flag,$table,$signal,$type,$sid,$extenList) {
        $level = $pro_arr[$recordCount+1]['level'];   //岗位级别
        if($pro_arr[$recordCount]['sid'] == 0) {
            //本部门组织提交
            $orgArr = array_unique(array_multi2single(array()));
            //通过组织架构获取uId
            $uidResult = $this->db->query($this->exSqlTemplate($this->publicSql['getAllUid'],array(implode(',',$orgArr),0)));
            $uidArr = array_unique(conventArr($uidResult->result_array(),'uId'));
            foreach($uidArr as $key=>$val) {
                if($val == $fromUid)  unset($uidArr[$key]);                      //去掉发起人
            }
            if(empty($uidArr))  die('The toUid does not exist');                               //判断流程发起人是否存在
            $siteResult = $this->db->query($this->exSqlTemplate($this->publicSql['getSite'],array(implode(',',$uidArr),$siteId,0)));
            $siteArr  = array_unique(conventArr($siteResult->result_array(),'uId'));           //匹配发起人所属站点
            $sidResult = $this->db->query($this->exSqlTemplate($this->publicSql['getSidAll'],array(implode(',',$siteArr),0)));
            $toUidArr = $this->getUserLevel(implode(',',$siteArr),$level,$jobId,1);
        }else {
            //跨部门提交
            $orgArr = $this->getAllOrg($array=array(),$pro_arr[$recordCount]['sid'],0);
            $uidResult = $this->db->query($this->exSqlTemplate($this->publicSql['getAllUid'],array(implode(',',$orgArr),0)));
            $resultStr = $uidResult->result_array();
            $uidArr = array_unique(conventArr($resultStr,'uId'));
            if(empty($uidArr))  die('The toUid does not exist');
            $toUidArr = $this->getUserLevel(implode(',',$uidArr),$level,$jobId,2);
        }
        $toUidArr['skip'] = $this->skip;
        if(!empty($type)) {
            //处理流程扩展节点
            if(empty($extenList))  die('The extension does not exist');
            foreach($extenList as $k=>$v) {
                if(!empty($v['sId'])) {
                    $extenSidArr[] = $v['sId'];
                }
            }

            foreach($extenList as $key=>$val) {
                if(!empty($val['sId'])) {
                    //查找发起人同一组织架构
                    if($val['sId'] == $sid) {
                        $approve  = $val['uId'];
                        $position = $val['level'];
                        $limits   = $val['limits'];
                    }
                }else {
                    //查找除分管审批组织架构的所有
                    if(!in_array($sid,$extenSidArr)) {
                        $approve  = $val['uId'];
                        $position = $val['level'];
                        $limits   = $val['limits'];
                    }
                }
            }
        }

        if($level == 5) {
            if(!empty($pro_arr[$recordCount+1]['name'])) {
                //如果该流程指定岗位级别是员工,并且存在具体用户id
                $toUidArr['uId'] = $pro_arr[$recordCount+1]['name'];
            }else {
                //主表中指定了该员工的id，字段approve
                $fieldArr = $this->db->list_fields($table);
                $fieldKey = $fieldArr[0];
                $getApproveInfo = $this->customQuery("approve",$table,"$fieldKey = $signal");
                $toUidArr['uId'] = $getApproveInfo[0]['approve'];
            }
        }
        if(!empty($type) && $approve && $position == $recordCount && $approve != $fromUid)  $toUidArr['uId'] = $approve;           //走扩展节点

        $this->load->model('admin/UserModel');
        $CI = & get_instance();

        if($recordCount == 0 && in_array($level,array(3,4)) && $flag == 1) {
            if($level==$jobId && $jobId==3 && $pro_arr[0]['sid']==0) {
                //过滤岗位级别为总经理的uId
                $new_recordCount = $recordCount+1;
                $newUidArr = $this->skipProcess($pro_arr,$new_recordCount,$fromUid,$siteId,$jobId,$applicant,$flag,$table,$signal,$type,$sid,$extenList);
                $toUidArr = $newUidArr;
                $toUidArr['recordCount'] = $new_recordCount;
            }
        }elseif($flag == 2) {
            //不超过审批额度，跳过上级领导审批，同时记录跳过的节点数
        	$new_recordCount = $recordCount+1;
        	$this->skip += 1;
        	if($new_recordCount < count($pro_arr)-1) {
        		$newUidArr = $this->skipProcess($pro_arr,$new_recordCount,$fromUid,$siteId,$jobId,$applicant,$flag,$table,$signal,$type,$sid,$extenList);
        		$toUidArr = $newUidArr;
        	}else {
        		$toUidArr['uId'] = $applicant;
        	}
        }
        return $toUidArr;
    }
    /*
     * $toUid       接收人
     * $table       表名
     * $signal      主键ID
     * $flag        状态  1.创建  2.流转
     */
    public function processFlow($toUid,$table,$signal,$flag) {
        $getResult = $this->db->query($this->exSqlTemplate($this->publicSql['getAppPend'],array($table,$signal)));
        $pendingList = $getResult->row_array();
        if(!empty($pendingList)) {
            $fromUid = $pendingList['fromUid'];
        }else {
            $fromUid = $this->session->userdata('uId');
        }
        //插入到流转记录
        $p_data	= array(
                'proTable'		=> $table,
                'tableId'	    => $signal,
                'fromUid'		=> $fromUid,
                'toUid'	        => $toUid,
                'createTime'	=> time()
        );
        //查询该记录是否 存在  不存在  插入流程审批记录
        $recordList = $this->db->query($this->exSqlTemplate($this->publicSql['getAppRecord'],array($table,$signal,$fromUid,$toUid,0,0)));
        $recordData = $recordList->row_array();
        if(empty($recordData)) {
            $this->db->insert('crm_process_record',$p_data);
        }

        //处理待处理事项
        $pro_data	= array(
                'tableId'	   => $signal,
                'proTable'	   => $table,
                'fromUid'	   => $fromUid,
                'toUid'	       => $toUid,
                'createTime'   => time()
        );
        if($flag == 1) {
            $this->insertSave('crm_pending',$pro_data);
        }else {
            $this->updateSave('crm_pending',array('tableId'=>$signal,'proTable'=>$table),array('toUid'=>$toUid));
        }
    }
    /*
     *  $table          表名
     *  $editid         主键ID
     *  $app_type       审批类型  1同意  2拒绝
     *  $app_con        审批意见
     *  $flowid         主键ID
     */
    function updateFlow($table,$editid,$app_type,$app_con,$flowid) {
        //修改流转人信息
        $result = array(
                'processIdea'	  => $app_con,
                'isOver'		  => $app_type,
                'updateTime'	  => time(),
        );
        $this->updateSave('crm_process_record',array('rId'=>$flowid),$result);
    }

    /**
     * @获取下一级审批人id
     * @param $uid_str 同一组织架构审批人ID
     * @param $level   下一集审批人岗位级别
     * @param $jobId   发起人岗位级别
     */
    public function getUserLevel($uid_str,$level,$jobId,$flag) {
        if(!empty($level)) {
            if($level>$jobId && $flag == 1)  $level = $jobId-1;          //查找岗位级别大于申请人的
            if($level <= 0) $level = 1;
            if(empty($uid_str))  die('The uid does not exist');
            $toResult = $this->db->query($this->exSqlTemplate($this->publicSql['getAppUid'],array($uid_str,0,0,$level)));
            $toUidArr = $toResult->result_array();
            if(empty($toUidArr)) {
                $now_level = $level-1;
                $newUid = ($now_level>0)?$this->getUserLevel($uid_str,$now_level,$jobId,$flag):'';
                $toUid = $newUid;
            }else {
                $toUidFiter = conventArr($toUidArr,'uId');
                $toUid = array('uId'=>$toUidFiter[0]);
            }
        }else {
            $toUid['uId'] = $this->session->userdata('uId');
        }
        return $toUid;
    }

    /**
     * @param 获取相关联的组织架构  向上查找
     */
    public function getAllOrg(&$arrayList,$parentId,$isDel) {
        $getResult =  $this->db->query($this->exSqlTemplate($this->publicSql['getAllOrg'],array($parentId,0)));
        $orgList = $getResult->result_array();
        if(!empty($orgList)) {
            foreach($orgList as $value) {
                $arrayList[] = $value['sId'];
                $this->getAllOrg($arrayList,$value['parentId'],0);
            }
        }
        return array_unique($arrayList);
    }


    /**
     * @param 获取相关联的组织架构  向下查找
     */
    public function getAllOrgSublevel(&$arrayList,$parentId,$isDel) {
        $getResult =  $this->db->query($this->exSqlTemplate($this->publicSql['getAllOrgSublevel'],array($parentId,$isDel)));
        $orgList = $getResult->result_array();
        /*针对地市分站拆分 做节点处理 开始*/
        $parentArr = explode(',',$parentId);
        foreach($parentArr as $val) {
            if(!in_array($val,$arrayList)) {
                $arrayList[] = $val;
            }
        }
        /*针对地市分站拆分 做节点处理 结束*/
        if(!empty($orgList)) {
            foreach($orgList as $value) {
                $arrayList[] = $value['sId'];
                $this->getAllOrgSublevel($arrayList,$value['sId'],0);
            }
        }
        return $arrayList;
    }


    /**
     * @param 获取处理事项详情
     */
    public function getFlowList($editid,$table) {
        $getResult =  $this->db->query($this->exSqlTemplate($this->publicSql['getFollow'],array($editid,$table,0)));
        $data = $getResult->result_array();
        $processState = $this->processState($editid,$table);
        foreach($data as $key=>$val) {
            $data[$key]['status'] = $processState['status'];
            if($val['processIdea'] == null) {
                $data[$key]['processIdea'] = '';
            }
        }
        return $data;
    }

    /**
     * @param 获取用户组织架构
     */
    public function getSecStrutrue($sid,$level) {
        $sidArr = $orgArr = array();
        $strutrue = explode(',',$sid);
        foreach($strutrue as $value) {
            $sidArr[] = $this->getAllOrg($array=array(),$value,0);
        }
        $orgArr = array_unique(array_multi2single($sidArr));
        $getResult = $this->db->query($this->exSqlTemplate($this->publicSql['getSec'],array(implode(',',$orgArr),$level,0)));
        $data = $getResult->row_array();
        return $data['sId'];
    }

    /**
     * @param 获取审批状态
     */
    public function processState($editid,$table) {
        $data = array();
        $record     = $this->db->query($this->exSqlTemplate($this->publicSql['proRecord'],array($editid,$table,0)));
        $recordList = $record->row_array();
        $fromRecord = $this->db->query($this->exSqlTemplate($this->publicSql['fromRecord'],array($editid,$table,0)));
        $fromRecordList = $fromRecord->row_array();
        $data['status'] = (!empty($recordList))?$recordList['isOver']:0;
        switch($data['status']) {
            //处理状态
            case '0':
                if($fromRecordList['isOver'] == 2 && empty($recordList)) {
                    $data['info'] = '<font color=red>申请失败</font>';
                    $data['status'] = 2;
                }elseif($fromRecordList['isOver'] == 1 && empty($recordList)) {
                    $data['info']   = '<font color=green>申请成功</font>';
                    $data['status'] = 1;
                }else {
                    $data['info'] = '<font color=0066FF>审批中</font>';
                }
                break;
            case '1':
                if($fromRecordList['isOver'] == 2) {
                    $data['info'] = '<font color=red>申请失败</font>';
                    $data['status'] = 2;
                }else{
                    $data['info'] = '<font color=green>申请成功</font>';
                }
                break;
            case '2':
                $data['info'] = '<font color=red>申请失败</font>';
                break;
        }
        return $data;
    }

    /**
     * @param 通过组织架构SID获取员工UID
     */
    public function getContactAllUid($sId,$isDel) {
        $query  = $this->db->query($this->exSqlTemplate($this->publicSql['getAllUid'],array($sId,$isDel)));
        $contractAllUid = $query->result_array();
        return $contractAllUid;
    }

    /**
     * @param 通过员工UID 获取SID
     */
    public function getContactAllSid($uId,$isDel) {
        $getResult  = $this->db->query($this->exSqlTemplate($this->publicSql['getContactAllSid'],array($uId,$isDel)));
        $contractAllList = $getResult->result_array();
        return $contractAllList;
    }

    /**
     * @param 通过员工UID 获取站点siteId
     */
    public function getContactAllSiteid($uId,$isDel) {
        $query  = $this->db->query($this->exSqlTemplate($this->publicSql['getContactAllSiteid'],array($uId,$isDel)));
        return $query->result_array();
    }

    /**
     * @param 获取申请信息
     */
    public function getProDirectory($fromName,$fromUid,$createTime) {
        $getUserInfo = $this->customQuery('jobId','crm_user','uId ='.$fromUid);
        $directory = "[姓名：".$fromName;
        $directory .= "]&nbsp;&nbsp;&nbsp;[部门：".implode(',',conventArr($this->getContactAllSid($fromUid,0),'name'));
        if($getUserInfo[0]['jobId'] > 2) {
            //经理以下级别显示所属站点
            $directory .= "]&nbsp;&nbsp;&nbsp;[站点：".implode(',',conventArr($this->getContactAllSiteid($fromUid,0),'name'));
        }
        $directory .= "]&nbsp;&nbsp;&nbsp;[时间：".date('Y-m-d H:i:s',$createTime)."]";
        return $directory;
    }

    /**
     * @param 数据状态验证
     * @param $tableName 表名称
     * @param $index 查询表字段 表主键/索引
     * @param $fileid 匹配表字段
     * @param $inputValue 查询数据值
     */
    public function provingIsExist($tableName,$index,$fileId,$inputValue) {
        $query = $this->db->query($this->exSqlTemplate($this->publicSql['provingIsExist'],array($index,$tableName,$fileId,$inputValue)));
        return $query->row_array();
    }

    /**
     * @param 自定义条件查询
     */
    public function customQuery($filed,$tableName,$whereStr) {
        $query = $this->db->query($this->exSqlTemplate($this->publicSql['customQuery'],array($filed,$tableName,$whereStr)));
        return $query->result_array();
    }

    /**
     * @param 获取同站点下的所有员工
     */
    public function getSiteUserInfo($siteId) {
        $getResult = $this->db->query($this->exSqlTemplate($this->publicSql['getSiteUserInfo'],array($siteId)));
        $siteUserList[$siteId] = $getResult->result_array();
        return $siteUserList[$siteId];
    }

    /**
     * @param 新增审批弹窗提示
     */
    public function inMsgInfo($originator,$toUid,$type,$pendingType,$urlAdress,$signal) {
        $getUserInfo = $this->customQuery('userName','crm_user','uId ='.$originator);
        $result = array(
                'msgtouid'     => $toUid,
                'folder'       => $type,
                'subject'      => $getUserInfo[0]['userName']." 向您提交了【".$pendingType."】，等待您的处理。",
                'createTime'   => time(),
                'msgUrl'       => site_url($urlAdress.'/'.$signal)
        );
        $this->insertSave('crm_pms',$result);
    }

    /**
     * @param 获取所有部门 xiaoping
     */
    public function getDepList(&$arrayList,$parentId,$isDel) {
        $getResult = $this->db->query($this->exSqlTemplate($this->publicSql['getChild'],array($parentId,$isDel)));
        $orgList   = $getResult->result_array();
        for($i=0;$i<count($orgList);$i++) {
            $arrayList[] = $orgList[$i];
            $this->getDepList($arrayList,$orgList[$i]['sId'],0);
        }
        return $arrayList;
    }

    /**
     * @获取单流程指定员工的ID
     * @param $table 表名
     */
    public function getProInfo($table,$level=1) {
        if(empty($table))  die('缺少表名');
        $getPending = $this->db->query($this->exSqlTemplate($this->publicSql['getPending'],array($table,0)));
        $pendingList = $getPending->row_array();
        $getProcess =  $this->db->query($this->exSqlTemplate($this->publicSql['getProcess'],array($pendingList['pNumber'],0)));
        $processList = $getProcess->row_array();
        $pro_arr = json_decode($processList['processStructrue'],true);
        return $pro_arr[count($pro_arr)-$level]['name'];
    }

    /**
     * @获取单流程扩展审批人的ID
     * @param $table 表名
     * @param $uId   用户ID
     */
    public function getInfo($table,$uId) {
        if(empty($table))  die('缺少表名');
        $getPending = $this->db->query($this->exSqlTemplate($this->publicSql['getPending'],array($table,0)));
        $pendingList = $getPending->row_array();
        $sId = $this->getContactAllSid($uId,0);
        if(empty($sId[0]['sId'])) {
            return '';
        }else {
            foreach($sId as $k=>$v) {
                $array[]=$v['sId'];
            }

            $sId = $this->getSecStrutrue(implode(',',$array),3);
            if(!empty($sId)) {
                $sIds = $sId;
            }else {
                $sIds = 0;
            }
            $whereStr="pNumber=".$pendingList['pNumber']." and sId =".$sIds;
            $approveList = $this->db->query($this->exSqlTemplate($this->publicSql['getAllSid'],array($whereStr)));
            $approve = $approveList->row_array();
            if(!empty($approve)) {
                return $approve['uId'];
            }else {
                $whereStr="pNumber=".$pendingList['pNumber']." and sId = 0";
                $approveList = $this->db->query($this->exSqlTemplate($this->publicSql['getAllSid'],array($whereStr)));
                $approve = $approveList->row_array();
                return $approve['uId'];
            }
        }
    }

    /**
     * @特殊的一级审批流程，发起人不确认
     * @param $table  主表表名
     * @param $signal 主表ID
     * @param $toUid  接收人uId
     * @param $app_con 审批意见
     * @param $flag   状态  1.创建  2.确认
     */
    public function singleProcess($table,$signal,$toUid,$app_con='',$flag) {
        if($flag == 1) {
            //新增待处理事项
            $pro_data = array(
                    'tableId'	   => $signal,
                    'proTable'   => $table,
                    'fromUid'	   => $this->session->userdata('uId'),
                    'toUid'	   => $toUid,
                    'createTime' => time()
            );
            $this->insertSave('crm_pending',$pro_data);

            //插入到流转记录
            $p_data	= array(
                    'proTable'   => $table,
                    'tableId'	   => $signal,
                    'fromUid'	   => $this->session->userdata('uId'),
                    'toUid'	   => $toUid,
                    'createTime' => time()
            );
            $this->insertSave('crm_process_record',$p_data);
        }else {
            //更新待处理事项
            $this->updateSave('crm_pending',array('tableId'=>$signal,'proTable'=>$table),array('status'=>1));
            //更新审核详情
            $result = array(
                    'isOver'      => 1,
                    'updateTime'  => time(),
                    'processIdea' => $app_con
            );
            $this->updateSave('crm_process_record',array('tableId'=>$signal,'proTable'=>$table),$result);
            //更新主表审批状态
            $fieldArr = $this->db->list_fields($table);              //获取主表的主键
            $fieldKey = $fieldArr[0];
            $this->updateSave($table,array($fieldKey=>$signal),array('state'=>1));
        }
    }

    /**
     * @获取附件信息 xiaoping
     */
    function getFile($fid) {
        $query = $this->db->query($this->exSqlTemplate($this->publicSql['getFile'],array($fid)));
        return $query->row_array();
    }


}
?>
