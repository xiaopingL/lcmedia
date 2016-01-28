<?php

/**
 * Validate email address
 *
 * @access	public
 * @return	bool
 */
if ( ! function_exists('valid_email')) {
    function valid_email($address) {
        return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $address)) ? FALSE : TRUE;
    }
}


/**
 * Validate url
 *
 * @access	public
 * @return	bool
 */
if ( ! function_exists('valid_url')) {
    function valid_url($url) {
        return ( ! preg_match("|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i", $url)) ? FALSE : TRUE;
    }
}


if ( ! function_exists('valid_mobile')) {
    function valid_mobile($mobile) {
        if(explode('-', $mobile)>1) {
            $mobileStr = "/(^(86)\-(\d{3,4})\-(\d{7,8})\-(\d{1,4})$)"
                    ."|(^(\d{3,4})\-(\d{7,8})$)"
                    ."|(^(\d{3,4})\-(\d{7,8})\-(\d{1,4})$)"
                    ."|(^(86)\-(\d{3,4})\-(\d{7,8})$)"
                    ."|(^(\d{7,8})$)/";
            return ( ! preg_match($mobileStr, $mobile)) ? FALSE : TRUE;
        }else {
            return ( ! preg_match("/^13[0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/", $mobile)) ? FALSE : TRUE;
        }
    }
}

/**
 * Validate email date
 *
 * @access	public
 * @return	bool
 */
if ( ! function_exists('valid_date')) {
    function valid_date($str,$format="Y-m-d") {
        $strArr = explode("-",$str);
        if(empty($strArr)) {
            return false;
        }
        foreach($strArr as $val) {
            if(strlen($val)<2) {
                $val="0".$val;
            }
            $newArr[]=$val;
        }
        $checkDate= date($format,strtotime(implode("-",$newArr)));
        if($checkDate==implode("-",$newArr))
            return true;
        else
            return false;
    }
}


/**
 * Validate isEmail
 *
 * @access	public
 * @return	bool
 */
if ( ! function_exists('valid_isEmail')) {
    function valid_isEmail($subject) {
        preg_match('/([a-z0-9A-Z]+)@([a-z0-9A-Z]+).([a-z0-9A-Z]{0,3})/i',$subject,$matches);
        if(!empty($matches)) {
            return true;
        }else {
            return false;
        }

    }
}


/**
 * Validate isMobile
 *
 * @access	public
 * @return	bool
 */
if ( ! function_exists('valid_isMobile')) {
    function valid_isMobile($subject) {
        preg_match('/([0-9]{11})/i',$subject,$matches);
        if(!empty($matches)) {
            return true;
        }else {
            return false;
        }
    }
}


/**
 * Validate isTel
 *
 * @access	public
 * @return	bool
 */
if ( ! function_exists('valid_isTel')) {
    function valid_isTel($subject) {
        preg_match('/([0-9]{2,4}+)-([0-9]{7})/i',$subject,$matches);
        if(!empty($matches)) {
            return true;
        }else {
            return false;
        }
    }
}


/**
 * Validate isUrl
 *
 * @access	public
 * @return	bool
 */
if ( ! function_exists('valid_isUrl')) {
    function valid_isUrl($subject) {
        preg_match('/http(s)?:\/\/[a-z0-9A-Z]+[.]+[a-z0-9A-Z]+[.]+[a-z0-9A-Z].*/i',$subject,$matches);
        if(!empty($matches)) {
            return true;
        }else {
            return false;
        }
    }
}

?>
