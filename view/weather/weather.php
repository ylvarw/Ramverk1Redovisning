<?php

namespace Anax\View;

/**
 * Render page for ip validation.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?>
<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
   <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
</head>

<h1>Kolla väder med ip</h1>
<br>

<form method="post">
    IP:  <input type="text" name="ip" placeholder="<?= $ipAddress ?>">
    <input type="submit" name="SearchIP" value="sök">
    <input type="submit" name="SearchHistoryIP" value="historisk data">
    <input type="submit" name="forecast" value="kommande prognos">
</form>
<br>
<!-- <form method="post">
    Ort: <input type="text" name="city" placeholder="<?= $placeholderCity ?>,SE"">
    <input type="submit" name="searchCity" value="sök">
    <input type="submit" name="searchHistoryCity" value="historisk data">
</form> -->

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
                <!-- Data:  <?= json_encode($data) ?>  -->
                <br>
                <b>Datum:</b> <?= date("Y-m-d", json_encode($data["dt"])); ?>
                <!-- <b>Datum:</b> <?= json_encode($data["dt"]); ?> -->
                <br>
                Dagens väder:  <?= json_encode($data["weather"][0]["description"]) ?> 
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
        <!-- <p><?= json_encode($weatherHistorydata) ?> </p> -->
        <?php foreach ($weatherHistorydata as $index => $data) : ?>
            <p>
                <!-- Data:  <?= json_encode($data) ?>  -->
                <br>
                <b>Datum:</b> <?= date("Y-m-d", json_encode($data["current"]["dt"])); ?>
                <!-- <b>Datum:</b> <?= json_encode($data["dt"]); ?> -->
                <br>
                Dagens väder:  <?= json_encode($data["current"]["weather"][0]["description"]) ?> 
                <br>
                Temperatur: <?= json_encode($data["current"]["temp"]) ?> C
                <!-- <br>
                Max: <?= json_encode($data["current"]["temp"]) ?> C
                <br>
                Min: <?= json_encode($data["current"]["temp"]) ?> C -->
                <br>
                Luftfuktighet: <?= json_encode($data["current"]["humidity"]) ?>%
                <br>
                Vindstyrka: <?= json_encode($data["current"]["wind_speed"]) ?> m/s
        </p>
        <?php endforeach;?>
<?php endif; ?>


<div id="mymap" class="mymap"></div>
<?php if($weatherdata || $forecastData || $weatherHistorydata) : ?>
        <!-- echo " -->
    <script type=\"text/javascript\">
        var mymap = L.map('mapid').setView([<?= $latitude ?>, <?= $longitude ?>], 13);
        
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
        <!-- "; -->
<?php endif; ?>