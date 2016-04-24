<?php

// 特殊字符过滤
function htmldecode($str){
    if (empty($str)) return;
    if ($str=="") return $str;
    $str = str_replace("&"," ",$str);
    $str = str_replace(">"," ",$str);
    $str = str_replace("<"," ",$str);
    $str = str_replace("chr(32)"," ",$str);
    $str = str_replace("chr(9)"," ",$str);
    $str = str_replace("chr(34)"," ",$str);
    $str = str_replace("\""," ",$str);
    $str = str_replace("chr(39)"," ",$str);
    $str = str_replace(""," ",$str);
    $str = str_replace("'"," ",$str);
    $str = str_replace("select"," ",$str);
    $str = str_replace("join"," ",$str);
    $str = str_replace("union"," ",$str);
    $str = str_replace("where"," ",$str);
    $str = str_replace("insert"," ",$str);
    $str = str_replace("delete"," ",$str);
    $str = str_replace("update"," ",$str);
    $str = str_replace("like"," ",$str);
    $str = str_replace("drop"," ",$str);
    $str = str_replace("create"," ",$str);
    $str = str_replace("modify"," ",$str);
    $str = str_replace("rename"," ",$str);
    $str = str_replace("alter"," ",$str);
    $str = str_replace("cas"," ",$str);
    $str = str_replace("replace"," ",$str);
    $str = str_replace("%"," ",$str);
    $str = str_replace("or"," ",$str);
    $str = str_replace("and"," ",$str);
    $str = str_replace("!"," ",$str);
    $str = str_replace("xor"," ",$str);
    $str = str_replace("not"," ",$str);
    $str = str_replace("user"," ",$str);
    $str = str_replace("||"," ",$str);
    $str = str_replace("<"," ",$str);
    $str = str_replace(">"," ",$str);
    return $str;
}

// 中文字符串截取
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix='...') {
    if (strlen($str)<=3*$length) {
        return $str;
    }
    if (function_exists("mb_substr")) {
        return mb_substr($str, $start, $length, $charset) . $suffix;
    } elseif (function_exists('iconv_substr')) {
        return iconv_substr($str,$start,$length,$charset) . $suffix;
    }
    $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";

    preg_match_all($re[$charset], $str, $match);
    $slice = join("", array_slice($match[0], $start, $length));
    return $slice . $suffix;
}

/*
 * getValueByField
 * 获取数组字段值
 * @param array $array 数组 默认为 array()
 * @param string $field 字段名 默认为id
 *
 * @return array $result 数组(各字段值)
 *
 */
function getValueByField($array = array(), $field = 'id') {
    $result = array();
    if (is_array($array)) {
        foreach ($array as $key => $value) {
            $result[] = $value[$field];
        }
    }
    return $result;
}

/*
 * getDataByArray
 * 通过关联数组获取数据
 * @param string $table 表名
 * @param array $array 数组
 * @param string $arrayField 数组的字段
 * @param string $getField 要获取的字段
 *
 * @return array $result 获取的数据
 *      使用参考：通过活动获取对应的课时列表,传递M(课时), 活动数组及课时ID字段
 */
function getDataByArray($table, $array, $arrayField, $getField = '*') {
    $result = array();
    $result = M($table)->where(array($arrayField => array('IN', implode(',', getValueByField($array, $arrayField)))))->field($getField)->select();
    return setArrayByField($result, $arrayField);
}

/*
 * setArrayByField
 * 根据字段重组数组
 * @param array $array 数组 默认为 array()
 * @param string $field 字段名 默认为id
 *
 * @return array $result 重组好的数组
 *
 */
function setArrayByField($array = array(), $field = 'id', $status = 0) {
    $result = array();
    if (is_array($array)) {
        foreach ($array as $key => $value) {
        	if (!$status) {
        		$result[$value[$field]] = $value;
        	} else {
        		$result[$value[$field]][] = $value;
        	}
        }
    }
    return $result;
}

