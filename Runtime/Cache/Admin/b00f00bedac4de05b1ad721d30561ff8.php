<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/back.css">
    <script type="text/javascript" src="__PUBLIC__/Js/jquery.js"></script>
    <script language="javascript">

        // 复选框全选/取消
        function CheckAll(form) {
            for (var i=0;i<form.elements.length;i++) { 
                var e = form.elements[i]; 
                if (e.Name != "chkAll"&&e.disabled!=true) 
                e.checked = form.chkAll.checked; 
            }
        }

        $(function ($) {

            // 行颜色效果
            $('.all_cont tr').hover(function () {
                $(this).children().css('background-color', '#f2f2f2');
            },function () {
                $(this).children().css('background-color', '#fff');
            });

            // ajax操作
            $('.del').click(function(){
                if(confirm('删除将不可恢复~')){
                var delobj=$(this).parent().parent();
                var id=delobj.attr('id');
                $.post("del", {id:id}, function(data){
                    if (data.status==1) {
                        delobj.remove();
                    } else {
                        alert(data.info);
                    }
                }, "json");
                }
            });
			
			//编辑edt
			$('.edt').click(function(){
				var delobj=$(this).parent().parent();
				var id=delobj.attr('id');
				var name=delobj.children('.writer').children('input').val();

				$.post("edit", {id:id,name:name}, function(data){
                    if (data.status==1) {
						alert(data.info);
                    }
                }, "json");
			});
        });

    </script>
    <title><?php echo ($optname); ?></title>
</head>
<body>
    <div class="contener">
        <div class="list_head_m">        
            <div class="list_head_ml">当前位置：【<?php echo ($optname); ?>列表】</div>
            <div class="list_head_mr"><a href="add" class="add">新增</a></div>
        </div>
		<table width="100%" border="0" cellpadding="0" cellspacing="1"   class="all_cont">
			<tr><th>增加来源</th></tr>
			<tr>
				<form action="add" method="post">
				<td>来源名称：<input type="text" name="name" />&nbsp;&nbsp;<input type="submit" value="添加" /></td>
				</form>
			</tr>
		</table>
        <table width="100%" border="0" cellpadding="0" cellspacing="1"   class="all_cont">
                <tr>
                    <th width="70">ID</th>
                    <th>来源名字</th>
					<th>操作</th>
                </tr>
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="<?php echo ($vo["id"]); ?>">
                        <td align="center"><?php echo ($vo["id"]); ?></td>
                        <td class="writer"><input name="name" value="<?php echo ($vo["name"]); ?>" /></td>
                        <td align="center"><div class="edt">修改</div><div class="del">删除</div></td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
    </div>
</body>
</html>