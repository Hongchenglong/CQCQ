<?php
require __DIR__ . '.../vendor/Aliyun/vendor/autoload.php';

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class index{
    public function send(){
        try {
            // Create Client
            AlibabaCloud::accessKeyClient('LTAI4GF7ef5Wyc3A8nZRi2EW', 'wMV3FQP1cM8ZOo8YH39Q739kwc00qW')->asDefaultClient();
            // Chain calls and send RPC request
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->options([
                    'query' => [
                        'RegionId' => "cn-hangzhou",
                        'PhoneNumbers' => '17720791683',
                        'SignName' => "验证码",
                        'TemplateCode' => "SMS_189611359",
                        'TemplateParam' => "{'code':'123456'}",
                    ],
                ])
                ->request();
            print_r($result->toArray());
        } catch (ClientException $exception) {
            // Get client error message
            print_r($exception->getErrorMessage());
        } catch (ServerException $exception) {
            // Get server error message
            print_r($exception->getErrorMessage());
        }

    }
    public function test(){
        dump(123);
    }
}