// 根据字段排序
function sortByField($arr, $field) {

    $count = count($arr);
    for ($i = 0; $i < $count; $i ++) {

        for ($j = $count-1; $j > $i; $j --) {

            if ($arr[$j][$field] < $arr[$i][$field] ) {

                $tmp = $arr[$j];
                $arr[$j] = $arr[$i];
                $arr[$i] = $tmp;
            }
        }
    }
    return $arr;
}

// 获取文件后缀名
function getFileExt($filename) {

    $pathinfo = pathinfo($filename);
    return $pathinfo['extension'];
}

function myStripSlashes($str) {
    return stripslashes($str);
}

function myAddSlashes($str) {
    return get_magic_quotes_gpc() ? $str : addslashes($str);
}

function mk_dir($dir, $mode = 0755) {
    if (is_dir($dir) || @mkdir($dir,$mode)) return true;
    if (!mk_dir(dirname($dir),$mode)) return false;
    return @mkdir($dir,$mode);
}


// 获取中英文混搭字符串的长度
function strAllLength($str,$charset='utf-8'){
    if($charset=='utf-8') {
        $str = iconv('utf-8','gb2312',$str);
    }
    $num = strlen($str);
    $cnNum = 0;
    for($i=0;$i<$num;$i++){
        if(ord(substr($str,$i+1,1))>127){
            $cnNum++;
            $i++;
        }
    }
    $enNum = $num-($cnNum*2);
    $number = ($enNum/2)+$cnNum;
    return ceil($number);
}

/**
 * getPathInfo
 * 根据文件名获取文件信息
 *
 * @param string $fileName 文件名
 *
 * @return array $result 文件名称的分割的数组
 */
function getPathInfo($fileName = '') {

    if ($fileName) {

        // 分割数组
        $pathinfo = explode('.', $fileName);

        // 获取上传文件扩展名
        $result['ext'] = end($pathinfo);

        // 删除扩展名
        array_pop($pathinfo);

        // 拼接其他数据
        $pathinfo = implode($pathinfo);

        // 按路径分割
        $pathinfo = explode('/', $pathinfo);

        // 获取文件名
        $result['name'] = end($pathinfo);

        // 删除文件名
        array_pop($pathinfo);

        // 留下路径
        $result['path'] = implode('/', $pathinfo);
    }
    return $result;
}


/*
 * getListByPage
 * 根据页码获取列表
 * @param string  $table           表名
 * @param string  $order           排序
 * @param array   $where           条件 默认为array()
 * @param int     $every_page_num  每页显示数量 默认为10
 * @param int     $ajax            是否AJAX
 * @param int     $p               页码
 * @param int     $field           字段
 * @return array $result 数组
 *         + array $result['list'] 结果集
           + string $result['page'] 分页
 */
function getListByPage($table, $order, $where = array(), $every_page_num = 10, $ajax = 0, $p = "", $field = '*', $group = '') {

    // 要返回的数组
    $result = array();

    if ($num > C('LIST_MAX_COUNT')) {
        return $result;
    }

    // 初始化参数
    $_GET['p'] = intval($_GET['p'])? intval($_GET['p']) : 1;
    $every_page_num = intval($every_page_num) > 0 ? intval($every_page_num) : C('PAGE_SIZE');

    if ($p) {
        $_GET['p'] = intval($p)? intval($p) : 1;
    }

    $Source = is_object($table) ? $table : M($table);

    if ($group) {
        $count= count($Source->where($where)->group($group)->select());
    } else {
        $count= $Source->where($where)->count();
    }

    // 获取总页数
    $regNum = ceil($count / $every_page_num);

    // 验证当前请求页码是否大于总页数
    if ($_GET['p'] > $regNum) {
        return $result;
    }

    if (intval($ajax)) {
        import("ORG.Util.AjaxPage");
        $Page = new AjaxPage($count, $every_page_num);
    } else {
        import("ORG.Util.Page");
        $Page = new Page($count, $every_page_num);
    }

    $result['count'] = $count;
    $result['page']  = trim($Page->show());
    $result['p']  = $_GET['p'];
    $result['list']  = (array)$Source->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->group($group)->field($field)->select();
    return $result;
}

