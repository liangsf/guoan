<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if($ttttt == 1): ?><title>公司注册、公司名称/地址变更、工商总局核名、公司注销、代理记账、商标注册/变更、软件著作权、发明专利_神州企业百科</title>
<meta name="Keywords" content="企业百科、公司注册、公司变更、工商核名、公司注销、代理记账、商标注册、商标变更、软件著作权、发明专利、外观设计专利、实用新型专利" />
<meta name="Description" content="神州企业百科提供公司注册、工商代办、公司注册、公司名称/地址变更、工商总局核名、公司注销、代理记账、商标注册/变更、软件著作权、发明专利等方面的企业百科资讯，轻松解决企业问题的一站式平台。" />
<?php elseif($ttttt == 2): ?>
<title>公司注册/变更/注销问答、代理记账问答、商标/著作权/专利问答_神州企业问答平台</title>
<meta name="Keywords" content="企业问答、企业问答平台、神州企业问答、企业服务平台、中小企业问答、神州企业知道" />
<meta name="Description" content="神州企业问答平台提供公司注册/变更/注销问答、代理记账问答、商标/著作权/专利问答等服务，为中小微企业提供免费的一站式问答服务。" />
<?php else: ?>
<title>公司注册、工商代办、公司名称/地址变更、工商总局核名、公司注销、代理记账、商标注册/变更、软件著作权、发明专利_神州企业服务平台</title>
<meta name="Keywords" content="公司注册、工商代办、公司注册、代办营业执照、营业执照代办、无地址注册公司、虚拟公司注册、虚拟注册地址、公司名称/地址变更、工商总局核名、公司注销、代理记账、商标注册/变更、软件著作权、发明专利、企业服务平台、企业服务。" />
<meta name="Description" content="神州网商学院是国内首家权威的企业服务平台，为中小微企业提供公司注册、工商代办、公司注册、代办营业执照、营业执照代办、无地址注册公司、虚拟公司注册、虚拟注册地址、公司名称/地址变更、工商总局核名、公司注销、代理记账、商标注册/变更、软件著作权、发明专利、企业服务平台、企业服务等企业服务。" /><?php endif; ?>

