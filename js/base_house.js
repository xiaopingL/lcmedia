	var Wi = [ 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2, 1 ];// 加权因子
	var ValideCode = [ 1, 0, 10, 9, 8, 7, 6, 5, 4, 3, 2 ];// 身份证验证位值.10代表X
	function IdCardValidate(idCard) {  
	    idCard = trim(idCard.replace(/ /g, ""));  
	    if (idCard.length == 15) {  
	        return isValidityBrithBy15IdCard(idCard);  
	    } else if (idCard.length == 18) {  
	        var a_idCard = idCard.split("");// 得到身份证数组
	        if(isValidityBrithBy18IdCard(idCard)&&isTrueValidateCodeBy18IdCard(a_idCard)){  
	            return true;  
	        }else {  
	            return false;  
	        }  
	    } else {  
	        return false;  
	    }  
	}  
	/**
	 * 判断身份证号码为18位时最后的验证位是否正确
	 * 
	 * @param a_idCard
	 *            身份证号码数组
	 * @return
	 */ 
	function isTrueValidateCodeBy18IdCard(a_idCard) {  
	    var sum = 0; // 声明加权求和变量
	    if (a_idCard[17].toLowerCase() == 'x') {  
	        a_idCard[17] = 10;// 将最后位为x的验证码替换为10方便后续操作
	    }  
	    for ( var i = 0; i < 17; i++) {  
	        sum += Wi[i] * a_idCard[i];// 加权求和
	    }  
	    valCodePosition = sum % 11;// 得到验证码所位置
	    if (a_idCard[17] == ValideCode[valCodePosition]) {  
	        return true;  
	    } else {  
	        return false;  
	    }  
	}  
	/**
	 * 通过身份证判断是男是女
	 * 
	 * @param idCard
	 *            15/18位身份证号码
	 * @return 'female'-女、'male'-男
	 */ 
	function maleOrFemalByIdCard(idCard){  
	    idCard = trim(idCard.replace(/ /g, ""));// 对身份证号码做处理。包括字符间有空格。
	    if(idCard.length==15){  
	        if(idCard.substring(14,15)%2==0){  
	            return 'female';  
	        }else{  
	            return 'male';  
	        }  
	    }else if(idCard.length ==18){  
	        if(idCard.substring(14,17)%2==0){  
	            return 'female';  
	        }else{  
	            return 'male';  
	        }  
	    }else{  
	        return null;  
	    }  
	}  
	 /**
		 * 验证18位数身份证号码中的生日是否是有效生日
		 * 
		 * @param idCard
		 *            18位书身份证字符串
		 * @return
		 */ 
	function isValidityBrithBy18IdCard(idCard18){  
	    var year =  idCard18.substring(6,10);  
	    var month = idCard18.substring(10,12);  
	    var day = idCard18.substring(12,14);  
	    var temp_date = new Date(year,parseFloat(month)-1,parseFloat(day));  
	    // 这里用getFullYear()获取年份，避免千年虫问题
	    if(temp_date.getFullYear()!=parseFloat(year)  
	          ||temp_date.getMonth()!=parseFloat(month)-1  
	          ||temp_date.getDate()!=parseFloat(day)){  
	            return false;  
	    }else{  
	        return true;  
	    }  
	}  
	  /**
		 * 验证15位数身份证号码中的生日是否是有效生日
		 * 
		 * @param idCard15
		 *            15位书身份证字符串
		 * @return
		 */ 
	  function isValidityBrithBy15IdCard(idCard15){  
	      var year =  idCard15.substring(6,8);  
	      var month = idCard15.substring(8,10);  
	      var day = idCard15.substring(10,12);  
	      var temp_date = new Date(year,parseFloat(month)-1,parseFloat(day));  
	      // 对于老身份证中的你年龄则不需考虑千年虫问题而使用getYear()方法
	      if(temp_date.getYear()!=parseFloat(year)  
	              ||temp_date.getMonth()!=parseFloat(month)-1  
	              ||temp_date.getDate()!=parseFloat(day)){  
	                return false;  
	        }else{  
	            return true;  
	        }  
	  }  
	// 去掉字符串头尾空格
	function trim(str) {  
	    return str.replace(/(^\s*)|(\s*$)/g, "");  
	}  
	

	// 返回对象
	function retobj(retobj){
		return document.getElementById(retobj);
	}
	
	
	// 隐藏对象
	function un_display(objid){
		if ( retobj(objid).style.display == 'none' ) {
			retobj(objid).style.display="";
		} else {
			retobj(objid).style.display="none";
		}
	}
	
	// 控制BODY背景
	function checkBodyColor(bodyid){
		if ( retobj(bodyid).style.background == '#ddd' ) {
			retobj(bodyid).style.background = '#fff';	
		} else {
			retobj(bodyid).style.background = '#ddd';	
		}
	}
	
	// 表单验证
	function checkForm(str,submitForm){
		var arr = str.split('<|$|>');
		var val = '';
		var vname="";
		for(var i = 0; i < arr.length; i++){
			var valStr = arr[i];
			if(valStr != ''){
				var valArr = valStr.split('|@|');
				if(submitForm[valArr[1]]){
					val = submitForm[valArr[1]].value;
					vname=submitForm[valArr[1]].name;
					var valType = valArr[2];
					if(valType == 1 && val == ''){	
						alert('请填写'+valArr[0]);
						submitForm[valArr[1]].focus();
						return false;
					}else if(vname == 'email' && val != ''){        // email
						if(! /^\w*@\w*\.\w*$/.test(val)){
							alert("邮箱格式不正确");
							submitForm[valArr[1]].focus();
							return false;
						}
					}else if(vname == 'mobilePhone' && val != ''){  // 电话
						if(! /^((0\d{2,3}-\d{7,8})|(1[3584]\d{9}))$/.test(val)){
							alert("手机/电话格式不正确,只允许出现数字或 - 组合");
							submitForm[valArr[1]].focus();
							return false;
						}
					}else if(vname == 'idCode' && val != ''){       // 身份证
						if(! IdCardValidate(val)){
							alert("身份证号码不正确 .请重新输入 ! ");
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
	
	// 表单提交
	function submitForm(checkInput,submitForm){
		//var checkInput = retobj(checkInput).value;
		var checkInput = submitForm[checkInput].value;
		if ( checkInput == '' ) {return false;}
		var check = checkForm(checkInput,submitForm);// 表单验证
		submitForm.action='http://usercrm.xkhouse.com/index.php/OutsideApply/applyInfo/';
		return check;
	}

	//实例化ajax 
	function xml(){
	  var xmlhttp
	  if(window.ActiveXObject){
		   xmlHttp= new ActiveXObject('Microsoft.XMLHTTP');
	  }else if(window.XMLHttpRequest){
		   xmlHttp= new XMLHttpRequest();
	  }
	}

	//去除前后空格
	function Trim(m){   
	  while((m.length>0)&&(m.charAt(0)==' '))   
	  m   =   m.substring(1, m.length);   
	  while((m.length>0)&&(m.charAt(m.length-1)==' '))   
	  m = m.substring(0, m.length-1);   
	  return m;   
	} 