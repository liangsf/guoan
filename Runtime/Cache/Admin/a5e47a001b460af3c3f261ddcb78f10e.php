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

            // 处理执行选择
            $('#dotype').change(function(){
                var delaction= "__URL__/del" ;
                if('del'==$(this).val()){
                    $('#dos').attr('action',delaction);
                    $('#col').hide();
                }else if('change'==$(this).val()){
                    $('#dos').attr('action',changeaction);
                    $('#col').show();
                }
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
                        alert(data.message);
                    }
                });
                }
            });
        });

    </script>
    <title>用户组列表</title>
</head>
<body>
    <div class="contener">
        <div class="list_head_m">        
            <div class="list_head_ml">当前位置：【用户组列表】</div>
            <div class="list_head_mr"><a href="add" class="add">新增</a></div>
        </div>

        <table width="100%" border="0" cellpadding="0" cellspacing="1"   class="all_cont">
            <form action="del" method="post" id="dos"  onSubmit="return confirm('执行后不可以恢复~确定要执行吗？');"> 
                <tr>
                    <th width="70">
                        <input style="color:#E2E2E2" type="checkbox" name="chkAll" value="checkbox" onClick="CheckAll(this.form)"/>
                    </th>
                    <th width="70">ID</th>
                    <th>用户组名称</th>
                    <th>用户组权限</th>
                    <th>管理选项</th>
                </tr>
                <?php if(is_array($info["list"])): $i = 0; $__LIST__ = $info["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="<?php echo ($vo["gr_id"]); ?>">
                        <td align="center"><input style="color:#E2E2E2" type="checkbox" name="delid[]" value="<?php echo ($vo["gr_id"]); ?>"/></td>
                        <td align="center"><?php echo ($vo["gr_id"]); ?></td>
                        <td><?php echo ($vo["gr_name"]); ?></td>
                        <td title="<?php echo ($vo["gr_diction"]); ?>"><?php echo (msubstr($vo["gr_diction"],0,90,'utf-8')); ?></td>
                        <td align="center"><a href="edit?id=<?php echo ($vo["gr_id"]); ?>" class="edt">编辑</a><div class="del">删除</div></td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                <tr>
                    <td colspan="3">
                        <div class="listdo"><input type="submit" class="btn btn-small"  value="删除"></div>
                    </td>
                    <td colspan="5"><div class="pagelist"><?php echo ($info["page"]); ?></div></td>
                </tr>
            </form>
        </table>
    </div>
</body>
</html>