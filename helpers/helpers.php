<?php
if (!function_exists('simple_google_chat_notifier')) {
    function simple_google_chat_notifier($config, $message): bool
    {
        $spaceId = $config['spaceId'] ?? null;
        $key = $config['key'] ?? null;
        $token = $config['token'] ?? null;
        $threadKey = $config['threadKey'] ?? null;
        if ($spaceId === null || $key === null || $token === null) {
            return false;
        }

        $notifier = new \nguyenanhung\Platform\Notification\GoogleChat\Notifier();
        $notifier->setSpaceId($spaceId)
                 ->setKey($key)
                 ->setToken($token)
                 ->setThreadKey($threadKey)
                 ->setMessage($message);

        return $notifier->send_text_message();
    }
}
