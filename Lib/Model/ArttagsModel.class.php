<?php

class ArttagsModel extends CommonModel {

    /*文章页标签相关内容的显示*/
	public function tags_list($tagsid)
	{

		//标签及父级标签
		$art = M('Article');
		$mtags = M('Tags');
		$tags['tagsname'] = $mtags->where("id = ".$tagsid)->find();//标签名称
		$tags['tagspname'] = $mtags->where("id = ".$tags['tagsname']['pid'])->find();//父标签名称

		$w['_string'] = " (FIND_IN_SET({$tagsid},`t_id`))";
		$tags['countthreeart'] = $art->where($w)->count();//该标签相关几篇文章
		$tags['counttwoart'] = $art->where("t_two = ".$tags['tagspname']['id'])->count();//父标签相关几篇文章

		//右侧问答百科
		$tags['bk'] = $art->where("types = 1 and (FIND_IN_SET(".$tags['tagsname']['id'].",`t_id`)) ")->limit(5)->select();
		$tags['wd'] = $art->where("types = 2 and (FIND_IN_SET(".$tags['tagsname']['id'].",`t_id`))")->limit(5)->select();
		$bkcount = $art->where("types = 1 and (FIND_IN_SET(".$tags['tagsname']['id'].",`t_id`)) ")->select();
		$wdcount = $art->where("types = 2 and (FIND_IN_SET(".$tags['tagsname']['id'].",`t_id`))")->select();
		
		$tags['countbk'] = count($bkcount);
		$tags['countwd'] = count($wdcount);

		//右侧标签分类
		$tags['tagsthreename'] = $mtags->where('pid = '.$tags['tagspname']['id'])->limit(5)->select();

		return $tags;
	}
    
    /*文章页标签底部相关的广告显示*/
    public function tags_serv($tagsid,$category){

    	/*广告位显示*/
		$servid = M('Tags')->where("id = ".$tagsid)->find();//标签所关联服务
		//所有服务
		$mserv = M('Serve');
		$w['position'] = 0;//底部
		$w['category'] = $category;//1服务 2活动 3应用
		$w['id'] = array("in",$servid['s_id']);
		$serv_view = $mserv->where($w)->find();
		
		return $serv_view;
		
    }

	/*广告位右侧轮播图显示*/
    public function tags_serv_right($tagsid){

		$servid = M('Tags')->where("id = ".$tagsid)->find();//标签所关联服务
		//所有服务
		$mserv = M('Serve');
		$w['position'] = 1;//右侧滚动
		$w['id'] = array("in",$servid['s_id']);
		$serv_view = $mserv->where($w)->select();

		return $serv_view;
    }
	
	//获取某级别所有标签
	public function getTags($level)
	{
		$mtags = M('Tags');
		if($level != ''){
			$w['level'] = $level;
		}
		$rs = $mtags->where($w)->field('id, name, level')->select();
		return $rs;
	}
	
	//替换字符串中出现的标签
	public function str_tag_replace($tags, $str)
	{
		if(!is_array($tags)){
			return '';
		}
		foreach($tags as $k=>$v){
			$find[] = $v['name'];
			//$chg[] = '<a href="javascript:;" class="Highlight" data="'.$v['id'].'-'.$v['level'].'">'.$v['name'].'</a>';
			$chg[] = '<b class="js_tip Highlight" data="'.$v['id'].'-'.$v['level'].'"><i style="font-style:normal;">'.$v['name'].'</i><span class="hover_window"></span></b>';
		}
		$rs = str_replace($find, $chg, $str);
		return $rs;
	}
	
	//标签相关信息查询
	public function tag_link($tagId, $tagLevel=1)
	{
		$art = M('Article');
		if($tagLevel == 1){
			$w['t_one'] = $tagId;
		}elseif($tagLevel == 2){
			$w['t_two'] =  $tagId;
		}elseif($tagLevel == 3){
			$w['_string'] =  " (FIND_IN_SET({$tagId},`t_id`))";
		}

		//百科
		$w['types'] = 1;
		$rs['bk_count'] = $art->where($w)->count();

		//问答
		$w['types'] = 2;
		$rs['wd_count'] = $art->where($w)->count();
		
		$serv = M('Tags')->where(array('id'=>$tagId))->find();

		$rs['pid'] = $serv['pid'];
		$rs['ppid'] = $serv['ppid'];
		$rs['id'] = $serv['id'];
		
		//获取广告相关信息
		$mserv = M('Serve');
		$sw['position'] = 0;//底部
		//$sw['category'] = $category;//1服务 2活动 3应用
		$sw['id'] = array("in",$serv['s_id']);
		$rs['ads'] = $mserv->where($sw)->field('link, id, name, category')->select();
		return $rs;
	}
}
