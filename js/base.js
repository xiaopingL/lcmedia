/**
 * @param objid
 * @returns 通过id返回对象
 */
function getObjById(objid) {
    return document.getElementById(objid);
}
/**
 */
function tourl(url) {
    window.location.href = url;
}

function hideElement(){
    $('#m_tagsItem').hide();
}

/**
 * 判断字段值不为空
 * */
function isItemNull(array,msg){
    var len    = array.length;
    var msglen = msg.length;
    if(len == 0){
        return false;
    }
    if(len != msglen){
        return false;
    }
    for(var i = 0; i < len; i ++){
        var value = Trim(getObjById(array[i]).value);
        if(value == ''){
            alert(msg[i] + '不能为空！');
            getObjById(array[i]).focus();
            return false;
        }
    }
}

/**
 * 去除左边空格
 */
function LTrim(str){
    var i;
    for(i=0;i<str.length;i++){
        if(str.charAt(i)!=" "&&str.charAt(i)!=" ")break;
    }
    str=str.substring(i,str.length);
    return str;
}
/**
 * 去除右边空格
 */
function RTrim(str){
    var i;
    for(i=str.length-1;i>=0;i--){
        if(str.charAt(i)!=" "&&str.charAt(i)!=" ")break;
    }
    str=str.substring(0,i+1);
    return str;
}
/**
 * 去除左右边空格
 */
function Trim(str){
    return LTrim(RTrim(str));
}

function qg_pl(qgtype,url){
    var idarray = new Array();//定义一个数组
    var cv = document.getElementsByTagName("input");
    var m = 0;
    for(var i=0; i<cv.length; i++){
        if(cv[i].type.toLowerCase() == "checkbox"){
            if(cv[i].checked)
            {
                idarray[m] = cv[i].value;
                m++;
            }
        }
    }
    var id = idarray.join(",");
    if(!id || id == "0"){
        alert("没有勾选要操作的主题！");
        return false;
    }
    var urls = url + "/id/" + id;
    if(qgtype == "delete"){
        question = confirm("确认删除该信息吗？特别说明，删除后无法恢复！");
        if (question != "0"){
            tourl(urls);
        }
    }else{
        tourl(urls);
    }
}
function checkForm(str){
    var arr = str.split('<|$|>');
    var val = '';
    for(var i = 0; i < arr.length; i++){
        var valStr = arr[i];
        if(valStr != ''){
            var valArr = valStr.split('|@|');
            if(document.getElementById(valArr[1])){
                val = document.getElementById(valArr[1]).value;
                var valType = valArr[2];
                if(valType == 1){
                    if(val == ''){
                        alert(valArr[0]);
                        O(valArr[1]).focus();
                        return false;
                    }
                }
            }else{
                return false;
            }
        }
    }
    return true;
}
/**
 * 搜索 获取url
 * idArr text/select/
 * boxIdArr checkbox,radio
 * */
function getSearchUrl(idArr,boxIdArr,url){
    var idLen  = idArr.length;
    var boxLen = boxIdArr.length;
    if(idLen > 0){
        for(var i = 0; i < idLen; i ++){
            var id = idArr[i];
            if(document.getElementById(id)){
                var val = document.getElementById(id).value;
                if(val != ''){
                    url = url + id + '/' + encodeURI(val) + '/';
                }
            }
        }
    }
    if(boxLen > 0 ){
        for(var j = 0; j < boxLen; j ++){
            var name = boxIdArr[j];
            var type = document.getElementsByName(name)[0].type.toLowerCase();
            if(type == 'radio'){
                var nameArr = document.getElementsByName(name);
                for(var k=0;k<nameArr.length;k++){
                    var objName = nameArr[k];
                    var objVal  = objName.value;
                    if(objName.checked){
                        if(objVal != ''){
                            url = url + name + '/' + objVal + '/';
                        }
                    }
                }
            }else if(type == 'checkbox'){
                var idarray = new Array();//定义一个数组
                var cv = document.getElementsByName(name);
                var m = 0;
                for(var o=0; o<cv.length; o++)				{
                    if(cv[o].checked){
                        idarray[m] = cv[o].value;
                        m++;
                    }
                }
                var strVal = idarray.join(",");
                url = url + name + '/' + strVal + '/';
            }
        }
    }
    window.location.href = url;
}

function deleteConFirm(tbl){
    if(window.confirm("您确认删除此数据吗？")){
        window.location = tbl;
    }
}
function oprConFirm(tbl){
    if(window.confirm("您确认此操作吗？")){
        window.location = tbl;
    }
}

function changeCustomerType(){
    var type = $("#type").val();
    for(i=1;i<=6;i++){
        if(i==type){
            $("#customer_"+type).css({
                "display":""
            });
            $("#customer_"+type+"_"+type).css({
                "display":""
            });
        }else{
            $("#customer_"+i).css({
                "display":"none"
            });
            $("#customer_"+i+"_"+i).css({
                "display":"none"
            });
        }
    }
    if(type == 6){
        $("#khname").html("物业公司名称");
        $("#khjb").html("物业资质");
        $("#property").css({'display':''});
        $("#level").css({'display':'none'});
        $("#wykh").css({'display':''});
        $("#wyll").css({'display':''});
        $("#qtkh").css({'display':'none'});
    }else{
        $("#khname").html("客户名称");
        $("#khjb").html("客户级别");
        $("#qtkh").css({'display':''});
        $("#wyll").css({'display':'none'});
        $("#wykh").css({'display':'none'});
    }
    if(type == 4){
        $("#carType").css({'display':''});
        $("#houseType").css({'display':'none'});
        $("#customerType").css({'display':'none'});
        $("#projectSize_1").css({'display':'none'});
        $("#projectSize_2").css({'display':'none'});
    }else if(type == 2){
        $("#carType").css({'display':'none'});
        $("#houseType").css({'display':''});
        $("#customerType").css({'display':'none'});
        $("#projectSize_1").css({'display':'none'});
        $("#projectSize_2").css({'display':'none'});
    }else if(type == 6){
        
    }else{
        $("#carType").css({'display':'none'});
        $("#houseType").css({'display':'none'});
        $("#customerType").css({'display':''});
        $("#projectSize_1").css({'display':''});
        $("#projectSize_2").css({'display':''});
    }
}


function changeContractTemplet(base_url){
    var contractId = $("#contractId").val();
    if(contractId == 0){
        alert("请选择模板");
        return false;
    }
    $.ajax({
        type: "POST",
        url: base_url+"/contract/ContractTempletController/getContractThemplet",
        data: {
            'tId':contractId
        },
        dataType: "json",
        async: false,
        success: function(data) {
            var oEditor = FCKeditorAPI.GetInstance('content');
            oEditor.SetHTML(data);//写入
        //alert(oEditor.GetXHTML(true)); 获取
        }
    })

}


/*快速查找广告位*/
function quick_look_ad(value,url,advertPosition){
    $.ajax({
        type: "POST",
        url: url,
        data: {
            'value':value
        },
        async: false,
        success: function(data) {
            $("#"+advertPosition).html(data);
        }
    })
}


