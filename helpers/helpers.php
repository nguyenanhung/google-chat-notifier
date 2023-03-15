<?php
if (!function_exists('simple_google_chat_notifier')) {
    function simple_google_chat_notifier($config, $message)
    {
        $spaceId = isset($config['spaceId']) ? $config['spaceId'] : null;
        $key = isset($config['key']) ? $config['key'] : null;
        $token = isset($config['token']) ? $config['token'] : null;
        $threadKey = isset($config['threadKey']) ? $config['threadKey'] : null;
        if ($spaceId === null || $key === null || $token === null) {
            return false;
        }

        $notifier = new \nguyenanhung\Platform\Notification\GoogleChat\Notifier();
        $notifier->setSpaceId($spaceId)
                 ->setKey($key)
                 ->setToken($token)
                 ->setThreadKey($threadKey)
                 ->setMessage($message);

        return $notifier->sendTextMessage();
    }
}
if (!function_exists('simple_google_chat_card_notifier')) {
    function simple_google_chat_card_notifier($config, $card)
    {
        $spaceId = isset($config['spaceId']) ? $config['spaceId'] : null;
        $key = isset($config['key']) ? $config['key'] : null;
        $token = isset($config['token']) ? $config['token'] : null;
        $threadKey = isset($config['threadKey']) ? $config['threadKey'] : null;
        if ($spaceId === null || $key === null || $token === null) {
            return false;
        }

        $notifier = new \nguyenanhung\Platform\Notification\GoogleChat\Notifier();
        $notifier->setSpaceId($spaceId)
                 ->setKey($key)
                 ->setToken($token)
                 ->setThreadKey($threadKey)
                 ->setCard($card);

        return $notifier->sendCardMessage();
    }
}
