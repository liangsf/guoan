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
                        alert(data.info);
                    }
                }, "json");
                }
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
            <form action="" method="get" id="colum" >
                <tr>
                    <td></td>
                    <td colspan="3"></td>
                    <td colspan="4" align="left">
                        <div style="float:left">搜索标题/内容：<input type="text" name="keyword" size="20" value="<?php echo ($keyword); ?>"></div>
                        <div style="float:left"><input type="submit" class="btn btn-success btn-small" value="搜索"></div>
                    </td>
                </tr>
            </form>
            <form action="del" method="post" id="dos"  onSubmit="return confirm('执行后不可以恢复~确定要执行吗？');"> 
                <tr>
                    <th width="70">
                        <input style="color:#E2E2E2" type="checkbox" name="chkAll" value="checkbox" onClick="CheckAll(this.form)"/>
                    </th>
                    <th width="70">ID</th>
                    <th>文章标题</th>
                    <th>所选标签</th>
                    <th>录入时间</th>
                    <th>管理选项</th>
                </tr>
                <?php if(is_array($list["list"])): $i = 0; $__LIST__ = $list["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr id="<?php echo ($vo["id"]); ?>">
                        <td align="center"><input style="color:#E2E2E2" type="checkbox" name="delid[]" value="<?php echo ($vo["id"]); ?>"/></td>
                        <td align="center"><?php echo ($vo["id"]); ?></td>
                        <td><?php echo ($vo["title"]); ?></td>
                        <td><?php echo ($vo["tagname"]); ?></td>
                        <td><?php echo (date('Y-m-d H:i',$vo["addtime"])); ?></td>
                        <td align="center">
                            <?php echo ($vo["cs_button"]); ?>
                        </td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                <tr>
                    <td colspan="2">
                        <div class="listdo"><input type="submit" class="btn btn-small"  value="删除"></div>
                    </td>
                    <td colspan="5"><div class="pagelist"><?php echo ($list["page"]); ?></div></td>
                </tr>
            </form>
        </table>
    </div>
</body>
</html>