/**
 * testDiction
 * 检测用户权限
 *
 * @param string $funcName 方法名
 * @param string $cacheName 方法名
 *
 * @return boolean
 */
function testDiction($funcName = '', $cacheName = '', $sessionName = '') {

    if (empty($funcName) || empty($cacheName) || empty($sessionName)) {
        return false;
        exit;
    }

    $user = session($sessionName);
    if ($user['diction'] == '#' && $user['userName'] == 'admin') {
        return true;
        exit;
    }

    $diction = F($cacheName);
    if (empty($diction[$funcName]['fun_id']) || empty($user['diction'])) {
        return false;
    }

    if (in_array($diction[$funcName]['fun_id'], $user['diction'])) {
        return true;
    } else {
        return false;
    }
}

/**
 *   通过接口发送邮件 由于服务器不支持访问外网
 *   邮件发送类
 *   $emial  收件人地址
 *   $content 发送的内容
 *   $title  邮件标题
 *
 *
 */
function sendEmail($emial, $content, $title) {

    // 修改为调用eai发送邮件
   $baowen = array(
		"SID"=>'110004',
		"PARAMS"=>array(
			'EMAIL'=>$emial,
			'SUBJECT'=>$title,
			'TEXT'=>$content,
		),
		'REQID'=>1
	);
	//'{"SID":110004, "PARAMS":{"EMAIL":"'.$emial.'", "SUBJECT":"'.$title.'", "TEXT":"'.$content.'"}, "REQID":1}'
    $apiRs = javaInterface($baowen);
    $rs = $apiRs->RESULT;
    return $rs->ERR_CODE;
}


/**
 * isLongin
 * 判断用户是否登录
 * $type  1为不跳转，0跳转。可不传为不跳转
 *
 */
function isLongin($type = "") {

    $redurl = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    //setrawcookie('__12366_MALL_BACKEND_URL__', 'http://' . $redurl, time()+3600, "/", C('SERVER_HTTP_HOST_YV'));
    $cookie_ticket = cookie('BCE1B411E4A0ABC72C515E0');
    $uid = session('userid');
    if (empty($cookie_ticket)) {
        session('username', null);
        session('userid', null);
        session('qydm', null);
        session('sjhm', null);
        if ($type == 1) {
            return 0;
        } else {
            $url = C('LOGINURL');
            header("Location: {$url}index.php/Userlogin/index");
        }
    } else {
        if (!empty($cookie_ticket)) {
            include_once('Common/jiamiwenjian/jiami_cookie.php');
            $usersdata = jiemi_cookie($cookie_ticket);
            $userinfo = D('Auth')->getUserInfo($usersdata['uid']);
            session('username', $usersdata['loginId']);
            session('userid', $usersdata['uid']);
            session('qydm', $userinfo['a_qydm']);
            session('sjhm', $userinfo['a_phone']);
        }
        if ($type == 1 ){
            return 1;
        } else {
            return 1;
        }
    }
}

/**
 * javaInterface
 * java接口请求
 *
 * @param string $param json参数
 *
 * @return object 接口返回的参数
 */
function javaInterface($param) {

    import("ORG.Util.ThirdApi");
    $objThird = new ThirdApi();
    return $objThird->request_api($param);
}

/**
 * request_by_other
 * 调用接口方法
 * $remote_server  请求的地址
 * $post_string    传入的数据
 *
 */
function request_by_other($remote_server, $post_string) {

    $timeout = 10;
    $context = array(
        'http' => array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-javascript'."\r\n".'User-Agent : Jimmy\'s POST Example beta'."\r\n".'Content-length: '.strlen($post_string)+8,
            'content' => "1449" . $post_string
        ),
        'timeout' => $timeout
    );
    $stream_context = stream_context_create($context);
    $data = file_get_contents($remote_server, FALSE, $stream_context);
    return $data;
}


