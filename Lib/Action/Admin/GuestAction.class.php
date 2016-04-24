<?php
/**
 * 作者管理
 * 作    者: bigliang.com
 * 创建时间: 2016-03-01
 *
 */
class GuestAction extends MyAction {

	public function __construct(){
      
	}

    //预约列表
    public function lists() {
		$where["stat"] = 1;
        $rs = getListByPage('Guest', 'id DESC', $where, 15, 0, $p);

		$this->assign('list',$rs);
		$this->display();
    }
	
    
    // edit类型特权
    public function edit() {

        if ($this->isPost()) {

            // 获取数据
            $date = array();
            $data['id']   = intval($_POST['id']);
            $data['writer'] = strval($_POST['name']);
			
            M('Writer')->save($data);
			echo json_encode(array("status"=>1, "info"=>"修改成功"));
        }
        
    }

    // del类型特权  物理、逻辑删除
    public function del() {

        if ($_POST['delid']) {
            //需要删除的数据
            M('Guest')->where(array('id'=>array('IN', $_POST['delid'])))->delete();
            $this->redirect('lists');
        }

        if ($_POST['id']) {

            // 更新的条件
            $where['id'] = $_POST['id'];
            if(M('Guest')->where($where)->delete()){
                echo json_encode(array("status"=>1, "info"=>"删除成功"));
            }else {
                echo json_encode(array("status"=>0, "info"=>"删除失败"));
            }
        }
    }

    // 导出问题
    public function daochu() {

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=顺利办预约信息.xls');
        header('Pragma: no-cache');
        header('Expires: 0');

        $title = array('ID', '姓名', '电话', '邮箱', '需求', '时间');
        echo iconv('utf-8', 'gbk', implode("\t", $title)) . "\n";

        //$id    = intval($_GET['id']);
        
        $yylist = M('Guest')->where("stat = 1")->order("id desc")->select();
        
        foreach ($yylist as $key => $vo) {
            $yylist[$key]['addtime'] = date("Y-m-d H:i:s",$vo['addtime']);
        }
        
        foreach ($yylist as $key => $value) {

            $list = $value['id'] . "\t" . $value['name'] . "\t" . $value['tel'] . "\t" . $value['email'] . "\t" . $value['content'] . "\t" . $value['addtime'];
            echo iconv('utf-8', 'gbk', $list) . "\n";
        }
    }

}