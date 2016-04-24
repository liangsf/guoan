<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/back.css" />
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Admin/Css/style.css" />
    <script type="text/javascript" src="__PUBLIC__/Js/jquery.js"></script>
    <title>添加<?php echo ($optname); ?></title>
</head>
<body> 
<?php if($info["type"] == 1): echo ($info["html"]); ?>
<?php else: ?>
<a href="<?php echo ($info["link"]); ?>" <?php if($info["open"] == 1): ?>target="_blank"<?php endif; ?> ><img src="/<?php echo ($info["pic"]); ?>" width="200" height="100" /></a><?php endif; ?>
</body>
</html>