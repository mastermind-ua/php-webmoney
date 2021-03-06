<?php

namespace baibaratsky\WebMoney\Api\X;

use baibaratsky\WebMoney\Request\XmlRequest;

abstract class Request extends XmlRequest
{
    const AUTH_CLASSIC = 'classic';
    const AUTH_LIGHT = 'light';
    const AUTH_SHA256 = 'sha256';
    const AUTH_MD5 = 'md5';
    const AUTH_SECRET_KEY = 'secret_key';

    /** @var string */
    protected $authType;

    /** @var string reqn */
    protected $requestNumber;

    /** @var string wmid */
    protected $signerWmid;

    /** @var string Light auth cert file name (PEM) */
    protected $lightCertificate;

    /** @var string Light auth key file name (PEM) */
    protected $lightKey;

    /** @var string Light auth key password */
    protected $lightPassword;

    public function __construct($authType = self::AUTH_CLASSIC)
    {
        $this->authType = $authType;
        $this->requestNumber = $this->generateRequestNumber();
    }

    /**
     * @param string $certificate Light auth certificate file name (PEM)
     * @param string $key Light auth key file name (PEM)
     * @param string $keyPassword Light auth key password
     */
    public function lightAuth($certificate, $key, $keyPassword = '')
    {
        $this->lightCertificate = $certificate;
        $this->lightKey = $key;
        $this->lightPassword = $keyPassword;
    }

    /**
     * @deprecated Use lightAuth() instead
     * @param string $certificate Light auth certificate file name (PEM)
     * @param string $key Light auth key file name (PEM)
     */
    public function cert($certificate, $key)
    {
        $this->lightAuth($certificate, $key);
    }

    /**
     * @return string
     */
    public function getAuthType()
    {
        return $this->authType;
    }

    /**
     * @return string
     */
    public function getLightCertificate()
    {
        return $this->lightCertificate;
    }

    /**
     * @return string
     */
    public function getLightKey()
    {
        return $this->lightKey;
    }

    /**
     * @return string
     */
    public function getLightPassword()
    {
        return $this->lightPassword;
    }

    /**
     * @return int
     */
    public function getRequestNumber()
    {
        return $this->requestNumber;
    }

    /**
     * @param int $requestNumber must be greater than a previous request number
     */
    public function setRequestNumber($requestNumber)
    {
        $this->requestNumber = (int)$requestNumber;
    }

    /**
     * @return string
     */
    public function getSignerWmid()
    {
        return $this->signerWmid;
    }

    /**
     * @param string $signerWmid
     */
    public function setSignerWmid($signerWmid)
    {
        $this->signerWmid = (string)$signerWmid;
    }

    /**
     * @return string
     */
    protected function generateRequestNumber()
    {
        list($msec, $sec) = explode(' ', substr(microtime(), 2));
        return $sec . substr($msec, 0, 5);
    }
}