/*快速查找用户*/
function locationUserSearch(value,url,inputName){
    $.ajax({
        type: "POST",
        url: url,
        data: {
            'userName':value
        },
        async: false,
        success: function(data) {
            $("#"+inputName).html(data);
        }
    })
}


function getBudgetName(value,base_url,url,inputName){
    $("#names").val(value);
    getInfo(base_url,url,inputName,2);
}

function Contrast(typeId){
    if(typeId == 33){
        $("#contrast").css({
            'display':''
        });
        $("#contrast_1").css({
            'display':''
        });
    }else{
        $("#contrast").css({
            'display':'none'
        });
        $("#contrast_1").css({
            'display':'none'
        });
    }
}

function getInfo(base_url,url,inputName){
    var dvelopersInfo = Array();
    var dvelopersArray = Array();
    var value = $("#"+inputName).val();
    var getUrl = base_url+url;
    if(value == '') return false;
    $.ajax({
        type: "POST",
        url: getUrl,
        data: {
            'value':value
        },
        async: false,
        success: function(data) {
            $("#dvelopersInfo").html('');
            dvelopersInfo = data.split('|');
            for(i=0;i<dvelopersInfo.length-1;i++){
            	dvelopersArray = dvelopersInfo[i].split('#');
            	$("#dvelopersInfo").append("<a href='javascript:void(0)' onclick=$('#"+inputName+"').val('"+dvelopersArray[1]+"');getContractInfo('"+dvelopersArray[1]+"','"+base_url+"/business/ContractController/getContractInfo');hideElement();>"+dvelopersArray[1]+"</a><br>");
            }

            var A_top = $("#"+inputName).offset().top + $("#"+inputName).outerHeight(true);
            var A_left =  $("#"+inputName).offset().left;

            $("#m_tagsItem").css({
                "display":"block",
                "position":"absolute",
                "top":A_top+"px" ,
                "left":A_left+"px"
            });
        }
    })

}


function particularHandle(detailsId){
    $("#"+detailsId).show();
}

function particularHandleSet(value,detailsId,Url){
    if(value == '') return false;
    $.ajax({
        type: "POST",
        url: Url,
        data: {
            'detailsId':detailsId,
            'rejectExplain':value
        },
        async: false,
        success: function(data) {
            if(data == 'Y'){
                $("#budget_"+detailsId).html("<span style='color:red'>【已拒绝】</span>："+value);
            }
        }
    })
}


function particularRemarkSet(value,detailsId,Url){
    if(value == '') return false;
    var remark = $('#remarkF_'+detailsId).val();
    $.ajax({
        type: "POST",
        url: Url,
        data: {
            'detailsId':detailsId,
            'nowbudgetMoney':value,
            'remark':remark
        },
        async: false,
        success: function(data) {
            if(data == 'Y'){
                $('#r_'+detailsId).text(value);
                alert('调整成功');
            }
        }
    })
}


function addAdMore(){
    var cnum = $("#cnum").val();
    cnum++;
    $("#cnum").val(cnum);
    $("#ad"+cnum).css('display', '');
}
function addAdMoreStr(){
    var cnum = $("#sumber").val();
    cnum++;
    $("#sumber").val(cnum);
    $("#add"+cnum).css('display', '');
}

function changeAdvert(id,type,Url){
    $.ajax({
        type: "POST",
        url: Url,
        data: {
            'type':type
        },
        async: false,
        success: function(data) {
            $('#advertPosition'+id).html(data);
        }
    })
}


