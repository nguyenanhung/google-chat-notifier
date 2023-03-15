<?php
if (!function_exists('simple_google_chat_notifier')) {
    function simple_google_chat_notifier($config, $message)
    {
        $spaceId = isset($config['spaceId']) ? $config['spaceId'] : null;
        $key = isset($config['key']) ? $config['key'] : null;
        $token = isset($config['token']) ? $config['token'] : null;
        if ($spaceId === null || $key === null || $token === null) {
            return false;
        }

        $notifier = new \nguyenanhung\Platform\Notification\GoogleChat\Notifier();
        $notifier->setSpaceId($spaceId)
                 ->setKey($key)
                 ->setToken($token)
                 ->setMessage($message);

        return $notifier->send();
    }
}
