<?php
namespace Ylvan\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A controller to check if a IP is a valid IPv5 or IPv6 and if it have a domain name.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class ValidateIpController implements ContainerInjectableInterface
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

        $page->add("ip/validate", [
            "content" => "Validera en ip-adress",
            "ipAddress" => $ipToValidate ?? null,
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

    // /**
    //  * return extra details from request for debugging
    //  */
    // public function requestDetails(
    //     string $method,
    //     array $args = []
    // ) : string
    // {
    //     $request    = $this->di->get("request");
    //     $path       = $request->getRoute();
    //     $httpMethod = $request->getMethod();
    //     $numArgs    = count($args);
    //     $strArgs    = implode(", ", $args);
    //     $queryString    = http_build_query($request->getGet(), '', ', ');

    //     return <<<EOD
    //         <h1>$method</h1>
    //         <p>The request were '$path' ($httpMethod).
    //         <p>Got '$numArgs' arguments: '$strArgs'.
    //         <p>Querry string contains: '$queryString'.
    //         <p>\$db is '{$this->db}'.
    //     EOD;
    // }

    // /**
    //  * Adding an optional catchAll() for debugging and error catching.
    //  * A catchAll() handles the following, if a specific action method is not
    //  * created:
    //  * ANY METHOD mountpoint/**
    //  *
    //  * @param array $args as a variadic parameter.
    //  *
    //  * @return mixed
    //  *
    //  * @SuppressWarnings(PHPMD.UnusedFormalParameter)
    //  */
    // public function catchAll(...$args)
    // {
    //             // print extra info on action
    //     $page = $this->di->get("page");
    //     $data = [
    //         "content" => $this->requestDetails(__METHOD__, $args),
    //     ];
    //     $page->add("anax/v2/article/default", $data);

    //     return $page->render([
    //         "title" => __METHOD__,
    //     ]);
    // }


    // /**
    //  * A catchAll() handles the following, if a specific action method is not
    //  * created:
    //  * ANY METHOD mountpoint/**
    //  *
    //  * @param array $args as a variadic parameter.
    //  *
    //  * @return mixed
    //  *
    //  * @SuppressWarnings(PHPMD.UnusedFormalParameter)
    //  */
    // public function catchAll(...$args)
    // {
    //     // Deal with the request and send an actual response, or not.
    //     //return __METHOD__ . ", \$db is {$this->db}, got '" . count($args) . "' arguments: " . implode(", ", $args);
    //     return;
    // }
}
