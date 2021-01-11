<?php

namespace Anax\View;

/**
 * Render page for ip validation.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>
<head>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/leaflet@1.3.3/dist/leaflet.css">
 
</head>

<h1>Se väder med ip</h1>
<br>

<form method="post">
    IP:  <input type="text" name="ip" placeholder="<?= $ipAddress ?>">
    <input type="submit" name="SearchIP" value="sök">
    <input type="submit" name="SearchHistoryIP" value="historisk data">
    <input type="submit" name="forecast" value="kommande prognos">
</form>
<br>


<!-- <p><b>testvar: </b> <?= $testvar ?> </p> -->
<h3> <?= $content ?> </h3>


<?php if ($noData) : ?>
    <p> <?= $noData ?> </p>
<?php endif; ?>


<?php if ($weatherdata) : ?>
    <p><b>Plats: </b>  <?= $city ?>, <?= $coordinates ?> </p>
    <p>
        Dagens väder:  <?= json_encode($descriptionWeather) ?> 
        <br>
        Temperatur: <?= json_encode($selectedtemp["temp"]) ?> C
        <br>
        Max: <?= json_encode($selectedtemp["temp_max"]) ?> C
        <br>
        Min: <?= json_encode($selectedtemp["temp_min"]) ?> C
        <br>
        Luftfuktighet: <?= json_encode($selectedtemp["humidity"]) ?>%
        Vindstyrka: <?= json_encode($selectedtwind["speed"]) ?> m/s
    </p>
<?php endif; ?>



<?php if ($forecastData) : ?>
    <p><b>Plats: </b> <?= $city ?>, <?= $coordinates ?> </p>
    <?php foreach ($forecastData["daily"] as $data) : ?>
        <p>
            <br>
            <b>Datum:</b> <?= date("Y-m-d", (int)json_encode($data["dt"])) ?>
            <br>
            Dagens väder: <?= json_encode($data["weather"][0]["description"]) ?> 
            <br>
            Temperatur: <?= json_encode($data["temp"]["day"]) ?> C
            <br>
            Max: <?= json_encode($data["temp"]["max"]) ?> C
            <br>
            Min: <?= json_encode($data["temp"]["min"]) ?> C
            <br>
            Luftfuktighet: <?= json_encode($data["humidity"]) ?>%
            Vindstyrka: <?= json_encode($data["wind_speed"]) ?> m/s
        </p>
    <?php endforeach;?>
<?php endif; ?>


<?php if ($weatherHistorydata) : ?>
    <p><b>Plats: </b> <?= $city ?>, <?= $coordinates ?> </p>
    <?php foreach ($weatherHistorydata as $index => $data) : ?>
        <p>
            <br>
            <b>Datum:</b> <?= date("Y-m-d", (int)json_encode($data["current"]["dt"])); ?>
            <br>
            Dagens väder:  <?= json_encode($data["current"]["weather"][0]["description"]) ?> 
            <br>
            Temperatur: <?= json_encode($data["current"]["temp"]) ?> C
            <br>
            Luftfuktighet: <?= json_encode($data["current"]["humidity"]) ?>%
            <br>
            Vindstyrka: <?= json_encode($data["current"]["wind_speed"]) ?> m/s
        </p>
    <?php endforeach;?>
<?php endif; ?>


<div id="map" style="height: 590px"></div>

<?php if ($weatherdata or $forecastData or $weatherHistorydata) : ?>
    <script src='https://unpkg.com/leaflet@1.3.3/dist/leaflet.js'></script>
    

    <script type="text/javascript">
        var map = L.map('map').setView([<?= $latitude ?>, <?= $longitude ?>], 3);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{3}/'+<?= $latitude ?>+ '/'+<?= $longitude ?> +'.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // L.marker([<?= $latitude ?>, <?= $longitude ?>]).addTo(map)
        // .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
        // .openPopup();


        </script>

    <!-- <img><?= $map ?></img> -->
    <!-- <div id="map" style="width: 1004px; height: 590px; background-color: #fff"></div>

    <script type="text/javascript">
        var map = new L.Map('map');
        
        // var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        var osmUrl = 'http://{s}.tile.openstreetmap.org/4/<?= $latitude ?>/<?= $longitude ?>.png',
            osmAttrib = 'Map data &copy; 2016 OpenStreetMap contributors',
            osm = new L.TileLayer(osmUrl, {maxZoom: 18, attribution: osmAttrib});
        
        map.setView(new L.LatLng(, ), 13).addLayer(osm);
    </script> -->

<?php endif; ?>