var is=1;
function addAdMores(id,url){
    is++;
    var cnum = $("#cnum").val();
    cnum++;
    $("#cnum").val(cnum);
    //$("#"+id).append('<br><select name="advertPosition'+i+'" id="advertPosition'+i+'" class="span2"><option value="1">顶部整屏</option> <option value="2">一屏通栏</option><option value="3">对联广告</option><option value="4">流媒体广告</option></select>天数 <input type="text" placeholder="" class="span1" name="days'+i+'" id="days'+i+'"  onchange="countAdPrice('+i+')" >&nbsp;<span id="price_'+i+'"></span>');
    $("#"+id).append('<br>快速查找：<input type="text" name="quick_look" class="span1" id="quick_look " value="" onkeyup=quick_look_ad(this.value,\''+url+'\',\"advertPosition'+cnum+'")\ /><select name="advertPosition'+cnum+'" id="advertPosition'+cnum+'" class="span2">\
<option value="1">顶部整屏</option>\
<option value="2">一屏整屏收缩</option>\
<option value="3">顶部导航通栏</option>\
<option value="4">中央通栏</option>\
<option value="5">流媒体</option>\
<option value="6">黄金眼</option>\
<option value="7">一屏通栏</option>\
<option value="8">二屏通栏</option>\
<option value="9">对联</option>\
<option value="10">楼市图片广告</option>\
<option value="11">社区首页一屏通栏</option>\
<option value="12">出水芙蓉</option>\
<option value="13">背投广告</option>\
<option value="14">视频等待广告</option>\
<option value="15">焦点图</option>\
<option value="16">安徽经济广播</option>\
<option value="17">汽车团购</option>\
<option value="18">房展会</option>\
<option value="19">星空团</option>\
<option value="20">首页顶部双通栏</option>\
<option value="21">家居汇杂志广告</option>\
<option value="22">首页三屏双通栏</option>\
<option value="23">首页二屏双通栏</option>\
<option value="24">首页流动通栏</option>\
<option value="25">首页一屏双通栏</option>\
<option value="26">首页固定飘浮通栏</option>\
<option value="27">星空团佣金</option>\
<option value="28">星空团佣金</option>\
<option value="29">星空团佣金</option>\
<option value="30">线下活动</option>\
<option value="31">资讯频道首页通栏</option>\
<option value="32">首页顶部通栏</option>\
<option value="33">首页双通栏</option>\
<option value="34">新闻详情页整屏收缩</option>\
<option value="35">楼盘详情页整屏收缩</option>\
<option value="36">首页流动通栏</option>\
<option value="37">别墅网内页通栏</option>\
<option value="38">网站维护</option>\
<option value="39">地产研究内页广告1P</option>\
<option value="40">地产研究封二、封三</option>\
<option value="41">地产研究封面、封底</option>\
<option value="42">大安徽内页广告1p</option>\
<option value="43">大安徽封面、封底</option>\
<option value="44">大安徽封二、封三</option>\
<option value="45">线下活动</option>\
<option value="46">星光奖：新房类</option>\
<option value="47">看房活动</option>\
<option value="48">地图广告</option>\
<option value="49">欢迎页右下方弹出图片广告</option>\
<option value="50">欢迎页半屏收缩广告</option>\
<option value="51">楼盘详情页出水芙蓉</option>\
<option value="52">楼盘详情页窗口</option>\
<option value="53">楼盘详情页通栏</option>\
<option value="54">论坛频道一屏通栏</option>\
<option value="55">新房网页出水芙蓉</option>\
<option value="56">新房网页通栏广告</option>\
<option value="57">新闻详情页出水芙蓉</option>\
<option value="58">新闻详情页一屏窗口</option>\
<option value="59">新闻详情页新闻画中画</option>\
<option value="60">新闻详情页标题通栏</option>\
<option value="61">楼市资讯页出水芙蓉</option>\
<option value="62">首页楼市图片</option>\
<option value="63">楼市资讯页整屏</option>\
<option value="64">首页黄金眼（1个）</option>\
<option value="65">首页中央通栏</option>\
<option value="66">首页顶部导航通栏</option>\
<option value="67">首页流媒体</option>\
<option value="68">首页二屏通栏</option>\
<option value="69">首页三、四屏通栏</option>\
<option value="70">微电影</option>\
<option value="71">微电影</option>\
<option value="72">微电影</option>\
<option value="73">商铺网频道通栏</option>\
<option value="74">写字楼频道通栏</option>\
<option value="75">家居大卖场一屏通栏</option>\
<option value="76">家居大卖场页眉</option>\
<option value="77">家居战略会员</option>\
<option value="79">首页皇冠环绕通栏</option>\
<option value="80">楼市资讯页通栏广告</option>\
<option value="81">新闻详情页通栏广告</option>\
<option value="82">首页侧边对联(2侧)</option>\
<option value="83">网站建设</option>\
<option value="84">会员</option>\
<option value="85">首页整屏</option>\
<option value="86">首页一屏通栏</option>\
<option value="87">线下活动</option>\
<option value="88">活动推广</option>\
<option value="89">青年置业会通栏</option>\
<option value="90">首页楼盘推荐图片广告</option>\
<option value="91">首页顶部通栏</option>\
<option value="92">首页双通栏</option>\
<option value="93">线下活动</option>\
<option value="94">地图广告</option>\
<option value="95">研究报告内页广告</option>\
<option value="96">研究报告封二、封三</option>\
<option value="97">研究报告封底、封面</option>\
<option value="98">大安徽内页广告</option>\
<option value="99">大安徽封二、封三</option>\
<option value="100">大安徽封面、封底</option>\
<option value="101">新闻详情页整屏收缩</option>\
<option value="102">楼盘详情页整屏收缩</option>\
<option value="103">首页流动通栏</option>\
<option value="104">别墅网内页通栏广告</option>\
<option value="105">网站维护费用</option>\
<option value="106">网站建设</option>\
<option value="107">地产研究内页广告1P</option>\
<option value="108">地产研究封二、封三</option>\
<option value="109">地产研究封面、封底</option>\
<option value="110">大安徽内页广告1版</option>\
<option value="111">大安徽封面、封底</option>\
<option value="112">大安徽封二、封三</option>\
<option value="113">线下活动</option>\
<option value="114">安房网会员</option>\
<option value="115">论坛频道首页双通栏</option>\
<option value="116">首页整屏</option>\
<option value="117">新闻详情页双通栏</option>\
<option value="118">星光奖：家居类</option>\
<option value="119">星光奖：车迷类</option>\
<option value="120">星光奖：新房类</option>\
<option value="121">星光奖：新房类</option>\
<option value="122">星光奖：二手房类</option>\
<option value="123">车展</option>\
<option value="124">车迷网会员</option>\
<option value="125">看房活动</option>\
<option value="126">地图广告</option>\
<option value="127">网站维护</option>\
<option value="128">网站建设</option>\
<option value="129">合房网会员服务</option>\
<option value="130">楼盘搜索页热点推荐楼盘</option>\
<option value="131">楼盘搜索页搜索对话框</option>\
<option value="132">新房页搜索对话框</option>\
<option value="133">每个楼盘页搜索对话框</option>\
<option value="134">首页搜索对话框</option>\
<option value="135">欢迎页导航搜索对话框</option>\
<option value="136">新闻搜索页通栏</option>\
<option value="137">房产视频前段投播广告</option>\
<option value="138">房产视频通栏广告</option>\
<option value="139">论坛底部通栏广告</option>\
<option value="140">论坛首贴通栏</option>\
<option value="141">论坛二屏通栏</option>\
<option value="142">论坛顶部导航通栏</option>\
<option value="143">楼盘出水芙蓉</option>\
<option value="144">楼盘窗口</option>\
<option value="145">楼盘详情页2/3通栏</option>\
<option value="146">楼盘通栏</option>\
<option value="147">新房问房频道窗口</option>\
<option value="148">新房问房频道通栏</option>\
<option value="149">新房通栏广告</option>\
<option value="150">新房整屏收缩</option>\
<option value="151">新闻内页出水芙蓉</option>\
<option value="152">新闻内页二屏窗口</option>\
<option value="153">新闻内页一屏窗口</option>\
<option value="154">新闻画中画</option>\
<option value="155">新闻内页标题通栏广告</option>\
<option value="156">新闻内页通栏广告</option>\
<option value="157">楼市出水芙蓉</option>\
<option value="158">楼市窗口广告</option>\
<option value="159">楼市通栏广告</option>\
<option value="160">楼市整屏收缩</option>\
<option value="161">首页楼市图片</option>\
<option value="162">首页右边图片</option>\
<option value="163">首页黄金眼（单个）</option>\
<option value="164">首页侧边对联（单个）</option>\
<option value="165">首页中央通栏</option>\
<option value="166">首页四屏通栏</option>\
<option value="167">首页三屏通栏</option>\
<option value="168">首页二屏通栏</option>\
<option value="169">首页一屏通栏</option>\
<option value="170">首页顶部导航通栏</option>\
<option value="171">首页流媒体</option>\
<option value="172">首页整屏收缩二</option>\
<option value="173">首页整屏收缩一</option>\
<option value="174">欢迎页背投广告</option>\
<option value="175">欢迎页右下角弹出图片</option>\
<option value="176">欢迎页半屏收缩广告</option>\
<option value="177">欢迎页右下角弹出图片</option>\
<option value="178">欢迎页半屏收缩广告</option>\
<option value="179">楼盘详情页出水芙蓉</option>\
<option value="180">楼盘详情页窗口</option>\
<option value="181">楼盘详情页通栏</option>\
<option value="182">论坛频道一屏通栏</option>\
<option value="183">新房网页出水芙蓉</option>\
<option value="184">新房网页通栏广告</option>\
<option value="185">新房网页整屏收缩</option>\
<option value="186">新闻详情页出水芙蓉</option>\
<option value="187">新闻详情页一屏窗口</option>\
<option value="188">新闻详情页新闻画中画</option>\
<option value="189">新闻详情页标题通栏广告</option>\
<option value="190">新闻详情页通栏广告</option>\
<option value="191">楼市资讯页出水芙蓉</option>\
<option value="192">楼市资讯页通栏广告</option>\
<option value="193">楼市资讯页整屏收缩</option>\
<option value="194">首页楼市图片</option>\
<option value="195">首页右边图片</option>\
<option value="196">首页黄金眼（1个）</option>\
<option value="197">首页侧边对联(2侧)</option>\
<option value="198">首页中央通栏</option>\
<option value="199">首页三、四屏通栏</option>\
<option value="200">首页二屏通栏</option>\
<option value="201">首页一屏通栏</option>\
<option value="202">首页顶部导航通栏</option>\
<option value="203">首页流媒体</option>\
<option value="204">首页整屏收缩</option>\
<option value="205">经纪人租房通会员</option>\
<option value="206">高级中介会员</option>\
<option value="207">普通中介会员</option>\
<option value="208">高级经纪人会员</option>\
<option value="209">普通经纪人会员</option>\
<option value="210">房源详情页半通栏</option>\
<option value="211">首页半通栏</option>\
<option value="212">首页通栏广告（第二屏）</option>\
<option value="213">首页出水芙蓉</option>\
<option value="214">首页对联广告</option>\
<option value="215">房源详情页区域侧边栏广告</option>\
<option value="216">房源详情页图片广告</option>\
<option value="217">房源详情页半通栏广告</option>\
<option value="218">房源详情页通栏广告</option>\
<option value="219">房源列表页区域侧边栏广告</option>\
<option value="220">首页侧边栏</option>\
<option value="221">首页（第二屏）2/3通栏</option>\
<option value="222">首页（第一屏）半通栏</option>\
<option value="223">首页（第一屏）通栏</option>\
<option value="224">首页（第一屏）全屏</option>\
<option value="225">家居全省战略合作会员</option>\
<option value="226">家居战略合作会员</option>\
<option value="227">家居钻石会员</option>\
<option value="228">家居金牌会员</option>\
<option value="229">家居银牌会员</option>\
<option value="230">家居铜牌会员</option>\
<option value="231">家居网店</option>\
<option value="232">论坛帖间通栏(前三贴）</option>\
<option value="233">家居论坛帖间旗帜</option>\
<option value="234">家居设计一屏通栏</option>\
<option value="235">家居设计页眉</option>\
<option value="236">家居促销一屏通栏</option>\
<option value="237">家居促销页眉</option>\
<option value="238">家装日记一屏通栏</option>\
<option value="239">家装日记页眉</option>\
<option value="240">家装话题一屏通栏</option>\
<option value="241">家装话题页眉</option>\
<option value="242">家居论坛贯通</option>\
<option value="243">新闻内页画中画</option>\
<option value="244">新闻内页旗帜</option>\
<option value="245">新闻资讯页眉</option>\
<option value="246">新闻顶部通栏A</option>\
<option value="247">建材通首页二屏通栏B</option>\
<option value="248">建材通首页一屏通栏A</option>\
<option value="249">建材通首页顶部通栏</option>\
<option value="250">建材通首页1/2通栏A</option>\
<option value="251">建材通首页1/3通栏A</option>\
<option value="252">首页品牌商家Loge推荐</option>\
<option value="253">首页伸缩通栏</option>\
<option value="254">首页出水芙蓉</option>\
<option value="255">首页流媒体</option>\
<option value="256">首页对联广告右</option>\
<option value="257">首页对联广告左</option>\
<option value="258">首页漂浮</option>\
<option value="259">首页黄金眼右</option>\
<option value="260">首页黄金眼左</option>\
<option value="261">首页二屏1/2通</option>\
<option value="262">首页一屏1/3通栏</option>\
<option value="263">首页挂</option>\
<option value="264">首页五屏通栏</option>\
<option value="265">首页四屏通栏</option>\
<option value="266">首页三屏通栏</option>\
<option value="267">首页二屏通栏</option>\
<option value="268">首页一屏通栏</option>\
<option value="269">首页通栏（顶通）</option>\
<option value="270">首页双通栏B</option>\
<option value="271">首页双通栏A</option>\
<option value="272">首页拉幕B</option>\
<option value="273">首页拉幕A</option>\
<option value="274">内页广告（第二屏）</option>\
<option value="275">论坛导航通栏（第一屏）</option>\
<option value="276">论坛首页通栏（第一屏）</option>\
<option value="277">新车页通栏（第二屏）</option>\
<option value="278">新车页通栏（第一屏）</option>\
<option value="279">资讯页画中画3</option>\
<option value="280">首页套红发布</option>\
<option value="281">资讯页画中画2</option>\
<option value="282">资讯页画中画1</option>\
<option value="283">资讯页导航通栏</option>\
<option value="284">资讯页通栏（第二屏）</option>\
<option value="285">资讯页通栏（第一屏）</option>\
<option value="286">首页侧边流动广告</option>\
<option value="287">首页弹出广告</option>\
<option value="288">首页品牌专区</option>\
<option value="289">首页流媒体</option>\
<option value="290">首页通栏（第四屏）</option>\
<option value="291">首页通栏（第三屏）</option>\
<option value="292">首页通栏（第二屏）</option>\
<option value="293">首页通栏（第一屏）</option>\
<option value="294">首页导航通栏（第一屏）</option>\
<option value="295">首页伸缩顶通</option>\
<option value="296">楼盘详情页右边图片</option>\
<option value="301">家居部一屏双通栏</option>\
<option value="302">家居部二屏双通栏</option>\\n\
<option value="303">家居首页北投广告</option>\
</select>&nbsp天数&nbsp<input type="text" placeholder="" class="span1" name="days'+cnum+'" id="days'+cnum+'" >&nbsp;<span id="price_'+cnum+'"></span>');
}


