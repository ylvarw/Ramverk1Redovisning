<?php

namespace Ylvan\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A JSON controller to show validation status of an IP
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class IpJsonController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $session = $this->di->session;

        $ipv4 = $session->get("ipv4", null);
        $ipv6 = $session->get("ipv6", null);
        $domain = $session->get("domain", null);
        $ipToValidate = $session->get("ipToValidate", null);


        $json = [
            "ipToValidate" => $ipToValidate,
            "ipv4" => $ipv4,
            "ipv6" => $ipv6,
            "domainName" => $domain
        ];

        $data = [
            "title" => "Validera med JSON",
            "json" => $json,
        ];

        $page->add("ip/validateJson", $data);


        // $title = "Validera IP med JSON";
        $title = "Validera IP med JSON";
        return $page->render([
            "title" => $title,
        ]);
    } 


    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint
     * GET METHOD mountpoint/
     * GET METHOD mountpoint/index
     *
     * @return array
     */
    public function indexActionPost() : array
    {
        // $page = $this->di->get("page");
        $request = $this->di->get("request");
        $session = $this->di->session;


        $ipToValidate = $request->getPOST("ip", null);
        $doValidate = $request->getPOST("doValidate", null);

        if ($doValidate) {
            $ipv4 = $this->ipv4($ipToValidate);
            $ipv6 = $this->ipv6($ipToValidate);
            $domain = $this->domainName($ipToValidate);
            // }
            $session->set("ipv4", $ipv4);
            $session->set("ipv6", $ipv6);
            $session->set("domain", $domain);
            $session->set("ipToValidate", $ipToValidate);
        }

        // Deal with the action and return a response.
        $json = [
            "ipToValidate" => $ipToValidate ?? null,
            "ipv4" => $ipv4 ?? null,
            "ipv6" => $ipv6 ?? null,
            "domainName" => $domain ?? null
        ];
        return [$json];
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
