<?php
/**
 * Project google-chat-notifier
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 15/03/2023
 * Time: 09:36
 */

namespace nguyenanhung\Platform\Notification\GoogleChat;

class Notifier
{
    const WEBHOOKS = 'https://chat.googleapis.com/v1/spaces/{{spaceId}}/messages?key={{key}}&token={{token}}';

    protected $config;
    protected $spaceId;
    protected $key;
    protected $threadKey;
    protected $token;
    protected $message;
    protected $textResponse;

    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    public function setSpaceId($spaceId)
    {
        $this->spaceId = $spaceId;

        return $this;
    }

    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    public function setThreadKey($threadKey)
    {
        $this->threadKey = $threadKey;

        return $this;
    }

    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    public function getTextResponse()
    {
        return $this->textResponse;
    }

    public function send_text_message()
    {
        $webhook = self::WEBHOOKS;
        $webhook = str_replace(
            array('{{spaceId}}', '{{key}}', '{{token}}'),
            array($this->spaceId, $this->key, $this->token),
            $webhook
        );
        if (!empty($this->threadKey)) {
            $webhook .= '&threadKey=' . urlencode($this->threadKey);
        }
        $params = array(
            'text' => $this->message
        );
        $request = Request::execute($webhook, $params);
        if ($request === false) {
            $this->textResponse = 'Send Message ' . $this->message . ' to is FAILED';

            return false;
        }
        $response = json_decode($request, false);
        if (isset($response->error)) {
            $this->textResponse = 'Send Message ' . $this->message . ' to is FAILED';

            return false;
        }
        $this->textResponse = $response->sender->displayName . ' Send Message ' . $response->text . ' to Space ' . $response->space->displayName . ' is SUCCESS';

        return true;
    }


}
