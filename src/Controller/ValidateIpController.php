<?php
namespace Anax\Controller;

// namespace Ylvan\Ip;


use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
// use Ylvan\Ip;
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
class ValidateIpController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;
    // private $valid = new Ylvan\Ip\ValidatorIp();

    // public function indexAction() : object
    // {
    //     $title = "Ip validation";
    //     $session = $this->di->get("session");
    //     $page = $this->di->get("page");
        
    //     $data = [
    //         "test" => "test2",
    //         "content" => "Validera en ip-adress",
    //         // "ipv6" => $ipv6,
    //         // "domain" => $domain
    //     ];

    //     $page->add("anax/v2/article/default", $data);

    //     return $page->render([
    //         "title" => $title,
    //     ]);
    // }
    public function indexAction() : object
    {
        $page = $this->di->get("page");
        $session = $this->di->get("session");

        $session->set("ipToValidate", null);
        $session->set("ipv4", null);
        $session->set("ipv6", null);
        $session->set("domainName", null);

        $page->add("ip/validate", [
            "content" => "Validera en ip-adress",
            "testvar" => "testar",
            "ipToValidate" => $ipToValidate ?? null,
            "ipv4" => $ipv4 ?? null,
            "ipv6" => $ipv6 ?? null,
            // "hasDomain" => null,
            "domainName" => $domain ?? null
        ]);

        return $page->render();
    }

    /**
     * handle validation from post request
     */
    public function validateAction() : object
    {
        $title = "validera ip adresser";

        $session = $this->di->get("session");
        $page = $this->di->get("page");
        $request = $this->di->get("request");


            //  använsa sessin för variablerna
        $ipToValidate = $request->getPOST("ip", null);
        $session->set("ipToValidate", null);

        $ipv4 = $this->ipv4($ipToValidate);
        $ipv6 = $this->ipv6($ipToValidate);
        // $domain = $this->hasDomainName($ipToValidate);
        $session->set("ipv4", $ipv4);
        $session->set("ipv6", $ipv6);

         // check if it's a valid ip
        if ($ipv4 == true || $ipv6 == true) {
            // code for domain name check
            // return gethostbyaddr($ipToValidate);
            $session->set("domainName", gethostbyaddr($ipToValidate));
        }
        // $session->set("domainName", $domain);


        $data = [
            "ipToValidate" => $ipToValidate ?? null,
            "ipv4" => $ipv4 ?? null,
            "ipv6" => $ipv6 ?? null,
            // "hasDomain" => $hasDomain ?? null,
            "domainName" => $domain ?? null
        ];

        $page->add("ip/validate", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * check if ipv4 is valid
     */
    public function ipv4($ip)
    {
        // code for ip check
        if (filter_var($ip, FILTER_FLAG_IPV4)) {
            return true;
        } else {
            return false;
        }

        // return "checking if $ip is valid ipv4";
        
    }

    /**
     * check if ipv6 is valid
     */
    public function ipv6($ip)
    {
        // code for ip check
        if (filter_var($ip, FILTER_FLAG_IPV6)) {
            return true;
        } else {
            return false;
        }
        
        // return "checking if $ip is valid ipv6";
    }

    /**
     * check if ip have a domain name
     */
    // public function hasDomainName($ip)
    // {
    //     $ipv4 = $this->ipv4($ip);
    //     $ipv6 = $this->ipv6($ip);

    //     // check if it's a valid ip
    //     if ($ipv4 == true || $ipv6 == true) {
    //         // code for domain name check
    //         return gethostbyaddr($ip);
    //     }
    // }


    /**
     * return extra details from request 
     */
    public function requestDetails(
        string $method,
        array $args = []
    ) : string
    {
        $request    = $this->di->get("request");
        $path       = $request->getRoute();
        $httpMethod = $request->getMethod();
        $numArgs    = count($args);
        $strArgs    = implode(", ", $args);
        $queryString    = http_build_query($request->getGet(), '', ', ');

        return <<<EOD
            <h1>$method</h1>
            <p>The request were '$path' ($httpMethod).
            <p>Got '$numArgs' arguments: '$strArgs'.
            <p>Querry string contains: '$queryString'.
            <p>\$db is '{$this->db}'.
        EOD;
    }



    /**
     * Adding an optional catchAll() method will catch all actions sent to the
     * router. You can then reply with an actual response or return void to
     * allow for the router to move on to next handler.
     * A catchAll() handles the following, if a specific action method is not
     * created:
     * ANY METHOD mountpoint/**
     *
     * @param array $args as a variadic parameter.
     *
     * @return mixed
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function catchAll(...$args)
    {
                // print extra info on action
        $page = $this->di->get("page");
        $data = [
            "content" => $this->requestDetails(__METHOD__, $args),
        ];
        $page->add("anax/v2/article/default", $data);

        return $page->render([
            "title" => __METHOD__,
        ]);
    }
}