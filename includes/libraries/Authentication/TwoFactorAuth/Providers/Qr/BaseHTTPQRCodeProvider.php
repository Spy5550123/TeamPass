<?php

namespace Authentication\TwoFactorAuth\Providers\Qr;
require_once(dirname(__FILE__)."/IQRCodeProvider.php");

abstract class BaseHTTPQRCodeProvider implements IQRCodeProvider
{
    protected $verifyssl;

    protected function getContent($url, $proxyIP, $proxyPort)
    {
        $curlhandle = curl_init();
        
        curl_setopt_array($curlhandle, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_DNS_CACHE_TIMEOUT => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => $this->verifyssl,
            CURLOPT_USERAGENT => 'TwoFactorAuth',
            CURLOPT_PROXY => empty($proxyIP) === true || empty($proxyPort) === true ? '' : $proxyIP.':'.$proxyPort
        ));
        $data = curl_exec($curlhandle);
        
        curl_close($curlhandle);
        return $data;
    }
}