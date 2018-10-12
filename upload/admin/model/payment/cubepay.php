<?php

class ModelPaymentCubepay extends Model
{
    function getFiat()
    {
        $api_url = (!empty($this->config->get('cubepay_url'))) ? $this->config->get('cubepay_url') : "https://api.cubepay.io";
        $api_url .= '/currency/fiat';
        $params['client_id']  = $this->config->get('cubepay_client_id');
        $sign = $this->sign($params);
        $params['sign'] = $sign;
        $ch = curl_init(trim($api_url));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }

    protected function sign($data)
    {
        $cubepay_secret = $this->config->get('cubepay_client_secret');
        ksort($data);
        $data_string = urldecode(http_build_query($data)) . "&client_secret=" . $cubepay_secret;
        $sign = strtoupper(hash("sha256", $data_string));
        return $sign;
    }
}
