<?php
/**
 * 作者Model
 * @author lsf <lsf880101@foxmail.com>
 */
class WriterModel extends CommonModel {

    protected $tableName='writer';
    
	//获取作者
	public function getWriter()
	{
		return $this->select();
	}
    
}
