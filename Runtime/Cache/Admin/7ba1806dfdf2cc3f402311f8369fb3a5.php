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
                { name:"name",min:2,simple:"方法名",focusMsg:'3-30个字符'},
            ];

            $("#info").skygqCheckAjaxForm({
                items : items_array
            });

            // 下拉选择菜单
            $('.funList').change(function(){

                var id = $(this).val();
                if (id == 0) {
                    $(this).parent().parent().next().hide();
                    if ($(this).attr('id') == 'funone') {
                        $(this).parent().parent().next().next().hide();
                    }
                } else {
                    $(this).parent().parent().next().show();
                }
                $(this).parent().parent().next().find('option').hide();
                $(this).parent().parent().next().find('option').each(function(){
                    if ($(this).attr('attr') == id || $(this).attr('attr') == 0) {
                        $(this).show();
                    }
                })
            })

            // 更改位置
            $('.save').click(function(){

                $('input[name=save]').val(1);
                $(this).parent().parent().hide();
                $(this).parent().parent().next().show();
            })

            $('#funone').change();
        });
    </script>
    <title>更改方法</title>
</head>
<body> 
    <div class="contener">
        <div class="list_head_m"><div class="list_head_ml">当前位置：【更改方法】</div></div>
        <form enctype="multipart/form-data" action="edit" method="post" id="info" name="info">
            <table class="all_cont" width="100%" border="0" cellpadding="5" cellspacing="1">
                <tr>
                    <td align="right" width="100"></td>
                    <td align="left"><a href="#" class="save">更改位置</a><input type="hidden" name="save" value="0" /></td>
                    <td class="inputhelp"></td>
                </tr>
                <tr style="display:none;">
                    <td align="right" width="100">选择一级模块：</td>
                    <td align="left">
                        <select name="funone" class="funList" id="funone">
                            <option attr="0" value="0" selected="selected">作为一级模块显示</option>
                                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo["fun_rank"]) == "0"): ?><option value="<?php echo ($vo["fun_id"]); ?>"><?php echo ($vo["fun_name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </td>
                    <td class="inputhelp">选择一级模块</td>
                </tr>
                <tr class="modelTwo">
                    <td align="right" width="100">选择二级模块：</td>
                    <td align="left">
                        <select name="funtwo" class="funList" id="funtwo">
                            <option attr="0" value="0" selected="selected">作为二级模块显示</option>
                                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo["fun_rank"]) == "1"): ?><option attr="<?php echo ($vo["fun_pid"]); ?>" value="<?php echo ($vo["fun_id"]); ?>"><?php echo ($vo["fun_name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </td>
                    <td class="inputhelp">选择二级模块</td>
                </tr>
                <tr class="modelThree">
                    <td align="right" width="100">方法等级：</td>
                    <td align="left">
                        <label>二级</label><input type="radio" name="show" id="show" value="2" <?php if(($info["fun_rank"]) == "2"): ?>checked="checked"<?php endif; ?> />
                        <label>三级</label><input type="radio" name="show" id="show" value="3" <?php if(($info["fun_rank"]) == "3"): ?>checked="checked"<?php endif; ?>/>
                    </td>
                    <td class="inputhelp">二级显示在左侧二级菜单 三级为隐藏方法</td>
                </tr>
                <tr class="modelFour">
                    <td align="right" width="100"><?php echo ($info["fun_show"]); ?>方法是否显示：</td>
                    <td align="left">
                        <label>显示</label>
                        <input type="radio" name="ishow" id="show" value='0' <?php if(($info["fun_show"]) == "0"): ?>checked="checked"<?php endif; ?> />
                        <label>不显示</label>
                        <input type="radio" name="ishow" id="show" value='1' <?php if(($info["fun_show"]) == "1"): ?>checked="checked"<?php endif; ?> />
                    </td>
                    <td class="inputhelp">方法是否显示</td>
                </tr>
                <tr>
                    <td align="right">方法名：</td>
                    <td align="left">
                        <input type="hidden" name="id" value="<?php echo ($info["fun_id"]); ?>" />
                        <input type="text" name="name" id="name" value="<?php echo ($info["fun_name"]); ?>" />
                    </td>
                    <td class="inputhelp">方法名</td>
                </tr>
                <tr>
                    <td align="right">方法地址：</td>
                    <td align="left">
                        <input type="text" name="url" id="url" value="<?php echo ($info["fun_url"]); ?>" />
                    </td>
                    <td class="inputhelp">方法地址</td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2" align="left">
                        <input type="submit" class="btn btn-primary btn-small" value="更新" />&nbsp;
                        <input class="btn btn-primary btn-small" type="reset" value="重置" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>