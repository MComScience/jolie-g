<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 20/11/2561
 * Time: 20:51
 */

namespace common\components;

use Yii;
use yii\base\Component;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot as BaseLINEBot;

class LineBotBuilder extends Component
{
    public $access_token;

    public $channelSecret;

    private $_httpClient;

    private $_bot;

    const ENDPOINT_BASE = 'https://api.line.me';

    public function init()
    {
        parent::init();
        if ($this->access_token == null) {
            $this->access_token = Yii::$app->keyStorage->get('access_token', null);
        }
        if ($this->channelSecret == null) {
            $this->channelSecret = Yii::$app->keyStorage->get('channelSecret', null);
        }
        $this->createHttpClient();
    }

    public function getHttpClient()
    {
        if (!is_object($this->_httpClient)) {
            $this->_httpClient = $this->createHttpClient();
        }
        return $this->_httpClient;
    }

    protected function createHttpClient()
    {
        $this->_httpClient = new CurlHTTPClient($this->access_token);
    }

    protected function createBot()
    {
        $this->_bot = new BaseLINEBot($this->_httpClient, [
            'channelSecret' => $this->channelSecret,
            'endpointBase' => self::ENDPOINT_BASE
        ]);
    }

    public function getBot()
    {
        return new BaseLINEBot($this->_httpClient, [
            'channelSecret' => $this->channelSecret,
            'endpointBase' => self::ENDPOINT_BASE
        ]);
    }

    public function getProfile($userId)
    {
        $bot = $this->getBot();
        $response = $bot->getProfile($userId);
        if ($response->isSucceeded()) {
            return $response->getJSONDecodedBody();
        }else{
            throw new \Exception($response->getHTTPStatus() . ' ' . $response->getRawBody());
        }
    }
}