function countAdPrice(n){
    var days = $("#days"+n).val();
    var advertPosition = $("#advertPosition"+n).val();
    var adprice = $("#adprice_"+advertPosition).val();
    var countPrice = days*adprice;
    $("#price_"+n).text(countPrice);
}

function addPurchaseMore(){
    var pnum = $("#pnum").val();
    pnum++;
    $("#pnum").val(pnum);
    $("#purchase_"+pnum).css({
        "display":""
    });
}

function addContrastMore(){
    var cnum = $("#cnum").val();
    cnum++;
    $("#cnum").val(cnum);
    $("#contrast_"+cnum).css({
        "display":""
    });
}

function addPaymentMore(){
    var pmnum = $("#pmnum").val();
    pmnum++;
    $("#pmnum").val(pmnum);
    $("#payment_"+pmnum).css({
        "display":""
    });
}


function countPurchasePrice(n){
    var unitPrice = $("#unitPrice_"+n).val();
    var quantity = $("#quantity_"+n).val();
    var countPrice = unitPrice*quantity;
    $("#pnum_"+n).text(countPrice);
    $("#h_pnum_"+n).val(countPrice);
}


function forCountPurchasePrice(){
    var countPrice = 0;
    var pnum = $("#pnum").val();
    for(i=1;i<=pnum;i++){
        if($("#h_pnum_"+i).val() > 0){
            countPrice = countPrice+parseFloat($("#h_pnum_"+i).val());
        }
    }
    $("#totalCost").val(countPrice);
}


function changeComment(id){
    $("#dpt"+id).hide();
    $("#dpc"+id).show();
}

function submitComment(id,Url){
    var comment = $("#comment"+id).val();
    if(comment == ''){
        alert("请填写点评内容");
        $("#comment"+id).focus();
        return false;
    }
    $.ajax({
        type: "POST",
        url: Url,
        data: {
            'comment':comment,
            'cMid':id
        },
        async: false,
        success: function(data) {
            if(data == 'N'){
                alert('没有点评权限');
            }else{
                alert("点评成功");
                $("#dpt"+id).html(comment);
                $("#dpt"+id).show();
                $("#dpc"+id).hide();
            }
        }
    })
}

