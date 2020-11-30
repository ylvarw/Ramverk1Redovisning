<?php

namespace Ylvan\Controller;
// namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class NamespaceController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;


    public function indexAction() : object
    {
        $page = $this->di->get("page");
        $request = $this->di->get("request");

        $ipToValidate = $request->getPOST("ip", null);
        $doValidate = $request->getPOST("doValidate", null);

        if ($doValidate) {
            $ipv4 = $this->ipv4($ipToValidate);
            $ipv6 = $this->ipv6($ipToValidate);
            $domain = $this->domainName($ipToValidate);
        }

        $page->add("ip/namespace", [
            "content" => "Validera en ip-adress",
            "ipToValidate" => $ipToValidate ?? null,
            "ipv4" => $ipv4 ?? null,
            "ipv6" => $ipv6 ?? null,
            // "hasDomain" => null,
            "domainName" => $domain ?? null
        ]);

        $title = "Validera IP";
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
