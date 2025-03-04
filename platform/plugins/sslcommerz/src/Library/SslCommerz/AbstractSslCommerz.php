<?php

namespace Srapid\SslCommerz\Library\SslCommerz;

abstract class AbstractSslCommerz implements SslCommerzInterface
{
    /**
     * @var string
     */
    protected $apiUrl;

    /**
     * @var string
     */
    protected $storeId;

    /**
     * @var string
     */
    protected $storePassword;

    /**
     * @param array $data
     * @param array $header
     * @param bool $setLocalhost
     * @return bool|string
     */
    public function callToApi($data, $header = [], $setLocalhost = false)
    {
        $curl = curl_init();

        if (!$setLocalhost) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,
                2); // The default value for this option is 2. It means, it has to have the same name in the certificate as is in the URL you operate against.
        } else {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,
                0); // When the verify value is 0, the connection succeeds regardless of the names in the certificate.
        }

        curl_setopt($curl, CURLOPT_URL, $this->getApiUrl());
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlErrorNo = curl_errno($curl);
        curl_close($curl);

        if ($code == 200 & !($curlErrorNo)) {
            return $response;
        }

        return 'cURL Error #:' . $err;
    }

    /**
     * @return string
     */
    protected function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * @param string $url
     */
    protected function setApiUrl($url)
    {
        $this->apiUrl = $url;
    }

    /**
     * @param $response
     * @param string $type
     * @param string $pattern
     * @return false|mixed|string
     */
    public function formatResponse($response, $type = 'checkout', $pattern = 'json')
    {
        $sslcz = json_decode($response, true);

        if ($type != 'checkout') {
            return $sslcz;
        }

        if (isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL'] != '') {
            // this is important to show the popup, return or echo to send json response back
            if ($this->getApiUrl() != null && $this->getApiUrl() == 'https://securepay.sslcommerz.com') {
                $response = json_encode([
                    'status' => 'SUCCESS',
                    'data'   => $sslcz['GatewayPageURL'],
                    'logo'   => $sslcz['storeLogo'],
                ]);
            } else {
                $response = json_encode([
                    'status' => 'success',
                    'data'   => $sslcz['GatewayPageURL'],
                    'logo'   => $sslcz['storeLogo'],
                ]);
            }
        } else {
            $response = json_encode(['status' => 'fail', 'data' => null, 'message' => 'JSON Data parsing error!']);
        }

        if ($pattern == 'json') {
            return $response;
        }

        echo $response;
    }

    /**
     * @param string $url
     * @param bool $permanent
     */
    public function redirect($url, $permanent = false)
    {
        header('Location: ' . $url, true, $permanent ? 301 : 302);

        exit();
    }

    /**
     * @return string
     */
    protected function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * @param string $storeID
     */
    protected function setStoreId($storeID)
    {
        $this->storeId = $storeID;
    }

    /**
     * @return string
     */
    protected function getStorePassword()
    {
        return $this->storePassword;
    }

    /**
     * @param string $storePassword
     */
    protected function setStorePassword($storePassword)
    {
        $this->storePassword = $storePassword;
    }
}