function submitUnit(id,Url){
    var unit = $("#unit"+id).val();
    if(unit == ''){
        //alert("请填写采购数量");
        $("#unit"+id).focus();
        return false;
    }
    $.ajax({
        type: "POST",
        url: Url,
        data: {
            'unit':unit,
            'dId':id
        },
        async: false,
        success: function(data) {
            if(data == 'N'){
               alert('调整失败');
            }else{
               alert("调整成功");
               $("#dps"+id).html(unit);
               $("#dpc"+id).hide();
            }
        }
    })
}

function getBudgetType(){
    var typeId = $("#typeId").val();
    var isPersonalId = $("#isPersonal"+typeId).val();
    if(isPersonalId == 0){
        $("#addButton").show();
    }else if(isPersonalId == 1){
        $("#addButton").hide();
    }
}


function addBudgetMore(base_url,id,isClient,typeId){
    var Name = '';
    var InputName = '';
    if(isClient == 1){
        var num = $("#"+typeId+"_num").val();
        var numVal = parseInt(num)+1;
        $("#"+typeId+"_num").val(numVal);
    //var widthStr = '100%';
    //Name = '客户';
    //InputName = '<input type="text" name="'+typeId+'_name'+numVal+'" class="" id="'+typeId+'_name'+numVal+'"  onkeyup=getInfo("'+base_url+'","/customer/IndexController/getCustomerInfo/","'+typeId+'_name'+numVal+'")>';
    }else{
    //var widthStr = '71%';
    }
    $("#budgetTr_"+typeId+'_'+numVal).css('display', '');
//$("#"+id).append('<table style="width:'+widthStr+'"><tr><td style="padding-left:0px;border:0px">执行人</td><td  style="border:0px"><input type="text" name="'+typeId+'_uId[]" class="" id="'+typeId+'_uId[]"></td><td style="border:0px">&nbsp;&nbsp;&nbsp;金额</td><td style="border:0px"><input type="text" name="'+typeId+'_budgetMoney[]" class="" id="'+typeId+'_budgetMoney[]"></td><td style="border:0px">'+Name+'</td><td style="border:0px">'+InputName+'</td> <td>备注</td><td><input type="text" name="'+typeId+'_remark[]" class="" id="'+typeId+'_remark[]" ></td></tr></table>');
}


function getUserDetailsId(Url){
    var typeId = $("#typeId").val()
    $.ajax({
        type: "POST",
        url: Url,
        data: {
            'typeId':typeId
        },
        async: false,
        success: function(data) {
            if(data == 'fundsDataNo'){
                alert('未找到申请信息');
                return false;
            }else if(data == 'tableNameNo'){
                alert('未绑定表信息');
                return fasle;
            }else{
                $("#appliIdSelect").html(data);
            }
        }
    })
}


function getUserDetailsIdPurchase(Url){
    var typeK = $("#typeK").val();
    var typeId = $("#typeId").val()
    var budgetId = $("#detailsIdTime").val();
    if(typeK > 0){
        var sendUrl = 'Key';
    }else{
        var sendUrl = 'Val';
    }
    $.ajax({
        type: "POST",
        url: Url,
        data: {
            'typeId':typeId,
            'budgetId':budgetId,
            'sendUrl':sendUrl
        },
        async: false,
        success: function(data) {
            if(data == 'fundsDataNo'){
                alert('未找到申请信息');
                return false;
            }else if(data == 'tableNameNo'){
                alert('未绑定表信息');
                return fasle;
            }else{
                $("#detailsId").html(data);
            }
        }
    })
}


function getFirstCustomer(cId,url){
    var advert = '';
    var visit = '';
    var retrieve = '';
    var contract = '';
    var operating = '';
    $("#visit").html('');
    $("#advert").html('');
    $("#retrieve").html('');
    $("#contract").html('');
    $("#operating").html('');

    $.ajax({
        type: "POST",
        url: url,
        dataType: 'json',
        data: {
            'cId':cId
        },
        async: false,
        success: function(data) {
            $("#rank").text(data[0].rank);
            $("#siteId").text(data[0].siteId);
            $("#Level").text(data[0].Level);
            $("#fax").text(data[1].fax);
            $("#phone").text(data[1].phone);
            $("#email").text(data[1].email);
            $("#address").text(data[1].address);
            $("#website").text(data[1].website);
            $("#name").text(data[1].name);
            $("#Source").text(data[0].Source);
            $("#SalesType").text(data[0].SalesType);
            $("#staffNumber").text(data[0].staffNumber);
            $("#annualIncome").text(data[1].annualIncome);
            $("#customerView").html('');
            $("#province").html(data[1].province+'&nbsp;&nbsp;&nbsp;&nbsp;'+data[1].city);

            for(i=0;i<data[2].contract.length;i++){
                $("#customerView").append('<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td width="142" align="center">合同编号</td><td width="208" align="center">回款金额</td><td width="156" align="center">收款账号</td><td width="136" align="center">回款日期</td></tr><tr><td height="25" colspan="4" align="center"><table width="100%" id="retrieve'+i+'"></table></td></tr></table> ');
                $("#customerView").append('<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td width="142" align="center">合同编号</td><td width="208" align="center">广告位置</td><td width="156" align="center">上线时间</td><td width="136" align="center">下线时间</td></tr><tr><td height="25" colspan="4" align="center"><table width="100%" id="advert'+i+'"></table></td></tr></table>')
                $("#customerView").append('<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td width="142" align="center">合同编号</td><td width="208" align="center">未收账款</td><td width="156" align="center"></td><td width="136" align="center"></td></tr><tr><td height="25" colspan="4" align="center"><table width="100%" id="noretrieve'+i+'"></table></td></tr></table> ');
                if(data[2].contract[i].operating != undefined){
                    $("#customerView").append('<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td width="142" align="center">合同编号</td><td width="208" align="center">支出联系人</td><td width="156" align="center">支出金额</td><td width="136" align="center"></td></tr><tr><td height="25" colspan="4" align="center"><table width="100%" id="operating'+i+'"></table></td></tr></table>');
                }
                $("#advert"+i).html(data[2].contract[i].advert);
                $("#retrieve"+i).html(data[2].contract[i].retrieve);
                $("#noretrieve"+i).html(data[2].contract[i].noretrieve);
                $("#operating"+i).html(data[2].contract[i].operating);
            }
            for(i=0;i<data[3].visit.length;i++){
                visit +='<tr><td width="142" align="center">'+data[3].visit[i].type+'</td><td width="208" align="center">'+data[3].visit[i].time+'</td><td width="158" align="center">'+data[3].visit[i].man+'</td><td width="136" align="center">'+data[3].visit[i].result+'</td> </tr>';
            }
            $("#visit").html(visit);

        }
    })
}

/**
 *@param JS 验证封装Function
 *@param url 请求地址
 *@param tableName 数据表名称
 *@param fileId 表字段名称
 *@param inputId 检索信息表单ID
 *@param type   提示类别 1/2
 */
