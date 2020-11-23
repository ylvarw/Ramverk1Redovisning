<?php

namespace Anax\Controller;

// namespace Ylvan\Ip;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample JSON controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 */
class IpJsonController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint
     * GET METHOD mountpoint/
     * GET METHOD mountpoint/index
     *
     * @return array
     */
    public function indexAction() : object
    // public function indexActionGet() : array
    {
        $page = $this->di->get("page");
        $request = $this->di->get("request");
        // $session = $this->di->get("session");

        $ipToValidate = $request->getPOST("ip", null);
        $doValidate = $request->getPOST("doValidate", null);

        if ($doValidate) {
            $ipv4 = $this->ipv4($ipToValidate);
            $ipv6 = $this->ipv6($ipToValidate);


            // check if it's a valid ip of any type
            // if (filter_var($ipToValidate, FILTER_VALIDATE_IP)) {
                // code for domain name check
            $domain = $this->domainName($ipToValidate);
            // }
        }
    
        // Deal with the action and return a response.
        $json = [
            "ipToValidate" => $ipToValidate ?? null,
            "ipv4" => $ipv4 ?? null,
            "ipv6" => $ipv6 ?? null,
            "domainName" => $domain ?? null
        ];

        $page->add("ip/validateJson", [
            "title" => "Validera med JOSN",
            "json" => [$json],

        ]);

        $title = "Validera IP med JSON";
        return $page->render([
            "title" => $title,
        ]);
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

        // return "checking if $ip is valid ipv4";
        
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
        
        // return "checking if $ip is valid ipv6";
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