/**
 * 通过ip获取区域信息
 *
 *
 */
function get_city($ip = '') {
    $timeout = array(
        'http' => array(

            // 设置一个超时时间，单位为秒
            'timeout'=>5
        )
    );

    $ctx = stream_context_create($timeout);

    $ip = empty($ip) ? getIP() : $ip;
    $url = "http://api.map.baidu.com/location/ip?ak=F454f8a5efe5e577997931cc01de3974&ip=" . $ip;
    $res = javaInterface('{"SID":110007,"PARAMS":{"URL":"' . $url . '"}}');
    return json_decode($res->RESULT);
}

/**
 * 绕过代理获取客户端的IP
 *
 *
 */
function getIP(){
    global $ip;
    if (getenv("HTTP_CLIENT_IP")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } else if (getenv("HTTP_X_FORWARDED_FOR")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    } else if (getenv("REMOTE_ADDR")) {
        $ip = getenv("REMOTE_ADDR");
    } else {
        $ip = "Unknow";
    }
    return $ip;
}

	
//上传文件方法
function imgUpload($path='',$ext='',$thumb=false,$width="100",$height="100",$maxSize='10000000'){
    header("Content-type: text/html; charset=utf-8");
    import("ORG.Net.UploadFile");
    $upload = new UploadFile();// 实例化上传类
    $upload->maxSize = $maxSize ;// 设置附件上传大小
    if(empty($ext)){
        $upload->allowExts = array('jpg', 'gif', 'png','docx','doc','xlsx','xls','txt','rar','pdf');// 设置附件上传类型
    }else{
        $upload->allowExts = explode(',',$ext);// 设置附件上传类型
    }
    //$M_C = S('M_C'.$uid);
    $upload->autoSub = true;
    $upload->subType=date;
    $upload->dateFormat='Y-m-d';
    $upload->hashLevel=1;
    //$filedate = date('Ymd',time()).'_'.$uid;
    $savePath = $path.$filedate.'/';
    $upload->savePath = 'Uploads/'.$savePath;// 设置附件上传目录
    
    //生成缩略图
    if($thumb){
        $upload->thumb=true;
        $upload->thumbMaxWidth=$width;
        $upload->thumbMaxHeight=$height;
    }
    //$allowExts_arry= array('.jpg', '.gif', '.png', '.bmp','.docx','.doc','.xlsx','.xls','.txt','.rar');
    //$upload->saveRule = str_replace($allowExts_arry,'',$_FILES['Filedata']['name']);
    //$upload->saveRule = time();
    if(!$upload->upload()) {

        // 上传错误时，提示的错误信息
        $err = $upload->getErrorMsg();
        return $err;
    }else{
        // 上传成功 获取上传文件信息
        $info = $upload->getUploadFileInfo();
        return $info;
    }
}

/**
 * arrayPage
 * 数据切割
 * $list   要切割的数组
 * $num    切割的数字
 *
 * return 三维数组
 */
function explodeArray($list = array(), $num = 1) {

    if (empty($list)) {
        return false;
    }

    $newArray = array();
    for ($i=0; $i<floor(count($list)/$num); $i++) {

        $newArray[] = array_slice($list, $i*$num,$num);
    }
    return $newArray;
}
/**
 * 返回缩略图的图片路径
 */
function thumb($img_url){
	if(empty($img_url)) return '';
	$thumb_img = 'thumb_'.trim(strrchr($img_url,'/'),'/');
	$url_ar = explode('/',$img_url);
	return $url_ar[0].'/'.$url_ar[1].'/'.$url_ar[2].'/'.$thumb_img;
}

/**
 * 增加财富值
 *{"SID":"9331","PARAMS":{"UID":"622867","ACTID":"140006JL0017"}}
 */