function provingIsExist(url,tableName,index,fileId,inputId,type){
    if(url == '' || tableName == '' || fileId == '' || inputId == ''){
        alert('参数不正确');
        return false;
    }
    var inputValue = inputId.value;
    if(inputValue == '') return false;
    $.ajax({
        type: "POST",
        url: url,
        data: {
            'index':index,
            'fileId':fileId,
            'tableName':tableName,
            'inputValue':inputValue
        },
        async: false,
        success: function(data) {
            if(type == 2){
                if(data == 2){
                    alert('当前数据信息已存在');
                }
            }else if(type == 1){
                if(data == 1){
                    alert('当前数据信息不存在');
                    return false;
                }
            }
        }
    })

}


function getClientName(url,inputName,setInputName){
    var value = $("#"+inputName).val();
    $.ajax({
        type: "POST",
        url: url,
        data: {
            'value':value
        },
        async: false,
        success: function(data) {
            var valArr = data.split('#');
            $('#cId').val(valArr[1]);
            $('#'+setInputName).val(valArr[0]);
        }
    })
}


function getEntertainNormalMoney(url){
    var numberPeople = $("#numberPeople").val();
    var entertainNormal = $("#entertainNormal").val();
    $.ajax({
        type: "POST",
        url: url,
        data: {
            'numberPeople':numberPeople,
            'entertainNormal':entertainNormal
        },
        async: false,
        success: function(data) {
            $("#totalCost").val(data);
        }
    })
}


function getSupplierName(url){
    var supplierName = $("#supplierName").val();
    $.ajax({
        type: "POST",
        url: url,
        data: {
            'supplierName':supplierName
        },
        async: false,
        success: function(data) {
            if(data == 1){
                $("#smpl_tbl_s").css({
                    "display":""
                });
            }else if(data == 2){
                $("#smpl_tbl_s").css({
                    "display":"none"
                });
            }
        }
    })
}

/**
 *@param 对数字验证 包括 整数 负数 小数
 **/
function checkNum(obj) {
    var re = /^-?[1-9]+(\.\d+)?$|^-?0(\.\d+)?$|^-?[1-9]+[0-9]*(\.\d+)?$/;
    if (!re.test(obj.value))    {
        alert("非数字，请输入数字！");
        obj.value="";
        return false;
    }
}


function getBudgetDetails(budgetdetails,url,typeId){
    if(budgetdetails == 0) return false;
    $.ajax({
        type: "POST",
        url: url,
        data: {
            'typeId':typeId,
            'budgetdetails':budgetdetails
        },
        async: false,
        success: function(data) {
            $("#detailsId").html(data);
        }
    })
}

function getAjaxClientInfo(typeId,budgetdetails,url){
    if(budgetdetails == 0) return false;
    $.ajax({
        type: "POST",
        url: url+'Ajax',
        data: {
            'typeId':typeId,
            'budgetdetails':budgetdetails
        },
        async: false,
        success: function(data) {
            alert(data);
        }
    })
}


function getContractInfo(val,url){
    if(val == '') return false;
    $.ajax({
        type: "POST",
        url: url,
        data: {
            'name':val
        },
        async: false,
        success: function(data) {
        	$("#dNumber").html(data);
        }
    })
}


function getAjaxMktime(url){
    var endDate = $("#endDate").val();
    var startDate = $("#startDate").val();
    var executivePrice = $("#executivePrice").val();
    if(startDate == '' || endDate == '' || executivePrice=='') return false;
    $.ajax({
        type: "POST",
        url: url,
        data: {
            'endDate':endDate,
            'startDate':startDate,
            'executivePrice':executivePrice
        },
        async: false,
        success: function(data) {
            var val = data.split('#');
            $("#run").val(val[0]);
            $("#days").val(val[1]);
        }
    })
}

function numberDaysAjaxMktime(url){
    var endDate = $("#endDate").val();
    var startDate = $("#startDate").val();
    if(startDate == '' || endDate == '') return false;
    $.ajax({
        type: "POST",
        url: url,
        data: {
            'endDate':endDate,
            'startDate':startDate
        },
        async: false,
        success: function(data) {
            $("#days").text(data);
        }
    })
}


function customerMktime(input1,input2,dayNum,url){
    var endDate = $("#"+input2).val();
    var startDate = $("#"+input1).val();
    if(startDate == '' || endDate == '') return false;
    $.ajax({
        type: "POST",
        url: url,
        data: {
            'endDate':endDate,
            'startDate':startDate
        },
        async: false,
        success: function(data) {
            $("#"+dayNum).val(data);
        }
    })
}

function contactApend(){
    var contact = $("#contact").val();
    $("#contact").val(parseInt(contact)+1);
    for(i=1;i<=3;i++){
        $("#contact"+i+"_"+contact).css({
            "display":""
        });
    }
}


function getCustomerContact(name,url){
    if(name == '') return false;
    $.ajax({
        type: "POST",
        url: url,
        data: {
            'name':name
        },
        async: false,
        success: function(data) {
            $("#ContactPeople").html(data);
        }
    })
}


function countTravel(){
    var carfare = $("#carfare").val();
    var boardwages = $("#boardwages").val();
    var hotelexpense = $("#hotelexpense").val();
    if(carfare == ''){
        carfare = 0;
    }
    if(boardwages == ''){
        boardwages = 0;
    }
    if(hotelexpense == ''){
        hotelexpense = 0;
    }
    var countNum = parseFloat(carfare)+parseFloat(boardwages)+parseFloat(hotelexpense);
    $("#totalCost").val(countNum);

}


function checkBudgetMoney(value,detailsId,url){
    if(value == '' || value == 0) return false;
    var details = $("#detailsId").val();
    $.ajax({
        type: "POST",
        url: url,
        data: {
            'totalCost':value,
            'detailsId':details
        },
        async: false,
        success: function(data) {
            if(data == 'NID'){
                alert('请选择预算明细');
            }else if(data == 'N'){
                alert('合计金额大于预算执行金额');
            }
        }
    })
}


function setFundsStaus(url){
    var fundsId = $("#fundsId").val();
    var explain = $("#explain").val();
    var fundsType = $('input[type="radio"][name="fundsType"]:checked').val();
    if(fundsType == undefined){
        alert('请选择用款状态操作类型');
        return false;
    }
    $.ajax({
        type: "POST",
        url: url,
        data: {
            'fundsId':fundsId,
            'explain':explain,
            'fundsType':fundsType
        },
        async: false,
        success: function(data) {
            if(data == 1){
                alert('操作成功！');
                $('#dialog-overlay, #dialog-box').hide();
            }else{
                alert('操作失败！');
            }
        }
    })
}



function setBudgetApplyforStaus(url){
    var applyId = $("#applyId").val();
    var explain = $("#explain").val();
    var confirmDate = $("#confirmDate").val();
    var fundsType = $('input[type="radio"][name="fundsType"]:checked').val();
    if(fundsType == undefined){
        alert('请选择用款状态操作类型');
        return false;
    }
    if(fundsType == 2 && confirmDate == ''){
        alert('请选择费用报销时间');
        return false;
    }
    $.ajax({
        type: "POST",
        url: url,
        data: {
            'applyId':applyId,
            'explain':explain,
            'fundsType':fundsType,
            'confirmDate':confirmDate,
        },
        async: false,
        success: function(data) {
            if(data == 1){
                alert('操作成功！');
                $('#dialog-overlay, #dialog-box').hide();
            }else{
                alert('操作失败！');
            }
        }
    })
}

