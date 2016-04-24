<?php
/**
 * AdminFuncAction
 * 方法列表
 *
 * 作    者: 张旭晨
 * 创建时间: 2014-12-25
 *
 */
class AdminFuncAction extends MyAction {

    // 首页
    public function index() {

        echo '';
    }

    // 查看后台方法列表
    public function lists() {

        $list = M('AdminFunction')->where('fun_status = 0 AND (fun_rank = 0 OR fun_rank = 1)')->field('fun_id,fun_url,fun_pid,fun_rank,fun_name')->select();
        $this->assign('list', $list);
        $this->display();
    }

    // 添加方法
    public function add() {

        if ($this->isPost()) {

            $data['fun_name']   = $_POST['name'];
            $data['fun_url']    = $_POST['url'];

            if (empty($data['fun_name'])) {
                $this->error('请填写方法名称');
            }

            if (!empty($_POST['funone'])) {
                $data['fun_pid']  = $_POST['funone'];
                $data['fun_rank'] = 1;
            }

            if (!empty($_POST['funtwo'])) {
                $data['fun_pid']  = $_POST['funtwo'];
                $data['fun_rank'] = 2;
            }

            if (!empty($_POST['funtwo'])) {
                $data['fun_rank'] = $_POST['show'];
            }

            $data['fun_show'] = $_POST['ishow'];

            // 添加数据
            $data['fun_created'] = time();
            $data['fun_updated'] = time();
            M('AdminFunction')->add($data);
            $this->saveCache();
            $this->redirect('lists');
        }

        $list = M('AdminFunction')->where('fun_status=0')->field('fun_id,fun_url,fun_pid,fun_rank,fun_name')->select();
        $this->assign('list', $list);
        $this->display();
    }

    // 更改方法
    public function edit() {

        if ($this->isPost()) {

            $data['fun_id']   = $_POST['id'];
            $data['fun_name'] = $_POST['name'];
            $data['fun_url']  = $_POST['url'];

            if (!empty($_POST['save'])) {
                if (empty($data['fun_id'])) {
                    $this->redirect('lists');
                }

                if (empty($data['fun_name'])) {
                    $this->error('请填写方法名称');
                }

                if (!empty($_POST['funone'])) {
                    $data['fun_pid']  = $_POST['funone'];
                    $data['fun_rank'] = 1;
                }

                if (!empty($_POST['funtwo'])) {
                    $data['fun_pid']  = $_POST['funtwo'];
                    $data['fun_rank'] = 2;
                }

                if (!empty($_POST['funtwo'])) {
                    $data['fun_rank'] = $_POST['show'];
                }
            }

            $data['fun_show'] = $_POST['ishow'];

            // 更改数据
            $data['fun_updated'] = time();
            M('AdminFunction')->save($data);
            $this->saveCache();
            $this->redirect('lists');
        } else {

            $id = intval($_GET['id']);
            if (!$id) {
                $this->redirect('lists');
            } else {
                $info = M('AdminFunction')->where(array('fun_id'=>$id))->find();
            }
        }

        $list = M('AdminFunction')->where('fun_status=0')->field('fun_id,fun_url,fun_pid,fun_rank,fun_name')->select();
        $this->assign('list', $list);
        $this->assign('info', $info);
        $this->display();
    }

    // 删除餐厅
    public function del() {

        if($_POST['delid']) {
            M('AdminFunction')->where(array('fun_id'=>array('IN', $_POST['delid'])))->delete();
            $this->redirect('lists');
        }

        if($_POST['id']) {
            if (M('AdminFunction')->where(array('fun_id'=>intval($_POST['id'])))->delete()) {
                echo json_encode(array("status"=>1, "info"=>"删除成功"));
            } else {
                echo json_encode(array("status"=>0, "info"=>"删除失败"));
            }
        }
    }

    // 查找下级方法
    public function findFunc() {

        $where['fun_pid'] = intval($_POST['pid']);

        if (empty($where['fun_pid'])) {
            return false;
        }

        $list = M('AdminFunction')->where($where)->field('fun_id,fun_url,fun_pid,fun_rank,fun_name')->select();
        echo json_encode($list);
    }
}