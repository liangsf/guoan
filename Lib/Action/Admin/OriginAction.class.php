<?php
/**
 * 来源管理
 * 作    者: bigliang.com
 * 创建时间: 2016-03-01
 *
 */
class OriginAction extends MyAction {

	public $optName;
	public function __construct(){
        parent::__construct();
		$this->optName = '来源管理';
		$this->assign('optname',$this->optName);
	}

    //作者列表
    public function lists() {
		$rs = M('Origin')->order('id desc')->select();
        
		$this->assign('list',$rs);
		$this->display();
    }
	
	//增加作者
	public function add()
	{
		if ($this->isPost()) {
			$data['name'] = strval($_POST['name']);
			
			M('Origin')->add($data);
            $this->redirect('lists');
		}
	}

    
    // edit类型特权
    public function edit() {

        if ($this->isPost()) {

            // 获取数据
            $date = array();
            $data['id']   = intval($_POST['id']);
            $data['name'] = strval($_POST['name']);
			
            M('Origin')->save($data);
			echo json_encode(array("status"=>1, "info"=>"修改成功"));
        }
        
    }

    // del类型特权  物理、逻辑删除
    public function del() {

        if ($_POST['delid']) {
            //需要删除的数据
            M('Origin')->where(array('id'=>array('IN', $_POST['delid'])))->delete();
            $this->redirect('lists');
        }

        if ($_POST['id']) {

            // 更新的条件
            $where['id'] = $_POST['id'];
            if(M('Origin')->where($where)->delete()){
                echo json_encode(array("status"=>1, "info"=>"删除成功"));
            }else {
                echo json_encode(array("status"=>0, "info"=>"删除失败"));
            }
        }
    }


}