<?php
/**
 * Project google-chat-notifier
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 15/03/2023
 * Time: 09:33
 */

namespace nguyenanhung\Platform\Notification\GoogleChat;

class Request
{
    /**
     * Function sendRequest - Hàm request tới Endpoint sử dụng phương thức GET, thư viện cURL với TLS v1.2
     *
     * @param string $url     URL Endpoint cần gọi
     * @param array  $params  Data Params cần truyền dữ liệu
     * @param int    $timeout Thời gian chờ phản hồi dữ liệu tối đa
     *
     * @return bool|string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 04/01/2021 00:35
     */
    public static function execute($url = '', $params = array(), $timeout = 30)
    {
        $endpoint = trim($url);
        $data = json_encode($params);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL            => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => $timeout,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSLVERSION     => CURL_SSLVERSION_TLSv1_2,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $data,
            CURLOPT_HTTPHEADER     => array(
                'Content-Type: application/json'
            ),
        ));
        $result = curl_exec($curl);

        $err = curl_error($curl);
        if ($err) {
            return false;
        }

        curl_close($curl);

        return $result;
    }
}
