<?php
/**
 * AdminUserAction
 * 用户列表
 *
 * 作    者: 张旭晨
 * 创建时间: 2015-1-4
 *
 */
class AdminUserAction extends MyAction {

    // 首页
    public function index() {

        echo '';
    }

    // 查看后台用户表
    public function lists() {

        $p = $this->getPage();
        $list = getListByPage('SxyAdminUser', 'gr_id DESC', 'adm_status = 0', 10, 0, $p);
        $this->getPage($list['p']);
        $this->assign('info', $list);
        $this->display();
    }

    // 添加用户
    public function add() {

        if ($this->isPost()) {

            if (empty($_POST['qydm']) && empty($_POST['sjqydm'])) {
                $this->error('请选择区域');
            }

            $sjqydm = $_POST['sjqydm'] ? $_POST['sjqydm'] : array();
            if (!in_array($sjqydm, '999999')) {
                $qydm   = $_POST['qydm'] ? $_POST['qydm'] : array();
                foreach ($sjqydm as $vo) {
                    foreach ($qydm as $key => $qy) {
                        if (substr($vo, 0,2) == substr($qy, 0,2)) {
                            unset($qydm[$key]);
                        }
                    }
                }
                $data['adm_qydm'] = serialize(array_merge($sjqydm, $qydm));
            }

            $data['adm_username'] = $_POST['username'];
            $user = M('AdminUser');
            if ($user->where($data)->getField('adm_id')) {
                $this->error('此用户名已有');
            }
            $data['adm_password'] = md5($_POST['password']);
            $data['adm_nickname'] = $_POST['nickname'];

            if (empty($data['adm_password']) || empty($data['adm_nickname'])) {
                $this->error('信息不全');
            }

            $user->add($data);
            $this->redirect('lists');
        }

        // 获取区域列表
        $areas = D('Area')->where("(qy_dm='999999' OR sj_qy_dm='999999') AND yx_bz='y'")->order('lft ASC')->field("qy_dm,qy_mc")->select();
        $this->assign('areas', $areas);
        $this->display();
    }

    // 更改用户
    public function edit() {

        if ($this->isPost()) {

            if (empty($_POST['qydm']) && empty($_POST['sjqydm'])) {
                $this->error('请选择区域');
            }

            $sjqydm = $_POST['sjqydm'] ? $_POST['sjqydm'] : array();
            if (!in_array($sjqydm, '999999')) {
                $qydm   = $_POST['qydm'] ? $_POST['qydm'] : array();
                foreach ($sjqydm as $vo) {
                    foreach ($qydm as $key => $qy) {
                        if (substr($vo, 0,2) == substr($qy, 0,2)) {
                            unset($qydm[$key]);
                        }
                    }
                }
                $data['adm_qydm'] = serialize(array_merge($sjqydm, $qydm));
            }

            $data['adm_id'] = $_POST['id'];
            $data['adm_username'] = $_POST['username'];
            $user = M('AdminUser');
            if ($user->where(array('adm_id'=>array('neq', $data['adm_id']), 'adm_username'=>$data['adm_username']))->getField('adm_id')) {
                $this->error('此用户名已有');
            }
            $data['adm_nickname'] = $_POST['nickname'];

            if (empty($data['adm_nickname'])) {
                $this->error('信息不全');
            }

            $user->save($data);
            $this->redirect('lists');
        } else {

            $id = intval($_GET['id']);
            if (!$id) {
                $this->redirect('lists');
            }

            $info = M('AdminUser')->where(array('adm_id'=>$id))->find();
            $info['adm_qydm'] = unserialize($info['adm_qydm']);
            $this->assign('info', $info);
        }

        // 获取区域列表
        $areas = D('Area')->where("(qy_dm='999999' OR sj_qy_dm='999999') AND yx_bz='y'")->order('lft ASC')->field("qy_dm,qy_mc")->select();
        $this->assign('areas', $areas);
        $this->display();
    }

    // 删除用户
    public function del() {

        if($_POST['delid']) {
            M('AdminUser')->where(array('adm_id'=>array('IN', $_POST['delid'])))->save(array('adm_status'=>1));
            $this->redirect('lists');
        }

        if($_POST['id']) {
            $id = intval($_POST['id']);
            if ($id == 1) {
                echo json_encode(array("status"=>0, "info"=>"超级管理员不可删除"));
                exit;
            }

            if (M('AdminUser')->where(array('adm_id'=>$id))->save(array('adm_status'=>1))) {
                echo json_encode(array("status"=>1, "info"=>"删除成功"));
            } else {
                echo json_encode(array("status"=>0, "info"=>"删除失败"));
            }
        }
    }

    // 初始化密码
    public function savePass() {

        if($_POST['id']) {
            M('AdminUser')->where(array('adm_id'=>intval($_POST['id'])))->save(array('adm_password'=>md5('111111')));
            echo json_encode(array("status"=>1, "info"=>"删除成功"));
        } else {
            echo json_encode(array("status"=>0, "info"=>"删除失败"));
        }
    }

    // 修改密码
    public function editPass() {

        if($this->isPost()) {
            $oldPass = $_POST['oldpass'];
            $newPass = $_POST['newpass'];
            $retPass = $_POST['retpass'];

            if (empty($oldPass) || empty($newPass)) {
                $this->error('您填写的信息不全');
            }

            if ($newPass != $retPass) {
                $this->error('您输入的两次新密码不一致');
            }

            if ($newPass == $oldPass) {
                $this->error('新密码不能等于原密码');
            }

            $admUser = M('AdminUser');
            if ($admUser->where('adm_id=' . $this->userInfo['userId'])->getField('adm_password') != md5($oldPass)) {
                $this->error('您输入的原密码错误');
            }

            if ($admUser->where('adm_id=' . $this->userInfo['userId'])->save(array('adm_password'=>md5($newPass)))) {
                $this->error('新密码修改成功');
            } else {
                $this->error('新密码修改失败');
            }
        }
        $this->display();
    }

    // 查找下级区域代码
    function findQydm() {

        $qydm = intval($_POST['pid']);
        $uid  = intval($_POST['uid']);

        // 获取区域列表
        $list = D('Area')->get_area("sj_qy_dm='" . $qydm . "' AND yx_bz='y' ","qy_dm,qy_mc");
        if ($uid) {
            $uid = unserialize(M('AdminUser')->where(array('adm_id'=>$uid))->getField('adm_qydm'));
            foreach ($list as $key => $vo) {
                if (in_array(substr($vo['qy_dm'], 0, 2) . '0000', $uid) || in_array(substr($vo['qy_dm'], 0, 4) . '00', $uid)) {
                    $list[$key]['checked'] = 'checked';
                }
            }
        }
        echo $this->ajaxReturn($list, '请求成功', 1);
    }
	
	//查看用户权限组
	function view()
	{
		$adm_id = intval($_GET['id']);
		if(empty($adm_id)) return false;
		$rs = M('AdminGroup')->where("FIND_IN_SET(".$adm_id.", adm_ids)")->field('gr_id, gr_name')->select();
		$this->assign('rs', $rs);
		$this->display();
	}
}