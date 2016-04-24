<?php


class QuestionAction extends Action {
    

	public function _initialize(){
		
        isLongin(1);
        
    }

	public function index(){
		
		$id = intval($_GET['id']);
		$art = M('SxyArticle');
		$info = $art->where('id = '.$id)->find();

		if(empty($id) || !$info){
			header('Location: http://'.$_SERVER['HTTP_HOST'].'');
		}

		// $info['description'] = strip_tags($info['description']);
		// $info['content'] = strip_tags($info['content']);

		$this->assign('thml_tags', $info['t_id']);//页面变量所有标签id
		$arrtagsid = explode(',', $info['t_id']);
		$info['t_id'] = $arrtagsid['0'];//多个标签取其中第一个
		//相关下载
		$where['id'] = array('in',$info['att_id']);
		$xiazai = M('SxyAttachment')->where($where)->select();

		/*标签相关文章显示*/
		$tags = D('Arttags')->tags_list($info['t_id']);
		$this->assign('tags',$tags);
		
		/*广告位底部显示*/
		$serv['one'] = D('Arttags')->tags_serv($info['t_id'],1);//1服务 2活动 3应用
		$serv['two'] = D('Arttags')->tags_serv($info['t_id'],2);
		$serv['three'] = D('Arttags')->tags_serv($info['t_id'],3);
		$this->assign("serv",$serv);
		
		/*广告位右侧轮播图显示*/
		$servright = D('Arttags')->tags_serv_right($info['t_id']);
		$this->assign('servright',$servright);

		$this->assign('info',$info);
		$this->assign('xiazai',$xiazai);

		$this->display("question");

	}
	
}