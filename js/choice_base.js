/*---------------------------------------------------------------------------------------
 
	File Name:			common.js	
	Create Time:		Jun 17th, 2007.
	Author:				Seamuz
	All Rights Reserved (c) Huohai Co.,Ltd
 
----------------------------------------------------------------------------------------*/
var useragent	= navigator.userAgent.toLowerCase();
var webtv		= useragent.indexOf('webtv') != -1;
var kon			= useragent.indexOf('konqueror') != -1;
var mac			= useragent.indexOf('mac') != -1;
var saf			= useragent.indexOf('applewebkit') != -1 || navigator.vendor == 'Apple Computer, Inc.';
var opera		= useragent.indexOf('opera') != -1 && opera.version();
var moz			= (navigator.product == 'Gecko' && !saf) && useragent.substr(useragent.indexOf('firefox') + 8, 3);
var ns			= useragent.indexOf('compatible') == -1 && useragent.indexOf('mozilla') != -1 && !opera && !webtv && !saf;
var ie			= (useragent.indexOf('msie') != -1 && !opera && !saf && !webtv) && useragent.substr(useragent.indexOf('msie') + 5, 3);


function $(elementid) {
	//alert(elementid);
	return document.getElementById(elementid);
}

function undefined(variable) {
	return typeof variable == 'undefined' ? true : false;
}

function empty(str) {
	return typeof str == 'undefined' || str == null || str == '';
}

function trim(str) {
	return (str + '').replace(/(\s+)$/g, '').replace(/^\s+/g, '');
}

function htmlencode(str) {
	str = str.replace(/&/g, '&amp;');
	str = str.replace(/</g, '&lt;');
	str = str.replace(/>/g, '&gt;');
	str = str.replace(/(?:\t| |\v|\r)*\n/g, '<br />');
	str = str.replace(/  /g, '&nbsp; ');
	str = str.replace(/\t/g, '&nbsp; &nbsp; ');
	str = str.replace(/\x22/g, '&quot;');
	str = str.replace(/\x27/g, '&#39;');
	return str;
}

