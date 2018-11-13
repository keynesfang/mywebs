<?php

$req_type = $_REQUEST['req_type'];
if ($req_type == "login") {
    $code = $_REQUEST['code'];
    $url = "https://api.weixin.qq.com/sns/jscode2session?appid=wx63e23c9d69dc4b69&secret=b9c7d6af251f392079ac27e1dd56a9d0&js_code=" . $code . "&grant_type=authorization_code";

    $res = file_get_contents($url); //获取文件内容或获取网络请求的内容
//    $result = json_decode($res);
//    if ($result->openid) {
//        $openid = $result->openid;
//        $user = 'user';
//        $userInfo = $user->where(array('openid' => $openid))->find();
//        if (!$userInfo) {
//            $data['openid'] = $openid;
//            $data['modifytime'] = date("Y-m-d H:i:s");
//            $userId = $user->add($data);
//            $this->success($userId, '', true);
//        } else {
//            $this->success($userInfo['id'], '', true);
//        }
//    }
    echo $res;
}