<?php
/**
 * 广告系统
 * 作    者: bigliang.com
 * 创建时间: 2016-03-01
 *
 */
class AdsAction extends MyAction {

	public $optName;
	public function __construct(){
        parent::__construct();
		$this->optName = '广告管理';
		$this->assign('optname',$this->optName);
	}

    //标签列表
    public function lists() {
        $this->content('list', $where);
    }

    // list显示
    public function content($status, $where) {
        $p       = $this->getPage();
        $list    = getListByPage('Ads', 'id DESC', $where, 15, 0, $p);
        foreach ($list['list'] as $key => $vo) {

            $html = '';
            $button = '';

            // 添加咨询
            if ($status == 'add') {

            }

            // 查看咨询
            if ($status == 'list') {
                $html .= '<a target="_blank" href="info?id=' . $vo['id'] . '&form=lists" class="edt">预览</a>';
            }

            $list['list'][$key]['button']  = $html;
            $list['list'][$key]['checked'] = $button;
        }

        $this->getPage($list['p']);
        $this->assign('list', $list);
        $this->display('lists');
    }

    // add类型特权
    public function add() {
        if ($this->isPost()) {
			

            // 获取数据
            $date = array();
            $user = session('user');
            $data['name']   = strval($_POST['name']);
			
			//判断服务是否重复
			$isHave = $this->checkAdsName($data['name']);
			if($isHave){
				$this->error('不可以重复添加服务！');
			}
            $data['link']     = strval($_POST['adlink']);
            $data['type']    = intval($_POST['adtype']);
            //$data['category']    = intval($_POST['category']);

            $data['content']    = strval($_POST['content']);
            $data['html']    = strval($_POST['adhtml']);
            $data['open'] = strval($_POST['adopen']);
            //$data['position'] = strval($_POST['adpos']);
            $data['addtime'] = time();

            if ($_FILES['pic']['name']) {
                $up_info = imgUpload('Admin','jpg,png');
                if (!is_array($up_info)) {
                    $this->error($up_info);
                }
                $data['pic'] = $up_info[0]['savepath'] . $up_info[0]['savename'];
            }

            $kid = M('Ads')->add($data);
            $this->redirect('lists');
        }else{
            $this->display();
        }
    }

    // edit类型特权
    public function edit() {

        if ($this->isPost()) {

            // 获取数据
            $date = array();
            $user = session('user');
            $data['id']   = strval($_POST['id']);
            $data['name']   = strval($_POST['name']);			
            $data['link']     = strval($_POST['adlink']);
            $data['type']    = intval($_POST['adtype']);
            //$data['category']    = intval($_POST['category']);

            $data['content']    = strval($_POST['content']);
            $data['html']    = strval($_POST['adhtml']);
            $data['open'] = strval($_POST['adopen']);
            //$data['position'] = strval($_POST['adpos']);
            $data['addtime'] = time();

            if ($_FILES['pic']['name']) {
                $up_info = imgUpload('Admin','jpg,png');
                if (!is_array($up_info)) {
                    $this->error($up_info);
                }
                $data['pic'] = $up_info[0]['savepath'] . $up_info[0]['savename'];
            }else{
				$data['pic'] = strval($_POST['picurl']);
			}
			
            M('Ads')->save($data);
            $this->redirect('lists');
        } else {

            $id = intval($_GET['id']);
            if (!$id) {
                $this->redirect('lists');
            }

            $info = M('Ads')->where(array('id'=>$id))->find();
            $this->assign('info', $info);
            $this->display();
        }
        
    }

    // 查看详情
    public function info() {
		//
		$id = intval($_GET['id']);
		$rs = M('Ads')->where(array('id'=>$id))->find();
		$this->assign('info',$rs);
		$this->display();
    }

    // del类型特权  物理、逻辑删除
    public function del() {

        if ($_POST['delid']) {
            //需要删除的数据
            M('Ads')->where(array('id'=>array('IN', $_POST['delid'])))->delete();
            $this->redirect('lists');
        }

        if ($_POST['id']) {

            // 更新的条件
            $where['id'] = $_POST['id'];
            if(M('Ads')->where($where)->delete()){
                echo json_encode(array("status"=>1, "info"=>"删除成功"));
            }else {
                echo json_encode(array("status"=>0, "info"=>"删除失败"));
            }
        }
    }
	
	private function checkAdsName($name='')
	{
		if(empty($name)){
			return true;
		}
		$rs = M('Ads')->where(array('name'=>$name))->find();
		if(empty($rs)){
			return false;
		}
		return true;
	}

}