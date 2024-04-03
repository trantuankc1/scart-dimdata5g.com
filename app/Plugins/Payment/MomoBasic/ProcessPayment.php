<?php
/**
 * ProcessPayment Momo basic
 * User for Momo api v1.0
 *
 * @package    App\Plugins\Payment\MomoBasic
 * @subpackage ProcessPayment
 * @copyright  Copyright (c) 2020 SCart opensource.
 * @author     Lanh le <lanhktc@gmail.com>
 */
#App\Plugins\Payment\MomoBasic\ProcessPayment.php

namespace App\Plugins\Payment\MomoBasic;


class ProcessPayment
{
    private $accessKey;
    private $partnerCode;
    private $secretKey;
    private $urlAPI;

    /**
     * PartnerInfo constructor.
     * @param $accessKey
     * @param $partnerCode
     * @param $secretKey
     */
    public function __construct($accessKey, $partnerCode, $secretKey, $urlAPI)
    {
        $this->accessKey = $accessKey;
        $this->partnerCode = $partnerCode;
        $this->secretKey = $secretKey;
        $this->urlAPI = $urlAPI;
    }

    /**
     * @return mixed
     */
    public function getAccessKey()
    {
        return $this->accessKey;
    }

    /**
     * @param mixed $accessKey
     */
    public function setAccessKey($accessKey): void
    {
        $this->accessKey = $accessKey;
    }

    /**
     * @return mixed
     */
    public function getPartnerCode()
    {
        return $this->partnerCode;
    }

    /**
     * @param mixed $partnerCode
     */
    public function setPartnerCode($partnerCode): void
    {
        $this->partnerCode = $partnerCode;
    }

    /**
     * @return mixed
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * @param mixed $secretKey
     */
    public function setSecretKey($secretKey): void
    {
        $this->secretKey = $secretKey;
    }

    /**
     * Create new capture
     *
     * @param   [array]  $orderData   Info order
     * @param   [array]  $configData  Config process payment
     *
     * @return  [array]
     */
    public function createCaptureMoMoRequest($orderData = [], $configData = []) {

        $data = [
            'partnerCode' => $this->partnerCode,
            'accessKey' => $this->accessKey,
            'requestId' => $orderData['id'].'_'.time(),
            'amount' => $orderData['amount'],
            'orderId' => $orderData['id'],
            'orderInfo' => 'Order SCart shop',
            'returnUrl' => $configData['returnUrl'] ?? '',
            'notifyUrl' => $configData['notifyUrl'] ?? '',
            'extraData' => empty($configData['email'])?'': 'emai='.$configData['email'],
        ];
        $stringData = urldecode(http_build_query($data));
        $signature = hash_hmac('sha256', $stringData, $this->secretKey);
        $data['requestType'] = 'captureMoMoWallet';
        $data['signature'] = $signature;

        $url = $this->urlAPI.'/gw_payment/transactionProcessor';
        $data_string = json_encode($data);                                                                                                                                                                                     
        $ch = curl_init($url);                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string))                                                                       
        );                                                                                                                                                                                                                           
        $result = curl_exec($ch);

        return json_decode($result, true);
        
    }
}
