<?php


class YgzAction extends Action {
    
	public function _initialize(){
		
        isLongin(1);
        
    }

	public function index(){
		$where['nt_id'] = 10;
		$rs = M('ComNews')->where($where)->select();
		$this->assign('list', $rs);
		$this->display();
	}
	//专题课程
	public function ztkc(){

		
		$this->display();
	}
	//政策法规
	public function zcfg(){
		$where['File_Id'] = array('in', '11352,12802,12800,11367,15106,11120,11218,12622,13151,13153,13154,13155,13156,12763,12758,13093,13157,11385,12647,12630,15100,15108,15109,12945,15101,12942,13373,15102,12887,13333,13112,13088,13081,13641,13079,13074,13066,13799,13841,15107,15032,15099');
		$rs = M('hl_taxinfo_fgcx_taxfile',null)->where($where)->order('File_Date, File_Id')->select();
		$this->assign('list', $rs);
		$this->display();
	}
	//实战解读
	public function szjd(){
		
		$rs = M('Explain')->where('e_id > 243 and e_id < 251')->select();
		$this->assign('list', $rs);
		$this->display();
	}
	//专家答疑
	public function zjdy(){

		$where["cs_status"] = 0;
		$where["cs_title"] = array("like","%营改增%");
		$list = M("ComCswd")->where($where)->order("cs_id desc")->limit(7)->select();
		foreach ($list as $k => $v) {
			$list[$k]['cs_content'] = strip_tags($v['cs_content']);
		}
		$this->assign("list",$list);
		$this->display();
	}

	public function tijiaoxx() {
        $data['slb_name'] = trim($_POST['name']);
        $data['slb_tel'] = trim($_POST['tel']);
        $data['slb_email'] = trim($_POST['email']);
        $data['slb_content'] = trim($_POST['conts']);
        $data['slb_stat'] = 1;
        $data['slb_time'] = time();
        
        if (M('Slb')->add($data)) {
            $this->ajaxReturn('', '提交成功', '1');
        } else {
            $this->ajaxReturn('', '提交失败', '0');
        }
    }
	
	public function view()
	{
		$id = intval($_GET['id']);
		$t = intval($_GET['t']);
		if($t == 1){
			$view = M('Explain')->find($id);
			$view['title'] = $view['e_name'];
			$view['content'] = $view['e_content'];
		}elseif($t == 2){
			$view = M('ComNews')->find($id);
			$view['title'] = $view['c_title'];
			$view['content'] = $view['c_content'];
		}
		$this->assign('view', $view);
		$this->display();
	}
	
}