<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/back.css" />
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/style.css" />
    <script type="text/javascript" src="__PUBLIC__/Js/jquery.js"></script>
    <script  type="text/javascript" language="javascript" src="__PUBLIC__/Js/jquery.skygqCheckAjaxform.js"></script>
    <script language="javascript">
        $(function ($) { 

            // 行颜色效果
            $('.all_cont tr').hover(function () {
                $(this).children().css('background-color', '#f2f2f2');
            },function () {
                $(this).children().css('background-color', '#fff');
            });

            // 表单验证
            var items_array = [
                { name:"name",min:2,simple:"广告名称",focusMsg:'3-30个字符'},
            ];

            $("#info").skygqCheckAjaxForm({
                items : items_array
            });
        });
    </script>
    <title>添加<?php echo ($optname); ?></title>
</head>
<body> 
    <div class="contener">
        <div class="list_head_m"><div class="list_head_ml">当前位置：【添加<?php echo ($optname); ?>】</div></div>
        <form enctype="multipart/form-data" action="edit" method="post" id="info" name="info">
			<input type="hidden" name="id" id="id" value="<?php echo ($info["id"]); ?>" />
            <table class="all_cont" width="100%" border="0" cellpadding="5" cellspacing="1">
                <tr>
                    <td align="right">广告名称：</td>
                    <td align="left">
                        <input type="text" name="name" value="<?php echo ($info["name"]); ?>" id="name" />
                    </td>
					<td class="inputhelp">广告名称</td>
                </tr>
				<tr>
                    <td align="right">广告地址：</td>
                    <td align="left">
                        <input type="text" name="adlink" value="<?php echo ($info["link"]); ?>" id="adlink" />
                    </td>
					<td class="inputhelp">广告地址</td>
                </tr>
				<tr>
                    <td align="right">展示类型：</td>
                    <td align="left">
                        <input type="radio" <?php if($info["type"] == 0): ?>checked="checked"<?php endif; ?> value="0" name="adtype" id="pic_type" />图片
                        <input type="radio" <?php if($info["type"] == 1): ?>checked="checked"<?php endif; ?> name="adtype" value="1" id="html_type" />html代码
                    </td>
					<td class="inputhelp">展示类型</td>
                </tr>
				<tr id="pic_area" <?php if($info["type"] == 1): ?>style="display:none;"<?php endif; ?>>
                    <td align="right">图片及说明：</td>
                    <td align="left">
                        <input type="file" name="pic" id="pic" />
						<?php if($info["type"] != ''): ?><input type="hidden" name="picurl" value="<?php echo ($info["pic"]); ?>" />
						<div style="width:60px;height:60px;float:right;"><img src="/<?php echo ($info["pic"]); ?>" width="50" height="50" /></div><?php endif; ?>
						<br />					
                        图片说明：<input type="text" value="<?php echo ($info["content"]); ?>" name="content" id="content" />
						
                    </td>
					<td class="inputhelp">图片及说明(图片要求200*100像素)</td>
                </tr>
				<tr id="html_area" <?php if($info["type"] == 0): ?>style="display:none;"<?php endif; ?>>
                    <td align="right">html代码：</td>
                    <td align="left">
                        <textarea name="adhtml" cols="70" rows="10"><?php echo ($info["html"]); ?></textarea>
                    </td>
					<td class="inputhelp">html代码：</td>
                </tr>
				<tr>
                    <td align="right">打开方式：</td>
                    <td align="left">
                        <input type="radio" name="adopen" <?php if($info["open"] == 0): ?>checked="checked"<?php endif; ?> value="0" id="adopen" />新窗口
                        <input type="radio" name="adopen" <?php if($info["open"] == 1): ?>checked="checked"<?php endif; ?> value="1" id="adopen" />本窗口
                    </td>
					<td class="inputhelp">打开方式</td>
                </tr>
				<tr>
                    <td align="right">广告位置：</td>
                    <td align="left">
                        <input type="radio" name="adpos" <?php if($info["position"] == 0): ?>checked="checked"<?php endif; ?> value="0" id="adpos" />底部
                        <input type="radio" name="adpos" <?php if($info["position"] == 1): ?>checked="checked"<?php endif; ?> value="1" id="adpos" />侧边
                        <input type="radio" name="adpos" <?php if($info["position"] == 2): ?>checked="checked"<?php endif; ?> value="2" id="adpos" />搜索页右侧
                    </td>
					<td class="inputhelp">广告位置</td>
                </tr>
				<tr>
                    <td align="right">广告分类：</td>
                    <td align="left">
                        <input type="radio" name="category" <?php if($info["category"] == 1): ?>checked="checked"<?php endif; ?> value="1" id="adpos" />广告
                        <input type="radio" name="category" <?php if($info["category"] == 2): ?>checked="checked"<?php endif; ?> value="2" id="adpos" />采购
                        <input type="radio" name="category" <?php if($info["category"] == 3): ?>checked="checked"<?php endif; ?> value="3" id="adpos" />应用
                    </td>
					<td class="inputhelp">广告分类</td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2" align="left">
                        <input type="submit" class="btn btn-primary btn-small" value="修改" />&nbsp;
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
<script>
$(document).ready(function(){
	$("#pic_type").bind("click",function(){
		$("#pic_area").show();
		$("#html_area").hide();
	});
	$("#html_type").bind("click",function(){
		$("#pic_area").hide();
		$("#html_area").show();
	});
});
</script>
</html>