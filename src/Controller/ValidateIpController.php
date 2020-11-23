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
 * A controller to check if a IP is a valid IPv5 or IPv6 and if it have a domain name.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
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

            // check if it's a valid ip of any type
            if (filter_var($ipToValidate, FILTER_VALIDATE_IP)) {
                // code for domain name check
                $domain = gethostbyaddr($ipToValidate);
            }
        }

        $page->add("ip/validate", [
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
    private function ipv4($ip)
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
    private function ipv6($ip)
    {
        // code for ip check
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return "Validerar";
        } else {
            return "Validerar ej";
        }
    }



    /**
     * This sample method dumps the content of $di.
     * GET mountpoint/dump-app
     *
     * @return string
     */
    public function dumpDiActionGet() : string
    {
        // Deal with the action and return a response.
        $services = implode(", ", $this->di->getServices());
        return __METHOD__ . "<p>\$di contains: $services";
    }



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