function wealth($userid) {
	
	$apiRs = javaInterface('{"SID":9331,"PARAMS":{"UID":"' . $userid . '","ACTID":"140006JL0017"}}');
	
}


/**
 * 获取post get 参数
 * @author	lsf880101@foxmail.com
 */
function getParam($key){
	return $_REQUEST[$key];
}

/**
 * 根据时间获取显示时间
 * @author	lsf880101@foxmail.com
 */
function time_tran($the_time){

    $now_time = date("Y-m-d H:i:s",time());
    $now_time = strtotime($now_time);
    $show_time = strtotime($the_time);
    $dur = $now_time - $show_time;
    if($dur < 0){
        return $the_time;
    }else{
        if($dur < 60){
            if($dur == 0){
                return '刚刚';
            }else{
                return $dur.'秒前';
            }
        }else{
            if($dur < 3600){
                return floor($dur/60).'分钟前';
            }else{
                if($dur < 86400){
                    return floor($dur/3600).'小时前';
                }else{
                    if($dur < 259200){//3天内
                       return floor($dur/86400).'天前';
                    }else{
                       return $the_time;
                    }
                }
            }
        }
    }
}

function fileUpload() {

    $img['status'] = 0;
    $img['info']   = '';
    $img['data']   = '';
    if ($_FILES['picture']['name']) {
        if ($_POST['name']) {
            unlink('.' . $_POST['name']);
        }
        $up_info = imgUpload('Manage', 'jpg,png,jpeg', false);
        if (!is_array($up_info)) {
            $img['info']   = $up_info;
            echo json_encode($img);
            exit;
        }
        $img['status'] = 1;
        $img['info']   = '上传成功';
        $img['data']   = $up_info[0]['savepath'] . $up_info[0]['savename'];
        echo json_encode($img);
    } else {

        $img['info']   = '请上传图片';
        echo json_encode($img);
    }
}
function WriteFiletext_n($filepath,$string){
	//global $public_r;
	$fp=@fopen($filepath,"w");
	@fputs($fp,$string);
	@fclose($fp);
	/*if(empty($public_r[filechmod]))
	{
		@chmod($filepath,0777);
	}*/
}
//通过区域代码获取 区域名称 $cj级别 1省2市3县 $ljf连接符
function getNameByQydm($qy_dm,$cj=1,$ljf=' '){
	if(empty($qy_dm)) return '';
	$qyMod = D('Dm_qy');
	$qy_mc = '';
	$where = array();
	if($cj==1){
		$where['qy_dm'] = array('in',$qy_dm);
	}elseif($cj==2){
		$sub1 = substr($qy_dm,0,2)."0000";
		$sub2 = substr($qy_dm,0,4)."00";
		$where['qy_dm'] = array('in',"{$sub1},{$sub2}");
	}elseif($cj==3){
		$sub1 = substr($qy_dm,0,2)."0000";
		$sub2 = substr($qy_dm,0,4)."00";
		$sub3 = $qy_dm;
		$where['qy_dm'] = array('in',"{$sub1},{$sub2},{$sub3}");
	}
	$list = $qyMod->where($where)->field('qy_mc')->select();
	foreach($list as $k=>$v){
		$qy_mc .= $v['qy_mc'].$ljf;
	}
	$qy_mc = trim($qy_mc,$ljf);
	return $qy_mc;
}


//获取wx-js config配置
function getWxConfig($userid=''){
	$rs = javaInterface('{"SID":1652, "PARAMS":{"UID":"'.$userid.'"}, "REQID":1}');
	$arr['jsapi_ticket'] = $rs->RESULT;
	$arr['noncestr'] = make_nonceStr();
	$arr['timestamp'] = time();
	return $arr;
}
//随机 签名字符串
function make_nonceStr()
{
	$codeSet = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	for ($i = 0; $i<16; $i++) {
		$codes[$i] = $codeSet[mt_rand(0, strlen($codeSet)-1)];
	}
	$nonceStr = implode($codes);
	return $nonceStr;
}
?>
