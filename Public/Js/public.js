
// 信息提示
function showMessage(message) {
    art.dialog({
        lock:        true,
        title:       '提示信息',
        drag:        false,
        background:  '#333', // 背景色
        opacity:     0.0,    // 透明度
        ok:          function () {},
        content:     message,
        time:        '100'
    });
}

// 确认对话框
function showConfirm(content, fun) {

    art.dialog({
        lock:        true,
        title:       '提示信息',
        drag:        false,
        background:  '#333',
        opacity:     0.0,
        cancelVal:   '关闭',
        ok:          function () {
            fun.call();
        },
        cancel: function () {},
        content:     content,
        time:        '100'
    });
}

// 确认对话框aa
function showConfirms(content,fun) {

    art.dialog({
        lock:        true,
        title:       '提示信息',
        drag:        false,
        background:  '#333',
        opacity:     0.0,
        cancelVal:   '关闭',
        ok:          function () {
			fun.call();
		},
		close:       function(){
			fun.call();
		},
        content:     content,
        time:        '100'
    });
}

// 登录提示
function showLogin(status) {

    document.domain='12366.com';
    /*
    url = url ? url : "http://ucenter5.12366.com/index.php/Userlogin/loginSmall";
    art.dialog.open(url, {
        title      : '登录',
        id         : 'opensp',
        //cancel     : false,
        cancelVal:   '关闭',
        lock       : true,
        drag       : false,
        background : '#333', // 背景色
        opacity    : 0.0, // 透明度
        width      : 450,
        height     : 400
    });*/
    var ifr = document.createElement('iframe');
    status  = status ? status : 0.0;
    ifr.src = 'http://ucenter5.12366.com/index.php/Userlogin/loginSmall';
    ifr.id            = 'iframeLogin';
    ifr.width         = '480';
    ifr.height        = '335';
    //ifr.frameborder   = 0;
    ifr.style.display = 'none';
    ifr.style.border  = '1px solid #f00';
    //document.body.appendChild(ifr);
    art.dialog({
        lock:        true,
        title:       '神州网',
        id         : 'opensp',
        drag:        false,
        background:  '#000',
        opacity:     status,
        cancelVal:   '关闭',
        content:     '<iframe src="http://ucenter5.12366.com/index.php/Userlogin/loginSmall" id="iframeLogin" width="450" height="335" frameborder="0" style="display: block; border: none"></iframe>',
        time:        '100',
        padding:     '0'
    });
}

// 更改iframe高
function saveHeight(height) {
    document.getElementById("iframeLogin").height = height;
}

// 绑定手机号
function showPhone(url) {

    document.domain='12366.com'; 

    /*url = url ? url : "http://ucenter5.12366.com/index.php/Binding/bindPhoneSmall";
    art.dialog.open(url, {
        title      : '绑定手机号',
        id         : 'opensp',
        //cancel     : false,
        cancelVal:   '关闭',
        lock       : true,
        drag       : false,
        background : '#333', // 背景色
        opacity    : 0.0, // 透明度
        width      : 360,
        height     : 240
    });*/

    var ifr = document.createElement('iframe');
    ifr.src = 'http://ucenter5.12366.com/index.php/Binding/bindPhoneSmall';
    ifr.id            = 'iframeBd';
    ifr.width         = '370';
    ifr.height        = '260';
	ifr.frameborder    = '0';
    ifr.style.display = 'none';
    ifr.style.border  = '0';
    document.body.appendChild(ifr);
    art.dialog({
        lock:        true,
        title:       '神州网',
        id         : 'opensp',
        drag:        false,
        background:  '#333',
        opacity:     0.0,
        cancelVal:   '关闭',
        content:     '<iframe src="http://ucenter5.12366.com/index.php/Binding/bindPhoneSmall" id="iframeLogin" width="370" height="260" frameborder="0" style="display: block; border: none"></iframe>',
        time:        '100'
    });
}

//关闭art弹出层
function closeDialog(id){
	art.dialog({id: id}).close();
}

// 检测图片格式
function checkImg(src, errImg) {

    var strs = src.split(";")[0];
    if (!strs[1]) {

        // IE格式检测
        var strs = src.split(".");
        strs = strs[strs.length-1];
    } else {
        strs = strs.split("/")[1];
    }
    strs = strs.toLowerCase();
    if (strs == 'png' || strs == 'jpg' || strs == 'jpeg') {

    } else {
        showMessage("图片上传格式错误");
        src = errImg ? errImg : "/Public/Manage/images/fwjg_35.png";
    }

    return src;
}

function inputFiles(name) {
    return $(name).click();
}

// 异步上传图片
function previewImage(url) {
	//var cur_img = $('#imghead').attr('src');
	//$('#imghead').attr('src', '/Public/Daguanjia/images/waitings.gif');
    $.ajaxFileUpload({
        url: url,
        data:{name:$('#uploadImg').val()},
        dataType: 'json',
        fileElementId: 'picture',
        success: function (data) {
            if (data.status) {
                //saveImg();
                $('#imghead').attr('src', '/' + data.data);
                $('.grzx_tx_icon img').attr('src', '/' + data.data);
                $('#uploadImg').val(data.data)
            } else {
				//$('#imghead').attr('src', cur_img);
                showMessage(data.info);
            }
        },
        error: function (data) {
            showMessage('图片上传失败');
        }
    });
}

// 个人中心 异步上传图片
function previewImage_zrzx(url) {
	var cur_img = $('#imghead').attr('src');
	$('#imghead').attr('src', '/Public/Daguanjia/images/waitings.gif');
    $.ajaxFileUpload({
        url: url,
        data:{name:$('#uploadImg').val()},
        dataType: 'json',
        fileElementId: 'picture',
        success: function (data) {
            if (data.status) {
                saveImg();
                $('#imghead').attr('src', '/' + data.data);
                $('.grzx_tx_icon img').attr('src', '/' + data.data);
                $('#uploadImg').val(data.data)
            } else {
				$('#imghead').attr('src', cur_img);
                showMessage(data.info);
            }
        },
        error: function (data) {
            showMessage('图片上传失败');
        }
    });
}

// 平台区域全选
function checkAll(box) {

    if ($(box).is(':checked')) {
        $(box).parent().find('input').prop('checked', true);
    } else {
        $(box).parent().find('input').prop('checked', false);
    }
}

function noCheckAll(box) {

    $(box).parent().find('input[value=0]').prop('checked', false);
}

// 后台查看返回
function goBack(param, url) {

    if (url) {
        window.location = param + url;
    } else {
        history.go(-1);
    }
}

// 后台批量提交
function submitForm(button) {

    $('#dos').attr('action', $(button).attr('rel'));
    $('#dos').submit();
}