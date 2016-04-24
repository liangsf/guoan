<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/back.css">
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/style.css">
    <script type="text/javascript" src="__PUBLIC__/Js/jquery.js"></script>
    <script type="text/javascript" src="__PUBLIC__/Js/public.js"></script>
    <script type="text/javascript" src="__PUBLIC__/Js/ArtDialog/artDialog.source.js?skin=twitter"></script>
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
            $(document).on('click', '.dele',function(){
                var delobj=$(this);
                var id=delobj.attr('attr');
                showConfirm('您确认要删除？删除将不可恢复', function(){
                    $.post("del", {id:id}, function(data){
                        if (data.status==1) {
                            delobj.parent().parent().parent().remove();
                        } else {
                            showMessage(data.info);
                        }
                    }, "json");
                });
            });

            // 显示编辑按钮
            $(document).on('mouseover', '.first p', function(){
                $('.first .edit').hide();
                $(this).find('.edit').show();
            })

            // 隐藏编辑按钮
            $(document).on('mouseput', '.first p', function(){
                $('.first .edit').hide();
            })

            // 获取下级方法
            $(document).on('click', 'span[rel=more]', function(){

                var more = $(this);
                if (more.attr('class') == 'funmore') {
                    more.addClass('funmore2').removeClass('funmore');
                    if (more.attr('attr')) {
                        $.post('__URL__/findFunc', {pid:more.attr('attr')}, function(data){
                            if (data) {
                                var html  = '<ul class="second">';
                                for (var i=0; i<data.length; i++) {
                                    html += '<li>';
                                    html += '<span rel="more" class="funmore" attr="' + data[i].fun_id + '"></span>';
                                    html += '<p>' + data[i].fun_name + '（' + data[i].fun_url + '）';
                                    html += '<span class="edit">';
                                    html += '<a href="edit?id=' + data[i].fun_id + '">[编辑]</a>';
                                    html += '<a href="#" class="dele" attr="' + data[i].fun_id + '">[删除]</a>';
                                    html += '</span>';
                                    html += '</p>';
                                    html += '</li>';
                                }
                                html += '</ul>';
                            }
                            more.parent().append(html);
                            more.next().next().slideToggle("slow");
                        }, "json");
                    }
                } else {
                    more.addClass('funmore').removeClass('funmore2');
                }
                more.next().next().slideToggle("slow");
            })
        });
    </script>
    <title>方法列表</title>
</head>
<body>
    <div class="contener">
        <div class="list_head_m">
            <div class="list_head_ml">当前位置：【方法列表】</div>
            <div class="list_head_mr"><a href="add" class="add">新增</a></div>
        </div>
        <form action="del" method="post" id="dos"  onSubmit="return confirm('执行后不可以恢复~确定要执行吗？');">
            <ul class="first">
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo["fun_rank"]) == "0"): ?><li>
                            <span rel="more" class="funmore"></span>
                            <p>
                                <?php echo ($vo["fun_name"]); ?>
                                <span class="edit">
                                    <a href="edit?id=<?php echo ($vo["fun_id"]); ?>">[编辑]</a>
                                    <a href="#" class="dele" attr="<?php echo ($vo["fun_id"]); ?>">[删除]</a>
                                </span>
                            </p>
                            <ul class="second">
                                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vos): $mod = ($i % 2 );++$i; if(($vos["fun_pid"]) == $vo["fun_id"]): ?><li>
                                            <span rel="more" class="funmore" attr="<?php echo ($vos["fun_id"]); ?>"></span>
                                            <p>
                                                <?php echo ($vos["fun_name"]); ?>
                                                <span class="edit">
                                                    <a href="edit?id=<?php echo ($vos["fun_id"]); ?>">[编辑]</a>
                                                    <a href="#" class="dele" attr="<?php echo ($vos["fun_id"]); ?>">[删除]</a>
                                                </span>
                                            </p>
                                        </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                        </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </form>
    </div>
</body>
</html>