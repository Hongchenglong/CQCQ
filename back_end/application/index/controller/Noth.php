<?php

namespace app\index\controller;

require __DIR__ . './Aliyun/vendor/autoload.php';

use think\Log;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class Noth
{
    public function send()
    {
        Log::init([
            'type'  =>  'File',
            'path'  =>  APP_PATH . 'logs/'
        ]);
        $phone = $_POST['phone'];
        cookie('code', rand(100000, 999999), 3600);
        $code = cookie('code');

        try {
            // Create Client
            AlibabaCloud::accessKeyClient('LTAI4GF7ef5Wyc3A8nZRi2EW', 'wMV3FQP1cM8ZOo8YH39Q739kwc00qW')->asDefaultClient();
            // Chain calls and send RPC request
            $result = AlibabaCloud::rpc()
                ->regionId('cn-hangzhou')
                ->product('Dysmsapi')
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->options([
                    'query' => [
                        'PhoneNumbers' => $phone,
                        'SignName' => "CQCQ",
                        'TemplateCode' => "SMS_189611359",
                        'TemplateParam' => "{'code':$code}",
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
}
