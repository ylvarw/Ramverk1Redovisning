<?php

namespace Anax\View;

/**
 * Render page for ip validation.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?>
<h1>Kolla väder med ip</h1>
<br>
<p> <?= $content ?> </p>

<form method="post">
    IP:  <input type="text" name="ip" placeholder="<?= $ipAddress ?>">
    <input type="submit" name="SearchIP" value="sök">
    <!-- <input type="submit" name="SearchHistoryIP" value="historisk data"> -->
    <input type="submit" name="forecast" value="kommande prognos">
</form>
<br>
<!-- <form method="post">
    Ort: <input type="text" name="city" placeholder="<?= $placeholderCity ?>,SE"">
    <input type="submit" name="searchCity" value="sök">
    <input type="submit" name="searchHistoryCity" value="historisk data">
</form> -->

<!-- <p><b>testvar: </b> <?= $testvar ?> </p> -->


<?php if ($noData) : ?>
    <p> <?= $noData ?> </p>
<?php endif; ?>


<?php if ($weatherdata) : ?>
    <p>Plats:  <?= $city ?>, <?= $coordinates ?> </p>
    <p>
        Dagens väder:  <?= json_encode($descriptionWeather) ?> 
        <br>
        Temperatur: <?= json_encode($selectedtemp["temp"]) ?> C, 
        Max: <?= json_encode($selectedtemp["temp_max"]) ?> C, 
        Min: <?= json_encode($selectedtemp["temp_min"]) ?> C
        <br>
        Luftfuktighet: <?= json_encode($selectedtemp["humidity"]) ?>%
        Vindstyrka: <?= json_encode($selectedtwind["speed"]) ?> m/s 
    </p>
<?php endif; ?>



<?php if ($forecastData) : ?>
    <?php if (json_encode($forecastData["cod"] == '401')) : ?>
        <p> <?= json_encode($forecastData["message"]) ?>
        <br>
        Service is not a part of your subscription </p>
    <?php else : ?>
        <p>Plats:  <?= $city ?>, <?= $coordinates ?> </p>
        <p>
            Dagens väder:  <?= json_encode($forecastData) ?> 
            <!-- <br>
            Temperatur: <?= json_encode($selectedtemp["temp"]) ?> C, 
            Max: <?= json_encode($selectedtemp["temp_max"]) ?> C, 
            Min: <?= json_encode($selectedtemp["temp_min"]) ?> C
            <br>
            Luftfuktighet: <?= json_encode($selectedtemp["humidity"]) ?>%
            Vindstyrka: <?= json_encode($selectedtwind["speed"]) ?> m/s  -->
        </p>
    <?php endif; ?>
<?php endif; ?>


<?php if ($weatherHistorydata) : ?>
    <?php if (json_encode($weatherHistorydata["cod"] == '401')) : ?>
        <p> <?= json_encode($weatherHistorydata["message"]) ?>
        <br>
        Service is not a part of your subscription </p>
    <?php else : ?>
        <p>Plats:  <?= $city ?>, <?= $coordinates ?> </p>
        <?php foreach ($weatherHistorydata as $data) : ?>
            <p>Data:  <?= json_encode($data) ?> </p>
        <?php endforeach;?>
    <?php endif; ?>
<?php endif; ?>