function setPaperStaus(url){
    var pId = $("#pId").val();
    var fundsType = $('input[type="radio"][name="fundsType"]:checked').val();

    if(fundsType == undefined){
        alert('请选择状态操作类型');
        return false;
    }

    $.ajax({
        type: "POST",
        url: url,
        data: {
            'pId':pId,
            'fundsType':fundsType
        },
        async: false,
        success: function(data) {
            if(data == 1){
                alert('操作成功！');
                $('#dialog-overlay, #dialog-box').hide();
            }else{
                alert('操作不正确！');
            }
        }
    })
}



function setBorrowmoneyStaus(url){
    var bId = $("#bId").val();
    var explain = $("#explain").val();
    var fundsType = $('input[type="radio"][name="fundsType"]:checked').val();

    if(fundsType == undefined){
        alert('请选择借款状态操作类型');
        return false;
    }

    $.ajax({
        type: "POST",
        url: url,
        data: {
            'bId':bId,
            'explain':explain,
            'fundsType':fundsType
        },
        async: false,
        success: function(data) {
            if(data == 1){
                alert('操作成功！');
                $('#dialog-overlay, #dialog-box').hide();
            }else{
                alert('操作失败！');
            }
        }
    })
}


function setRefundStaus(url){
    var rId = $("#rId").val();
    var explain = $("#explain").val();
    var fundsType = $('input[type="radio"][name="fundsType"]:checked').val();

    if(fundsType == undefined){
        alert('请选择状态操作类型');
        return false;
    }

    $.ajax({
        type: "POST",
        url: url,
        data: {
            'rId':rId,
            'explain':explain,
            'fundsType':fundsType
        },
        async: false,
        success: function(data) {
            if(data == 1){
                alert('操作成功！');
                $('#dialog-overlay, #dialog-box').hide();
            }else{
                alert('操作失败！');
            }
        }
    })
}


function getContractNumber(value,url,cNumber){
    if(value == '' || value == 0) return false;
    $.ajax({
        type: "POST",
        url: url,
        data: {
            'contractTitle':value
        },
        async: false,
        success: function(data) {
            $("#cNumber").val(data);
        }
    })
}


function getHouseCustomerInfo(unitName,siteUrl,url){
    if(unitName == '') return false;
    $.ajax({
        type: "POST",
        url: url,
        dataType:"json",
        data: {
            'unitName':unitName,
            'siteUrl':siteUrl
        },
        async: false,
        success: function(data) {
            if(data == '')return false;
            $("#projectSize").val(data.totalArea);
            $("#address").val(data.salesAddress)
            $("#phone").val(data.salesPhone);
            $("#website").val(data.unitSite);
            $("#agent").val(data.actingCom);
            $("#investment").val(data.investors);
        }
    })
}


function getAdpost(adpos,siteUrl){
    if(adpos == '') return false;
    $.ajax({
        type: "POST",
        url: siteUrl,
        data: {
            'adpos':adpos,
            'siteUrl':siteUrl
        },
        async: false,
        success: function(data) {
            $("#adpos_id_ch").html(data);
        }
    });
}


function contains(a, obj) {
    for (var i = 0; i < a.length; i++) {
        if (a[i] === obj) {
            return true;
        }
    }
    return false;
}

function keyupHouseCustomerInfo(unitName,siteUrl,getUrl){
    var siteIdArray = ['1','10','11','8'];
    var siteId = $("#siteId").val();
    if(!contains(siteIdArray,siteId)) return false;

    if(unitName == '') return false;
    $.ajax({
        type: "POST",
        url: siteUrl,
        dataType:"json",
        data: {
            'keywords':unitName
        },
        async: false,
        success: function(data) {
            if(data == '')return false;
            $("#dvelopersInfo").text('');
            var A_top = $("#name").offset().top + $("#name").outerHeight(true);
            var A_left =  $("#name").offset().left;
            for(i=0;i<data.length;i++){
                $("#dvelopersInfo").append("<a href='#' onClick=$('#name').val('"+data[i]+"');hideElement();getHouseCustomerInfo('"+data[i]+"','http://api.xkhouse.com/hfnewhouse/root/rootlist/rows/1/unitName/','"+getUrl+"')>"+data[i]+"<br>");
            }
            $("#m_tagsItem").css({
                "display":"block",
                "position":"absolute",
                "top":A_top+"px" ,
                "left":A_left+"px"
            });
        }
    })
}


function keyupMon(peopleName,siteUrl){

    if(peopleName == '') return false;
    $.ajax({
        type: "POST",
        url: siteUrl,
        dataType:"json",
        data: {
            'keywords':peopleName
        },
        async: false,
        success: function(data) {
            if(data == '')return false;
            $("#dvelopersInfo").text('');
            var A_top = $("#peopleName").offset().top + $("#peopleName").outerHeight(true);
            var A_left =  $("#peopleName").offset().left;

            for(i=0;i<data.length;i++){

                $("#dvelopersInfo").append("<a href='#' onClick=$('#peopleName').val('"+data[i]+"');hideElement();>"+data[i]+"<br>");
            }
            $("#m_tagsItem").css({
                "display":"block",
                "position":"absolute",
                "top":A_top+"px" ,
                "left":A_left+"px"
            });
        }
    })
}

function fas(infoUid,siteUrl){
    if(infoUid == '') return false;
    $.ajax({
        type: "POST",
        url: siteUrl,
        dataType:"json",
        data: {
            'keywords':infoUid
        },
        async: false,
        success: function(data) {
            if(data == '')return false;
            $("#dvelopersInfo").text('');
            var A_top = $("#infoUid").offset().top + $("#infoUid").outerHeight(true);
            var A_left =  $("#infoUid").offset().left;

            for(i=0;i<data.length;i++){

                $("#dvelopersInfo").append("<a href='#' onClick=$('#infoUid').val('"+data[i]+"');hideElement();>"+data[i]+"<br>");
            }
            $("#m_tagsItem").css({
                "display":"block",
                "position":"absolute",
                "top":A_top+"px" ,
                "left":A_left+"px"
            });
        }
    })
}

function fasApprove(approveUid,siteUrl){
    if(approveUid == '') return false;
    $.ajax({
        type: "POST",
        url: siteUrl,
        dataType:"json",
        data: {
            'keywords':approveUid
        },
        async: false,
        success: function(data) {
            if(data == '')return false;
            $("#dvelopersInfo").text('');
            var A_top = $("#approveUid").offset().top + $("#approveUid").outerHeight(true);
            var A_left =  $("#approveUid").offset().left;

            for(i=0;i<data.length;i++){

                $("#dvelopersInfo").append("<a href='#' onClick=$('#approveUid').val('"+data[i]+"');hideElement();>"+data[i]+"<br>");
            }
            $("#m_tagsItem").css({
                "display":"block",
                "position":"absolute",
                "top":A_top+"px" ,
                "left":A_left+"px"
            });
        }
    })
}

