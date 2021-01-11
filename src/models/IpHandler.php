<?php
namespace Ylvan\Models;

/**
 * A class to handle IP
 * request user IP address, validate Ip
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class IpHandler
{
    /**
     * return user/device IP address
     */
    public function getUserIp() : string
    {
        $ip = $this->findIp();
        return $ip;
    }

    /**
     * get user/device external IP address
     */
    public function findIp() : string
    {
        $externalContent = file_get_contents('http://checkip.dyndns.com/');
        preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
        $externalIp = $m[1];
        return $externalIp;
    }

    /**
     * check if address is valid ipv4
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
     * check if adress is valid ipv6
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
     * check if ip is valid for either ipv4 or ipv6
     * returns true or false
     */
    public function ipIsValid($ip) : string
    {
        // code for ip check
        $ipv4 = $this->ipv4($ip);
        $ipv6 = $this->ipv6($ip);
        if ($ipv4 == "Validerar" or $ipv6 == "Validerar") {
            return "true";
        } else {
            return "false";
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
