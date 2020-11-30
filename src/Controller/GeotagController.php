<?php

namespace Ylvan\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// include 'helpers/GeoTag.php';
// include 'helpers/IpHandler.php';


/**
 * A test controller to show off redirect.
 */
class GeotagController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;
    // use GeoTag;
    // use IpHandler;

    public function indexAction() : object
    {
        $ip = new IpHandler();
        $geo = new IpPosition();

        $page = $this->di->get("page");
        $request = $this->di->get("request");

        $ipAddress = $request->getPOST("ip", null);
        $doLocate = $request->getPOST("doLocate", null);
        $userIp = $ip->getUserIp();
        $userPosition = $geo->getPosition($userIp);
        $latitude = $userPosition['latitude'];
        $longitude = $userPosition['longitude'];
        $city = $userPosition['city'];
        $coordinates = 'Latitude: '.$latitude . ' ' . 'Longitude: ' . $longitude;
        
        
        $ipv4 = $ip->ipv4($userIp);
        $ipv6 = $ip->ipv6($userIp);

        if ($doLocate) {
            $ipv4 = $ip->ipv4($ipAddress);
            $ipv6 = $ip->ipv6($ipAddress);

            $domain = $ip->domainName($ipAddress);
            $ipPosition = $geo->getPosition($ipAddress);
            $latitude = $ipPosition['latitude'];
            $longitude = $ipPosition['longitude'];
            $city = $ipPosition['city'];
            $coordinates = 'Latitude: '.$latitude . ' ' . 'Longitude: ' . $longitude;
        }

        $page->add("ip/location", [
            "content" => "Hitta position med ip-address",
            "ipPosition" => $coordinates ?? null,
            "latitude" => $latitude ?? null,
            "longitude" => $longitude ?? null,
            "city" => $city ?? null,
            "ipAddress" => $ipAddress ?? $userIp,
            "ipv4" => $ipv4 ?? null,
            "ipv6" => $ipv6 ?? null,
            // "hasDomain" => null,
            "domainName" => $domain ?? null
        ]);

        $title = "hantera IP";
        return $page->render([
            "title" => $title,
        ]);
    }

}