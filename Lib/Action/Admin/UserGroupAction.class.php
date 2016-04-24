<?php
/**
 * UserGroupAction
 * 用户组列表
 *
 * 作    者: 张旭晨
 * 创建时间: 2014-12-29
 *
 */
class UserGroupAction extends MyAction {

    // 首页
    public function index() {

        echo '';
    }

    // 查看后台方法列表
    public function lists() {

        // 检测权限
        $p    = $this->getPage();
        $list = getListByPage('SxyAdminGroup', 'gr_id DESC', 'gr_type=0 AND gr_status=0', 10, 0, $p);
        $diction = setArrayByField(M('AdminFunction')->field('fun_id,fun_name,fun_url')->select(), 'fun_id');
        foreach ($list['list'] as $key => $vo) {
            $dicname = '';
            foreach (explode(',', $vo['gr_diction']) as $dic) {
                $dicname[] = $diction[$dic]['fun_name'];
            }
            $list['list'][$key]['gr_diction'] = implode(', ', $dicname);
        }
        $this->getPage(intval($list['p']));
        $this->assign('info', $list);
        $this->display();
    }

    // 添加方法
    public function add() {

        if ($this->isPost()) {

            $data['gr_name']    = strval($_POST['name']);
            $data['adm_ids']    = $_POST['uid'];
            $data['gr_diction'] = $_POST['dic'];

            if (empty($data['gr_name']) || empty($data['gr_diction'])) {
                $this->error('信息不全');
            }

            $group = M('AdminGroup');
            if ($group->where(array('gr_name' => $data['gr_name']))->getField('gr_id')) {
                $this->error('此方法已有');
            }

            // 添加数据
            $data['gr_diction'] = implode(',', $data['gr_diction']);
            $data['adm_ids']    = implode(',', $data['adm_ids']) . ',';
            $data['gr_created'] = time();
            $data['gr_updated'] = time();
            $group->add($data);
            $this->redirect('lists');
        }

        $list = M('AdminFunction')->where('fun_status=0')->field('fun_id,fun_url,fun_pid,fun_rank,fun_name')->select();
        $user = M('AdminUser')->where(array('adm_status'=>0 ,'adm_id'=>array('neq', '1')))->field('adm_id,adm_nickname')->select();
        $this->assign('user', $user);
        $this->assign('list', $list);
        $this->display();
    }

    // 更改方法
    public function edit() {

        if ($this->isPost()) {

            $data['gr_id']      = intval($_POST['id']);
            $data['gr_name']    = strval($_POST['name']);
            $data['adm_ids']    = $_POST['uid'];
            $data['gr_diction'] = $_POST['dic'];

            if (empty($data['gr_name']) || empty($data['gr_diction'])) {
                $this->error('信息不全');
            }

            // 添加数据
            $data['gr_diction'] = implode(',', $data['gr_diction']);
            $data['adm_ids']    = implode(',', $data['adm_ids']) . ',';
            $data['gr_updated'] = time();
            M('AdminGroup')->save($data);
            $this->redirect('lists');
        } else {

            $id = intval($_GET['id']);
            if (!$id) {
                $this->redirect('lists');
            }

            $info = M('AdminGroup')->where(array('gr_id'=>$id))->find();
            $info['adm_ids']    = explode(',', $info['adm_ids']);
            $info['gr_diction'] = explode(',', $info['gr_diction']);
        }

        $list = M('AdminFunction')->where('fun_status=0')->field('fun_id,fun_url,fun_pid,fun_rank,fun_name')->select();
        $user = M('AdminUser')->where(array('adm_status'=>0 ,'adm_id'=>array('neq', '1')))->field('adm_id,adm_nickname')->select();
        $this->assign('user', $user);
        $this->assign('list', $list);
        $this->assign('info', $info);
        $this->display();
    }

    // 删除用户组
    public function del() {

        if($_POST['delid']) {
            M('AdminGroup')->where(array('gr_id'=>array('IN', $_POST['delid'])))->save(array('gr_status'=>1));
            $this->redirect('lists');
        }

        if($_POST['id']) {
            if (M('AdminGroup')->where(array('gr_id'=>intval($_POST['id'])))->save(array('gr_status'=>1))) {
                echo json_encode(array("status"=>1, "info"=>"删除成功"));
            } else {
                echo json_encode(array("status"=>0, "info"=>"删除失败"));
            }
        }
    }
}