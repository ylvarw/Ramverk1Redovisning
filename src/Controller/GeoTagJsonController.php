<?php

namespace Ylvan\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * A controller show position of IP with JSON format
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class GeoTagJsonController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    public function indexActionGet() : object
    {
        $ip = $this->di->get("ipHandler");
        $geo = $this->di->get("ipPosition");
        $page = $this->di->get("page");
        $session = $this->di->session;

        $userIp = $ip->getUserIp();
        $useripv4 = $ip->ipv4($userIp);
        $useripv6 = $ip->ipv6($userIp);
        // $userDomain = $ip->domain($userIp);
        $userPosition = $geo->getPosition($userIp);

        $ipPosition = $session->get("ipPosition", $userPosition);
        $ipv4 = $session->get("ipv4", $useripv4);
        $ipv6 = $session->get("ipv6", $useripv6);
        $domain = $session->get("domain", null);


        $json = [
            "ip" => $ipPosition['ip'] ?? null,
            "latitude" => $ipPosition['latitude'] ?? null,
            "longitude" => $ipPosition['longitude'] ?? null,
            "ipv4" => $ipv4,
            "ipv6" => $ipv6,
            "domainName" => $domain,
        ];

        $data = [
            "title" => "Validera med JSON",
            "json" => $json,
        ];

        $page->add("ip/jsonlocation", $data);


        $title = "Validera IP med JSON";
        return $page->render([
            "title" => $title,
        ]);
    } 


    /**
     * This is the index method action, it handles:
     * POST METHOD mountpoint
     * POST METHOD mountpoint/
     * POST METHOD mountpoint/index
     *
     * @return array
     */
    public function indexActionPost() : array
    {
        $ip = $this->di->get("ipHandler");
        $geo = $this->di->get("ipPosition");

        $request = $this->di->get("request");
        $session = $this->di->session;


        $findIp = $request->getPOST("ip", null);
        $doLocate = $request->getPOST("doLocate", null);

        if ($doLocate) {
            $ipPosition = $geo->getPosition($findIp);
            $latitude = $ipPosition['latitude'];
            $longitude = $ipPosition['longitude'];
            $ip = $ipPosition['ip'];
            $ipv4 = $ip->ipv4($findIp);
            $ipv6 = $ip->ipv6($findIp);
            $domain = $ip->domainName($findIp);

            
            $session->set("ipPosition", $ipPosition);
            $session->set("latitude", $ipPosition);
            $session->set("longitude", $ipPosition);
            $session->set("ipv4", $ipv4);
            $session->set("ipv6", $ipv6);
            $session->set("domain", $domain);
            $session->set("findIp", $findIp);
        }

        $json = [
            "ipPosition" => $ipPosition ?? null,
            "latitude" => $latitude ?? null,
            "longitude" => $longitude ?? null,
            "ip" => $findIp ?? null,
            "ipv4" => $ipv4 ?? null,
            "ipv6" => $ipv6 ?? null,
            "domainName" => $domain ?? null,
        ];
        return [$json];
    }
}
