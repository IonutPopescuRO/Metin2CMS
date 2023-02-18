<?php
class GetClientIp
{
    protected static $ipServerHeaders = [
        'HTTP_X_FORWARDED_FOR',
        'X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'X-REAL-IP',
        'VIA',
        'HTTP_CLIENT_IP',
        'REMOTE_ADDR',
		'HTTP_CF_CONNECTING_IP' //CloudFlare
    ];
	
    protected $serverHeaders = [];

    protected $clientIP = null;

    public function __construct()
    {
        $this->setServerHeaders();
        $this->setClientIp();
    }

    protected function setServerHeaders()
    {
        $serverHeaders = $_SERVER;

        $this->serverHeaders = [];

        foreach(self::getIpServerHeaders() as $key)
			if(array_key_exists($key, $serverHeaders))
				$this->serverHeaders[$key] = $serverHeaders[$key];
    }

    protected function getServerHeaders()
    {
        return $this->serverHeaders;
    }

    protected function getIpServerHeaders()
    {
        return self::$ipServerHeaders;
    }

    public function validate_ip($ip)
    {
        if(filter_var($ip, FILTER_VALIDATE_IP))
            return true;

        return false;
    }
	
    protected function setClientIp()
    {
        foreach($this->getIpServerHeaders() as $ipHeader)
            if(isset($this->serverHeaders[$ipHeader]))
                foreach(explode(',', $this->serverHeaders[$ipHeader]) as $ip) {
                    $ip = trim($ip);
                    if(self::validate_ip($ip)) {
                        $this->clientIP = $ip;

                        return $ip;
                    }
                }

        return false;
    }

    public function getClientIp()
    {
        return $this->clientIP;
    }
}