<?php
/**
 * MyAction
 * 后台公告类
 *
 * 作    者: 张旭晨
 * 创建时间: 2014-12-25
 *
 */
class MyAction extends Action {

    public $userInfo;
    public $table;
    public $tableName;
    public $button;
	public $button_wdk;
    public function __construct(){

        $this->userInfo = session('user');
        if (!session('user')) {
            $this->redirect('Index/login');
        }

        $diction = F('diction');
        if (empty($diction)) {
            $this->saveCache();
        }
        $action  = substr(get_class($this),0,-6);
        $nameKey = array_search($action, $_GET['_URL_']);

        $func = array(
            'ServiceReview/fileUpload',
            'ServiceReview/getDiction',
            'AdminUser/findQydm',
            'ServiceAccess/findQydm',
            'ServicePeople/ServiceReview',
            'AgentService/getCity'
        );

        if (false === testDiction($action . '/' . $_GET['_URL_'][$nameKey+1], 'diction', 'user') && !in_array($action . '/' . $_GET['_URL_'][$nameKey+1], $func)) {
            $this->error('没有权限');
        }

        $this->table = C('FAGUI_TABLE');

        $this->tableName = C('TABLE_NAME');

        $this->message = array(0 => '信息已审核', 4 => '信息已驳回');

        $this->button_wdk = Array(
            'add' => '<input type="button" rel="del" onclick="chexiao(3)" class="btn btn-small" value="删除">&nbsp;<input type="button" onclick="chexiao(2)" rel="push" class="btn btn-small" value="提交审核">',
            'sh' => '<input type="button" rel="revoke" onclick="chexiao(1)" class="btn btn-small" value="撤销">',
        );
		$this->button = Array(
            'add' => '<input type="button" rel="del" onclick="submitForm(this)" class="btn btn-small" value="删除">&nbsp;<input type="button" onclick="submitForm(this)" rel="push" class="btn btn-small" value="提交审核">',
            'sh' => '<input type="button" rel="revoke" onclick="submitForm(this)" class="btn btn-small" value="撤销">',
        );
    }

    // 更新后台权限缓冲
    public function saveCache() {

        R('Admin/Cache/diction');
    }

    // 更新前台权限缓冲
    public function saveHomeCache() {

        R('Admin/Cache/homeDiction');
    }

	//上传文件方法
	public function imgUpload($path='',$ext='',$thumb=false,$width="100",$height="100"){
		header("Content-type: text/html; charset=utf-8");
		import("ORG.Net.UploadFile");
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize = 5242880 ;// 设置附件上传大小
		if(empty($ext)){
			$upload->allowExts = array('jpg', 'gif', 'png','docx','doc','xlsx','xls','txt','rar','pdf');// 设置附件上传类型
		}else{
			$upload->allowExts = explode(',',$ext);// 设置附件上传类型
		}
		//$M_C = S('M_C'.$uid);
		$upload->autoSub = true;
		$upload->subType=date;
		$upload->dateFormat='Y-m-d';
		$upload->hashLevel=1;
		//$filedate = date('Ymd',time()).'_'.$uid;
		$savePath = $path.$filedate.'/';
		$upload->savePath = 'Uploads/'.$savePath;// 设置附件上传目录
		
		//生成缩略图
		if($thumb){
			$upload->thumb=true;
			$upload->thumbMaxWidth=$width;
			$upload->thumbMaxHeight=$height;
		}
		//$allowExts_arry= array('.jpg', '.gif', '.png', '.bmp','.docx','.doc','.xlsx','.xls','.txt','.rar');
		//$upload->saveRule = str_replace($allowExts_arry,'',$_FILES['Filedata']['name']);
		//$upload->saveRule = time();
		if(!$upload->upload()) {// 上传错误时，提示的错误信息
			//print_R($err = $upload->getErrorMsg());
			return false;
		}else{// 上传成功 获取上传文件信息
			$info = $upload->getUploadFileInfo();
			return $info;
		}
		
	}

    // 附件上传
    // public function uploadFile() {

    //     $img['status'] = 0;
    //     $img['info']   = '图片上传失败';
    //     $img['data']   = '';
    //     if ($_FILES['picture']['name']) {
    //         if ($_POST['name']) {
    //             unlink('.' . $_POST['name']);
    //         }
    //         $up_info = imgUpload('Admin', 'jpg,png,jpeg,doc,docx,txt,xlsx,xls,bmp,rar,zip', false);
    //         if (!is_array($up_info)) {
    //             $img['info'] = $up_info;
    //             exit(json_encode($img));
    //         }

    //         // 附件入库
    //         $data['re_title'] = $up_info[0]['name'];
    //         $data['re_savename'] = $up_info[0]['savename'];
    //         $data['adm_id'] = $this->userInfo['userId'];
    //         $data['re_ext'] = $up_info[0]['extension'];
    //         $data['re_created'] = time();

    //         $img['data']['name'] = $up_info[0]['name'];
    //         if ($img['data']['id'] = M('Resource')->add($data)) {

    //             $img['status'] = 1;
    //             $img['info']   = '图片上传成功';
    //             exit(json_encode($img));
    //         }
    //     }
    //     exit(json_encode($img));
    // }


    // 附件上传 ——新
    public function uploadFile() {
        $img['status'] = 0;
        $img['info']   = '图片上传失败';
        $img['data']   = '';
        if ($_FILES['picture']['name']) {
            if ($_POST['name']) {
                unlink('.' . $_POST['name']);
            }
            $up_info = imgUpload('Admin', 'jpg,png,jpeg,doc,docx,txt,xlsx,xls,bmp,rar,zip', false);
            if (!is_array($up_info)) {
                $img['info'] = $up_info;
                exit(json_encode($img));
            }

            // 附件入库
            $data['attname'] = $up_info[0]['name'];
            $data['url'] = "Uploads/Admin/".$up_info[0]['savename'];
            $data['adm_id'] = $this->userInfo['userId'];
            $data['attext'] = $up_info[0]['extension'];
            $data['addtime'] = time();

            $img['data']['name'] = $up_info[0]['name'];
            if ($img['data']['id'] = M('Attachment')->add($data)) {

                $img['status'] = 1;
                $img['info']   = '图片上传成功';
                exit(json_encode($img));
            }
        }
        exit(json_encode($img));
    }

    public function getPage($p) {

        if ($p) {
            return session('nowpage', $p);
        } else {
            $fromName = reset(explode('?',end(explode('/', $_SERVER['HTTP_REFERER']))));
            if ($fromName == 'info' || $fromName == 'edit') {

                if (is_array(session('nowpage'))) return session('nowpage');
                return intval(session('nowpage')) ? intval(session('nowpage')) : 1;
            } else {
                return intval($_GET['p']) ? intval($_GET['p']) : 1;
            }
        }
    }
}