<?php

namespace Ylvan\Controller;
// namespace Anax\Controller;


/**
 * A class to handle IP
 */
class IpHandler
{

    // /**
    //  * get user IP address
    //  */
    // public function getUserIp() : string
    // {
    //     // return the user Ip address
    //     $ipaddress = '';
    //     if (getenv('HTTP_CLIENT_IP'))
    //         $ipaddress = getenv('HTTP_CLIENT_IP');
    //     else if(getenv('HTTP_X_FORWARDED_FOR'))
    //         $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    //     else if(getenv('HTTP_X_FORWARDED'))
    //         $ipaddress = getenv('HTTP_X_FORWARDED');
    //     else if(getenv('HTTP_FORWARDED_FOR'))
    //         $ipaddress = getenv('HTTP_FORWARDED_FOR');
    //     else if(getenv('HTTP_FORWARDED'))
    //         $ipaddress = getenv('HTTP_FORWARDED');
    //     else if(getenv('REMOTE_ADDR'))
    //         $ipaddress = getenv('REMOTE_ADDR');
    //     else
    //         $ipaddress = 'UNKNOWN';
    //     return $ipaddress;
    // }

    /**
     * get user IP address
     */
    public function getUserIp() : string
    {
        $ip = $this->findIp();
        return $ip;
    }

    /**
     * get user IP address
     */
    public function findIp() : string
    {
        // if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //     //ip from share internet
        //     $ip = $_SERVER['HTTP_CLIENT_IP'];
        // }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //     //ip pass from proxy
        //     $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        // }else{
        //     $ip = $_SERVER['REMOTE_ADDR'];
        // }
        $externalContent = file_get_contents('http://checkip.dyndns.com/');
        preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
        $externalIp = $m[1];
        return $externalIp;
    }

    /**
     * check if ipv4 is valid
     */
    public function ipv4($ip) : string
    {
        // code for ip check
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return "Validerar";
        } else {
            return "Validerar ej";
        }        
    }

    /**
     * check if ipv6 is valid
     */
    public function ipv6($ip) : string
    {
        // code for ip check
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return "Validerar";
        } else {
            return "Validerar ej";
        }
    }

    
    /**
     * check if ip have a domain name
     */
    public function domainName($ip) : string
    {
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return gethostbyaddr($ip);
        } else {
            return "ip ej validerad";
        }
    }

}
