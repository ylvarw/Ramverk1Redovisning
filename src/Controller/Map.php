<?php
namespace Ylvan\Controller;

/**
 * a Clas to return a map woth positions based on input coordinates
 */
class Map
{
    public function getMap($lat, $lon)
    {
        return "
            <script type=\"text/javascript\">
            var mymap = L.map('mapid').setView(['<?= $lat ?>', '<?= $lon ?>'], 13);
            
            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: 'pk.eyJ1IjoieWx2YW4iLCJhIjoiY2tpazJ5cHE3MDV3eDJ4cGtkbmc5ZXJkcyJ9.ntJutXJ7TINM5SwIA6rNzQ'
            }).addTo(mymap);
            var marker = L.marker(['<?= $lat ?>', '<?= $lon ?>']).addTo(mymap);
            </script>
        ";
    }
}
