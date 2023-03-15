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
    protected $card;

    public function uuid()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), // 32 bits for "time_low"
                       mt_rand(0, 0xffff), // 16 bits for "time_mid"
                       mt_rand(0, 0xffff), // 16 bits for "time_hi_and_version",

            // four most significant bits holds version number 4
                       mt_rand(0, 0x0fff) | 0x4000, // 16 bits, 8 bits for "clk_seq_hi_res",

            // 8 bits for "clk_seq_low",

            // two most significant bits holds zero and one for variant DCE1.1
                       mt_rand(0, 0x3fff) | 0x8000, // 48 bits for "node"
                       mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
    }

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

    public function setCard($card)
    {
        $this->card = $card;

        return $this;
    }

    public function getTextResponse()
    {
        return $this->textResponse;
    }

    /**
     * Function sendTextMessage
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 15/03/2023 35:53
     *
     * @see      https://developers.google.com/chat/api/guides/message-formats/text
     */
    public function sendTextMessage()
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
            $this->textResponse = 'Send Message ' . $this->message . ' is ERROR';

            return false;
        }
        $response = json_decode($request, false);
        if (isset($response->error)) {
            $this->textResponse = 'Send Message ' . $this->message . ' is FAILED';

            return false;
        }
        $this->textResponse = $response->sender->displayName . ' Send Message ' . $response->text . ' to Space ' . $response->space->displayName . ' is SUCCESS';

        return true;
    }

    /**
     * Function sendCardMessage
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 15/03/2023 35:42
     *
     * @see      https://developers.google.com/chat/api/guides/message-formats/cards
     * @see      https://developers.google.com/chat/ui/read-form-data
     * @see      https://developers.google.com/chat/ui/widgets/card-header
     */
    public function sendCardMessage()
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
        $cardParams = array(
            'cardsV2' => array(
                'cardId' => date('YmdHis') . '-' . $this->uuid(),
                'card'   => $this->card
            )
        );
        $request = Request::execute($webhook, $cardParams);
        if ($request === false) {
            $this->textResponse = 'Send Message is ERROR';

            return false;
        }
        $response = json_decode($request, false);
        if (isset($response->error)) {
            $this->textResponse = 'Send Message to is FAILED';

            return false;
        }
        $this->textResponse = $response->sender->displayName . ' Send Message to Space ' . $response->space->displayName . ' is SUCCESS';

        return true;
    }

    public function buildCardExample()
    {
        return array(
            'header'   => array(
                'title'        => 'Beetsoft Test',
                'subtitle'     => 'Google Chat Test',
                'imageUrl'     => 'https://developers.google.com/chat/images/quickstart-app-avatar.png',
                'imageType'    => 'CIRCLE',
                'imageAltText' => 'Avatar'
            ),
            'sections' => array(
                array(
                    'header'                    => 'Contact Info',
                    'collapsible'               => true,
                    'uncollapsibleWidgetsCount' => 1,
                    'widgets'                   => array(
                        array(
                            'decoratedText' => array(
                                'startIcon' => array(
                                    'knownIcon' => "EMAIL"
                                ),
                                'text'      => 'contact@beetsoft.com.vn'
                            )
                        ),
                        array(
                            'decoratedText' => array(
                                'startIcon' => array(
                                    'knownIcon' => "EMAIL"
                                ),
                                'text'      => 'hungna@beetsoft.com.vn'
                            )
                        ),
                        array(
                            'buttonList' => array(
                                'buttons' => array(
                                    array(
                                        'text'    => 'Share 2',
                                        'onClick' => array(
                                            'openLink' => array(
                                                'url' => 'abc'
                                            )
                                        )
                                    )
                                )
                            )
                        )
                    ),
                )
            )
        );
    }
}