function keyupQuarters(qName,siteUrl){
    if(qName == '') return false;
    $.ajax({
        type: "POST",
        url: siteUrl,
        dataType:"json",
        data: {
            'keywords':qName
        },
        async: false,
        success: function(data) {
            if(data == '')return false;
            $("#dvelopersInfo").text('');
            var A_top = $("#qName").offset().top + $("#qName").outerHeight(true);
            var A_left =  $("#qName").offset().left;

            for(i=0;i<data.length;i++){

                $("#dvelopersInfo").append("<a href='#' onClick=$('#qName').val('"+data[i]+"');hideElement();>"+data[i]+"<br>");
            }
            $("#m_tagsItem").css({
                "display":"block",
                "position":"absolute",
                "top":A_top+"px" ,
                "left":A_left+"px"
            });
        }
    })
}


function monitorDescription(monId,siteUrl,description){

    if(monId == '') return false;
    $.ajax({
        type: "POST",
        url: siteUrl,
        dataType:"json",
        data: {
            'monId':monId,
            'description':description
        },
        async: false,
        success: function(data) {
            if(data == Y){
                $("#descriptioncontent_"+monId).text(description);
            }else{
                alert('dd');
            }
        }
    })
}



function monGrade(monId,siteUrl,grade){

    if(monId == '') return false;
    $.ajax({
        type: "POST",
        url: siteUrl,
        dataType:"json",
        data: {
            'monId':monId,
            'grade':grade
        },
        async: false,
        success: function(data) {
            if(data == 1){
            //$("#gradetext_"+monId).text(grade);
            //$("#gradetext_"+monId).append('<input type="text" name="grade_'+monId+'"  style="width:50px;display:none" id="grade_'+monId+'" value="'+grade+'"  onchange=monGrade('+monId+',"'+siteUrl+'",this.value);monHidden('+monId+')>');
            }else{
                alert('dd');
            }
        }
    })
}

function quitDate(quitId,siteUrl,quitDate){

    if(quitId == '') return false;
    $.ajax({
        type: "POST",
        url: siteUrl,
        dataType:"json",
        data: {
            'quitId':quitId,
            'quitDate':quitDate
        },
        async: false,
        success: function(data) {
            if(data == 1){
            $("#gradetext_"+quitId).text(quitDate);
            $("#gradetext_"+quitId).append('<input type="text" name="quitDate"  style="width:70px;" id="quitDate_'+quitId+'" value="'+quitDate+'" onClick="WdatePicker()"  onchange=quitDate('+quitId+',"'+siteUrl+'",this.value);quitHidden('+quitId+')>');
            }else{
                alert('dd');
            }
        }
    })
}

function trainDate(iId,siteUrl,datetime){
    if(iId == '') return false;
    $.ajax({
        type: "POST",
        url: siteUrl,
        dataType:"json",
        data: {
            'iId':iId,
            'datetime':datetime
        },
        async: false,
        success: function(data) {
            if(data == 1){
            $("#gradetext_"+iId).text(datetime);
            $("#gradetext_"+iId).append('<input type="text" name="trainDate"  style="width:70px;" id="trainDate_'+iId+'" value="'+datetime+'" onClick="WdatePicker()"  onchange=trainDate('+iId+',"'+siteUrl+'",this.value);trainHidden('+iId+')>');
            }else{
                alert('dd');
            }
        }
    })
}


function getTravelHistoryInfo(value,url){
    $.ajax({
        type: "POST",
        url: url,
        data: {
            'detailsId':value
        },
        async: false,
        success: function(data) {
           $("#oldTravelDiv").html(data);
        }
    })
}


function getEntertainHistoricalRecords(url,value){
    $.ajax({
        type: "POST",
        url: url,
        data: {
            'detailsId':value
        },
        async: false,
        success: function(data) {
           $("#HistoricalRecords").html(data);
        }
    })
}



function getAppliIdBudgetMoney(){
    var objAppliId = document.getElementById("appliId");
    var indexAppliId = objAppliId.selectedIndex;
    var appliIdText = objAppliId.options[indexAppliId].text;
    var appliIdTextArray = appliIdText.split('-');
    $("#budgetMoney").val(appliIdTextArray[1]);
}


function setDetailsIdBudgetMoney(getInputId,setInputId){
    var objAppliId = document.getElementById('detailsId');
    var indexAppliId = objAppliId.selectedIndex;
    var appliIdText = objAppliId.options[indexAppliId].text;
    var appliIdTextArray = appliIdText.split('-');
    $("#"+setInputId).val(appliIdTextArray[1]);
}


function setActivityFile(id1,id2,value){
    if(value == 33 || value == 34 || value == 38){
        $("#"+id1).css('display','');
        $("#"+id2).css('display','');
    }
}

function refundNum(){
    var num = $("#num").val();
    $("#refund_1_"+num).css({"display":""});
    $("#refund_2_"+num).css({"display":""});
    $("#refund_3_"+num).css({"display":""});
    $("#refund_4_"+num).css({"display":""});
    $("#num").val(parseInt(num)+1);
}

function calculationMoney(value){
    var payment = document.getElementsByName("payment[]");
    var refundMoney = document.getElementsByName("refundMoney[]");
    var cNum = 0;
    var paymentNum = 0;
    for(i=0;i<refundMoney.length;i++){
        if(refundMoney[i].value != ''){
            cNum += parseInt(refundMoney[i].value);
            if(payment[i].value == 2){
                paymentNum += parseInt(refundMoney[i].value);
            }
        }
    }
    $("#cashNum").val(paymentNum);
    $("#cMoneyNum").val(cNum);
    $("#moneyNum").val(cNum);
}


function isEmail(imail){
    var emailPattern = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
    if (emailPattern.test(imail)==false){
        return false;
    }

    else{
        return true;
    }
}

function isMobile(val){
    if(! /^((0\d{2,3}-\d{7,8})|(1[3584]\d{9}))$/.test(val)){
        return false;
    }else{
        return true;
    }
}

function isURL(url) {
    var strRegex = "^((https|http|ftp|rtsp|mms)://)?[a-z0-9A-Z]{0,8}\.[a-z0-9A-Z][a-z0-9A-Z]{0,61}?[a-z0-9A-Z]\.com|net|cn|cc (:s[0-9]{1-4})?/$";
    var re = new RegExp(strRegex);
    if (re.test(url)) {
        return true;
    } else {
        return false;
    }
}

function getAllInfo(getUrl,inputName){
    var dvelopersInfo = Array();
    var dvelopersArray = Array();
    var value = $("#"+inputName).val();
    if(value == '') return false;
    $.ajax({
        type: "POST",
        url: getUrl,
        data: {
            'value':value
        },
        async: false,
        success: function(data) {
            $("#dvelopersInfo").html('');
            dvelopersArray = data.split('#');

            for(i=0;i<dvelopersArray.length-1;i++){
                    $("#dvelopersInfo").append("<a href='#' onClick=checktag('"+inputName+"','"+dvelopersArray[i]+"')>"+dvelopersArray[i]+"</a><br>");
                }

            var A_top = $("#"+inputName).offset().top + $("#"+inputName).outerHeight(true);
            var A_left =  $("#"+inputName).offset().left;

            $("#m_tagsItem").css({
                "display":"block",
                "position":"absolute",
                "top":A_top+"px" ,
                "left":A_left+"px"
            });
        }
    })

}