<link href="__PUBLIC__/Home/css/sxy_gb.css" rel="stylesheet" type="text/css" />
<script src="__PUBLIC__/Home/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script>
function search()
{
	var k = $("#keyword").val();
	if($.trim(k) == ""){
		$('#keyword').css('border', '1px solid red');
		setTimeout("$('#keyword').css('border', '1px solid #b6c6d6')", 2000);
		return false;
	}
	return true;
}
</script>
</head>
<body>
<!--头部 开始-->
<div class="header">
	<div class="header_box">
		<div class="logo fl"><a target="_blank" href="<?php echo (C("HOMEURL")); ?>"><img src="__PUBLIC__/Home/images/logo.png" alt="" /></a></div>
		<ul class="nav fl">
			<li><a target="_blank" href="<?php echo (C("HOMEURL")); ?>">首页</a></li>
			<li>
				<a href="<?php echo (C("HOMEURL")); ?>Slb" target="_blank" class="sl"><i></i>顺利办</a>
				<div class="sub_nav">
					<ul class="sub_nav_list">
						<li>
							<p>工商服务</p>
							<div class="z_list">
								<a href="<?php echo (C("HOMEURL")); ?>Slb/hdcytc" target="_blank">海淀创业套餐</a>
								<a href="<?php echo (C("HOMEURL")); ?>Slb/cycytc" target="_blank">朝阳创业套餐</a>
								<a href="<?php echo (C("HOMEURL")); ?>Slb/ftcytc" target="_blank">丰台创业套餐</a>
								<a href="<?php echo (C("HOMEURL")); ?>Slb/zgccytc" target="_blank">中关村平谷科技园创业套餐</a>
								<a href="<?php echo (C("HOMEURL")); ?>Slb/gsbgfw" target="_blank">公司变更服务</a>
								<a href="<?php echo (C("HOMEURL")); ?>Slb/zcshfw" target="_blank">增值审批服务</a>
							</div>
						</li>
						<li>
							<p>财税服务</p>
							<div class="z_list">
								<a href="<?php echo (C("HOMEURL")); ?>Slb/djz3" target="_blank">代理记账小规模企业3个月</a>
								<a href="<?php echo (C("HOMEURL")); ?>Slb/djz6" target="_blank">代理记账小规模企业6个月</a>
								<a href="<?php echo (C("HOMEURL")); ?>Slb/djz12" target="_blank">代理记账小规模企业12个月</a>
								<a href="<?php echo (C("HOMEURL")); ?>Slb/djzybr" target="_blank">代理记账一般纳税人</a>
								<a href="<?php echo (C("HOMEURL")); ?>Slb/djzwz" target="_blank">代理记账外资企业</a>
								<a href="<?php echo (C("HOMEURL")); ?>Slb/djzyz" target="_blank">验资/审计/评估</a>
							</div>
						</li>
						<li>
							<p>商标注册</p>
							<div class="z_list">
								<a href="<?php echo (C("HOMEURL")); ?>Slb/sbzcfw" target="_blank">商标注册服务</a>
								<a href="<?php echo (C("HOMEURL")); ?>Slb/jsjrj" target="_blank">计算机软件著作权</a>
								<a href="<?php echo (C("HOMEURL")); ?>Slb/wzms" target="_blank">文字美术版权</a>
								<a href="<?php echo (C("HOMEURL")); ?>Slb/sbzr" target="_blank">商标转让</a>
								<a href="<?php echo (C("HOMEURL")); ?>Slb/sbbg" target="_blank">商标变更</a>
								<a href="<?php echo (C("HOMEURL")); ?>Slb/sbyy" target="_blank">商标异议</a>
							</div>
						</li>
													<li>
							<p>社保代理</p>
							<div class="z_list">
								<a href="<?php echo (C("HOMEURL")); ?>Slb/bzxtc" target="_blank">标准型套餐</a>
								<a href="<?php echo (C("HOMEURL")); ?>Slb/bzxtc" target="_blank">标准型套餐</a>
								<a href="<?php echo (C("HOMEURL")); ?>Slb/bzxtc" target="_blank">标准型套餐</a>
							</div>
						</li>
					</ul>
				</div>
			</li>
			<li><a target="_blank" href="http://emall.12366.com/">企采团</a></li>
			<li class="active"><a href="/">商学院</a></li>
			<li><a target="_blank" href="<?php echo (C("HOMEURL")); ?>Bighome/Index/biglist">企博士</a></li>
			<li><a target="_blank" href="<?php echo (C("HOMEURL")); ?>Bighome/Index/qiyeyun">企业云</a></li>
			<li><a target="_blank" href="<?php echo (C("HOMEURL")); ?>Bighome/Integral">积分宝</a></li>
		</ul>
		<script>document.write('<script src="<?php echo (C("SITEURL")); ?>index.php/Dynamic/header?t='+Math.random()+'"><'+'/script>');</script>
	</div>
