<?php

namespace Guilty\Imageshop\services;

use Craft;
use craft\base\Component;
use Guilty\Imageshop\Imageshop;

class Soap extends Component
{
    public function getTemporaryToken()
    {
        $settings = Imageshop::$plugin->settings;

        // If no token is sent or set in settings
        if (empty($settings->token) || empty($settings->key)) {
            return null;
        }

        $action = 'http://imageshop.no/V4/GetTemporaryToken';

        $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        $xml .= "<soap:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\">\n";
        $xml .= "  <soap:Body>\n";
        $xml .= "    <GetTemporaryToken xmlns=\"http://imageshop.no/V4\">\n";
        $xml .= "      <token>" . $settings->token . "</token>\n";
        $xml .= "      <privateKey>" . $settings->key . "</privateKey>\n";
        $xml .= "    </GetTemporaryToken>\n";
        $xml .= "  </soap:Body>\n";
        $xml .= "</soap:Envelope>";

        return $this->_request($action, $xml);
    }

    private function _request($action, $xml, $cacheDuration = 86400)
    {
        $url = 'https://webservices.imageshop.no/V4.asmx';

        $headers = [
            'POST /V4.asmx HTTP/1.1',
            'Host: webservices.imageshop.no',
            'Content-Type: text/xml; charset=utf-8',
            'Content-Length: ' . strlen($xml),
            'SOAPAction: ' . $action
        ];

        $cacheKey = md5($url . implode(', ', $headers) . $xml);


        if (($cached = Craft::$app->getCache()->get($cacheKey)) !== false) {
            return $cached;
        }

        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($curl);
            curl_close($curl);

            $response1 = str_replace("<soap:Body>", "", $response);
            $response2 = str_replace("</soap:Body>", "", $response1);

            $result = json_decode(json_encode(simplexml_load_string($response2)));

        } catch (\Throwable $e) {
            Craft::warning("Couldn't get SOAP response: {$e->getMessage()}", __METHOD__);

            $result = null;

            // Set shorter cache duraction
            $cacheDuration = 300; // 5 minutes
        }

        Craft::$app->getCache()->set($cacheKey, $result, $cacheDuration);

        return $result;
    }
}
