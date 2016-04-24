function fileQueueError(file, errorCode, message) {
	try {
		var imageName = "error.gif";
		var errorName = "";
		console.log(errorCode);
		if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
			show_error("超过了允许上传的张数啦！");
			return ;
		}

		if (errorName !== "") {
			//alert(errorName);
			return;
		}
		
		switch (errorCode) {
		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
			imageName = "zerobyte.gif";
			show_error("不能上传0字节的文件！");
			break;
		case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
			imageName = "toobig.gif";
			//console.log(2);
			show_error("文件太大啦！");
			break;
		case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
			show_error("文件格式不正确！");
			//console.log(3);
			break;
		default:
			//alert(message);
			//console.log(4);
			show_error('其他错误');
			break;
		}

	} catch (ex) {
		this.debug(ex);
	}

}

function fileDialogComplete(numFilesSelected, numFilesQueued) {
	try {
		if (numFilesQueued > 0) {
			this.startUpload();
		}
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadProgress(file, bytesLoaded) {
	try {
		var percent = Math.ceil((bytesLoaded / file.size) * 100);

		//var progress = new FileProgress(file,  this.customSettings.upload_target);
		//progress.setProgress(percent);
		if (percent === 100) {
			//progress.setStatus("Creating thumbnail...");
			//progress.toggleCancel(false, this);
		} else {
			//progress.setStatus("Uploading...");
			//progress.toggleCancel(true, this);
			$(".waiting").show();
		}
	} catch (ex) {
		this.debug(ex);
	}
}
//当flash加载完毕调用的方法
function uploadLoaded(){
	
	var liangs = swfu.getStats();
	liangs.successful_uploads=cur_zzzm;
	swfu.setStats(liangs);
}
function uploadLoaded2(){
	
	var liangs2 = upload2.getStats();
	liangs2.successful_uploads=cur_yyzz;
	upload2.setStats(liangs2);
}
function uploadSuccess(file, serverData) {
	try {
		//var progress = new FileProgress(file,  this.customSettings.upload_target);
		var obj = eval('(' + serverData + ')');
		if(obj.status == 1){
			addAll(obj.imgurl,obj.imgdir+obj.imgname);
			img_num = $("#img_list").children();
			if(img_num.length>=5){
				$("#up_btn").hide();
			}
		}else{
			//addImage("/Public/images/error.gif");
		}
		/*
		if (serverData.substring(0, 7) === "FILEID:") {
			addImage("thumbnail.php?id=" + serverData.substring(7));

			progress.setStatus("Thumbnail Created.");
			progress.toggleCancel(false);
		} else {
			addImage("images/error.gif");
			progress.setStatus("Error.");
			progress.toggleCancel(false);
			alert(serverData);

		}*/


	} catch (ex) {
		this.debug(ex);
	}
}

function uploadSuccess2(file, serverData) {
	try {
		//var progress = new FileProgress(file,  this.customSettings.upload_target);
		$(".waiting").hide();
		var obj = eval('(' + serverData + ')');
		if(obj.status == 1){
			addAll2(obj.imgurl,obj.imgdir+obj.imgname);
			img_num = $("#img_list2").children();
			if(img_num.length>=1){
				$("#up_btn2").hide();
			}
		}else{
			//addImage("/Public/images/error.gif");
		}
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadComplete(file) {
	try {
		/*  I want the next upload to continue automatically so I'll call startUpload here */
		if (this.getStats().files_queued > 0) {
			this.startUpload();
		} else {
			var progress = new FileProgress(file,  this.customSettings.upload_target);
			progress.setComplete();
			progress.setStatus("All images received.");
			progress.toggleCancel(false);
		}
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadError(file, errorCode, message) {
	var imageName =  "error.gif";
	var progress;
	try {
		switch (errorCode) {
		case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
			try {
				progress = new FileProgress(file,  this.customSettings.upload_target);
				progress.setCancelled();
				progress.setStatus("Cancelled");
				progress.toggleCancel(false);
			}
			catch (ex1) {
				this.debug(ex1);
			}
			console.log(8);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
			try {
				progress = new FileProgress(file,  this.customSettings.upload_target);
				progress.setCancelled();
				progress.setStatus("Stopped");
				progress.toggleCancel(true);
				console.log(7);
			}
			catch (ex2) {
				this.debug(ex2);
			}
		case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
			imageName = "uploadlimit.gif";
			console.log(6);
			break;
		default:
			//alert(message);
			console.log(5);
			break;
		}

		//addImage("/Public/images/" + imageName);

	} catch (ex3) {
		this.debug(ex3);
	}

}


function addImage(src) {
	var newImg = document.createElement("img");
	newImg.style.margin = "5px";
	newImg.width = "100";
	newImg.height = "100";
	document.getElementById("img_list").appendChild(newImg);
	if (newImg.filters) {
		try {
			newImg.filters.item("DXImageTransform.Microsoft.Alpha").opacity = 0;
		} catch (e) {
			// If it is not set initially, the browser will throw an error.  This will set it if it is not set yet.
			newImg.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + 0 + ')';
		}
	} else {
		newImg.style.opacity = 0;
	}

	newImg.onload = function () {
		fadeIn(newImg, 0);
	};
	newImg.src = src;
}
function addAll(src,val) {
	var newDiv = document.createElement("dt");

	var newImg = document.createElement("img");
	newImg.width = "60";
	newImg.height = "40";
	newImg.src = src;
	newDiv.appendChild(newImg);
	//input
	var newInput = document.createElement("input");
	newInput.type='hidden';
	newInput.name="file_zzzm[]";
	newInput.value= val;	
	newDiv.appendChild(newInput);

	var newHref = document.createElement("a");
	newHref.className = 'closed_icon';
	newHref.id = 'delImg';
	//newHref.innerHTML='删除';
	newHref.onclick=function(){dodelimg(this)};
	newDiv.appendChild(newHref);
	document.getElementById("img_list").appendChild(newDiv);
	if (newImg.filters) {
		try {
			newImg.filters.item("DXImageTransform.Microsoft.Alpha").opacity = 0;
		} catch (e) {
			newImg.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + 0 + ')';
		}
	} else {
		newImg.style.opacity = 0;
	}

	newImg.onload = function () {
		fadeIn(newImg, 0);
	};
	newImg.src = src;
}

function addAll2(src,val) {
	var newDiv = document.createElement("dt");

	var newImg = document.createElement("img");
	newImg.width = "120";
	newImg.height = "50";
	newImg.src = src;
	newDiv.appendChild(newImg);
	//input
	var newInput = document.createElement("input");
	newInput.type='hidden';
	newInput.name="file_yyzz";
	newInput.value= val;	
	newDiv.appendChild(newInput);

	var newHref = document.createElement("a");
	newHref.className = 'closed_icon';
	newHref.id = 'delImg';
	//newHref.innerHTML='删除';
	newHref.onclick=function(){dodelimg2(this)};
	newDiv.appendChild(newHref);
	document.getElementById("img_list2").appendChild(newDiv);
	if (newImg.filters) {
		try {
			newImg.filters.item("DXImageTransform.Microsoft.Alpha").opacity = 0;
		} catch (e) {
			newImg.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + 0 + ')';
		}
	} else {
		newImg.style.opacity = 0;
	}

	newImg.onload = function () {
		fadeIn(newImg, 0);
	};
	newImg.src = src;
}

function fadeIn(element, opacity) {
	var reduceOpacityBy = 5;
	var rate = 30;	// 15 fps


	if (opacity < 100) {
		opacity += reduceOpacityBy;
		if (opacity > 100) {
			opacity = 100;
		}

		if (element.filters) {
			try {
				element.filters.item("DXImageTransform.Microsoft.Alpha").opacity = opacity;
			} catch (e) {
				// If it is not set initially, the browser will throw an error.  This will set it if it is not set yet.
				element.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + opacity + ')';
			}
		} else {
			element.style.opacity = opacity / 100;
		}
	}

	if (opacity < 100) {
		setTimeout(function () {
			fadeIn(element, opacity);
		}, rate);
	}
}



/* ******************************************
 *	FileProgress Object
 *	Control object for displaying file info
 * ****************************************** */

function FileProgress(file, targetID) {
	return false;
	this.fileProgressID = "divFileProgress";

	this.fileProgressWrapper = document.getElementById(this.fileProgressID);
	if (!this.fileProgressWrapper) {
		this.fileProgressWrapper = document.createElement("div");
		this.fileProgressWrapper.className = "progressWrapper";
		this.fileProgressWrapper.id = this.fileProgressID;

		this.fileProgressElement = document.createElement("div");
		this.fileProgressElement.className = "progressContainer";

		var progressCancel = document.createElement("a");
		progressCancel.className = "progressCancel";
		progressCancel.href = "#";
		progressCancel.style.visibility = "hidden";
		progressCancel.appendChild(document.createTextNode(" "));

		var progressText = document.createElement("div");
		progressText.className = "progressName";
		progressText.appendChild(document.createTextNode(file.name));

		var progressBar = document.createElement("div");
		progressBar.className = "progressBarInProgress";

		var progressStatus = document.createElement("div");
		progressStatus.className = "progressBarStatus";
		progressStatus.innerHTML = "&nbsp;";

		this.fileProgressElement.appendChild(progressCancel);
		this.fileProgressElement.appendChild(progressText);
		this.fileProgressElement.appendChild(progressStatus);
		this.fileProgressElement.appendChild(progressBar);

		this.fileProgressWrapper.appendChild(this.fileProgressElement);

		document.getElementById(targetID).appendChild(this.fileProgressWrapper);
		fadeIn(this.fileProgressWrapper, 0);

	} else {
		this.fileProgressElement = this.fileProgressWrapper.firstChild;
		this.fileProgressElement.childNodes[1].firstChild.nodeValue = file.name;
	}

	this.height = this.fileProgressWrapper.offsetHeight;

}
FileProgress.prototype.setProgress = function (percentage) {
	this.fileProgressElement.className = "progressContainer green";
	this.fileProgressElement.childNodes[3].className = "progressBarInProgress";
	this.fileProgressElement.childNodes[3].style.width = percentage + "%";
};
FileProgress.prototype.setComplete = function () {
	this.fileProgressElement.className = "progressContainer blue";
	this.fileProgressElement.childNodes[3].className = "progressBarComplete";
	this.fileProgressElement.childNodes[3].style.width = "";

};
FileProgress.prototype.setError = function () {
	this.fileProgressElement.className = "progressContainer red";
	this.fileProgressElement.childNodes[3].className = "progressBarError";
	this.fileProgressElement.childNodes[3].style.width = "";

};
FileProgress.prototype.setCancelled = function () {
	this.fileProgressElement.className = "progressContainer";
	this.fileProgressElement.childNodes[3].className = "progressBarError";
	this.fileProgressElement.childNodes[3].style.width = "";

};
FileProgress.prototype.setStatus = function (status) {
	this.fileProgressElement.childNodes[2].innerHTML = status;
};

FileProgress.prototype.toggleCancel = function (show, swfuploadInstance) {
	this.fileProgressElement.childNodes[0].style.visibility = show ? "visible" : "hidden";
	if (swfuploadInstance) {
		var fileID = this.fileProgressID;
		this.fileProgressElement.childNodes[0].onclick = function () {
			swfuploadInstance.cancelUpload(fileID);
			return false;
		};
	}
};

function dodelimg(t){
	$(t).parent().remove();
	$("#up_btn").show();
	setTimeout("gomudan()","1000");
}

function gomudan(){
	
	var liangs = swfu.getStats();
	liangs.successful_uploads=liangs.successful_uploads-1;
	if(liangs.successful_uploads>=5){
		//$("#up_btn").hide();
	}
	swfu.setStats(liangs);
}

function dodelimg2(t){
	$(t).parent().remove();
	$("#up_btn2").show();
	setTimeout("gomudan2()","1000");
}

function gomudan2(){
	
	var liangs2 = upload2.getStats();
	liangs2.successful_uploads=liangs2.successful_uploads-1;
	if(liangs2.successful_uploads>=1){
		//$("#up_btn2").hide();
	}
	upload2.setStats(liangs2);
}

function show_error(info){
	alert(info);
	return false;
}
