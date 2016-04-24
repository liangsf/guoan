<?php
/**
 * 文章发布
 * 作    者: bigliang.com
 * 创建时间: 2016-03-01
 *
 */
class ArticleAction extends MyAction {

	public $optName;
	public function __construct(){
        parent::__construct();
		$this->optName = '百科管理';
		$this->assign('optname',$this->optName);
	}

    // 咨询增加显示
    public function insert() {

        $where['types'] = 1;
        if ($_GET['where'] != '') {
            $where['status'] = $_GET['where'];
        } else {
            $where['status'] = array('IN', '0,1,3,4,5');
        }

        if ($_GET['keyword']) {
            $where['_string'] = ' (title like "%' . $_GET['keyword'] . '%")  OR ( content like "%' . $_GET['keyword'] . '%") ';
        }

        $this->content('add', $where);
    }

    // 咨询审核显示
    public function shenhe() {

        $where['types'] = 1;
        if ($_GET['where'] != '') {
            $where['status'] = $_GET['where'];
        } else {
            $where['status'] = array('IN', '0,3,4,5');
        }

        if ($_GET['keyword']) {
            $where['_string'] = ' (title like "%' . $_GET['keyword'] . '%")  OR ( content like "%' . $_GET['keyword'] . '%") ';
        }

        $this->content('sh', $where);
    }

    //标签列表
    public function lists() {
		$where['types'] = 1;
		//$where['status'] = 1;

        if ($_GET['keyword']) {
            $where['_string'] = ' (title like "%' . $_GET['keyword'] . '%")  OR ( content like "%' . $_GET['keyword'] . '%") ';
        }

        $this->content('list', $where);
    }

    // list显示
    public function content($status, $where) {
        $p       = $this->getPage();
        $list    = getListByPage('Article', 'id DESC', $where, 15, 0, $p);
        foreach ($list['list'] as $key => $vo) {

            $html = '';
            $button = '';

            // 添加咨询
            if ($status == 'add') {

            }

            // 查看咨询
            if ($status == 'list') {

                //$html .= '<a target="_blank" href="info?id=' . $vo['id'] . '&form=lists" class="edt">预览</a>';
                $html .= '<a target="_blank" href="info?id=' . $vo['id'] . '" class="edt">预览</a>';
                $html .= '<a href="edit?id=' . $vo['id'] . '" class="edt">编辑</a>';
                $html .= '<div class="del">删除</div>';

            }
            
            $list['list'][$key]['tagname'] = implode(',',M('Tags')->where(array('id'=>array('IN',$vo['t_id'])))->getField('name',true));
            $list['list'][$key]['cs_button']  = $html;
            $list['list'][$key]['checked'] = $button;
        }

        $this->getPage($list['p']);
        $this->assign('list', $list);
        $this->assign('keyword', $_GET['keyword']);
        $this->assign('checked', $html);
        $this->display('lists');
    }

    // add类型特权
    public function add() {
        if ($this->isPost()) {

            // 获取数据
            $date = array();
            $user = session('user');
            $data['title']   = strval($_POST['title']);
            $data['shorttitle']   = strval($_POST['shorttitle']);
			
            $data['writer']     = strval($_POST['writer']);
            $data['source']    = strval($_POST['source']);
			//标签
			$data['t_one']    = intval($_POST['t_one']);
			$data['t_two']    = intval($_POST['t_two']);
			$data['t_id']      = implode(',', $_POST['tags']);
			
            $data['content']    = strval($_POST['content']);
			
			//附件id
			$data['att_id']      = implode(',', $_POST['files']) . ',';
			
            $data['types']    = 1;
            $data['adm_id']    = $user['userId'];
            $data['addtime']    = time();
            
            $aid = M('Article')->add($data);
            $this->redirect('lists');
        }else{
			$wts = D('Writer')->getWriter();	//作者
			$ors = D('Origin')->getOrigin();	//来源
			$tags = M('Tags')->where(array('level'=>1))->select();	//
			$this->assign('wts',$wts);
			$this->assign('ors',$ors);
			$this->assign('tags',$tags);
            $this->display();
        }
    }

    // edit类型特权
    public function edit() {

        if ($this->isPost()) {

            // 获取数据
            $date = array();
            $user = session('user');
            $data['id']   = intval($_POST['id']);

            $data['title']   = strval($_POST['title']);
            $data['shorttitle']   = strval($_POST['shorttitle']);
			
            $data['writer']     = strval($_POST['writer']);
            $data['source']    = strval($_POST['source']);
			//标签
			$data['t_one']    = intval($_POST['t_one']);
			$data['t_two']    = intval($_POST['t_two']);
			$data['t_id']      = implode(',', $_POST['tags']);
			
            $data['content']    = strval($_POST['content']);
			
			//附件id
			$data['att_id']      = implode(',', $_POST['files']) . ',';
			
            $data['types']    = 1;
            $data['adm_id']    = $user['userId'];
            $data['addtime']    = time();
			
            M('Article')->save($data);
            $this->redirect('lists');
        } else {

            $id = intval($_GET['id']);
            if (!$id) {
                $this->redirect('lists');
            }

            $info = M('Article')->where(array('id'=>$id))->find();
			$where['id'] = array('in', trim($info['att_id'],','));
			$acs = M('Attachment')->where($where)->select();
			
			//标签列表
			$tags_one = M('Tags')->where(array('level'=>1))->select();	//
			$tags_two = M('Tags')->where(array('level'=>2,'pid'=>$info['t_one']))->select();	//
			$tags_three = M('Tags')->where(array('level'=>3,'pid'=>$info['t_two']))->select();	//

			$this->assign('tags',$tags_one);
			$this->assign('tag_two',$tags_two);
			$this->assign('tag_three',$tags_three);
			
			$info['att_id'] = $acs;
            $this->assign('info', $info);
            $this->display();
        }
        
    }

    // 查看详情
    public function info() {
		//
		$id = intval($_GET['id']);
		$rs = M('Article')->where(array('id'=>$id))->find();

        $admUser = M('AdminUser')->where('adm_id IN(' . $rs['adm_id'] . ')')->getField('adm_id,adm_nickname as adm_username');
        //$info['shname'] = $rs['adm_pid'] ? $admUser[$rs['adm_pid']] : '无';
        $rs['fbname'] = $admUser[$rs['adm_id']];

        $rs['tagsname'] = implode(',',M('Tags')->where(array('id'=>array('IN',$rs['t_id'])))->getField('name',true));

		$this->assign('info',$rs);

        $this->assign('url', $_GET['form']);
		$this->display();
    }

    // del类型特权  物理、逻辑删除
    public function del() {

        if ($_POST['delid']) {
            //需要删除的数据
            M('Article')->where(array('id'=>array('IN', $_POST['delid'])))->delete();
            $this->redirect('lists');
        }

        if ($_POST['id']) {

            // 更新的条件
            $where['id'] = $_POST['id'];
            if(M('Article')->where($where)->delete()){
                echo json_encode(array("status"=>1, "info"=>"删除成功"));
            }else {
                echo json_encode(array("status"=>0, "info"=>"删除失败"));
            }
        }
    }
	
	//附件上传
    public function fileUpload() {

        $this->uploadFile();
    }
	
	//获取标签
	public function getAjaxTag()
	{
		$pid = intval($_POST['pid']);
		$tags = M('Tags')->where(array('pid'=>$pid))->select();	//
		$this->ajaxReturn($tags,'',1);
	}

}