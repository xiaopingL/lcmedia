-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-01-05 03:15:33
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lcmedia`
--

-- --------------------------------------------------------

--
-- 表的结构 `crm_ad_position`
--

CREATE TABLE IF NOT EXISTS `crm_ad_position` (
  `sId` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `contractId` int(10) NOT NULL COMMENT '合同ID',
  `ad_type` tinyint(1) NOT NULL COMMENT '广告形式',
  `ad_other` varchar(30) DEFAULT NULL COMMENT '其他',
  `pay_type` tinyint(1) NOT NULL COMMENT '支付形式',
  `content` text COMMENT '影城信息',
  `remark` varchar(400) DEFAULT NULL COMMENT '备注',
  `operator` smallint(4) NOT NULL COMMENT '创建人',
  `createTime` int(10) NOT NULL COMMENT '创建时间',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审批状态',
  `isDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`sId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='阵地广告执行单' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `crm_ad_position`
--

INSERT INTO `crm_ad_position` (`sId`, `contractId`, `ad_type`, `ad_other`, `pay_type`, `content`, `remark`, `operator`, `createTime`, `state`, `isDel`) VALUES
(1, 1, 9, '大屏', 1, '1##2015-12-30##2016-01-06##1||2##2016-01-07##2016-01-20##2||', '11111111111111', 2, 1451372235, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_ad_show`
--

