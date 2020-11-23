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
class ipJsonController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    // /**
    //  * @var string $db a sample member variable that gets initialised
    //  */
    // private $db = "not active";



    // /**
    //  * The initialize method is optional and will always be called before the
    //  * target method/action. This is a convienient method where you could
    //  * setup internal properties that are commonly used by several methods.
    //  *
    //  * @return void
    //  */
    // public function initialize() : void
    // {
    //     // Use to initialise member variables.
    //     $this->db = "active";
    // }



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
            if (filter_var($ipToValidate, FILTER_VALIDATE_IP)) {
                // code for domain name check
                $domain = "Domain name: " . gethostbyaddr($ipToValidate);
            }
        }
        // Deal with the action and return a response.
        $json = [
            // "message" => __METHOD__ . ", \$db is {$this->db}",
            "ipToValidate" => $ipToValidate ?? null,
            "ipv4" => $ipv4 ?? null,
            "ipv6" => $ipv6 ?? null,
            "domainName" => $domain ?? null
        ];
        // return [$json];

        $page->add("ip/validateJson", [
            "title" => "Validera med JOSN",
            "json" => [$json],
            // "ipToValidate" => $ipToValidate ?? null,
            // "ipv4" => $ipv4 ?? null,
            // "ipv6" => $ipv6 ?? null,
            // "hasDomain" => null,
            // "domainName" => $domain ?? null
        ]);

        $title = "Validera IP med JSON";
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
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return "ipv4: Validerar";
        } else {
            return "ipv4: Validerar ej";
        }

        // return "checking if $ip is valid ipv4";
        
    }

    /**
     * check if ipv6 is valid
     */
    public function ipv6($ip)
    {
        // code for ip check
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return "ipv6: Validerar";
        } else {
            return "ipv6: Validerar ej";
        }
        
        // return "checking if $ip is valid ipv6";
    }

    // /**
    //  * This sample method dumps the content of $di.
    //  * GET mountpoint/dump-app
    //  *
    //  * @return array
    //  */
    public function dumpDiActionGet() : array
    {
        // Deal with the action and return a response.
        $services = implode(", ", $this->di->getServices());
        $json = [
            "message" => __METHOD__ . "<p>\$di contains: $services",
            "di" => $this->di->getServices(),
        ];
        return [$json];
    }



    /**
     * Try to access a forbidden resource.
     * ANY mountpoint/forbidden
     *
     * @return array
     */
    public function forbiddenAction() : array
    {
        // Deal with the action and return a response.
        $json = [
            "message" => __METHOD__ . ", forbidden to access.",
        ];
        return [$json, 403];
    }
}
