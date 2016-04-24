<?php
/**
 * ThirdApi
 * java接口调用类
 *
 *
 */
class ThirdApi {

    private $api_sid;
    private $api_reqid;

    public function request_api($map) {

        is_array();
        if (is_array($map)) {
            $apiurl = json_encode($map);
        } else {
            $apiurl = $map;
        }
        $rs = $this->send_request($apiurl);
        return json_decode($rs);
    }

    private function send_request($apiurl) {
        set_time_limit(3); 
        return request_by_other(C('OTHER_API_URL'), $apiurl);
    }
}
?>