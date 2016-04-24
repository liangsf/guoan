<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/back.css" />
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/style.css" />
    <script type="text/javascript" src="__PUBLIC__/Js/jquery.js"></script>
    <script  type="text/javascript" language="javascript" src="__PUBLIC__/Js/jquery.skygqCheckAjaxform.js"></script>
	<script type="text/javascript" charset="utf-8" src="__PUBLIC__/Js/Ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="__PUBLIC__/Js/Ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="__PUBLIC__/Js/Ueditor/lang/zh-cn/zh-cn.js"></script>
	<script type="text/javascript" charset="utf-8" src="__PUBLIC__/Js/tags.js"></script>
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
                { name:"title",min:2,simple:"文章名称",focusMsg:'3-30个字符'},
            ];

            $("#info").skygqCheckAjaxForm({
                items : items_array
            });
        });
		function tijiao(){
			var chktag = $("input[name='tags[]']:checked");
			if(chktag.length<1){
				$("#tag_error").css('color', 'red');
				return false;
			}
			return true;
		}
    </script>
    <title>添加<?php echo ($optname); ?></title>
</head>
<body> 
    <div class="contener">
        <div class="list_head_m"><div class="list_head_ml">当前位置：【添加<?php echo ($optname); ?>】</div></div>
        <form enctype="multipart/form-data" action="edit" method="post" id="info" name="add" onsubmit="return tijiao();">
			<input type="hidden" name="id" value="<?php echo ($info["id"]); ?>" />
            <table class="all_cont" width="100%" border="0" cellpadding="5" cellspacing="1">
                <tr>
                    <td align="right">标题：</td>
                    <td align="left">
                        <input type="text" name="title" value="<?php echo ($info["title"]); ?>" id="title" />
                    </td>
					<td class="inputhelp">标题</td>
                </tr>
				<tr>
                    <td align="right">短标题：</td>
                    <td align="left">
                        <input type="text" name="shorttitle" value="<?php echo ($info["shorttitle"]); ?>" id="shorttitle" />
                    </td>
					<td class="inputhelp">短标题</td>
                </tr>
				<tr>
                    <td align="right">作者：</td>
                    <td align="left">
                        <input type="text" name="writer" value="<?php echo ($info["writer"]); ?>" id="writer" />
						<select name="w_id" onchange="document.add.writer.value=document.add.w_id.value">
							<option value="选择作者">选择作者</option>
							<?php if(is_array($wts)): $i = 0; $__LIST__ = $wts;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["writer"]); ?>"><?php echo ($vo["writer"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
						<a href="__GROUP__/Writer/lists" target="_blank">增加作者</a>
                    </td>
					<td class="inputhelp">作者</td>
                </tr>
				<tr>
                    <td align="right">来源：</td>
                    <td align="left">
                        <input type="text" name="source" value="<?php echo ($info["source"]); ?>" id="source" />
						<select name="o_id" onchange="document.add.source.value=document.add.o_id.value">
							<option value="选择作者">选择来源</option>
							<?php if(is_array($ors)): $i = 0; $__LIST__ = $ors;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["name"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
						<a href="__GROUP__/Origin/lists" target="_blank">增加来源</a>
                    </td>
					<td class="inputhelp">来源</td>
                </tr>
				<tr>
                    <td align="right">文章标签：</td>
                    <td align="left">
						一级
						<select name="t_one" id="tag_f" onchange="gettags(this,'#tag_w')">
							<option>请选择</option>
							<?php if(is_array($tags)): $i = 0; $__LIST__ = $tags;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo["id"]) == $info["t_one"]): ?><option selected="selected" value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option>
								<?php else: ?>
								<option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
						</select>
						二级
						<select name="t_two" id="tag_w" onchange="gettags(this,'#tag_s')">
							<option>请选择</option>
							<?php if(is_array($tag_two)): $i = 0; $__LIST__ = $tag_two;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo["id"]) == $info["t_two"]): ?><option selected="selected" value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option>
								<?php else: ?>
								<option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
						</select>
                    </td>
					<td class="inputhelp">文章标签</td>
                </tr>
				<tr>
                    <td align="right">选择标签：</td>
                    <td align="left" id="tag_s">
                        <?php if(is_array($tag_three)): $i = 0; $__LIST__ = $tag_three;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; $tag_arr = explode(',',$info['t_id']); if(in_array($vo['id'],$tag_arr)){ ?>
							<input type="checkbox" name="tags[]" checked="checked" value="<?php echo ($vo["id"]); ?>" /><?php echo ($vo["name"]); ?>
							<?php }else{ ?>
							<input type="checkbox" name="tags[]" value="<?php echo ($vo["id"]); ?>" /><?php echo ($vo["name"]); ?>
							<?php } endforeach; endif; else: echo "" ;endif; ?>
                    </td>
					<td class="inputhelp">选择标签</td>
                </tr>
				<tr>
                    <td align="right">文章内容：</td>
                    <td align="left">
						<script id="sdjx" name="content" type="text/plain" style="width:630px;height:200px;"><?php echo ($info["content"]); ?></script>
                    </td>
					<td class="inputhelp">文章内容</td>
                </tr>
				<tr>
    <td align="right">附件上传：</td>
    <td align="left">
        <ul class="allContentList myFile">
            <?php if(!empty($info["att_id"])): if(is_array($info["att_id"])): $i = 0; $__LIST__ = $info["att_id"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                        <p title="<?php echo ($vo["attname"]); ?>">
                            <a href="/<?php echo ($vo["url"]); ?>" target="_blank"><?php echo (msubstr($vo["attname"],0,32)); ?></a>
                            <a href="javascript:;" class="fileDelete">删除</a>
                        </p>
                        <input name="files[]" type="hidden" value="<?php echo ($vo["id"]); ?>" />
                    </li><?php endforeach; endif; else: echo "" ;endif; endif; ?>
        </ul>
        <div class="fileUpload">
            <input type="button" value="上传附件" onclick="inputFiles('.expertPic');" class="button" />
            <input type="file" name="picture" id="picture" class="expertPic" onchange="previewImage()" />
        </div>
    </td>
    <td class="inputhelp">附件上传</td>
</tr>
<script type="text/javascript" src="__PUBLIC__/Js/ajaxfileupload.js"></script>
<script type="text/javascript">

    $(function(){

        if ($("#hideFile").val() == 1) {
            $('.fileUpload,.fileDelete').hide();
        }

        $(document).on('click', '.fileDelete', function(){

            $(this).parent().parent().remove();
        })
    })
    function inputFiles(name) {
        return $(name).click();
    }

    // 异步上传图片
    function previewImage(url) {

        url = url ? url : '__URL__/fileUpload';
        $.ajaxFileUpload({
            url: url,
            data:{},
            dataType: 'json',
            fileElementId: 'picture',
            success: function (info) {

                if (info.status) {

                    var html = '';
                    html += '<li>';
                    html += '    <p title="' + info.data.name + '">' + info.data.name.substring(0,32) + '<a href="javascript:;" class="fileDelete">删除</a></p>';
                    html += '    <input name="files[]" type="hidden" value="' + info.data.id + '" />';
                    html += '</li>';
                    $(html).appendTo('.myFile');
                } else {
                    showMessage(info.info);
                }
            },
            error: function (info) {
                alert('ok')
                showMessage('图片上传失败');
            }
        });
    }
</script>
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

</script>
</html>
<script language="javascript">

    // 实例化编辑器
    var sd = UE.getEditor('sdjx', {
        toolbars: [
            ['source', '|', 'undo', 'redo', '|', 'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'indent', 'formatmatch', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'fullscreen'],
            ['fontfamily', 'fontsize', 'justifyleft', 'justifyright', 'justifycenter', 'justifyjustify', 'link', 'unlink', 'anchor', 'simpleupload', 'insertvideo', 'inserttable']
        ],
        autoHeightEnabled  : false,
        enableAutoSave     : false,
        elementPathEnabled : false,
        wordCount          : false,
        width              : '530px'
    });
</script>