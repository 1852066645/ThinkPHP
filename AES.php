<?php

class AES
{
    static protected $iv = [1,-1,1,-1,1,-1,1,-1,1,-1,1,-1,1,-1,1,-1];

    static protected $key = '170cb1aa1850ffb99aa13b6fb5d314ec';

    public function __construct()
    {
        self::$key = hash('md5',self::$key,true);
    }

    /**
     * @brief encrypt aes
     * @param string $input 要加密的数据
     * @return string
     */
    public static function encrypt($input)
    {
        $data = openssl_encrypt($input, 'AES-128-CBC', self::$key, OPENSSL_RAW_DATA, self::toStr(self::$iv));

        $data = base64_encode($data);

        return $data;
    }

    /**
     * @brief decrypt aes解密
     * @param string $sStr [要解密的数据]
     * @return string
     */
    public static function decrypt($sStr)
    {
        $decrypted = openssl_decrypt(base64_decode($sStr), 'AES-128-CBC', self::$key, OPENSSL_RAW_DATA, self::toStr(self::$iv));

        return $decrypted;
    }

    protected static function toStr($bytes) {
        $str = '';
        foreach($bytes as $ch) {
            $str .= chr($ch);
        }
        return $str;
    }
}

$example = new AES();

var_dump($encrypt = $example::encrypt('123456'));
echo '<br>';
var_dump($example::decrypt($encrypt));
