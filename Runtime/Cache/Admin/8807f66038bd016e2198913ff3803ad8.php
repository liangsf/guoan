<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>神州易桥信息管理系统_用户登录</title>
    <script language="javascript">

        // 重载验证码
        function fleshVerify() {
            var timenow = new Date().getTime();
            document.getElementById('verifyImg').src= "__URL__/verify/"+timenow;
        }

    </script>
    <style type="text/css">
        .newbody { background:url("__PUBLIC__/Admin/Images/spt_login_bg.jpg"); background-size:cover; }
		<!--
        body {
            background-color:#f7f7f7;
        }
        * {
            margin:0;
            padding:0;
            font-size:12px;
            font-family:'微软雅黑';
        }
        .STYLE1 {
            color: #333;
            font-size: 12px;
			line-height:27px;
			float:left;
        }
        .con {
            background:url(__PUBLIC__/Admin/Images/login_bg.png) center no-repeat;
            width:489px;
            height:341px;
            position:absolute;
            left:50%;
            top:50%;
            margin:-170px 0 0 -244px;
        }
        .for {
            padding:100px 0 0 100px;
        }
        td {
            height:45px;
        }
        .intext {
            height:25px;
            line-height:25px;
            border:1px solid #ccc;
            font-size:12px; color:#333;
            padding:0 5px;
			float:left;
        }
        .code {
            float:left;
            height:27px;
			margin-right:10px;
        }
        #verifyImg {
			height:27px;
            cursor:pointer;
        }
        -->
    </style>
</head>

<body class="newbody">
    <div class="con">
        <div class="for">
            <form action=""  method="post" >
                <div style="width:200px; float:left">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td width="25%" align="right"><span class="STYLE1">用&nbsp;&nbsp;&nbsp;户：</span></td>
                            <td width="75%"><input type="text" name="adm_username" id="username" class="intext" size="18"></td>
                        </tr>
                        <tr>
                            <td align="right"><span class="STYLE1">密&nbsp;&nbsp;&nbsp;码：</span></td>
                            <td><input type="password" name="adm_password" id="password" class="intext" size="18"></td>
                        </tr>
                        <tr>
                            <td  align="right"><span class="STYLE1">验证码：</span></td>
                            <td>
                                <div class="code"><input type="text" name="verify" id="checkcode" class="intext" size="4"></div>
                                <div class="code"><img src="verify" border="0" height="27" width="50" onClick="fleshVerify()" id="verifyImg"/></div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="float:left; width:83px; padding-top:8px"><input type="image" src="__PUBLIC__/Admin/Images/dl.gif" width="83" height="75"></div>
            </form>
        </div>
        <div style="display:block; clear:both; text-align:center; padding-top:60px; color: #999"><?php echo ($ver); ?> Copyright @2012-2013</div>
    </div>
</body>
</html>