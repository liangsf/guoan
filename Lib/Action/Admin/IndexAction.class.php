<?php
/**
 * IndexAction
 * 后台
 *
 * 作    者: 张旭晨
 * 创建时间: 2014-12-25
 *
 */
class IndexAction extends Action {

    // 首页
    public function index() {
        if (!session('user')) {
            $this->redirect('login');
        }
		
        $user = session('user');
        $list = M('AdminFunction')->where('fun_rank != 3 AND fun_status=0 AND fun_show=0')->field('fun_id,fun_name,fun_url,fun_pid,fun_rank')->select();

        // #为所有权限 如果是所有权限不过滤
        if ($user['userName'] != 'admin') {

            // 获取用户权限
            $diction = M('AdminGroup')->where(array('adm_ids' => array('LIKE', '%' . $user['userId'] . ',%')))->field('gr_id,gr_diction')->select();
            foreach ($diction as $vo) {
                $diction['dic'] .= ',' . $vo['gr_diction'];
            }

            // 写入权限
            $diction = array_unique(explode(',', $diction['dic']));
            $_SESSION['user']['diction'] = $diction;
            foreach ($list as $key => $vo) {
                if (!in_array($vo['fun_id'], $diction)) {
                    unset($list[$key]);
                }
            }
        } else {
            $_SESSION['user']['diction'] = '#';
        }

        // 编辑菜单按钮
        foreach ($list as $oneValue) {
            if ($oneValue['fun_rank'] == 0) {
                $one['title'] = $oneValue['fun_name'];
                $one['channels'] = array();
                foreach ($list as $twoValue) {
                    if ($twoValue['fun_pid'] == $oneValue['fun_id']) {
                        $two['channel'] = $twoValue['fun_name'];
                        $two['pages'] = array();
                        foreach ($list as $threeValue) {
                            if ($threeValue['fun_pid'] == $twoValue['fun_id']) {
                                $three['name'] = $threeValue['fun_name'];
                                $three['url']  = '__GROUP__/' . $threeValue['fun_url'];
                                $two['pages'][] = $three;
                            }
                        }
                        $one['channels'][] = $two;
                    }
                }
                $menulist[] = $one;
            }
        }
        $diction = session('user');
        $diction = $diction['diction'];
        if (array_search('369', $diction)) {
            $this->assign('question', '1');
        }
        $this->assign('menulist', json_encode($menulist));
        $this->assign('user', session('user'));
        $this->display();
    }


    public function login() {

        if (session('user')) {
            $this->redirect('index');
        }

        // 表单提交
        if ($this->isPost()) {

            if (empty($_POST['adm_username'])) {
                $this->error('帐号不能为空！', '');
            }

            if (empty($_POST['adm_password'])){
                $this->error('密码必须！', '');
            }
            
            if ('' === trim($_POST['verify'])){
                $this->error('验证码必须！', '');
            }

            //生成认证条件
            $map['adm_username'] = $_POST['adm_username'];
            $map["adm_status"]  = 0;

            if($_SESSION['verify'] != md5($_POST['verify'])) {
                $this->error('验证码错误！', '', 'verify');
            }

            $User = M('AdminUser');
            $authInfo = $User->where($map)->find();

            //使用用户名、密码和状态的方式进行认证
            if (false === $authInfo) {
                $this->error('帐号不存在或已禁用！', '');
            } else {

                if ($authInfo['adm_password'] != md5($_POST['adm_password'])) {
                    $this->error('密码错误！', '');
                }

                $_SESSION['user']['userId']     = $authInfo['adm_id'];
                $_SESSION['user']['admQydm']    = $authInfo['adm_qydm'];
                $_SESSION['user']['userName']   = $authInfo['adm_username'];
                $_SESSION['user']['nickName']   = $authInfo['adm_nickname'];
                $_SESSION['user']['enterTime']  = $authInfo['adm_login_time'];

                //保存登录信息
                $data = array();
                $data['adm_id']         = $authInfo['adm_id'];
                $data['adm_login_time'] = time();
                $User->save($data);
                $this->redirect('index');
            }
        }

        $this->display();
    }

    // 后台首页
    public function welcome() {

        $this->display();
    }

    // 退出登录
    public function logout() {

        session('user', null);
        $this->redirect('index');
    }

    // 验证码显示
    public function verify() {
        import("ORG.Util.Image");
        $length  =  C('VERIFY_CODE_LENGTH');
        if(strpos($length, ',')) {
            $rand   = explode(',', $length);
            $length = floor(mt_rand(intval($rand[0]), intval($rand[1])));
        }
        Image::buildImageVerify($length? $length: 4);
    }
}