CREATE TABLE IF NOT EXISTS `crm_ad_show` (
  `sId` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `contractId` int(10) NOT NULL COMMENT '合同ID',
  `duration` varchar(30) NOT NULL COMMENT '广告片时长',
  `content` text COMMENT '影院信息',
  `supplier` varchar(400) DEFAULT NULL COMMENT '广告片提供方',
  `position` varchar(400) DEFAULT NULL COMMENT '位置要求',
  `monitor` varchar(400) DEFAULT NULL COMMENT '监播要求',
  `operator` smallint(4) NOT NULL COMMENT '创建人',
  `createTime` int(10) NOT NULL COMMENT '创建时间',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审批状态',
  `isDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`sId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='映前广告执行单' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `crm_ad_show`
--

INSERT INTO `crm_ad_show` (`sId`, `contractId`, `duration`, `content`, `supplier`, `position`, `monitor`, `operator`, `createTime`, `state`, `isDel`) VALUES
(1, 1, '4分钟', '1##2015-12-29##2016-01-05##1||', '金鱼传媒', '位置要求11111', '监播要求11111', 2, 1451292749, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_billing`
--

CREATE TABLE IF NOT EXISTS `crm_billing` (
  `billingId` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `contractId` int(10) NOT NULL COMMENT '合同ID',
  `class` tinyint(1) NOT NULL COMMENT '分类',
  `type` tinyint(1) NOT NULL COMMENT '发票性质',
  `ourCompany` tinyint(1) NOT NULL COMMENT '我方开票公司',
  `cate` tinyint(1) NOT NULL COMMENT '发票类型',
  `company` varchar(100) NOT NULL COMMENT '客户开票名称',
  `money` varchar(100) NOT NULL COMMENT '开票金额',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `billingDate` int(10) DEFAULT '0' COMMENT '开票时间',
  `number` varchar(80) DEFAULT NULL COMMENT '发票编码',
  `operator` smallint(4) NOT NULL COMMENT '申请人',
  `createTime` int(10) NOT NULL COMMENT '创建时间',
  `state` tinyint(1) NOT NULL COMMENT '审批状态',
  `isDel` tinyint(1) NOT NULL COMMENT '是否删除',
  PRIMARY KEY (`billingId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='发票管理表' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `crm_billing`
--

INSERT INTO `crm_billing` (`billingId`, `contractId`, `class`, `type`, `ourCompany`, `cate`, `company`, `money`, `remark`, `billingDate`, `number`, `operator`, `createTime`, `state`, `isDel`) VALUES
(1, 1, 1, 2, 0, 0, '合肥华润影城有限公司', '2500', '财务尽快', 1448553600, 'FP2015-001', 2, 1446279911, 1, 0),
(2, 1, 1, 2, 0, 0, '合肥华润影城有限公司', '800', '无', 1450108800, '20168521', 2, 1450168859, 1, 0),
(3, 1, 1, 1, 0, 0, '合肥华润影城有限公司', '1000', '无', 0, NULL, 2, 1450662327, 0, 1),
(4, 1, 1, 3, 1, 2, '合肥华润影城有限公司', '1000', '无', 0, NULL, 2, 1450662494, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_client`
--

CREATE TABLE IF NOT EXISTS `crm_client` (
  `cId` int(11) NOT NULL AUTO_INCREMENT COMMENT '客户编号，唯一，自增',
  `name` varchar(100) NOT NULL COMMENT '客户名称',
  `proname` varchar(60) DEFAULT NULL COMMENT '项目名称',
  `industry` tinyint(1) DEFAULT '0' COMMENT '所属行业',
  `source` tinyint(2) DEFAULT '1' COMMENT '客户来源',
  `siteId` tinyint(8) DEFAULT '1' COMMENT '站点id',
  `level` char(1) DEFAULT NULL COMMENT '客户级别',
  `phone` varchar(20) DEFAULT NULL COMMENT '电话',
  `dockName` varchar(30) DEFAULT NULL COMMENT '对接人',
  `position` varchar(30) DEFAULT NULL COMMENT '职务',
  `address` varchar(100) DEFAULT NULL COMMENT '客户地址',
  `isStop` tinyint(1) DEFAULT '0' COMMENT '是否停用,默认不停用',
  `createTime` int(10) DEFAULT NULL COMMENT '创建时间',
  `operator` int(11) DEFAULT NULL COMMENT '最后操作人用户id',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态：0、正常1、转交中',
  `isDel` tinyint(1) DEFAULT '0' COMMENT '是否删除,默认不删除',
  PRIMARY KEY (`cId`),
  KEY `operator` (`operator`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `crm_client`
--

INSERT INTO `crm_client` (`cId`, `name`, `proname`, `industry`, `source`, `siteId`, `level`, `phone`, `dockName`, `position`, `address`, `isStop`, `createTime`, `operator`, `status`, `isDel`) VALUES
(1, '中环城影城', '合肥中环', 5, 1, 1, 'A', '0551-62345678', NULL, NULL, '合肥市西城区金融大街25号', 0, 1444725389, 1, 0, 0),
(3, '华润影城', '华润置地', 7, 3, 1, 'A', '0551-62345678', '张勇', '经理', '北京市西城区金融大街25号', 0, 1444802393, 2, 0, 0),
(4, '合肥乐富强地产有限公司', '御景城', 1, 2, 1, 'A', '13855552145', '周建', '策划经理', '政务区', 0, 1449627188, 2, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_client_relation`
--

CREATE TABLE IF NOT EXISTS `crm_client_relation` (
  `relationId` int(11) NOT NULL AUTO_INCREMENT,
  `cId` int(11) NOT NULL COMMENT '客户编号',
  `salesmanId` int(11) NOT NULL COMMENT '业务员id',
  `startDate` int(10) DEFAULT NULL COMMENT '服务开始日期',
  `endDate` int(10) DEFAULT NULL COMMENT '服务结束日期',
  `createTime` int(10) DEFAULT NULL COMMENT '创建时间',
  `state` tinyint(1) DEFAULT '0',
  `isDel` tinyint(1) DEFAULT '0' COMMENT '是否删除,默认不删除',
  PRIMARY KEY (`relationId`),
  KEY `cId` (`cId`),
  KEY `salesmanId` (`salesmanId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='客户分配记录表' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `crm_client_relation`
--

INSERT INTO `crm_client_relation` (`relationId`, `cId`, `salesmanId`, `startDate`, `endDate`, `createTime`, `state`, `isDel`) VALUES
(1, 1, 2, 1444725389, 1893427200, 1444725389, 1, 0),
(2, 3, 2, 1444802393, 1444805869, 1444802393, 1, 0),
(3, 3, 2, 1444752000, 1893427200, 1444802411, 1, 0),
(4, 4, 2, 1449627188, 1893427200, 1449627188, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_competence`
--

CREATE TABLE IF NOT EXISTS `crm_competence` (
  `comCode` varchar(40) NOT NULL COMMENT '权限代码，唯一',
  `comeName` varchar(25) NOT NULL COMMENT '权限名称',
  `level` tinyint(2) NOT NULL DEFAULT '1',
  `codeUrl` varchar(80) DEFAULT NULL,
  `parent` varchar(40) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL COMMENT '权限描述',
  `weight` smallint(4) DEFAULT '0',
  `isDel` tinyint(1) DEFAULT '0' COMMENT '0菜单 1删除 2操作',
  `createTime` int(10) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`comCode`),
  KEY `comCode` (`comCode`),
  KEY `level` (`level`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限代码表 操作、菜单权限';

--
-- 转存表中的数据 `crm_competence`
--

INSERT INTO `crm_competence` (`comCode`, `comeName`, `level`, `codeUrl`, `parent`, `description`, `weight`, `isDel`, `createTime`) VALUES
('panel', '个人面板', 1, '#', '', '', 1, 0, 1436429715),
('welcome', '我的首页', 2, 'panel/WelcomeController/welcome', 'panel', NULL, 0, 0, 1436429715),
('system', '系统管理', 1, '#', '', '', 2, 0, 1436429715),
('userList', '用户列表', 2, 'admin/UserController/userList', 'system', NULL, 0, 0, 1436429715),
('menuList', '权限列表', 2, 'admin/MenuController/menuList', 'system', '', 0, 0, 1436429715),
('roleList', '角色列表', 2, 'admin/RoleController/roleList', 'system', NULL, 0, 0, 1436429715),
('siteList', '站点列表', 2, 'admin/SiteController/siteList', 'system', '', 0, 0, 1436435441),
('orgList', '部门列表', 2, 'admin/OrgController/orgList', 'system', '', 0, 0, 1436435518),
('baseInfoEdit', '个人设置', 2, 'public/UpdatebaseController/baseInfoEdit', 'panel', '', 0, 0, 1436513476),
('emailList', '内部邮件', 2, 'public/EmailController/emailListView', 'panel', '', 0, 0, 1436513539),
('announceList', '公告通知', 2, 'public/AnnounceController/announceList/?type=1', 'panel', '', 0, 0, 1436513623),
('contList', '内部通讯', 2, 'public/ContactsController/contList', 'panel', '', 0, 0, 1436513656),
('forumList', '讨论专区', 2, 'office/ForumController/classList', 'panel', '', 0, 0, 1436513678),
('panelList', '待办事项', 2, 'panel/PanelController/panelList', 'panel', '', 4, 0, 1436513717),
('personnel', '人事管理', 1, '#', '', '', 3, 0, 1437307893),
('expandList', '档案管理', 2, 'personnel/ExpandController/expandList', 'personnel', '', 0, 0, 1437307921),
('overworkList', '考勤管理', 2, 'personnel/OverworkController/overworkListView', 'personnel', '', 0, 0, 1437308031),
('process', '流程管理', 1, '#', '', '', 6, 0, 1437719778),
('processList', '流程列表', 2, 'process/ProcessController/processList', 'process', '', 0, 0, 1437720185),
('pendList', '处理事项列表', 2, 'process/PendController/pendList', 'process', '', 0, 0, 1437720471),
('extensionList', '流程扩展列表', 2, 'process/ProcessController/extensionList', 'process', '', 0, 0, 1437720677),
('addForum', '新建讨论区', 2, NULL, 'panel', '', 0, 2, 1438670441),
('allExpand', '档案所有', 2, NULL, 'personnel', '', 0, 2, 1438673041),
('allOverTime', '加班单所有', 2, NULL, 'personnel', '', 0, 2, 1438673186),
('allLeave', '请假单所有', 2, NULL, 'personnel', '', 0, 2, 1438674113),
('allFalsesign', '误打卡所有', 2, NULL, 'personnel', '', 0, 2, 1438674183),
('allHoliday', '公休日设置', 2, NULL, 'personnel', '', 0, 2, 1438675433),
('office', '行政管理', 1, '#', '', '', 5, 0, 1438676206),
('toolsList', '库存管理', 2, 'office/ToolsController/toolsList', 'office', '', 0, 0, 1439788070),
('goodsList', '领料申请', 2, 'office/GoodsController/goodsList', 'office', '', 0, 0, 1439860838),
('customer', '业务管理', 1, '#', '', '', 3, 0, 1439882058),
('customerList', '客户管理', 2, 'business/CustomerController/customerList', 'customer', '', 0, 0, 1439882191),
('allCustomer', '客户所有', 2, NULL, 'customer', '', 0, 2, 1439960449),
('callbackList', '票务回收', 2, 'office/CallbackController/callbackList', 'office', '', 0, 0, 1440392561),
('madeList', '客户定制票务', 2, 'office/MadeController/madeList', 'office', '', 0, 0, 1440399426),
('allTools', '库存管理', 2, NULL, 'office', '', 0, 2, 1440731094),
('allCallback', '票务回收', 2, NULL, 'office', '', 0, 2, 1440731119),
('allMade', '客户定制票务', 2, NULL, 'office', '', 0, 2, 1440731138),
('contractList', '合同管理', 2, 'business/ContractController/contractList', 'customer', '', 0, 0, 1444806573),
('billingList', '开票管理', 2, 'business/BillingController/billingList', 'customer', '', 0, 0, 1446277090),
('journalList', '工作日志', 2, 'public/JournalController/journalListView', 'panel', '', 3, 0, 1446688518),
('visitList', '拜访管理', 2, 'business/VisitController/visitList', 'customer', '', 10, 0, 1446788183),
('retrieveList', '应收账款', 2, 'business/RetrieveController/retrieveList', 'customer', '', 0, 0, 1448516025),
('retrieveAdd', '回款录入', 2, NULL, 'customer', '', 0, 2, 1448516971),
('paymentList', '回款管理', 2, 'business/PaymentController/paymentList', 'customer', '', 0, 0, 1448522141),
('allContract', '合同所有', 2, NULL, 'customer', '', 0, 2, 1448776585),
('allBilling', '开票所有', 2, NULL, 'customer', '', 0, 2, 1448776691),
('allRetrieve', '应收账款所有', 2, NULL, 'customer', '', 0, 2, 1448776818),
('allPayment', '回款所有', 2, NULL, 'customer', '', 0, 2, 1448776882),
('allVisit', '拜访所有', 2, NULL, 'customer', '', 0, 2, 1448776946),
('allJournal', '工作日志所有', 2, '', 'panel', '', 0, 2, 1448777159),
('customerContactList', '客户联系人', 2, 'business/CustomerContactController/customerContactListView', 'customer', '', 11, 0, 1450255415),
('media', '媒介管理', 1, '#', '', '', 4, 0, 1451097736),
('studioList', '影城管理', 2, 'media/StudioController/studioList', 'media', '', 0, 0, 1451098064),
('studioContactList', '影城联系人', 2, 'media/StudioContactController/studioContactListView', 'media', '', 0, 0, 1451114070),
('showList', '映前广告执行单', 2, 'media/ShowController/showList', 'media', '', 0, 0, 1451269928),
('positionList', '阵地广告执行单', 2, 'media/PositionController/positionList', 'media', '', 0, 0, 1451366331);

-- --------------------------------------------------------

--
-- 表的结构 `crm_contract`
--

CREATE TABLE IF NOT EXISTS `crm_contract` (
  `contractId` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `cId` int(10) NOT NULL COMMENT '客户ID',
  `title` varchar(80) NOT NULL COMMENT '合同名称',
  `money` varchar(100) NOT NULL COMMENT '合同金额',
  `discount` varchar(80) DEFAULT NULL COMMENT '折扣',
  `service` varchar(400) NOT NULL COMMENT '增值服务',
  `issueDate` int(10) DEFAULT NULL COMMENT '上刊时间',
  `content` text COMMENT '合同内容',
  `description` varchar(400) DEFAULT NULL COMMENT '备注',
  `contractNumber` varchar(60) DEFAULT NULL COMMENT '合同编号',
  `operator` smallint(4) NOT NULL COMMENT '申请人',
  `createTime` int(10) NOT NULL COMMENT '创建时间',
  `state` tinyint(1) DEFAULT '0' COMMENT '审批状态',
  `isDel` tinyint(1) DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`contractId`),
  KEY `cId` (`cId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='合同表' AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `crm_contract`
--

INSERT INTO `crm_contract` (`contractId`, `cId`, `title`, `money`, `discount`, `service`, `issueDate`, `content`, `description`, `contractNumber`, `operator`, `createTime`, `state`, `isDel`) VALUES
(1, 3, '华润影城广告服务', '5000', '400', '2##包场，有违约金||', 1445529600, '<p>\r\n	华润影城广告服务\r\n</p>\r\n<p>\r\n	华润影城广告服务\r\n</p>\r\n<p>\r\n	华润影城广告服务\r\n</p>\r\n<p>\r\n	华润影城广告服务\r\n</p>', NULL, 'LC2015-001', 2, 1445233241, 1, 0),
(2, 1, '中环影城分销合同书', '4000', '100', '3##无||', 1446566400, '<p>\r\n	中环影城分销合同书\r\n</p>\r\n<p>\r\n	中环影城分销合同书\r\n</p>\r\n<p>\r\n	中环影城分销合同书\r\n</p>\r\n<p>\r\n	中环影城分销合同书\r\n</p>', NULL, 'LC2015-002', 1, 1445237016, 0, 1),
(3, 1, '中环影城分销合同书', '4000', '100', '3##无||', 1446652800, '<p>\r\n	中环影城分销合同书\r\n</p>\r\n<p>\r\n	中环影城分销合同书\r\n</p>\r\n<p>\r\n	中环影城分销合同书\r\n</p>\r\n<p>\r\n	中环影城分销合同书\r\n</p>\r\n<p>\r\n	中环影城分销合同书\r\n</p>', NULL, 'LC2015-003', 2, 1445237084, 0, 0),
(4, 4, '合肥华润地产分销合同书1', '8000', '11', '1##1111||3##2222||4##333||', 1450108800, '11', NULL, 'LC2015-004', 2, 1450166883, 0, 0),
(5, 4, '合肥乐富强地产分销合同书', '120000', '无', '5##1||', 1451923200, '1212', '1、2323\r\n2、12221', 'LC2015-005', 1, 1451094470, 0, 1),
(6, 4, '合肥乐富强地产分销合同书2', '120000', '无', '5##111||', 1452096000, '2232', '1、任务\r\n2、的说法是否', 'LC2015-005', 2, 1451094787, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_contract_file`
--

CREATE TABLE IF NOT EXISTS `crm_contract_file` (
  `fileId` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `contractId` int(11) NOT NULL COMMENT '合同编号',
  `fId` int(11) NOT NULL COMMENT '附件ID',
  `isDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`fileId`),
  KEY `cNumber` (`contractId`),
  KEY `fId` (`fId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='合同附件表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `crm_contract_file`
--

INSERT INTO `crm_contract_file` (`fileId`, `contractId`, `fId`, `isDel`) VALUES
(1, 1, 3, 1);

-- --------------------------------------------------------

--
-- 表的结构 `crm_customer_contact`
--

CREATE TABLE IF NOT EXISTS `crm_customer_contact` (
  `id` int(5) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `telName` char(10) DEFAULT NULL COMMENT '联系人姓名',
  `telNumber` char(13) DEFAULT NULL COMMENT '联系人电话',
  `telPosition` char(12) DEFAULT NULL COMMENT '联系人职位',
  `cId` int(5) NOT NULL COMMENT '客户ID',
  `sex` tinyint(1) DEFAULT NULL COMMENT '性别',
  `birthday` varchar(30) DEFAULT NULL COMMENT '生日',
  `zodiac` tinyint(1) DEFAULT NULL COMMENT '属相',
  `constellatory` tinyint(1) DEFAULT NULL COMMENT '星座',
  `bloodType` tinyint(1) DEFAULT NULL COMMENT '血型',
  `nativePlace` char(6) DEFAULT NULL COMMENT '籍贯',
  `academy` varchar(50) DEFAULT NULL COMMENT '毕业院校',
  `hobby` varchar(100) DEFAULT NULL COMMENT '兴趣爱好',
  `operator` int(5) NOT NULL COMMENT '最后操作人ID',
  `createTime` int(10) NOT NULL COMMENT '创建时间',
  `updateTime` int(10) DEFAULT '0' COMMENT '最后修改时间',
  `isDel` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cId` (`cId`),
  KEY `operator` (`operator`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='客户联系人表' AUTO_INCREMENT=12346 ;

--
-- 转存表中的数据 `crm_customer_contact`
--

INSERT INTO `crm_customer_contact` (`id`, `telName`, `telNumber`, `telPosition`, `cId`, `sex`, `birthday`, `zodiac`, `constellatory`, `bloodType`, `nativePlace`, `academy`, `hobby`, `operator`, `createTime`, `updateTime`, `isDel`) VALUES
(12345, '张三', '13856789099', '经理', 4, 2, '1987-8-23', 4, 5, 2, '合肥', '安徽大学', '篮球', 2, 1450254427, 1450259979, 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_daily`
--

CREATE TABLE IF NOT EXISTS `crm_daily` (
  `pId` int(11) NOT NULL AUTO_INCREMENT COMMENT '个人工作日志主键',
  `dailyTitle` varchar(50) NOT NULL COMMENT '标题',
  `startDate` int(10) NOT NULL COMMENT '开始时间',
  `endDate` int(10) NOT NULL COMMENT '结束时间',
  `createTime` int(10) NOT NULL COMMENT '创建时间',
  `updateTime` int(10) NOT NULL COMMENT '修改时间',
  `operator` smallint(4) NOT NULL COMMENT '操作人',
  `other` varchar(255) NOT NULL COMMENT '其他工作',
  `score` varchar(20) NOT NULL COMMENT '个人工作日志打分',
  `remarks` varchar(255) NOT NULL COMMENT '个人工作日志评价',
  `uId` smallint(4) NOT NULL COMMENT '评价人',
  `evaTime` int(10) NOT NULL COMMENT '评价时间',
  `isDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`pId`),
  KEY `operator` (`operator`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='个人日志表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `crm_daily`
--

INSERT INTO `crm_daily` (`pId`, `dailyTitle`, `startDate`, `endDate`, `createTime`, `updateTime`, `operator`, `other`, `score`, `remarks`, `uId`, `evaTime`, `isDel`) VALUES
(1, '工作日志 2015-11-06', 1446739200, 1446825599, 1446777479, 1446780403, 2, '1、其他工作1111\r\n2、其他工作2222\r\n3、其他工作333333', '', '', 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_daily_detail`
--

CREATE TABLE IF NOT EXISTS `crm_daily_detail` (
  `logId` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `pId` int(11) NOT NULL COMMENT '个人日志ID',
  `type` tinyint(1) DEFAULT NULL COMMENT '1、拜访情况 2、明日计划',
  `clientName` int(10) DEFAULT '0' COMMENT '客户名称ID',
  `userName` varchar(50) DEFAULT NULL COMMENT '客户姓名',
  `shape` tinyint(1) DEFAULT NULL COMMENT '拜访形式',
  `content` varchar(255) DEFAULT NULL COMMENT '洽谈内容',
  `plan` varchar(255) DEFAULT NULL COMMENT '下次行动计划',
  `morning` varchar(255) CHARACTER SET ucs2 DEFAULT NULL COMMENT '上午',
  `mTarget` varchar(255) DEFAULT NULL COMMENT '上午目标',
  `afternoon` varchar(255) DEFAULT NULL COMMENT '下午',
  `aTarget` varchar(255) DEFAULT NULL COMMENT '下午目标',
  `createTime` int(10) NOT NULL COMMENT '创建时间',
  `operator` smallint(4) NOT NULL COMMENT '操作人',
  `isDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`logId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='个人日志详情表' AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `crm_daily_detail`
--

INSERT INTO `crm_daily_detail` (`logId`, `pId`, `type`, `clientName`, `userName`, `shape`, `content`, `plan`, `morning`, `mTarget`, `afternoon`, `aTarget`, `createTime`, `operator`, `isDel`) VALUES
(5, 1, 1, 3, '李四', 4, '洽谈内容2222', '下次行动计划2222', NULL, NULL, NULL, NULL, 1446730403, 2, 0),
(4, 1, 1, 1, '张三', 1, '洽谈内容1111', '下次行动计划1111', NULL, NULL, NULL, NULL, 1446780403, 2, 0),
(6, 1, 2, 0, NULL, NULL, NULL, NULL, '上午111', '目标111', '下午1111', '目标112222', 1446780403, 2, 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_file`
--

CREATE TABLE IF NOT EXISTS `crm_file` (
  `fid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fileName` varchar(100) NOT NULL DEFAULT '',
  `filePath` varchar(100) NOT NULL DEFAULT '',
  `origName` varchar(100) NOT NULL DEFAULT '',
  `fileExt` varchar(10) NOT NULL DEFAULT '',
  `fileSize` varchar(10) DEFAULT '0',
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `crm_file`
--

INSERT INTO `crm_file` (`fid`, `fileName`, `filePath`, `origName`, `fileExt`, `fileSize`) VALUES
(1, '458ca404e3c68b977d01f53fe629248d.jpg', 'D:/wamp/www/lcmedia/application/upload/201508/', 'pic.jpg', '.jpg', '6.17'),
(2, 'd84c62032b8ca8d6bbd98d85329243f3.png', './application/upload/201511/', 'cr_backend_group_manage_4.png', '.png', '70.46'),
(3, '1e74ab57062fab6474be15f86749d743.png', './application/upload/201511/', 'cr_backend_user_manage_4_1.png', '.png', '72.02'),
(4, '484c82c32fdc20dc917e8170a610ea57.png', './application/upload/201512/', 'cr_backend_mail_3.png', '.png', '55.38'),
(5, 'b2c4e2000afaf3e187c7a92e3bce508f.png', './application/upload/201512/', 'cr_backend_mail.png', '.png', '102.11'),
(6, 'a7d7ab2a4447734ab636b56d77e22d07.png', './application/upload/201512/', 'cr_backend_mail_3.png', '.png', '55.38'),
(7, '06ce1415ac650be3015d51f557f4e242.png', './application/upload/201512/', 'cr_backend_mail_1.png', '.png', '112.85'),
(8, '1d39e399e093abdfd73f4346218396c5.png', './application/upload/201512/', 'cr_backend_mail.png', '.png', '102.11'),
(9, 'ed0ee6b0da1af1e69f6380d9a7a7118d.png', 'E:/wamp/www/lcmedia/application/upload/201512/', 'nopic.png', '.png', '4.15');

-- --------------------------------------------------------

--
-- 表的结构 `crm_forum_area`
--

CREATE TABLE IF NOT EXISTS `crm_forum_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` tinyint(4) NOT NULL DEFAULT '0' COMMENT '子类别，为主题帖id',
  `className` varchar(100) NOT NULL DEFAULT '' COMMENT '分类名称、板块名称',
  `classMemo` varchar(200) NOT NULL COMMENT '板块介绍',
  `isName` tinyint(2) NOT NULL DEFAULT '1',
  `areaAdmin` varchar(100) NOT NULL DEFAULT '' COMMENT '版主名字，‘；’号隔开',
  `postDate` int(11) NOT NULL DEFAULT '0' COMMENT '发布日期时间',
  `topicNum` int(11) NOT NULL DEFAULT '0',
  `commentNum` int(11) NOT NULL DEFAULT '0',
  `lasttopicId` int(11) DEFAULT '0',
  `lasttopicStaff` varchar(30) DEFAULT NULL,
  `lasttopicDate` int(11) DEFAULT '0',
  `lastcommentStaff` varchar(30) DEFAULT NULL,
  `lastcommentDate` int(11) DEFAULT '0',
  `flag` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `crm_forum_area`
--

INSERT INTO `crm_forum_area` (`id`, `pid`, `className`, `classMemo`, `isName`, `areaAdmin`, `postDate`, `topicNum`, `commentNum`, `lasttopicId`, `lasttopicStaff`, `lasttopicDate`, `lastcommentStaff`, `lastcommentDate`, `flag`) VALUES
(2, 0, '媒介专区', ' 媒介部工作布置、监播视频及竞争客户通报', 1, '朱长翠;', 1442285694, 1, 0, 0, '李小平', 1442285731, NULL, 0, 0),
(3, 0, '业务交流', '工作上的问题相互沟通，好的经验分享', 1, '朱长翠;', 1442285714, 0, 0, 0, NULL, 0, NULL, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_forum_topic`
--

CREATE TABLE IF NOT EXISTS `crm_forum_topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL DEFAULT '0' COMMENT '员工id',
  `real_name` varchar(20) DEFAULT NULL COMMENT '姓名',
  `staff_name` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '标题',
  `click_name` text NOT NULL COMMENT '浏览人姓名',
  `click_num` int(11) DEFAULT '0' COMMENT '点击次数',
  `comments_num` smallint(6) NOT NULL COMMENT '点评数量',
  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '置顶属性',
  `content` longtext NOT NULL COMMENT '文本内容',
  `include` char(50) DEFAULT '0' COMMENT '附件ID',
  `pid` int(11) DEFAULT '0' COMMENT '（评论）父id',
  `aid` int(11) DEFAULT '0' COMMENT '类别id',
  `subcid` int(11) NOT NULL DEFAULT '0' COMMENT '讨论专题ID，子类别ID',
  `childClassId` smallint(4) NOT NULL DEFAULT '0' COMMENT '帖子子类别，专题贴的类别ID',
  `post_date` int(11) NOT NULL DEFAULT '0' COMMENT '发表日期',
  `flag` int(2) DEFAULT '0' COMMENT '软删除0,1删除',
  `lastReser` varchar(10) NOT NULL COMMENT '最新回复人姓名',
  `lastTime` int(11) NOT NULL COMMENT '最新回复时间',
  PRIMARY KEY (`id`),
  KEY `areaid` (`aid`),
  KEY `pid` (`pid`),
  KEY `childClassId` (`childClassId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `crm_forum_topic`
--

INSERT INTO `crm_forum_topic` (`id`, `staff_id`, `real_name`, `staff_name`, `title`, `click_name`, `click_num`, `comments_num`, `type`, `content`, `include`, `pid`, `aid`, `subcid`, `childClassId`, `post_date`, `flag`, `lastReser`, `lastTime`) VALUES
(1, 2, '李小平', '李小平', '9.10日保利监播', '', 1, 0, 0, '111', '0', 0, 2, 0, 0, 1442285731, 0, '', 1442285731);

-- --------------------------------------------------------

--
-- 表的结构 `crm_office_callback`
--

CREATE TABLE IF NOT EXISTS `crm_office_callback` (
  `backId` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `type` tinyint(1) NOT NULL COMMENT '回收类型 1影城 2个人',
  `tId` int(10) NOT NULL,
  `cId` int(10) DEFAULT NULL COMMENT '影城名称',
  `callbackDate` int(10) NOT NULL COMMENT '回收时间',
  `callbackNum` int(10) NOT NULL COMMENT '回收数量',
  `totalPrice` varchar(80) DEFAULT NULL COMMENT '合计金额',
  `salesman` int(10) DEFAULT NULL COMMENT '业务员ID',
  `operator` mediumint(8) NOT NULL COMMENT '申请人',
  `createTime` int(10) NOT NULL COMMENT '创建时间',
  `isDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`backId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='票务回收表' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `crm_office_callback`
--

INSERT INTO `crm_office_callback` (`backId`, `type`, `tId`, `cId`, `callbackDate`, `callbackNum`, `totalPrice`, `salesman`, `operator`, `createTime`, `isDel`) VALUES
(1, 2, 1, NULL, 1441036800, 10, '', 1, 2, 1442285193, 0),
(2, 2, 1, NULL, 1438358400, 5, '100', 1, 1, 1442455026, 0),
(3, 1, 1, 1, 1448899200, 2, '19', 0, 2, 1451272543, 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_office_goods`
--

CREATE TABLE IF NOT EXISTS `crm_office_goods` (
  `gId` int(10) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL COMMENT '1票务申请 2其他申请',
  `category` tinyint(1) DEFAULT NULL COMMENT '1合同赠票  2客户购买  3个人申领',
  `tId` int(10) NOT NULL,
  `cId` int(10) DEFAULT NULL COMMENT '客户ID',
  `number` varchar(80) DEFAULT NULL COMMENT '票务编号',
  `contractPrice` varchar(40) DEFAULT NULL COMMENT '合同金额',
  `contractDate` int(10) DEFAULT NULL COMMENT '合同上刊时间',
  `num` int(10) NOT NULL COMMENT '数量',
  `actNum` int(10) NOT NULL DEFAULT '0' COMMENT '实领数量',
  `note` varchar(400) DEFAULT NULL COMMENT '备注',
  `operator` smallint(4) NOT NULL COMMENT '申请人',
  `createTime` int(10) NOT NULL COMMENT '申请时间',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审批状态',
  `isDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`gId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='领料申请单' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `crm_office_goods`
--

INSERT INTO `crm_office_goods` (`gId`, `type`, `category`, `tId`, `cId`, `number`, `contractPrice`, `contractDate`, `num`, `actNum`, `note`, `operator`, `createTime`, `state`, `isDel`) VALUES
(1, 1, 3, 1, NULL, 'LC00000020', NULL, NULL, 20, 0, '', 1, 1442283723, 0, 1),
(2, 1, 3, 1, NULL, 'LC00000010', NULL, NULL, 20, 10, '', 1, 1442283785, 1, 0),
(3, 1, 3, 1, NULL, 'LC00000035', NULL, NULL, 20, 25, '', 1, 1442285014, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_office_made`
--

CREATE TABLE IF NOT EXISTS `crm_office_made` (
  `mId` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `cId` int(10) NOT NULL COMMENT '客户名称',
  `madeDate` int(10) NOT NULL COMMENT '购买时间',
  `tId` int(10) NOT NULL COMMENT '票种',
  `madeNum` int(10) NOT NULL COMMENT '购买数量',
  `price` varchar(80) NOT NULL COMMENT '制版费',
  `lastDate` int(10) NOT NULL COMMENT '有效期',
  `operator` smallint(4) NOT NULL COMMENT '申请人',
  `createTime` int(10) NOT NULL COMMENT '创建时间',
  `isDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`mId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='客户定制票务管理表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `crm_office_madedetail`
--

CREATE TABLE IF NOT EXISTS `crm_office_madedetail` (
  `dId` int(11) NOT NULL AUTO_INCREMENT,
  `mId` int(11) NOT NULL,
  `getDate` int(11) NOT NULL,
  `getNum` int(11) NOT NULL,
  PRIMARY KEY (`dId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='客户定制票务回收详情表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `crm_office_news`
--

CREATE TABLE IF NOT EXISTS `crm_office_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operator` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `content` longtext NOT NULL,
  `click_name` text NOT NULL COMMENT '点击人数',
  `count` int(11) NOT NULL DEFAULT '0',
  `annex` int(11) DEFAULT '0',
  `approve` smallint(4) NOT NULL COMMENT '审批人',
  `isDel` tinyint(2) NOT NULL DEFAULT '0',
  `type` tinyint(2) NOT NULL DEFAULT '0',
  `istop` tinyint(2) NOT NULL DEFAULT '0',
  `createTime` int(11) NOT NULL DEFAULT '0',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `sId` int(11) NOT NULL COMMENT '部门',
  PRIMARY KEY (`id`),
  KEY `operator` (`operator`),
  KEY `annex` (`annex`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `crm_office_tools`
--

CREATE TABLE IF NOT EXISTS `crm_office_tools` (
  `tId` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `name` varchar(40) NOT NULL COMMENT '物料名称',
  `type` tinyint(1) NOT NULL COMMENT '类型',
  `unit` varchar(20) NOT NULL COMMENT '单位',
  `num` varchar(80) NOT NULL COMMENT '录入总数量',
  `price` varchar(80) NOT NULL COMMENT '价格',
  `remark` varchar(400) DEFAULT NULL COMMENT '备注',
  `operator` smallint(4) NOT NULL COMMENT '填写人ID',
  `createTime` int(10) NOT NULL COMMENT '创建时间',
  `isDel` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`tId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='物料管理表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `crm_office_tools`
--

INSERT INTO `crm_office_tools` (`tId`, `name`, `type`, `unit`, `num`, `price`, `remark`, `operator`, `createTime`, `isDel`) VALUES
(1, '领程2D通兑券', 1, '张', '5000', '45', NULL, 1, 1442283709, 0),
(2, '领程3D通兑券', 1, '张', '3000', '58', '阿飞是', 2, 1451095132, 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_payment`
--

CREATE TABLE IF NOT EXISTS `crm_payment` (
  `paymentId` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `billingId` int(10) NOT NULL COMMENT '开票ID',
  `payUnit` varchar(80) NOT NULL COMMENT '付款单位',
  `retrieveTime` int(10) NOT NULL COMMENT '实际回款日期',
  `retrieveMoney` varchar(60) NOT NULL COMMENT '回款金额',
  `type` tinyint(1) NOT NULL COMMENT '付款方式',
  `bank` tinyint(1) NOT NULL COMMENT '收款银行',
  `remark` varchar(400) NOT NULL COMMENT '备注',
  `operator` smallint(4) NOT NULL COMMENT '申请人',
  `createTime` int(10) NOT NULL COMMENT '创建时间',
  `isDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`paymentId`),
  KEY `billingId` (`billingId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='回款记录表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `crm_payment`
--

INSERT INTO `crm_payment` (`paymentId`, `billingId`, `payUnit`, `retrieveTime`, `retrieveMoney`, `type`, `bank`, `remark`, `operator`, `createTime`, `isDel`) VALUES
(1, 1, '华润媒体有限公司', 1448553600, '2000', 1, 1, '还有500元没有回', 2, 1448521482, 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_pending`
--

CREATE TABLE IF NOT EXISTS `crm_pending` (
  `pendId` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID ',
  `tableId` int(11) NOT NULL DEFAULT '0' COMMENT '主表ID ',
  `proTable` varchar(50) NOT NULL COMMENT '主表表名 ',
  `fromUid` int(11) NOT NULL DEFAULT '0' COMMENT '发起人用户ID',
  `toUid` int(11) NOT NULL DEFAULT '0' COMMENT '接收人用户ID',
  `createTime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '操作时间',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态 默认0未处理',
  `isDel` tinyint(1) DEFAULT '0' COMMENT '是否删除 默认0不删，1删除',
  PRIMARY KEY (`pendId`),
  KEY `tableId` (`tableId`),
  KEY `toUid` (`toUid`),
  KEY `proTable` (`proTable`),
  KEY `fromUid` (`fromUid`),
  KEY `status` (`status`),
  KEY `isDel` (`isDel`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='流程审批提醒表' AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `crm_pending`
--

INSERT INTO `crm_pending` (`pendId`, `tableId`, `proTable`, `fromUid`, `toUid`, `createTime`, `status`, `isDel`) VALUES
(1, 2, 'crm_office_goods', 1, 1, 1442283785, 0, 0),
(2, 3, 'crm_office_goods', 1, 1, 1442285014, 0, 0),
(3, 3, 'crm_client_relation', 2, 2, 1444802411, 1, 0),
(4, 1, 'crm_personnel_falsesign', 2, 1, 1445230849, 0, 1),
(5, 1, 'crm_contract', 2, 2, 1445233241, 1, 0),
(6, 3, 'crm_contract', 2, 1, 1445237084, 0, 0),
(7, 1, 'crm_billing', 2, 2, 1446279911, 1, 0),
(8, 4, 'crm_contract', 2, 1, 1450166883, 0, 0),
(9, 2, 'crm_billing', 2, 2, 1450168859, 0, 0),
(10, 3, 'crm_billing', 2, 1, 1450662327, 0, 1),
(11, 4, 'crm_billing', 2, 1, 1450662494, 0, 0),
(12, 6, 'crm_contract', 2, 1, 1451094787, 0, 0),
(13, 1, 'crm_ad_show', 2, 2, 1451292749, 0, 0),
(14, 1, 'crm_ad_position', 2, 1, 1451372235, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_pending_contact`
--

CREATE TABLE IF NOT EXISTS `crm_pending_contact` (
  `pId` mediumint(8) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `proTable` varchar(50) NOT NULL COMMENT '主表表名 ',
  `pendingType` varchar(50) NOT NULL COMMENT '事项类型',
  `urlAdress` varchar(100) NOT NULL COMMENT 'url地址',
  `pNumber` varchar(400) DEFAULT NULL COMMENT '流程编号',
  `createTime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '操作时间',
  `isDel` tinyint(1) DEFAULT '0' COMMENT '是否删除 默认0不删，1删除',
  PRIMARY KEY (`pId`),
  KEY `proTable` (`proTable`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='流程处理事项表' AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `crm_pending_contact`
--

INSERT INTO `crm_pending_contact` (`pId`, `proTable`, `pendingType`, `urlAdress`, `pNumber`, `createTime`, `isDel`) VALUES
(1, 'crm_office_news', '公告通知申请单', 'public/AnnounceController/announceOne', '1', 1439774414, 0),
(2, 'crm_personnel_overtime', '加班单申请', 'personnel/OverworkController/overworkLookView', '2', 1439775591, 0),
(3, 'crm_personnel_leave', '请假单申请', 'personnel/LeaveController/leaveLookView', '3', 1439775797, 0),
(4, 'crm_personnel_falsesign', '误打卡申请', 'personnel/FalsesignController/falsesignLookView', '4', 1439775845, 0),
(5, 'crm_office_goods', '领料申请单', 'office/GoodsController/goodsDetailView', '[{"number":"5","numType":"2"},{"number":"6","numType":"1"}]', 1440036780, 0),
(6, 'crm_client_relation', '客户转交申请', 'business/CustomerController/relationDetail', '7', 1444801844, 0),
(7, 'crm_contract', '合同申请单', 'business/ContractController/contractDetail', '8', 1445233104, 0),
(8, 'crm_billing', '开票申请单', 'business/BillingController/billingDetail', '9', 1446279827, 0),
(9, 'crm_ad_show', '映前广告执行单', 'media/ShowController/showDetail', '10', 1451292610, 0),
(10, 'crm_ad_position', '阵地广告执行单', 'media/PositionController/positionDetail', '11', 1451370818, 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_personnel_expand`
--

CREATE TABLE IF NOT EXISTS `crm_personnel_expand` (
  `eId` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uId` smallint(4) NOT NULL COMMENT '用户ID',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别',
  `birthday` int(10) NOT NULL COMMENT '出生年月',
  `idcard` varchar(30) DEFAULT NULL COMMENT '身份证号码',
  `political` tinyint(1) NOT NULL DEFAULT '0' COMMENT '政治面貌',
  `nativePlace` varchar(50) DEFAULT NULL COMMENT '籍贯',
  `isMarriage` tinyint(1) NOT NULL DEFAULT '0' COMMENT '婚否',
  `vision` varchar(10) DEFAULT NULL COMMENT '视力',
  `bloodType` tinyint(1) NOT NULL DEFAULT '0' COMMENT '血型',
  `height` varchar(20) DEFAULT NULL COMMENT '身高',
  `weight` varchar(20) DEFAULT NULL COMMENT '体重',
  `graduateFrom` varchar(30) DEFAULT NULL COMMENT '毕业院校',
  `professional` varchar(40) DEFAULT NULL COMMENT '专业',
  `graduateTime` int(10) NOT NULL COMMENT '毕业时间',
  `education` tinyint(1) NOT NULL DEFAULT '0' COMMENT '学历',
  `workSum` varchar(400) DEFAULT NULL COMMENT '工作经历',
  `phone` varchar(15) NOT NULL COMMENT '手机号码',
  `cardAddr` varchar(80) DEFAULT NULL COMMENT '身份证地址',
  `address` varchar(80) DEFAULT NULL COMMENT '家庭住址',
  `currentAddress` varchar(80) DEFAULT NULL COMMENT '当前居住地',
  `contactSum` varchar(400) DEFAULT NULL COMMENT '家庭成员及联系方式',
  `photo` int(10) NOT NULL DEFAULT '0' COMMENT '个人照片',
  `idCardPhoto` int(10) NOT NULL DEFAULT '0' COMMENT '身份证扫描件',
  `eduPhoto` int(10) NOT NULL DEFAULT '0' COMMENT '学历证书',
  `certPhoto` int(10) NOT NULL DEFAULT '0' COMMENT '专业技术职称证书扫描件',
  `workqq` varchar(40) DEFAULT NULL COMMENT '工作QQ',
  PRIMARY KEY (`eId`),
  KEY `uId` (`uId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户个人档案表' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `crm_personnel_expand`
--

INSERT INTO `crm_personnel_expand` (`eId`, `uId`, `sex`, `birthday`, `idcard`, `political`, `nativePlace`, `isMarriage`, `vision`, `bloodType`, `height`, `weight`, `graduateFrom`, `professional`, `graduateTime`, `education`, `workSum`, `phone`, `cardAddr`, `address`, `currentAddress`, `contactSum`, `photo`, `idCardPhoto`, `eduPhoto`, `certPhoto`, `workqq`) VALUES
(1, 1, 2, 1440691200, '340827199003081475', 1, '安徽', 1, '良好', 0, '165', '112', '合肥师范学院', '计算机科学与技术', 1440691200, 5, '', '15855114720', '身份证地址111', '安徽合肥包河区马鞍山路万达广场娱乐楼4层', '当前居住地1111', '', 9, 0, 0, 0, NULL),
(2, 2, 1, 1439913600, '340827199003081475', 1, '安徽', 1, '良好', 0, '165', '112', '合肥师范学院', '计算机科学与技术', 1439222400, 6, NULL, '15855114720', '身份证地址111', '家庭住址111', '当前居住地1111', NULL, 0, 0, 0, 0, NULL),
(3, 3, 1, 1448467200, '340827198708264758', 1, '安徽', 1, '4', 2, '175', '70', '合肥', '计算机', 1446480000, 5, NULL, '15850621623', '111', '11222', '323', NULL, 0, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `crm_personnel_falsesign`
--

CREATE TABLE IF NOT EXISTS `crm_personnel_falsesign` (
  `fId` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `cause` varchar(50) NOT NULL COMMENT '误打卡事由',
  `address` varchar(255) NOT NULL COMMENT '误打卡地址',
  `startDate` int(10) NOT NULL COMMENT '误打卡时间',
  `type` tinyint(1) NOT NULL COMMENT '误打卡类型',
  `num` tinyint(1) NOT NULL COMMENT '误打卡次数',
  `operator` smallint(4) NOT NULL COMMENT '申请人ID',
  `createTime` int(10) NOT NULL COMMENT '创建时间',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审批状态',
  `isDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`fId`),
  KEY `operator` (`operator`),
  KEY `startDate` (`startDate`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='员工误打卡单' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `crm_personnel_falsesign`
--

INSERT INTO `crm_personnel_falsesign` (`fId`, `cause`, `address`, `startDate`, `type`, `num`, `operator`, `createTime`, `state`, `isDel`) VALUES
(1, '', '', 1445184000, 1, 1, 2, 1445230849, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `crm_personnel_holiday`
--

CREATE TABLE IF NOT EXISTS `crm_personnel_holiday` (
  `hId` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `operator` smallint(4) NOT NULL COMMENT '填写人ID',
  `setDate` int(10) NOT NULL COMMENT '设置日期',
  `setStatus` tinyint(1) NOT NULL COMMENT '设置类型 1公休 2正常上班',
  `setType` tinyint(1) NOT NULL COMMENT '1法定节假日 2不是法定节假日',
  `createTime` int(10) NOT NULL COMMENT '创建时间',
  `isDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`hId`),
  KEY `setDate` (`setDate`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公休日表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `crm_personnel_leave`
--

CREATE TABLE IF NOT EXISTS `crm_personnel_leave` (
  `leaveId` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `type` tinyint(1) NOT NULL COMMENT '请假类型',
  `pLeavetype` tinyint(1) NOT NULL COMMENT '哺乳假休假时间类型',
  `cause` varchar(80) NOT NULL COMMENT '请假原因',
  `startDate` int(10) NOT NULL COMMENT '请假开始时间',
  `endDate` int(10) NOT NULL COMMENT '请假结束时间',
  `allDay` varchar(10) NOT NULL COMMENT '请假天数',
  `annex` int(10) NOT NULL DEFAULT '0' COMMENT '附件',
  `operator` smallint(4) NOT NULL COMMENT '申请人',
  `createTime` int(10) NOT NULL COMMENT '创建时间',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审批状态',
  `isDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`leaveId`),
  KEY `startDate` (`startDate`),
  KEY `endDate` (`endDate`),
  KEY `operator` (`operator`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='员工请假单' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `crm_personnel_overtime`
--

CREATE TABLE IF NOT EXISTS `crm_personnel_overtime` (
  `oId` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `leaveId` int(10) NOT NULL DEFAULT '0' COMMENT '请假外键关联',
  `operator` smallint(4) NOT NULL COMMENT '申请人ID',
  `content` varchar(100) DEFAULT NULL COMMENT '工作内容',
  `addr` varchar(40) DEFAULT NULL COMMENT '加班地点',
  `startDate` int(10) NOT NULL COMMENT '加班开始时间',
  `endDate` int(10) NOT NULL COMMENT '加班结束时间',
  `allDay` varchar(15) NOT NULL DEFAULT '0' COMMENT '加班天数',
  `allHour` tinyint(1) NOT NULL DEFAULT '0' COMMENT '加班小时数',
  `overContent` varchar(50) NOT NULL COMMENT '备注',
  `createTime` int(10) NOT NULL COMMENT '创建时间',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审批状态',
  `isDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`oId`),
  KEY `operator` (`operator`),
  KEY `startDate` (`startDate`),
  KEY `endDate` (`endDate`),
  KEY `leaveId` (`leaveId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='员工加班单' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `crm_pms`
--

CREATE TABLE IF NOT EXISTS `crm_pms` (
  `pmsId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `msgId` int(10) NOT NULL COMMENT '外键关联',
  `msgtoUid` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '收件人id',
  `folder` varchar(15) NOT NULL COMMENT '短信息类型',
  `isRead` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否查看 0未看，1已看',
  `subject` varchar(200) NOT NULL COMMENT '主题',
  `createTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发送时间',
  `msgUrl` varchar(255) NOT NULL COMMENT '查看地址',
  `isDel` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除 默认0不删，1删除',
  PRIMARY KEY (`pmsId`),
  KEY `IX_m_f_n_d` (`msgtoUid`,`folder`,`isRead`),
  KEY `msgId` (`msgId`),
  KEY `createTime` (`createTime`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `crm_pms`
--

INSERT INTO `crm_pms` (`pmsId`, `msgId`, `msgtoUid`, `folder`, `isRead`, `subject`, `createTime`, `msgUrl`, `isDel`) VALUES
(1, 1, 1, 'forum', 0, '行政部　李小平  发表了新帖子：《9.10日保利监播》', 1442285731, 'http://www.lc.com/index.php/office/ForumArtController/artDet/1', 0),
(2, 1, 2, 'forum', 0, '行政部　李小平  发表了新帖子：《9.10日保利监播》', 1442285731, 'http://www.lc.com/index.php/office/ForumArtController/artDet/1', 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_process`
--

CREATE TABLE IF NOT EXISTS `crm_process` (
  `pNumber` int(8) NOT NULL AUTO_INCREMENT COMMENT '流程编号',
  `processName` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '流程名称 ',
  `processStructrue` varchar(400) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '流程流转结构,json形式',
  `processExtension` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '扩展信息',
  `isDel` tinyint(1) DEFAULT '0' COMMENT '是否删除 默认0不删，1删除',
  `createTime` int(11) DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`pNumber`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='流程表' AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `crm_process`
--

INSERT INTO `crm_process` (`pNumber`, `processName`, `processStructrue`, `processExtension`, `isDel`, `createTime`) VALUES
(1, '公告通知申请流程', '[{"level":0,"sid":0,"price":"","name":""},{"level":"5","sid":0,"price":"","name":""}]', '', 0, 1439774176),
(2, '加班单申请流程', '[{"level":0,"sid":0,"price":"","name":""},{"level":"3","sid":0,"price":"","name":""}]', '', 0, 1439775426),
(3, '请假单申请流程', '[{"level":0,"sid":0,"price":"","name":""},{"level":"3","sid":0,"price":"","name":""}]', '', 0, 1439775449),
(4, '误打卡申请流程', '[{"level":0,"sid":0,"price":"","name":""},{"level":"3","sid":0,"price":"","name":""}]', '', 0, 1439775467),
(5, '领料申请流程', '[{"level":0,"sid":"3","price":"","name":""},{"level":"4","sid":0,"price":"","name":""}]', '{"numType":"2"}', 0, 1439968953),
(6, '领料申请流程(合同赠票)', '[{"level":0,"sid":0,"price":"","name":""},{"level":"3","sid":0,"price":"","name":""},{"level":"1","sid":"3","price":"","name":""},{"level":"4","sid":0,"price":"","name":""}]', '{"numType":"1"}', 0, 1439969016),
(7, '客户转交流程', '[{"level":0,"sid":0,"price":"","name":""},{"level":"3","sid":0,"price":"","name":""}]', '', 0, 1444801756),
(8, '合同申请流程', '[{"level":0,"sid":0,"price":"","name":""},{"level":"3","sid":0,"price":"","name":""}]', '', 0, 1445233052),
(9, '开票申请流程', '[{"level":0,"sid":0,"price":"","name":""},{"level":"3","sid":"8","price":"","name":""},{"level":"3","sid":0,"price":"","name":""}]', '', 0, 1448514013),
(10, '映前广告执行流程', '[{"level":0,"sid":0,"price":"","name":""},{"level":"3","sid":0,"price":"","name":""}]', '', 0, 1451292540),
(11, '阵地广告执行流程', '[{"level":0,"sid":0,"price":"","name":""},{"level":"3","sid":0,"price":"","name":""}]', '', 0, 1451370715);

-- --------------------------------------------------------

--
-- 表的结构 `crm_process_extension`
--

CREATE TABLE IF NOT EXISTS `crm_process_extension` (
  `eId` int(8) NOT NULL AUTO_INCREMENT COMMENT '表主键',
  `pNumber` int(8) NOT NULL COMMENT '关联流程编号',
  `level` tinyint(2) NOT NULL COMMENT '节点位置(之前)',
  `uId` int(8) NOT NULL COMMENT '审批人',
  `sId` mediumint(8) NOT NULL COMMENT '二级组织架构ID',
  `limits` int(10) NOT NULL DEFAULT '0' COMMENT '审批额度',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `isDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除 默认0不删，1删除',
  PRIMARY KEY (`eId`),
  KEY `pNumber` (`pNumber`),
  KEY `uId` (`uId`),
  KEY `sId` (`sId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='流程新增节点信息表' AUTO_INCREMENT=2051 ;

-- --------------------------------------------------------

--
-- 表的结构 `crm_process_record`
--

CREATE TABLE IF NOT EXISTS `crm_process_record` (
  `rId` int(11) NOT NULL AUTO_INCREMENT,
  `proTable` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '主表表名 ',
  `tableId` int(11) NOT NULL COMMENT '对应主表ID',
  `fromUid` int(11) NOT NULL COMMENT '流程记录发起用户ID ',
  `toUid` int(11) NOT NULL COMMENT '流程记录结束用户ID ',
  `processIdea` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '审批记录意见 ',
  `node` tinyint(1) DEFAULT '0' COMMENT '跳过的节点数',
  `isSkip` tinyint(1) DEFAULT '0' COMMENT '是否跳过 默认0不跳，1跳过',
  `isOver` tinyint(2) DEFAULT '0' COMMENT '改流程记录是否处理 默认0未处理 1已处理 2已拒绝',
  `isDel` tinyint(1) DEFAULT '0' COMMENT '是否删除 默认0不删，1删除',
  `createTime` int(11) DEFAULT '0' COMMENT '添加时间',
  `updateTime` int(11) DEFAULT '0',
  PRIMARY KEY (`rId`),
  KEY `tableId` (`tableId`),
  KEY `fromUid` (`fromUid`),
  KEY `toUid` (`toUid`),
  KEY `proTable` (`proTable`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='流程审批详情记录表' AUTO_INCREMENT=24 ;

--
-- 转存表中的数据 `crm_process_record`
--

INSERT INTO `crm_process_record` (`rId`, `proTable`, `tableId`, `fromUid`, `toUid`, `processIdea`, `node`, `isSkip`, `isOver`, `isDel`, `createTime`, `updateTime`) VALUES
(1, 'crm_office_goods', 2, 1, 2, '', 0, 0, 1, 0, 1442283785, 1442284972),
(2, 'crm_office_goods', 2, 1, 1, NULL, 0, 0, 0, 0, 1442284972, 0),
(3, 'crm_office_goods', 3, 1, 2, '', 0, 0, 1, 0, 1442285014, 1442285046),
(4, 'crm_office_goods', 3, 1, 1, NULL, 0, 0, 0, 0, 1442285046, 0),
(5, 'crm_client_relation', 3, 2, 1, '', 0, 0, 1, 0, 1444802411, 1444805802),
(6, 'crm_client_relation', 3, 2, 2, '0', 0, 0, 1, 0, 1444805802, 1444805869),
(7, 'crm_personnel_falsesign', 1, 2, 1, NULL, 0, 0, 0, 0, 1445230849, 0),
(8, 'crm_contract', 1, 2, 1, '', 0, 0, 1, 0, 1445233241, 1445236455),
(9, 'crm_contract', 1, 2, 2, '0', 0, 0, 1, 0, 1445236455, 1445237819),
(10, 'crm_contract', 3, 2, 1, NULL, 0, 0, 0, 0, 1445237084, 0),
(11, 'crm_billing', 1, 2, 1, '', 0, 0, 1, 0, 1446279911, 1448514041),
(12, 'crm_billing', 1, 2, 3, '', 0, 0, 1, 0, 1448514041, 1448515264),
(13, 'crm_billing', 1, 2, 2, '0', 0, 0, 1, 0, 1448515264, 1448515600),
(14, 'crm_contract', 4, 2, 1, NULL, 0, 0, 0, 0, 1450166883, 0),
(15, 'crm_billing', 2, 2, 1, '', 0, 0, 1, 0, 1450168859, 1450168888),
(16, 'crm_billing', 2, 2, 3, '', 0, 0, 1, 0, 1450168888, 1450169814),
(17, 'crm_billing', 2, 2, 2, NULL, 0, 0, 0, 0, 1450169814, 0),
(18, 'crm_billing', 3, 2, 1, NULL, 0, 0, 0, 0, 1450662327, 0),
(19, 'crm_billing', 4, 2, 1, NULL, 0, 0, 0, 0, 1450662494, 0),
(20, 'crm_contract', 6, 2, 1, NULL, 0, 0, 0, 0, 1451094787, 0),
(21, 'crm_ad_show', 1, 2, 1, '', 0, 0, 1, 0, 1451292749, 1451296292),
(22, 'crm_ad_show', 1, 2, 2, NULL, 0, 0, 0, 0, 1451296292, 0),
(23, 'crm_ad_position', 1, 2, 1, NULL, 0, 0, 0, 0, 1451372235, 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_public_email`
--

CREATE TABLE IF NOT EXISTS `crm_public_email` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '邮件id',
  `from_uid` int(11) NOT NULL DEFAULT '0' COMMENT '发件人id',
  `to_uid` int(11) NOT NULL DEFAULT '0' COMMENT '收件人id',
  `copy_to_id` int(11) DEFAULT '0' COMMENT '抄送人id',
  `folder` enum('all','inbox','sent','trash') NOT NULL DEFAULT 'all' COMMENT '暂时未用',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '收件人是否查看',
  `title` varchar(100) DEFAULT NULL COMMENT '标题',
  `emailType` tinyint(1) NOT NULL DEFAULT '0' COMMENT '区分erm/erp邮件，1代表erp老邮件，0代表erm新邮件',
  `include` int(11) NOT NULL DEFAULT '0' COMMENT '附件id',
  `del_r` tinyint(2) NOT NULL DEFAULT '0' COMMENT '收件人是否删除此邮件',
  `del_s` tinyint(2) NOT NULL DEFAULT '0' COMMENT '发件人是否删除此邮件',
  `post_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发送时间',
  `content` text NOT NULL COMMENT '邮件内容',
  PRIMARY KEY (`id`),
  KEY `post_date` (`post_date`),
  KEY `from_uid` (`from_uid`),
  KEY `to_uid` (`to_uid`),
  KEY `include` (`include`),
  KEY `emailType` (`emailType`),
  FULLTEXT KEY `content` (`content`),
  FULLTEXT KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `crm_public_email`
--

INSERT INTO `crm_public_email` (`id`, `from_uid`, `to_uid`, `copy_to_id`, `folder`, `status`, `title`, `emailType`, `include`, `del_r`, `del_s`, `post_date`, `content`) VALUES
(1, 2, 1, 0, 'all', 0, '邮件功能测试', 0, 0, 0, 0, 1450330709, '您好：<br />\r\n<br />\r\n111<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n    致<br />\r\n礼!'),
(2, 1, 2, 0, 'all', 0, '邮件头像测试', 0, 0, 0, 0, 1450330782, '您好：<br />\r\n<br />\r\n<br />\r\n1122<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n    致<br />\r\n礼!');

-- --------------------------------------------------------

--
-- 表的结构 `crm_public_group`
--

CREATE TABLE IF NOT EXISTS `crm_public_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分组主键ID',
  `operator` smallint(4) NOT NULL COMMENT '添加人',
  `grouptitle` varchar(20) NOT NULL COMMENT '分株标题',
  `groupcontent` text NOT NULL COMMENT '用户姓名',
  `isDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`group_id`),
  KEY `operator` (`operator`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='邮件分组表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `crm_public_journal`
--

CREATE TABLE IF NOT EXISTS `crm_public_journal` (
  `pId` int(11) NOT NULL AUTO_INCREMENT COMMENT '个人工作日志主键',
  `journalTitle` varchar(50) NOT NULL COMMENT '标题',
  `startDate` int(10) NOT NULL COMMENT '开始时间',
  `endDate` int(10) NOT NULL COMMENT '结束时间',
  `createTime` int(10) NOT NULL COMMENT '创建时间',
  `updateTime` int(10) NOT NULL COMMENT '修改时间',
  `operator` smallint(4) NOT NULL COMMENT '操作人',
  `journalExperience` varchar(255) NOT NULL COMMENT '经验分享',
  `journalSugges` varchar(255) NOT NULL COMMENT '合理化建议',
  `score` varchar(20) NOT NULL COMMENT '个人工作日志打分',
  `journalRemarks` varchar(255) NOT NULL COMMENT '个人工作日志评价',
  `uId` smallint(4) NOT NULL COMMENT '评价人',
  `evaTime` int(10) NOT NULL COMMENT '评价时间',
  `isDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`pId`),
  KEY `operator` (`operator`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='个人日志表' AUTO_INCREMENT=21233 ;

--
-- 转存表中的数据 `crm_public_journal`
--

INSERT INTO `crm_public_journal` (`pId`, `journalTitle`, `startDate`, `endDate`, `createTime`, `updateTime`, `operator`, `journalExperience`, `journalSugges`, `score`, `journalRemarks`, `uId`, `evaTime`, `isDel`) VALUES
(21232, '工作日志 2015-11-05', 1446652800, 1446739199, 1446691482, 0, 2, '底层代码需要优化', '无', '', '', 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_public_logdetail`
--

CREATE TABLE IF NOT EXISTS `crm_public_logdetail` (
  `logId` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `pId` int(11) NOT NULL COMMENT '个人日志ID',
  `type` tinyint(1) NOT NULL COMMENT '工作计划、临时计划、总结类型',
  `logDescription` varchar(255) NOT NULL COMMENT '工作描述',
  `timeConsuming` varchar(50) NOT NULL COMMENT '耗时',
  `completion` varchar(255) NOT NULL COMMENT '完成情况',
  `noComplete` varchar(255) NOT NULL COMMENT '未完成差异分析',
  `improvementMeasures` varchar(255) NOT NULL COMMENT '改进措施',
  `deadline` varchar(255) CHARACTER SET ucs2 NOT NULL COMMENT '完成期限',
  `createTime` int(10) NOT NULL COMMENT '创建时间',
  `operator` smallint(4) NOT NULL COMMENT '操作人',
  `isDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`logId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='个人日志详情表' AUTO_INCREMENT=86443 ;

--
-- 转存表中的数据 `crm_public_logdetail`
--

INSERT INTO `crm_public_logdetail` (`logId`, `pId`, `type`, `logDescription`, `timeConsuming`, `completion`, `noComplete`, `improvementMeasures`, `deadline`, `createTime`, `operator`, `isDel`) VALUES
(86439, 21232, 1, '菜单权限功能完善', '4', '100%', '', '', '', 1446691482, 2, 0),
(86440, 21232, 1, '操作权限控制底层封装', '2', '50%', '未完成差异分析111', '改进措施111', '11.6', 1446691482, 2, 0),
(86441, 21232, 2, '协助后台新增统计功能', '1', '100%', '', '', '', 1446691482, 2, 0),
(86442, 21232, 3, '继续完成操作权限控制底层封装', '5', '需要测试', '测试人员协助测试', '', '', 1446652800, 2, 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_report`
--

CREATE TABLE IF NOT EXISTS `crm_report` (
  `rId` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `type` enum('week','month') NOT NULL COMMENT '报表类型',
  `createTime` int(10) NOT NULL COMMENT '创建时间',
  `fId` int(11) DEFAULT '0' COMMENT '创建时间',
  `remark` varchar(400) DEFAULT NULL COMMENT '备注',
  `operator` smallint(4) NOT NULL COMMENT '创建人',
  `isDel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`rId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='工作周/月报表' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `crm_report`
--

INSERT INTO `crm_report` (`rId`, `title`, `type`, `createTime`, `fId`, `remark`, `operator`, `isDel`) VALUES
(1, '2015年12月第2周报', 'week', 1450240942, 6, '111', 2, 0),
(2, '2015年12月第1周报', 'week', 1450241099, 7, '222', 2, 0),
(3, '2015年12月份月报', 'month', 1450242350, 8, '11', 2, 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_site`
--

CREATE TABLE IF NOT EXISTS `crm_site` (
  `siteId` int(8) NOT NULL AUTO_INCREMENT COMMENT '站点id',
  `name` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '站点名称',
  `isDel` tinyint(1) DEFAULT '0' COMMENT '是否删除 默认0不删，1删除',
  `createTime` int(11) DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`siteId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='站点信息' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `crm_site`
--

INSERT INTO `crm_site` (`siteId`, `name`, `isDel`, `createTime`) VALUES
(1, '合肥', 0, 1436435699);

-- --------------------------------------------------------

--
-- 表的结构 `crm_structrue`
--

CREATE TABLE IF NOT EXISTS `crm_structrue` (
  `sId` int(8) NOT NULL AUTO_INCREMENT COMMENT '组织架构id',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '组织架构名称',
  `parentId` int(11) DEFAULT '0' COMMENT '父ID，默认0',
  `level` int(4) DEFAULT '1' COMMENT '级别，默认1',
  `strNumber` varchar(20) NOT NULL COMMENT '组织架构编号',
  `phoneNumber` varchar(20) NOT NULL COMMENT '电话号码',
  `isDel` tinyint(1) DEFAULT '0' COMMENT '是否删除 默认0不删，1删除',
  `createTime` int(11) DEFAULT '0' COMMENT '添加时间',
  `weight` smallint(4) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`sId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='组织架构' AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `crm_structrue`
--

INSERT INTO `crm_structrue` (`sId`, `name`, `parentId`, `level`, `strNumber`, `phoneNumber`, `isDel`, `createTime`, `weight`) VALUES
(1, '总经办', 0, 1, '', '', 0, 1436435931, 0),
(2, '媒介部', 1, 2, '', '', 0, 1436772810, 0),
(3, '行政部', 1, 2, '', '', 0, 1439968710, 0),
(4, '销售部', 1, 2, '', '', 0, 1440390058, 0),
(5, '销售一部', 4, 3, '', '', 0, 1440390067, 0),
(6, '销售二部', 4, 3, '', '', 0, 1440390074, 0),
(7, '销售三部', 4, 3, '', '', 0, 1440390084, 0),
(8, '财务部', 1, 2, '', '0551-65678923', 0, 1448513954, 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_structrue_contact`
--

CREATE TABLE IF NOT EXISTS `crm_structrue_contact` (
  `sId` int(8) NOT NULL AUTO_INCREMENT COMMENT '组织架构id',
  `uId` int(11) NOT NULL COMMENT '用户id ',
  `isDel` tinyint(1) DEFAULT '0' COMMENT '是否删除 默认0不删，1删除',
  `createTime` int(11) DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`sId`,`uId`),
  KEY `uId` (`uId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='组织架构关联用户表' AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `crm_structrue_contact`
--

INSERT INTO `crm_structrue_contact` (`sId`, `uId`, `isDel`, `createTime`) VALUES
(1, 1, 0, 1444802292),
(3, 2, 0, 1442283756),
(8, 3, 0, 1448777381);

-- --------------------------------------------------------

--
-- 表的结构 `crm_studio`
--

CREATE TABLE IF NOT EXISTS `crm_studio` (
  `sId` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `name` varchar(60) NOT NULL COMMENT '影城名称',
  `siteId` smallint(4) NOT NULL COMMENT '站点ID',
  `room_num` int(10) DEFAULT '0' COMMENT '厅数',
  `seat_num` int(10) DEFAULT '0' COMMENT '座位数',
  `month_market_num` varchar(20) DEFAULT NULL COMMENT '月均场次',
  `month_person_num` varchar(20) DEFAULT NULL COMMENT '月均人次',
  `address` varchar(200) NOT NULL COMMENT '地址',
  `situation` varchar(400) DEFAULT NULL COMMENT '影院代理情况',
  `chain` varchar(100) DEFAULT NULL COMMENT '所属院线',
  `publish_price_fifteen` varchar(30) DEFAULT NULL COMMENT '刊例价（15秒）',
  `publish_price_thirty` varchar(30) DEFAULT NULL COMMENT '刊例价（30秒）',
  `operator` smallint(4) NOT NULL COMMENT '创建人',
  `createTime` int(10) NOT NULL COMMENT '创建时间',
  `isDel` tinyint(1) DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`sId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='影城资源表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `crm_studio`
--

INSERT INTO `crm_studio` (`sId`, `name`, `siteId`, `room_num`, `seat_num`, `month_market_num`, `month_person_num`, `address`, `situation`, `chain`, `publish_price_fifteen`, `publish_price_thirty`, `operator`, `createTime`, `isDel`) VALUES
(1, '合肥中环城国际影城', 1, 35, 2000, '400', '5000', '合肥市经开区繁华大道与翡翠路交口', '良好', '无', '50', '20', 2, 1451107383, 0),
(2, '合肥包河万达影城', 1, 30, 2000, '400', '5000', '合肥市经开区繁华大道与翡翠路交口', '良好', '无', '35', '20', 2, 1451371404, 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_studio_contact`
--

CREATE TABLE IF NOT EXISTS `crm_studio_contact` (
  `id` int(5) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `telName` char(10) DEFAULT NULL COMMENT '联系人姓名',
  `telNumber` char(13) DEFAULT NULL COMMENT '联系人电话',
  `telPosition` char(12) DEFAULT NULL COMMENT '联系人职位',
  `sId` int(5) NOT NULL COMMENT '影城ID',
  `sex` tinyint(1) DEFAULT NULL COMMENT '性别',
  `birthday` varchar(30) DEFAULT NULL COMMENT '生日',
  `zodiac` tinyint(1) DEFAULT NULL COMMENT '属相',
  `constellatory` tinyint(1) DEFAULT NULL COMMENT '星座',
  `bloodType` tinyint(1) DEFAULT NULL COMMENT '血型',
  `nativePlace` char(6) DEFAULT NULL COMMENT '籍贯',
  `academy` varchar(50) DEFAULT NULL COMMENT '毕业院校',
  `hobby` varchar(100) DEFAULT NULL COMMENT '备注',
  `operator` int(5) NOT NULL COMMENT '最后操作人ID',
  `createTime` int(10) NOT NULL COMMENT '创建时间',
  `updateTime` int(10) DEFAULT '0' COMMENT '最后修改时间',
  `isDel` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cId` (`sId`),
  KEY `operator` (`operator`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='影城联系人表' AUTO_INCREMENT=12347 ;

--
-- 转存表中的数据 `crm_studio_contact`
--

INSERT INTO `crm_studio_contact` (`id`, `telName`, `telNumber`, `telPosition`, `sId`, `sex`, `birthday`, `zodiac`, `constellatory`, `bloodType`, `nativePlace`, `academy`, `hobby`, `operator`, `createTime`, `updateTime`, `isDel`) VALUES
(1, '张三', '13856789099', '经理', 1, 2, '1987-8-23', 4, 5, 2, '合肥', '安徽大学', '篮球', 2, 1450254427, 1450259979, 0),
(12346, '李四', '13656789099', '经理', 1, 2, '1985-8-23', 7, 9, 3, '合肥', '安徽师范大学', '重要客户', 2, 1451113352, 1451115825, 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_user`
--

CREATE TABLE IF NOT EXISTS `crm_user` (
  `uId` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id，唯一',
  `userName` varchar(30) NOT NULL COMMENT '用户名',
  `password` varchar(32) DEFAULT NULL COMMENT '用户密码',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '入职状态：0：未转正 1：转正',
  `roleId` int(11) DEFAULT NULL COMMENT '角色ID ',
  `jobId` tinyint(4) DEFAULT NULL COMMENT '岗位级别ID',
  `isInherit` tinyint(6) DEFAULT '0' COMMENT '是否继承角色权限',
  `isDisabled` tinyint(6) DEFAULT '0' COMMENT '是否禁用',
  `isDel` tinyint(1) DEFAULT '0' COMMENT '是否删除',
  `createTime` int(10) DEFAULT NULL COMMENT '创建时间',
  `lastTime` int(10) DEFAULT NULL COMMENT '最后登录时间',
  `lastIp` varchar(60) DEFAULT NULL COMMENT '最后登录IP',
  `isPms` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否消息弹窗 0.开启1.关闭',
  PRIMARY KEY (`uId`),
  KEY `userName` (`userName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `crm_user`
--

INSERT INTO `crm_user` (`uId`, `userName`, `password`, `status`, `roleId`, `jobId`, `isInherit`, `isDisabled`, `isDel`, `createTime`, `lastTime`, `lastIp`, `isPms`) VALUES
(1, '朱长翠', 'e10adc3949ba59abbe56e057f20f883e', 0, 1, 1, 1, 0, 0, 1440726318, 1451897678, '::1', 0),
(2, '李小平', 'e10adc3949ba59abbe56e057f20f883e', 0, 1, 4, 1, 0, 0, 1440727846, 1451364694, '::1', 0),
(3, '财务经理', 'e10adc3949ba59abbe56e057f20f883e', 0, 1, 3, 0, 0, 0, 1448513904, 1450169702, '::1', 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_user_contact`
--

CREATE TABLE IF NOT EXISTS `crm_user_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comCode` varchar(40) NOT NULL COMMENT '权限代码',
  `uId` int(14) NOT NULL COMMENT '用户/角色ID',
  `type` tinyint(1) DEFAULT '0' COMMENT '类型 默认0角色ID，1用户ID',
  `isDel` tinyint(1) DEFAULT '0' COMMENT '0菜单 2操作',
  `createTime` int(10) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `uId` (`uId`),
  KEY `type` (`type`),
  KEY `comCode` (`comCode`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='权限代码' AUTO_INCREMENT=649 ;

--
-- 转存表中的数据 `crm_user_contact`
--

INSERT INTO `crm_user_contact` (`id`, `comCode`, `uId`, `type`, `isDel`, `createTime`) VALUES
(637, 'positionList', 1, 0, 0, 1451366338),
(636, 'showList', 1, 0, 0, 1451366338),
(635, 'studioContactList', 1, 0, 0, 1451366338),
(634, 'studioList', 1, 0, 0, 1451366338),
(633, 'media', 1, 0, 0, 1451366338),
(632, 'billingList', 1, 0, 0, 1451366338),
(630, 'customerList', 1, 0, 0, 1451366338),
(631, 'contractList', 1, 0, 0, 1451366338),
(629, 'customer', 1, 0, 0, 1451366338),
(628, 'madeList', 1, 0, 0, 1451366338),
(627, 'callbackList', 1, 0, 0, 1451366338),
(648, 'retrieveAdd', 1, 0, 2, 1451366338),
(647, 'allTools', 1, 0, 2, 1451366338),
(646, 'allOverTime', 1, 0, 2, 1451366338),
(626, 'goodsList', 1, 0, 0, 1451366338),
(426, 'retrieveList', 2, 0, 0, 1450255422),
(425, 'visitList', 2, 0, 0, 1450255422),
(424, 'billingList', 2, 0, 0, 1450255422),
(423, 'contractList', 2, 0, 0, 1450255422),
(422, 'customerList', 2, 0, 0, 1450255422),
(421, 'customer', 2, 0, 0, 1450255422),
(420, 'goodsList', 2, 0, 0, 1450255422),
(419, 'office', 2, 0, 0, 1450255422),
(625, 'toolsList', 1, 0, 0, 1451366338),
(624, 'office', 1, 0, 0, 1451366338),
(645, 'allMade', 1, 0, 2, 1451366338),
(644, 'allLeave', 1, 0, 2, 1451366338),
(623, 'extensionList', 1, 0, 0, 1451366338),
(622, 'pendList', 1, 0, 0, 1451366338),
(621, 'processList', 1, 0, 0, 1451366338),
(643, 'allHoliday', 1, 0, 2, 1451366338),
(642, 'allFalsesign', 1, 0, 2, 1451366338),
(620, 'process', 1, 0, 0, 1451366338),
(619, 'overworkList', 1, 0, 0, 1451366338),
(641, 'allExpand', 1, 0, 2, 1451366338),
(618, 'expandList', 1, 0, 0, 1451366338),
(617, 'personnel', 1, 0, 0, 1451366338),
(616, 'orgList', 1, 0, 0, 1451366338),
(418, 'overworkList', 2, 0, 0, 1450255422),
(417, 'expandList', 2, 0, 0, 1450255422),
(416, 'personnel', 2, 0, 0, 1450255422),
(415, 'journalList', 2, 0, 0, 1450255422),
(414, 'panelList', 2, 0, 0, 1450255422),
(413, 'forumList', 2, 0, 0, 1450255422),
(412, 'contList', 2, 0, 0, 1450255422),
(411, 'announceList', 2, 0, 0, 1450255422),
(410, 'emailList', 2, 0, 0, 1450255422),
(409, 'baseInfoEdit', 2, 0, 0, 1450255422),
(615, 'siteList', 1, 0, 0, 1451366338),
(614, 'roleList', 1, 0, 0, 1451366338),
(613, 'menuList', 1, 0, 0, 1451366338),
(640, 'allCustomer', 1, 0, 2, 1451366338),
(639, 'allCallback', 1, 0, 2, 1451366338),
(384, 'allPayment', 3, 1, 2, 1448777381),
(385, 'retrieveAdd', 3, 1, 2, 1448777381),
(408, 'welcome', 2, 0, 0, 1450255422),
(407, 'panel', 2, 0, 0, 1450255422),
(427, 'paymentList', 2, 0, 0, 1450255422),
(428, 'customerContactList', 2, 0, 0, 1450255422),
(612, 'userList', 1, 0, 0, 1451366338),
(611, 'system', 1, 0, 0, 1451366338),
(610, 'panelList', 1, 0, 0, 1451366338),
(638, 'addForum', 1, 0, 2, 1451366338),
(609, 'forumList', 1, 0, 0, 1451366338),
(607, 'announceList', 1, 0, 0, 1451366338),
(608, 'contList', 1, 0, 0, 1451366338),
(606, 'emailList', 1, 0, 0, 1451366338),
(605, 'baseInfoEdit', 1, 0, 0, 1451366338),
(604, 'welcome', 1, 0, 0, 1451366338),
(603, 'panel', 1, 0, 0, 1451366338);

-- --------------------------------------------------------

--
-- 表的结构 `crm_user_role`
--

CREATE TABLE IF NOT EXISTS `crm_user_role` (
  `roreId` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增单id，唯一',
  `roleName` varchar(25) NOT NULL COMMENT '角色名',
  `description` varchar(100) DEFAULT NULL COMMENT '角色描述',
  `createTime` int(10) DEFAULT NULL COMMENT '创建时间',
  `isDel` tinyint(1) DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`roreId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户角色' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `crm_user_role`
--

INSERT INTO `crm_user_role` (`roreId`, `roleName`, `description`, `createTime`, `isDel`) VALUES
(1, '管理员', '管理员拥有操作所有的权限', 1436431735, 0),
(2, '公共角色组', '对所有人开放的权限', 1438672014, 0);

-- --------------------------------------------------------

--
-- 表的结构 `crm_user_site`
--

CREATE TABLE IF NOT EXISTS `crm_user_site` (
  `siteId` int(8) NOT NULL AUTO_INCREMENT COMMENT '站点id',
  `uId` int(11) NOT NULL COMMENT '用户id ',
  `isDel` tinyint(1) DEFAULT '0' COMMENT '是否删除 默认0不删，1删除',
  `createTime` int(11) DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`siteId`,`uId`),
  KEY `uId` (`uId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户关联站点' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `crm_user_site`
--

INSERT INTO `crm_user_site` (`siteId`, `uId`, `isDel`, `createTime`) VALUES
(1, 1, 0, 1444802292),
(1, 2, 0, 1442283756),
(1, 3, 0, 1448777381);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
