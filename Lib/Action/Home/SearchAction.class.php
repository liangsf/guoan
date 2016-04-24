<?php


class SearchAction extends Action {
    
	public function index(){
		$type = intval($_GET['t']);
		if($type == ''){
			$type = 1;
		}

		$view['type'] = $type;
		$keyword = strip_tags(strval($_GET['keyword']));
		if(empty($keyword)){
			//echo '没有关键词';exit;
		}else{
			//$where['title'] = array('like', "%{$keyword}%");
			$where['_string'] = "title like '%".$keyword."%' OR content like '%".$keyword."%'";
			$view['k'] = $keyword;
		}
		$where['types'] = $type;
		$p	= intval($_GET['p']);
		
		
		$list = getListByPage('SxyArticle', 'id DESC', $where, 10, 0, $p);	
		
		//获取另一个数量
		if($type == 1){
			$view['b_count'] = $list['count'];
			$where['types'] = 2;
			if($list['count'] == 0){
				$list = getListByPage('SxyArticle', 'id DESC', $where, 10, 0, $p);
			}
			$view['w_count'] = M('SxyArticle')->where($where)->count();
		}
		if($type == 2){
			$view['w_count'] = $list['count'];
			$where['types'] = 1;
			if($list['count'] == 0){
				$list = getListByPage('SxyArticle', 'id DESC', $where, 10, 0, $p);
			}
			$view['b_count'] = M('SxyArticle')->where($where)->count();
		}
		
		$tag_id = $this->get_tag_id($list['list']);
		$fuwu_arr = M('SxyTags')->where(array('id'=>$tag_id))->find();

		$hot_where['id'] = array('in', $fuwu_arr['s_id']);
		$hot_where['position'] = 2;
		$view['fuwus'] = M('SxyServe')->where($hot_where)->select();

		$view['all_count'] = $view['b_count']+$view['w_count'];
		
		$this->assign($list);
		$this->assign($view);

		if($view['all_count']<=0){
			$this->display('none');
			exit;
		}
		$this->display("search");
	}
	
	//获取关联文章最多的标签id
	protected function get_tag_id($list)
	{
		$tags = array();
		foreach($list as $k=>$v){
			$sub_arr = explode(',', $v['t_id']);
			foreach($sub_arr as $i=>$j){
				$tags[] = $j;
			}
		}

		$arr_count = array_count_values($tags);
		$max_tag_v = 0;
		$max_tag_id = '';
		foreach($arr_count as $k=>$v){
			if($v>$max_tag_v){
				$max_tag_id = $k;
				$max_tag_v = $v;
			}
		}
		return $max_tag_id;
	}
	
}