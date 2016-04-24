<?php
/**
 * 区域操作
 * @author lsf <lsf880101@foxmail.com>
 */
class AreaModel extends CommonModel {

    protected $tableName='dm_qy';
    protected $trueTableName='eq_dm_qy';
        
    /**
     * 获取区域数据
     * @author lsf<lsf880101@foxmail.com>
     * @param unknown_type $where
     * @param unknown_type $field
     */
    public function get_area($where, $field='*') {
        if(empty($where)) return null;
        return  $this->get_more_data($where,$field);
    }

    /**
     * 递归获取所属区域
     * @author lsf<lsf880101@foxmail.com>
     * Enter description here ...
     * @param $cityId
     */
    public function get_area_info($cityId) {

        $area_html = '';
        if(empty($cityId)) return null;
        if ($cityId == '999999'){
            echo $result['addrinfo']."<br>";
        }else{
            $rs = $this->get_one_data("qy_dm='{$cityId}' and yx_bz='y'",'qy_mc,sj_qy_dm');
            $area_html = $rs['qy_mc'].' '.$area_html;
            $area_html = $this->get_area_info($rs['sj_qy_dm']).'  '.$area_html;
        }
        return $area_html;
    }

    /**
     * 获取单个区域数据
     * @author zz
     * @param unknown_type $where
     * @param unknown_type $field
     */
    public function get_area_list($where, $field='*'){
        if(empty($where)) return null;
        return  M('dm_qy')->field($field)->where($where)->find();
    }

    /**
     * 获取详细地址
     *
     * $qydm  区域代码
     *
     * return string 地址
     */
    public function getAddress($qydm = '', $mark = '—', $qydms) {

        if (empty($qydms)) {
            $where['qy_dm'] = array('IN', array(substr($qydm, 0, 2) . '0000', substr($qydm, 0, 4) . '00', $qydm));
        } else {
            $where['qy_dm'] = array('IN', $qydms);
        }
        return implode($mark, getValueByField($this->where($where)->field('qy_mc')->order('qy_dm ASC')->select(), 'qy_mc'));
    }
}
