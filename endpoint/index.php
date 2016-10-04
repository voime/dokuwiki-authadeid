<?php
if(!defined('DOKU_INC')) define('DOKU_INC',dirname(__FILE__).'/../../../../');
require_once(DOKU_INC.'inc/init.php');

// read client sert info to $data array
$s = $_SERVER['SSL_CLIENT_S_DN'];
$l = preg_split ('|/|', $s, -1, PREG_SPLIT_NO_EMPTY);
$valid_params = array("SN","GN","serialNumber");
    foreach ($l as $e) {
        list ($n, $v) = explode ('=', $e, 2);
        if(in_array($n,$valid_params)){
            $x=certstr2utf8($v);
            $data[$n]=$x;
        }
    }

// what is username?
$username = $data['serialNumber'];

if (validate($username)){
    // make session and redirect back
    $_SESSION['eid_username'] = $username;
    $gotowikiurl = DOKU_URL . 'doku.php?u='.$username.'&p=eid&id='.getId();
    header('Location: '.$gotowikiurl);

}else{

    echo "Something goes wrong!";

}

// validates username
// TODO: need smarter validation
function validate($username){
    if (strlen($username)==11){
        return true;
    }else{
        return false;
    }
}

// convert encoding
function certstr2utf8 ($str) {
    $str = preg_replace ("/\\\\x([0-9ABCDEF]{1,2})/e", "chr(hexdec('\\1'))", $str);
    $result="";
    $encoding=mb_detect_encoding($str,"ASCII, UCS2, UTF8");
    if ($encoding=="ASCII") {
        $result=mb_convert_encoding($str, "UTF-8", "ASCII");
    } else {
        if (substr_count($str,chr(0))>0) {
            $result=mb_convert_encoding($str, "UTF-8", "UCS2");
        } else {
            $result=$str;
        }
    }
    return $result;
}