function htmldecode(str) {
	str = str.replace(/&amp;/gi, '&');
	str = str.replace(/&nbsp;/gi, ' ');
	str = str.replace(/&quot;/gi, '"');
	str = str.replace(/&#39;/g, "'");
	str = str.replace(/&lt;/gi, '<');
	str = str.replace(/&gt;/gi, '>');
	str = str.replace(/<br[^>]*>(?:(\r\n)|\r|\n)?/gi, '\n');
	return str;
}

function textencode(str) {
	str = str.replace(/&amp;/gi, '&');
	str = str.replace(/</g, '&lt;');
	str = str.replace(/>/g, '&gt;');
	return str;
}

function textdecode(str) {
	str = str.replace(/&amp;/gi, '&');
	str = str.replace(/&lt;/gi, '<');
	str = str.replace(/&gt;/gi, '>');
	return str;
}

function specialchar(str) {
	var chars = "!@#$%^&*()+=|\/?<>,.:;'\"`[]{}";
	for (var i=0; i<chars.length; i++)
	{
		if ( str.indexOf(chars.substring(i, i + 1)) != -1 )
		{
			return true;
		}
	}
	return false;
}

function bytes(str) {
	var len = 0;
	for (i = 0; i < str.length; len += (str.charCodeAt(i++) < 255 ? 1 : 2));
	return len;
}

function form(f) {
	switch (typeof f) {
		default:
		case null:
		case '':
		case 'undefined':
			return document.forms[0];
		case 'string':
		case 'number':
			return document.forms[f];
		case 'object':
			return f;
	}	
}

function forminlist(arr) {
	for(var i in arr) {
		var tmpform = form(arr[i]);
		if(!undefined(tmpform)) return tmpform;
	}
	return null;
}

function msg(message, focusctrl) {
	alert(message);
	if (focusctrl != null) {
		focusctrl.focus();
	}
	return false;
}

function offset(element) {
	var point = { x: element.offsetLeft, y: element.offsetTop };
	if (element.offsetParent) {
		var parentPoint = offset(element.offsetParent);
		point.x += parentPoint.x;
		point.y += parentPoint.y;
	}
	return point;
}

function inarray(obj, arr) {
	if(typeof obj == 'string') {
		for(var i in arr) {
			if(arr[i] == obj) {
					return true;
			}
		}
	}
	return false;
}

function checkallbox(box)
{
	var f = box.form;
	var ischecked = box.checked;
	for (var i=0; i<f.elements.length; i++)
	{
		if (f.elements[i].type.toLowerCase() == "checkbox")
		{
			f.elements[i].checked = ischecked;
		}
	}
}

function basepath() {
	var path = location.href.replace(/^https?:\/\/[^\/]+(\/.*)$/gi, "$1");
	path = path.substring(0, path.lastIndexOf("/"));
	path = path.replace(/\/(?:behind|plugin|archive)$/i, '');
	if (path == '/') {
		return '';
	}
	return path;
}

function setcookie(name,value, days)
{ 
	var exp = new Date();
	exp.setTime(exp.getTime() + days*24*60*60*1000);
	document.cookie = name + "="+ escape(value) +";expires="+ exp.toGMTString();
}

function getcookie(name)
{
	var arr = document.cookie.match(new RegExp("[\s\S]*"+ name +"=([^;]*)(;|$)"));
	if(arr != null)
		return unescape(arr[1]); 
	return null;
}

function isimg(src)
{
	var ext = ['.gif', '.jpg', '.jpeg', '.png'];
	var s = src.toLowerCase();
	var r = false;
	for(var i = 0; i < ext.length; i++)
	{
		if (s.indexOf(ext[i]) > 0)
		{
			r = true;
			break;
		}
	}	
	return r;
}


function jump(obj)
{
	var selectedValue = obj.options[obj.selectedIndex].value;
	if (selectedValue.indexOf(',') != -1 || selectedValue == -1)
	{
		obj.options[0].selected = true;
		return;
	}
	location.href = 'board.aspx?boardid=' + selectedValue;
}

function checkbyvalue(c, v)
{	
	if (!undefined(c.options))
	{
			
		for (var i = 0; i < c.options.length; i++)
		{
			if (c.options[i].value == v)
			{
				c.options[i].selected = true;
				break;
			}
		}
	}
	
}

function checkradiobyvalue(c, v)
{
	if (!undefined(c.item))
	{
		for (var i = 0; i < c.item.length; i++)
		{
			if (c.item(i).value == v)
			{
				c.item(i).checked = true;
				break;
			}
		}
	}
	
}

function switchlogin(c)
{
	var loginform = $(c);
	if(loginform.style.display == '' )
		loginform.style.display = 'none';
	else
		loginform.style.display = '';
		
}

// --- ??è?ClassName
document.getElementsByClassName = function(cl) {
	var retnode = [];
	var myclass = new RegExp('\\b'+cl+'\\b');
	var elem = this.getElementsByTagName('*');
	for (var j = 0; j < elem.length; j++) {
		var classes = elem[j].className;
		if (myclass.test(classes)) retnode.push(elem[j]);
	}
	return retnode;
}

function getOffset(el) {
	var point = { x: el.offsetLeft, y: el.offsetTop };
	//Recursion
	if (el.offsetParent) {
		var parentPoint = getOffset(el.offsetParent);
		point.x += parentPoint.x;
		point.y += parentPoint.y;
	}
	return point;
}

function getScrollOffset() {
	var point;
	if (document.body.scrollTop != 0) {
		point = { x : document.body.scrollLeft, y : document.body.scrollTop };
	} else {
		point = { x : document.documentElement.scrollLeft, y : document.documentElement.scrollTop };
	}
	return point;
}

// μ?×óóê?tD￡?é
function isEmail(imail){   
 var emailPattern = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;   
 if (emailPattern.test(imail)==false){
		 return false;
	}   
	
	else{
		return true;  
	}
}

function chkShowSpecial(i,t)
{
	if ($(i).checked==true)
	{
		$(t).style.display="";
		//$("classId").style.display="none";
	}
	else
	{
		$(t).style.display="none";
		//$("classId").style.display="";
	}
}

function ReShowSpecial(i,t)
{
	if ($(i).checked==true)
	{
		$(t).style.display="none";
	}
	else
	{
		$(t).style.display="";
	}
}

function changeWin(i)
{
	if ($(i).style.display=="none")
	{
		$(i).style.display="";
	}
	else
	{
		$(i).style.display="none";
	}
}

function newsrelated(i)
{
	if ($(i).className=="areaDiv")
	{
		$(i).className="areaClick";
		$("plateClass").value = $("plateClass").value + "|" + i + "|";
	}
	else
	{
		$(i).className="areaDiv";
		$("plateClass").value=$("plateClass").value.split("|" + i + "|").join("");  
	}
}

function AreaDivColor(i)
{
	if ($(i).className=="areaDiv")
	{
		$(i).className="areaClick";
		$("plateClass").value = $("plateClass").value + "|" + i;
	}
	else
	{
		$(i).className="areaDiv";
		$("plateClass").value=$("plateClass").value.split("|" + i).join("");    
	}
}

function RoadDivColor(i,j)
{
	if ($(i).className=="roadDiv")
	{
		$(i).className="roadClick";
		$("roadClass").value = $("roadClass").value + "|" + j;
	}
	else
	{
		$(i).className="roadDiv";
		$("roadClass").value=$("roadClass").value.split("|" + j).join("");    
	}
}


//′ò?a?￡ì?′°?ú
function OpenWindowDemo(Url,Width,Height,WindowObj){
//	OpenWindow(Url,Width,Height,WindowObj);
//	alert(Url);
	var r=showModalDialog(Url,WindowObj,'dialogWidth:'+Width+'pt;dialogHeight:'+Height+'pt;scroll:0;status:0;help:0;resizable:0;');
	if(r){//·μ??true?ò??D???è?(window.returnValue=true;)
		window.location = window.location;
	}
}
function OpenWindow(Url,Width,Height,WindowObj){
	window.open (Url,WindowObj, "height="+ Height +"px, width="+ Width +"px, toolbar=no, menubar=no, scrollbars=auto, resizable=no,location=no, status=no") 
}

//?????¨?D??
function setTab(name,cursel,n){
 for(i=1;i<=n;i++){
  var menu=document.getElementById(name+i);
  var con=document.getElementById("con_"+name+"_"+i);
  menu.className=i==cursel?"childhouverDiv":"childDiv";
  con.style.display=i==cursel?"block":"none";
  //self.scrollBy(0,document.body.scrollHeight)
 }
}
//?1?aè?2??????¨
function showTab(name,cursel,n){
 for(i=1;i<=n;i++){
  var menu=document.getElementById(name+i);
  var con=document.getElementById("con_"+name+"_"+i);
  if (menu.className=="childDiv"){
  menu.className="childhouverDiv";
  con.style.display="block";
  }
  else
  {
   menu.className="childDiv";
  con.style.display="none";
 }
  //self.scrollBy(0,document.body.scrollHeight)
 }
}

//下拉选取
function singleSelect(obj,val){
	if(obj==""||val=="")return false;
	if(document.getElementById(obj).options.length<1)return false;
	for (var i=0;i<document.getElementById(obj).options.length;i++ ){
		if (document.getElementById(obj).options(i).value==val){
			document.getElementById(obj).selectedIndex =i;
		}
	}
}
