<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sms
 *
 * @author Broff
 */
class Sms
{
    private static $urlApi = 'http://letsads.com/api';
    private static $login = '375445378289';
    private static $pass = '244234';
    private static $sender = 'caffe.by';//'test';//
    
    public static function send($message, $phone)
    {
        $xml = Sms::xmlGenerateMessage($message, $phone);
        $rCurl = curl_init(self::$urlApi);
        curl_setopt($rCurl, CURLOPT_HEADER, 0);
        curl_setopt($rCurl, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($rCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($rCurl, CURLOPT_POST, 1);
        $sAnswer = curl_exec($rCurl);
        curl_close($rCurl);
    }
    
    private static function xmlGenerateMessage($message, $phone)
    {
        $xml ='<?xml version="1.0" encoding="UTF-8"?>
        <request>
            <auth>
                <login>'.self::$login.'</login>
                <password>'.self::$pass.'</password>
            </auth>
            <message>
                <from>'.self::$sender.'</from>
                <text>'.$message.'</text>
                <recipient>'. $phone .'</recipient>
            </message>
        </request>';
        return $xml;
    }
    
    
}
