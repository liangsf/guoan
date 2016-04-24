<?php
/**
 * 来源Model
 * @author lsf <lsf880101@foxmail.com>
 */
class OriginModel extends CommonModel {

    protected $tableName='origin';
    
	//获取作者
	public function getOrigin()
	{
		return $this->select();
	}
    
}
