<?php
class WeChat{
    protected $appID     =  'wx8dd5312cc9b5d792';
    protected $appsecret =  '27806dc5944a02c948084de0fc384c8a';
    public function __construct()
    {
        $code = $_GET['code'];
        if ( $code ) {
            $this->getAccessToken($code);
        }
    }

    public function getCode()
    {
        $redirect_uri = '60.205.191.165';
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->appID.'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_userinfo &state=STATE#wechat_redirect ';
        header("Location: $url");

    }

    public function getAccessToken($code)
    {
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->appID.'&secret='.$this->appsecret.'&code='.$code.'&grant_type=authorization_code ';
        $res = json_decode($this->postCurl($url),true);
        if ( $res['access_token'] && $res['openid'] ) {
            $newurl = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$res['access_token'].'&openid='.$res['openid'].'&lang=zh_CN ';
            var_dump(json_decode($this->postCurl($newurl),true));
        }

    }


    //发送curl请求
    public function postCurl($url,$post_data,$type){
        $ch=curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output=curl_exec($ch);
        curl_close($ch);
        return $output;


    }


}


$list = new WeChat();
$code = $list->getCode();
