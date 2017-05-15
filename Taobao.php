<?php
class TaoBao
{

    public $api_key = '';
    public $secret_key = '';
    public $callback = "";
    public $errmsg="";
    private $_authorize_url = 'https://oauth.taobao.com/authorize';
    private $_accesstoken_url = 'https://oauth.taobao.com/token';
    /**
     * 获取授权地址
     * @param  [type] $callback [回调地址]
     * @param  string $state    [本次请求的标识]
     * @return [type]           [授权URL地址]
     */
    public  function getAuthorizeURL()
    {
        $state = md5(time().mt_rand(1000000,9999999));
        $_SESSION['tb_state'] = $state;
        $url = $this->_authorize_url . '?response_type=code&client_id=' . $this->api_key . '&redirect_uri=' . urlencode($this->callback) . '&state=' . $state;
        return $url;
    }
    /**
     * 获取AccessToken
     * @param  [type] $code [description]
     * @return [type]       [description]
     */
    public function getAccessToken($code)
    {
        $params = array(
            'grant_type' => 'authorization_code',
            'client_id' => $this->api_key,
            'client_secret' => $this->secret_key,
            'code' => $code,
            'redirect_uri' => $this->callback
        );
        $token = json_decode($this->curl($this->_accesstoken_url, $params), true);
        return $token;
    }

    public function curl($url, $postFields = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (is_array($postFields) && 0 < count($postFields)) {
            $postBodyString = "";
            foreach ($postFields as $k => $v) {
                $postBodyString .= "$k=" . urlencode($v) . "&";
            }
            unset($k, $v);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString, 0, -1));
        }
        $reponse = curl_exec($ch);
        // if (curl_errno($ch)) {
        //     throw new Exception(curl_error($ch), 0);
        // } else {
        //     $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //     if (200 !== $httpStatusCode) {
        //         throw new Exception($reponse, $httpStatusCode);
        //     }
        // }
        curl_close($ch);
        return $reponse;
    }

    public function _get($key,$default="")
    {
       return isset($_GET[$key]) ? $_GET[$key] : $default;
    }

    public function _post($key,$default="")
    {
       return isset($_POST[$key]) ? $_POST[$key] : $default;
    }
    public function _session($key,$val=null,$default="")
    {
        if(is_null($val))
        {
            return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
        }
        else
        {
            $_SESSION[$key] = $val;
        }
    }

    public function show($msg){
        header("Content-Type: text/html;charset=utf-8");
        echo "<pre>";
        print_r($msg);
        echo "</pre>";
        die();
    }


}

session_start();
$taoBao = new TaoBao();
$taoBao->api_key = "";   //填写开放平台应用appkey
$taoBao->secret_key = ""; //填写开放平台应用appsecret
$taoBao->callback = "http://www.taobao.com/Taobao.php"; //回调地址

//获取toekn
if( $state = $taoBao->_get('state') )
{
    $dbstate = $taoBao->_session("tb_state");

    if($state != $dbstate )
    {
        $taoBao->show("授权校验失败,<a style='color:red;font-size:18px;' href='".$taoBao->callback."'>重新授权</a>");
    }
    //授权成功后的code
    $code = $taoBao->_get("code");

    if(!$code)
    {
        $taoBao->show("授权失败,<a style='color:red;font-size:18px;' href='".$taoBao->callback."'>重新授权</a>");
    }
    $token = $taoBao->getAccessToken($code);

    //改tb_state值为空
    $taoBao->_session("tb_state","");

    if(isset($token['error']))
    {
        $taoBao->show("授权失败,<a style='color:red;font-size:18px;' href='".$taoBao->callback."'>重新授权</a><p>".sprintf("错误代码%s,错误描述%s",$token['error'],$token['error_description'])."</p>");
    }
    $taoBao->show( sprintf("%s您的授权accessToken: <span style='color:red;padding:5px;'>%s</span> ，授权到期时间:%s",urldecode($token['taobao_user_nick']),$token['access_token'],date('Y-m-d:H:i:s',ceil($token['expire_time']/1000))) );
}
else
{
    $url = $taoBao->getAuthorizeURL();
    header("location:".$url);
    die();
}

















