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
    <title>顺利办预约信息</title>
</head>
<body>
    <div class="contener">
        <div class="list_head_m">        
            <div class="list_head_ml">当前位置：【顺利办预约信息】</div>
        </div>
        <table width="100%" border="0" cellpadding="0" cellspacing="1"   class="all_cont">
        <form action="del" method="post" id="dos"  onSubmit="return confirm('执行后不可以恢复~确定要执行吗？');"> 
            <tr>
                <th width="70">
                    <input style="color:#E2E2E2" type="checkbox" name="chkAll" value="checkbox" onClick="CheckAll(this.form)"/>
                </th>
                <th width="70">ID</th>
                <th>姓名</th>
                <th>电话</th>
                <th>邮箱</th>
                <th>需求</th>
                <th>时间</th>
                <th>操作</th>
            </tr>
            <?php if(is_array($list["list"])): $i = 0; $__LIST__ = $list["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="<?php echo ($vo["slb_id"]); ?>">
                    <td align="center"><input style="color:#E2E2E2" type="checkbox" name="delid[]" value="<?php echo ($vo["slb_id"]); ?>"/></td>
                    <td align="center"><?php echo ($vo["slb_id"]); ?></td>
                    <td align="center"><?php echo ($vo["slb_name"]); ?></td>
                    <td align="center"><?php echo ($vo["slb_tel"]); ?></td>
                    <td align="center"><?php echo ($vo["slb_email"]); ?></td>
                    <td align="center"><?php echo ($vo["slb_content"]); ?></td>
                    <td align="center"><?php echo (date("Y-m-d H:i",$vo["slb_time"])); ?></td>
                    <td align="center"><!-- <div class="edt">修改</div> --><div class="del">删除</div></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            <tr>
                <td colspan="2">
                    <div class="listdo"><input type="submit" class="btn btn-small"  value="删除">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="__URL__/daochu">导出</a></div>
                </td>
                <td colspan="6"><div class="pagelist"><?php echo ($list["page"]); ?></div></td>
            </tr>
        </form>
    </table>
    </div>
</body>
</html>