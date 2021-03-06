<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>神州易桥信息管理系统</title>
    <link href="__PUBLIC__/Admin/Css/back.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="__PUBLIC__/Js/jquery.js"></script>
    <script type="text/javascript" src="__PUBLIC__/Js/flv/swfobject.js"></script>
    <script language="javascript">

        var menulist=<?php echo ($menulist); ?>;
        
        $(function($){

            // 显示顶部菜单
            showtopmenu();

            // 显示默认左侧菜单
            showleftmenu($('.top_menu').first().attr('id'));

            $('.menumid_list').hide();

            // 左侧隐现
            $('#switchPoint').click(function(){
                var left = $('#frmTitle');
                if(left.css("display") == 'none'){
                    left.show(); 
                    $('#switchPoint').attr("class","navPoint1");
                } else {
                    left.hide();
                    $('#switchPoint').attr("class","navPoint2");
                }
            });

            // 自适应高度
            var just_block = $('.middlel,.middler');
            just_block.css('height',$(window).height()-70+'px');
            $(window).resize(function(){just_block.css('height',$(window).height()-70+'px')});
            $('#bloading').hide();
            $('#body').fadeIn();

            // iframe加载效果
            $("#rightfr").load(function(){
                $("#loading").hide();
                $("#rightfr").fadeIn();

                // 限制内容中图片大小
                $("#rightfr").contents().find("img").not("#coverimg").each(function(){
                    if($(this).width() > 600){
                        $(this).height($(this).height()*(600/$(this).width()));
                        $(this).width(600);
                        $(this).wrap("<a href=" + $(this)[0].src + " target=_blank></a>");
                    }
                });
            });

            // 刷新按钮效果
            $("#refreash").click(function(){ 
                $("#rightfr").hide();
                $("#loading").show(); 
                window.right.location.reload();
            });

            // 按钮点击效果
            $(document).on('click', '.menumid_list li', function(){

                $('.menumid_list a').removeClass('hover');
                $(this).find('a').addClass('hover');
            })
        });

         
        // 左侧菜单
        function showleftmenu(target) {

            // 当前主菜单标题
            $('#menutop').html(menulist[target].title);
            var leftmenu='';
            var channels=menulist[target].channels;
            for (i=0; i<channels.length; i++) {
                if(channels[i]){
                    leftmenu+='<div class="menumid_tit">'+channels[i].channel+'</div><ul class="menumid_list">';
                    for(var j=0;j<channels[i].pages.length;j++){
                        leftmenu+='<li><a href="'+channels[i].pages[j].url+'" target="right">'+channels[i].pages[j].name+'</a></li>';
                    }
                    leftmenu+='</ul>';
                }
            }
            $('#menumid').html(leftmenu);

            // 菜单收起、显示
            $('.menumid_tit').click(function(){
                var list = $(this).next();
                if (list.css("display") == 'none') {
                    list.slideDown(); 
                } else {
                    list.slideUp();
                }
            });

            // iframe加载效果  
            $(".menumid_list a").click(function(){
                //$("#rightfr").hide();
                $("#loading").show();
            }); 
        }

        // 顶部菜单
        function showtopmenu() {
            var topmenu='';
            for(var i=0;i<menulist.length;i++){
                var flag=0;
                for (var j=0; j<menulist[i].channels.length; j++) {
                    if(menulist[i].channels[j]) flag=1;
                }
                if(flag) topmenu+='<a class="top_menu btn" id="'+i+'" href="#">'+menulist[i].title+'</a>';
            }
            $('#topmenu').html(topmenu);

            // 顶部菜单处理
            var topmenu=$('.top_menu');

            // 初始第一个为选中样式
            topmenu.first().addClass(" btn-primary");
            topmenu.click(function(){

                // 显示左菜单
                showleftmenu($(this).attr('id'));
                topmenu.removeClass(" btn-primary");
                $(this).addClass(" btn-primary");
                $('.menumid_list').hide();
            });
        }

        // 循环请求是否有新问答
        if ('<?php echo ($question); ?>' == '1') {
            setInterval(function(){
                $.post('__URL__/nocity', '', function(data){
                    if (data.status == '1') {
                        showTitle();
                    }
                }, 'json')
            }, 10000);
        }

        // 开始提示
        var s5 = new SWFObject("__PUBLIC__/Js/flv/flv.swf","playlist","698","508","7");

        function showTitle() { 

            $('#topinfo').show();
            var path = "__PUBLIC__/Js/flv/5103.mp3";
            s5.addParam("allowfullscreen", "true");
            s5.addVariable("autostart", "true");
            s5.addVariable('repeat', 'true');
            s5.addVariable("file", path);
            s5.addVariable("width", "10");
            s5.addVariable("height", "10");
            s5.write("r_flv");
        }

        // 停止提示
        function clearTitle() {

            s5.addVariable('autostart', 'false');
            s5.write("r_flv");
            $('#topinfo').hide();
        }
    </script>
</head>
<body style="overflow-y:hidden">
    <div id="bloading"></div>
    <div id="body">
        <table cellpadding="0" cellspacing="0" height="100%" width="100%">

            <!--头部开始-->
            <tr class="top_t">
                <td>
                    <div class="logo"></div>
                    <div id="topmenu"><!--js动态获得--></div>
                    <div id="topinfo">您有新的待回答!<a href="__GROUP__/Question/lists" target="right">去回答</a></div>
                    <div class="func">
                        <div class="link_info">当前用户：<?php echo ($user["nickName"]); ?></div>
                        <a class="link_index link" href="__URL__/index">首页</a>
                        <div class="link_up link"  onClick="history.go(1);">前进</div>
                        <div class="link_down link" onClick="history.go(-1);">后退</div>
                        <div class="link_flush link" id="refreash" onClick="history.go(1);">刷新</div>
                        <a class="link_ext link" href="__URL__/logout">退出</a>
                    </div>
                </td>
            </tr>
            <!--头部结束-->

            <!--中部开始-->
            <tr>
                <td>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="middlel" width="171" align="center" valign="top" id="frmTitle">
                                <div class="menumid" id="menumid"><!--js动态获得--></div>
                                <div class="menubot"><a target="_blank" href=""><?php echo ($ver); ?></a></div>  
                            </td>
                            <td width="15" valign="middle" class="middlem" >
                                <div class="navPoint1" id="switchPoint" title="关闭/打开左栏"></div>
                            </td>
                            <td class="middler" width="100%" align="center" valign="top">
                                <iframe name="right" id="rightfr" height="100%" width="100%" border="0" frameborder="0" src="__URL__/welcome"></iframe>
                                <div id="loading"></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!--中部结束-->
        </table>
    </div>
    <div id="r_flv" style="width:1px;height:1px; overflow:hidden"></div>
</body>
</html>