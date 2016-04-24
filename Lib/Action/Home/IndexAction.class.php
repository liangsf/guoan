<?php


class IndexAction extends Action {
    
	public function _initialize(){
		
        isLongin(1);
        
    }

	public function index(){

		//标签显示
		$tags = M('SxyTags')->where(array('level'=>2))->order('tagsort')->select();
		$id = intval($_GET['id']);//?$_GET['id']:$tags[0]['id'];//二级标签选择
		if(empty($id)){
			$id = $tags[0]['id'];//默认选中第一个效果
		}else{
			$chatwo = 1;//为了光查二级标签
		}
		$this->assign('tagsid',$_GET['id']);//二级id、input传值
		$this->assign('id',$id); //判断选中
		$mrthreetags = M('SxyTags')->where(array('pid'=>$id))->select();//默认三级标签
		$this->assign('mrthreetags',$mrthreetags);//默认三级标签
		$this->assign('tags',$tags);
		//以下均作为where条件
		//三级标签id
		$threetagsid = intval($_GET['threetagsid'])?intval($_GET['threetagsid']):0;
		$this->assign('threetagsid',$threetagsid);
		//列表显示&&分类
		$types = intval($_GET['types']);
		if(empty($types)){
			$types = 1;
			$ttttt = 0;
		}else{
			$ttttt = $types;
		}
		$this->assign('ttttt',$ttttt);//为了临时显示一下页面title keyword
		$this->assign('types',$types);

		
		$article = M('SxyArticle');

		//显示上面条数
		$count['baike'] = $article->where('types = 1')->count();
		$count['wenda'] = $article->where('types = 2')->count();
		$this->assign('count',$count);


		$where['types'] = $types;
		if($chatwo == 1){
			$where['t_two'] = $id;

			$count['baike'] = $article->where("types = 1 and t_two = ".$id)->count();
			$count['wenda'] = $article->where("types = 2 and t_two = ".$id)->count();
			$this->assign('count',$count);

		}
		if($threetagsid){
			$where['t_id'] = array('like',"%".$threetagsid."%");

			$count['baike'] = $article->where("types = 1 and t_id like '%".$threetagsid."%'")->count();
			$count['wenda'] = $article->where("types = 2 and t_id like '%".$threetagsid."%'")->count();
			$this->assign('count',$count);
		}

		//显示数据列表
		$p = $_GET['p'] ? $_GET['p'] : 1;
		$baike = getListByPage('SxyArticle', 'id DESC', $where, 10, 0, $p);
		foreach ($baike['list'] as $k => $v) {
			$baike['list'][$k]['content'] = strip_tags($v['content']);
			if($v['types'] == 1){
				$baike['list'][$k]['url'] = C('SITEURL').'bitertanol/?id='.$v['id'];
			}else{
				$baike['list'][$k]['url'] = C('SITEURL').'question/?id='.$v['id'];
			}
			
		}

		$this->assign('baike',$baike);
		$this->display();
	}
	
}