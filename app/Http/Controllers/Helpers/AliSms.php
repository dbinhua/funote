<?php

namespace App\Http\Controllers\Helpers;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

trait AliSms
{
    public function __construct()
    {
        AlibabaCloud::accessKeyClient(env('ALI_ACCESSKEYID'), env('ALI_ACCESSSECRET'))
            ->regionId('cn-hangzhou')
            ->asDefaultClient();
    }

    public function sendSms(string $phoneNumbers, array $templateParam = [], string $templateCode = 'SMS_197465395')
    {
        try {
                AlibabaCloud::rpc()
                ->product('Dysmsapi')
                ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => [
                        'PhoneNumbers' => $phoneNumbers,
                        'SignName' => '赤道文学',
                        'TemplateCode' => $templateCode,
                        'TemplateParam' => json_encode($templateParam),
                    ],
                ])->request();
        } catch (ClientException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
        } catch (ServerException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
        }
    }
}
