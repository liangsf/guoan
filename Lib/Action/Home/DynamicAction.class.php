<?php
/**
 * DynamicAction
 * 首页
 *
 * 作    者: 梁少峰
 * 创建时间: 2015-06-05
 *
 */
 

class DynamicAction extends Action {
	public $newsinfo_tx;
	public function header(){
		$login_status = isLongin(1);
		$uc_site_url = C('LOGINURL');
		$site_url = C('SITEURL');
		$sessusername = session('username');
		if($login_status == 1){
$html=<<<ETO
<div class="header_right fr"><div class="header_icon fl" style="display:none;"><i></i></div><div class="name fl"><p><a href="{$uc_site_url}index.php">{$sessusername}</a><i></i></p><ul class="drop bg_f"><li><a href="{$uc_site_url}index.php" class="a1">我的神州网</a></li><li><a href="{$uc_site_url}index.php/Userlogin/login_quit" class="a2">退出登录</a></li></ul></div></div>
ETO;
			echo "document.write('".$html."')";
		}else{
$html=<<<ETO
<ul class="loginbar fr"><li><a href="{$uc_site_url}index.php/Userlogin/index">登录</a></li><li>|</li><li><a href="{$uc_site_url}index.php/User/signin">注册</a></li></ul>
ETO;
			echo "document.write('".$html."')";
		}
		
	}

	//营改增专题
	public function ygz_header(){
		$login_status = isLongin(1);
		$uc_site_url = C('LOGINURL');
		$site_url = C('SITEURL');
		$sessusername = session('username');
		if($login_status == 1){
$html=<<<ETO
<div class="header_right fr"><div class="name fl"><p><a href="{$uc_site_url}index.php">{$sessusername}</a><i></i></p><ul class="drop bg_f"><li><a href="{$uc_site_url}index.php" class="a1">我的神州网</a></li><li><a href="{$uc_site_url}index.php/Userlogin/login_quit" class="a2">退出登录</a></li></ul></div></div>
ETO;
			echo "document.write('".$html."')";
		}else{
$html=<<<ETO
<ul class="loginbar fr"><li><a href="{$uc_site_url}index.php/Userlogin/index">登录</a></li><li>|</li><li><a href="{$uc_site_url}index.php/User/signin">注册</a></li></ul>
ETO;
			echo "document.write('".$html."')";
		}

	}

}