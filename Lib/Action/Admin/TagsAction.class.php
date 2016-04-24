<?php
/**
 * TagsAction
 * 标签列表
 *
 * 作    者: 张旭晨
 * 创建时间: 2014-12-25
 *
 */
class TagsAction extends MyAction {

    // 首页
    public function index() {

        echo '';
    }

    // 查看后台标签列表
    public function lists() {
        $list = M('Tags')->select();
        foreach ($list as $k => $v) {
            $list[$k]['fuwuname'] = implode(',',M('Serve')->where(array('id'=>array('IN',$v['s_id'])))->getField('name',true));
            if(empty($list[$k]['fuwuname'])){
                $list[$k]['fuwuname'] = "暂无服务";
            }
        }
        $this->assign('list', $list);
        $this->display();
    }

    // 添加标签
    public function add() {

        if ($this->isPost()) {

            $data['name']   = $_POST['name'];
            $data['ppid'] = $_POST['funone'];
            $data['pid'] = $_POST['funtwo'];
            if($data['ppid'] && !$data['pid']){
                $data['level'] = 2;
                $data['pid'] = $data['ppid'];
            }elseif ($data['ppid'] && $data['pid']) {
                $data['level'] = 3;
            }else{
                $data['level'] = 1;
            }

            $data['s_id']    = implode(',', $_POST['fw']);

            if (empty($data['name'])) {
                $this->error('请填写名称');
            }
            $where['name'] = $data['name'];
            $where['level'] = $data['level'];
            if(M('Tags')->where($where)->getfield('id')){
                $this->error('该标签已存在');
            }

            // 添加数据
            $data['addtime'] = time();
            M('Tags')->add($data);
            $this->saveCache();
            $this->redirect('lists');
        }

        $list = M('Tags')->select();
        $serve = M('Serve')->select();
        $this->assign('serve', $serve);
        $this->assign('list', $list);
        $this->display();
    }

    // 更改标签
    public function edit() {

        if ($this->isPost()) {

            $data['id']   = $_POST['id'];
            $data['name'] = $_POST['name'];
            $data['s_id']  = implode(',', $_POST['fuwu']);

            if (empty($data['name'])) {
                $this->error('请填写标签名称');
            }

            // 更改数据
            M('Tags')->save($data);
            $this->saveCache();
            $this->redirect('lists');
        } else {

            $id = intval($_GET['id']);
            if (!$id) {
                $this->redirect('lists');
            } else {
                $info = M('Tags')->where(array('id'=>$id))->find();
                $info['s_id'] = explode(',', $info['s_id']);
            }
        }

        $list = M('Serve')->select();
        $this->assign('list', $list);
        $this->assign('info', $info);
        $this->display();
    }

    // 删除标签
    public function del() {

        // if($_POST['delid']) {
        //     M('AdminFunction')->where(array('fun_id'=>array('IN', $_POST['delid'])))->delete();
        //     $this->redirect('lists');
        // }
        $id = $_POST['id'];
        $where = "id = ".$id." or pid = ".$id." or ppid = ".$id;
        if($_POST['id']) {
            if (M('Tags')->where($where)->delete()) {
                echo json_encode(array("status"=>1, "info"=>"删除成功"));
            } else {
                echo json_encode(array("status"=>0, "info"=>"删除失败"));
            }
        }
    }

    // 查找下级标签
    public function findFunc() {

        $where['pid'] = intval($_POST['pid']);

        if (empty($where['pid'])) {
            return false;
        }

        $list = M('Tags')->where($where)->select();
        foreach ($list as $k => $v) {
            $list[$k]['fuwuname'] = implode(',',M('Serve')->where(array('id'=>array('IN',$v['s_id'])))->getField('name',true));
            if(empty($list[$k]['fuwuname'])){
                $list[$k]['fuwuname'] = "暂无服务";
            }
        }
        echo json_encode($list);
    }
}