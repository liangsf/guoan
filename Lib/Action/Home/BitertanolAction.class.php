<?php

/*和问答action一样 仅为了需求每天各种改方便*/
class BitertanolAction extends Action {
    

	public function _initialize(){
		
        isLongin(1);
        
    }

	public function index(){
		
		$id = intval($_GET['id']);
		$art = M('SxyArticle');
		$info = $art->where('id = '.$id)->find();
		//$info['content'] = strip_tags($info['content']);
		
		if(empty($id) || !$info){
			header('Location: http://'.$_SERVER['HTTP_HOST'].'');
		}
		
		//格式化正文
		$all_tags = D('Arttags')->getTags(3);
		$info['content'] = D('Arttags')->str_tag_replace($all_tags, $info['content']);
		
		$this->assign('thml_tags', $info['t_id']);//页面变量所有标签id
		$arrtagsid = explode(',', $info['t_id']);
		$info['t_id'] = $arrtagsid['0'];//多个标签取其中第一个
		//相关下载
		$where['id'] = array('in',$info['att_id']);
		$xiazai = M('SxyAttachment')->where($where)->select();

		/*标签相关文章显示*/
		$tags = D('Arttags')->tags_list($info['t_id']);
		$this->assign('tags',$tags);

		/*广告位显示*/
		$serv['one'] = D('Arttags')->tags_serv($info['t_id'],1);//1服务 2活动 3应用
		$serv['two'] = D('Arttags')->tags_serv($info['t_id'],2);
		$serv['three'] = D('Arttags')->tags_serv($info['t_id'],3);
		$this->assign("serv",$serv);

		/*广告位右侧轮播图显示*/
		$servright = D('Arttags')->tags_serv_right($info['t_id']);
		$this->assign('servright',$servright);

		$this->assign('info',$info);
		$this->assign('xiazai',$xiazai);

		$this->display("bitertanol");

	}
	
	//获取标签相关联数据
	public function getLinkInfo()
	{
		$tags = strval($_POST['tag']);
		$txt = strval($_POST['txt']);
		$tag_arr = explode('-',$tags);
		$rs = D('Arttags')->tag_link($tag_arr[0], $tag_arr[1]);

		//拼接html代码
		$html = '<dt>'.$txt.'</dt>';
		$html .= '<dd><span>相关百科：<label class="bk_count">'.$rs['bk_count'].'</label>篇</span><a target="_blank" href="'.C('SITEURL').'Index/?id='.$rs['pid'].'&threetagsid='.$rs['id'].'&types=1">查看</a></dd>';
		$html .= '<dd><span>相关问答：<label class="wd_count">'.$rs['wd_count'].'</label>篇</span><a target="_blank"  href="'.C('SITEURL').'Index/?id='.$rs['pid'].'&threetagsid='.$rs['id'].'&types=2">查看</a></dd>';

		$sub = array();
		foreach($rs['ads'] as $k=>$v){
			if(in_array($v['category'], $sub)){
				continue;
			}else{
				$sub[] = $v['category'];
				if($v['category'] == 1){
					$html .= '<dd><span>相关服务<!--：代办工商注册--></span></span><a  target="_blank" href="'.$v['link'].'">查看</a></dd>';
				}elseif($v['category'] == 2){
					$html .= '<dd><span>相关活动<!--：代办工商注册--></span><a  target="_blank" href="'.$v['link'].'">查看</a></dd>';
				}elseif($v['category'] == 3){
					$html .= '<dd><span>相关应用<!--：代办工商注册--></span><a  target="_blank" href="'.$v['link'].'">查看</a></dd>';
				}
			}
		}
		/*if($rs['ads'][''])
		$html .= '<dd><span>相关服务<!--：代办工商注册--></span></span><a href="###">查看</a></dd>';
		$html .= '<dd><span>相关采购<!--：代办工商注册--></span><a href="###">查看</a></dd>';
		//拼接html代码*/
		
		$this->ajaxReturn($html, '成功', 1);
	}
	
}