</div>
<!--头部 结束-->
<div class="index_cont">
	<div class="search_box">
		<div class="search">
			<div class="sel">
				<p class="/*hover*/">企业百科</p>
				<ul class="in_list bg_f">
					<li>企业百科</li>
					<!--<li onclick="window.open('http://www.12366.com/Home');">财税学堂</li>-->
				</ul>
			</div>
			<form method="get" target="_blank" action="__APP__/search" id="sousuo" onsubmit="return search();">
				<input class="text" name="keyword" id="keyword" type="text" value="" placeholder="请写下您所需常识的关键词">
				<a href="javascript:;" onclick="$('#sousuo').submit();" class="btn">搜索</a>
			</form>
			<div class="clear"></div>
		</div>
		<script>
			$(".sel p").click(function(){
				$(".sel p").addClass("hover");
				$(".in_list").show();
			});
			$(".in_list li").click(function(){
			   // $(".sel p").text($(this).text());
			    $(this).parent(".in_list").hide();
			    $(".sel p").removeClass("hover");
			});
		</script>
		<div class="tag_title">
			<a href="/" class="active">企业百科</a>
			<a target="_blank" href="http://www.12366.com/Home">财税学堂</a>
		</div>
	</div>
	<div class="index_main qybk" style="display:block;">
		<div class="index_main_box">
			<form method="get" action="__URL__/" id="searchform">
			<div class="main m_top bg_f">
				
				<ul class="big_tag">
					<?php if(is_array($tags)): $i = 0; $__LIST__ = $tags;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo["level"]) == "2"): ?><li <?php if($vo["id"] == $id): ?>class="active"<?php endif; ?>><a href="javascript:;" onclick="fun_topxz('id',<?php echo ($vo["id"]); ?>)"><?php echo ($vo["name"]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
					<input type="hidden" id="id" name="id" value="<?php echo ($tagsid); ?>">
					<input type="hidden" id="threetagsid" name="threetagsid" value="<?php echo ($threetagsid); ?>">
				</ul>
				<ul class="small_tag" style="display:block;">
					<?php if(is_array($mrthreetags)): $i = 0; $__LIST__ = $mrthreetags;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a <?php if($vo["id"] == $threetagsid): ?>class="hover"<?php endif; ?> href="javascript:;" onclick="fun_xz('threetagsid',<?php echo ($vo["id"]); ?>)"><?php echo ($vo["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>
			<div class="main m_bottom bg_f">
				<ul class="big_tag">
					<li <?php if($types == 1): ?>class="active"<?php endif; ?>><a href="javascript:;" onclick="fun_xz('types',1)">百科　<?php echo ($count['baike']); ?></a></li>
					<li <?php if($types == 2): ?>class="active"<?php endif; ?>><a href="javascript:;" onclick="fun_xz('types',2)">问答　<?php echo ($count['wenda']); ?></a></li>
					<input type="hidden" id="types" name="types" value="<?php echo ($types); ?>">
				</ul>
				</form>
				<ul class="list_box baike"style="display:block;">
					<?php if(is_array($baike["list"])): $i = 0; $__LIST__ = $baike["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
						<dl>
							<dt><a target="_blank" href="<?php echo ($vo["url"]); ?>" title="<?php echo ($vo["title"]); ?>"><?php echo ($vo["title"]); ?></a></dt>
							<dd>
								<p><?php echo (msubstr($vo["content"],0,120,'utf-8')); ?></p>
								<span><?php echo (date('Y-m-d H:i',$vo["addtime"])); ?></span>
							</dd>
						</dl>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
				<div class="page">
					<?php echo ($baike["page"]); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="index_main csxt" style="height:500px;">
		
	</div>
</div>
<!--脚部 开始-->

<div class="footer">
	<div class="footer_top">
		<div class="footer_top_box">
			<div class="link fl">
				<a href="http://www.eqiao.com.cn/" target="_blank">神州易桥集团</a>
				<a href="<?php echo (C("HOMEURL")); ?>Bighome/Index/biginfo?id=82" target="_blank">关于我们</a>
				<a href="<?php echo (C("HOMEURL")); ?>Bighome/Index/biginfo?id=83" target="_blank">联系我们</a>
				<a href="<?php echo (C("HOMEURL")); ?>Bighome/Index/biginfo?id=84" target="_blank">招贤纳士</a>
				<a href="<?php echo (C("HOMEURL")); ?>Bighome/Index/wangzhanditu" target="_blank">网站地图</a>
			</div>
			<div class="phone fr">服务热线：400-686-5658</div>
		</div>
	</div>
	<div class="footer_middle">
		<div class="box">
			<div class="logo_slb fl">
				<img src="__PUBLIC__/Home/images/logo2.png" alt="" />
				<p>顺利办-企业服务</p>
			</div>
			<div class="service fl">
				<ul class="nav_title">
					<li class="active"><a href="###">工商服务</a></li>
					<li><a href="###">财税服务</a></li>
					<li><a href="###">商标注册</a></li>
					<li><a href="###">社保代理</a></li>
				</ul>
				<ul class="nav_list" style="display:block;">
					<li><a href="<?php echo (C("HOMEURL")); ?>Slb/hdcytc" target="_blank">海淀创业套餐</a></li>
					<li><a href="<?php echo (C("HOMEURL")); ?>Slb/cycytc" target="_blank">朝阳创业套餐</a></li>
					<li><a href="<?php echo (C("HOMEURL")); ?>Slb/ftcytc" target="_blank">丰台创业套餐</a></li>
					<li><a href="<?php echo (C("HOMEURL")); ?>Slb/zgccytc" target="_blank">中关村平谷科技园创业套餐</a></li>
					<li><a href="<?php echo (C("HOMEURL")); ?>Slb/gsbgfw" target="_blank">公司变更服务</a></li>
					<li><a href="<?php echo (C("HOMEURL")); ?>Slb/zcshfw" target="_blank">增值审批服务</a></li>
				</ul>
				<ul class="nav_list">
					<li><a href="<?php echo (C("HOMEURL")); ?>Slb/djz3" target="_blank">代理记账小规模企业3个月</a></li>
					<li><a href="<?php echo (C("HOMEURL")); ?>Slb/djz6" target="_blank">代理记账小规模企业6个月</a></li>
					<li><a href="<?php echo (C("HOMEURL")); ?>Slb/djz12" target="_blank">代理记账小规模企业12个月</a></li>
					<li><a href="<?php echo (C("HOMEURL")); ?>Slb/djzybr" target="_blank">代理记账一般纳税人</a></li>
					<li><a href="<?php echo (C("HOMEURL")); ?>Slb/djzwz" target="_blank">代理记账外资企业</a></li>
					<li><a href="<?php echo (C("HOMEURL")); ?>Slb/djzyz" target="_blank">验资/审计/评估</a></li>
				</ul>
				<ul class="nav_list">
					<li><a href="<?php echo (C("HOMEURL")); ?>Slb/sbzcfw" target="_blank">商标注册服务</a></li>
					<li><a href="<?php echo (C("HOMEURL")); ?>Slb/jsjrj" target="_blank">计算机软件著作权</a></li>
					<li><a href="<?php echo (C("HOMEURL")); ?>Slb/wzms" target="_blank">文字美术版权</a></li>
					<li><a href="<?php echo (C("HOMEURL")); ?>Slb/sbzr" target="_blank">商标转让</a></li>
					<li><a href="<?php echo (C("HOMEURL")); ?>Slb/sbbg" target="_blank">商标变更</a></li>
					<li><a href="<?php echo (C("HOMEURL")); ?>Slb/sbyy" target="_blank">商标异议</a></li>
				</ul>
				<ul class="nav_list">
					<li><a href="<?php echo (C("HOMEURL")); ?>Slb/bzxtc" target="_blank">标准型套餐</a></li>
					<li><a href="<?php echo (C("HOMEURL")); ?>Slb/bzxtc" target="_blank">标准型套餐</a></li>
					<li><a href="<?php echo (C("HOMEURL")); ?>Slb/bzxtc" target="_blank">标准型套餐</a></li>
				</ul>
			</div>
			<div class="rwm fr">
				<img src="__PUBLIC__/Home/images/rwm.png" alt="" />
			</div>
		</div>
	</div>
	<div class="footer_bottom">
		<p class="copyright">Copyright © 1998 - 2015 All Rights Reserved. 　神州网版权所有<br />京ICP备10028182号　京公网安备110108400735号</p>
	</div>
</div>

<div class="window_right">
	<ul class="window">
		<li>
			<a href="javascript:;" class="a2"></a>
			<div class="hover_rwm">
				<img src="__PUBLIC__/Home/images/right_rwm.png" alt="" />
				<p>关注神州网公众号</p>
			</div>
		</li>
		<li class="back_top">
			<a href="javascript:;" class="a3"></a>
			<p class="hover_text">返回顶端</p>
		</li>
	</ul>
</div>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?d6e55a0630719621719ab28fbb30fd16";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
<!--脚部 结束-->

<script>
	//返回顶部
  	$(".window .back_top").click(function(){
  		$("html, body").animate({scrollTop: 0}, 500);
  	});
	//
	// $(".tag_title a").bind("click",function(){
	// 	var idx=$(".tag_title").find("a").index($(this));
	// 	//alert(idx);
	// 	$(".tag_title a").removeClass("active");
	// 	$(this).addClass("active");
	// 	$(".index_main").hide();
	// 	$(".index_main").eq(idx).show();
	// 	return false;
	// });
	//分类
	// $(".m_top .big_tag li").bind("click",function(){
	// 	var idx=$(".m_top .big_tag").find("li").index($(this));
	// 	//alert(idx);
	// 	$(".m_top .big_tag li").removeClass("active");
	// 	$(this).addClass("active");
	// 	$(".small_tag").hide();
	// 	$(".small_tag").eq(idx).show();
	// 	return false;
	// });
	// // 百科 问答
	// $(".m_bottom .big_tag li").bind("click",function(){
	// 	var idx=$(".m_bottom .big_tag").find("li").index($(this));
	// 	//alert(idx);
	// 	$(".m_bottom .big_tag li").removeClass("active");
	// 	$(this).addClass("active");
	// 	$(".list_box").hide();
	// 	$(".list_box").eq(idx).show();
	// 	return false;
	// });
	//footer
	$(".nav_title li").bind("click",function(){
		var idx=$(".nav_title").find("li").index($(this));
		//alert(idx);
		$(".nav_title li").removeClass("active");
		$(this).addClass("active");
		$(".nav_list").hide();
		$(".nav_list").eq(idx).show();
		return false;
	});



	//选中效果查询
	function fun_topxz(str,id){
		$('#'+str).val(id);
		$('#threetagsid').val(0);
		$('#searchform').submit();
	}
	function fun_xz(str,id){
		$('#'+str).val(id);
		$('#searchform').submit();
	}
</script>
</body>
</html>