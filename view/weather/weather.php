<?php

namespace Anax\View;

/**
 * Render page for ip validation.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?>
<h1>kolla väder med ip</h1>
<br>
<p> <?= $content ?> </p>

<form method="post">
    IP:  <input type="text" name="ip" placeholder="<?= $ipAddress ?>">
    <input type="submit" name="SearchIP" value="sök">
    <input type="submit" name="SearchHistoryIP" value="historisk data">
</form>
<br>
<!-- <form method="post">
    Ort: <input type="text" name="city" placeholder="<?= $placeholderCity ?>,SE"">
    <input type="submit" name="searchCity" value="sök">
    <input type="submit" name="searchHistoryCity" value="historisk data">
</form> -->

<!-- <p><b>testvar: </b> <?= $testvar ?> </p> -->


<?php if ($NoData) : ?>
    <p> <?= $NoData ?> </p>

<?php endif; ?>
<?php if ($weatherdata) : ?>
    <p>Plats:  <?= $city ?>, <?= $coordinates ?> </p>
    <p>Väder: <?= json_encode($selectedWeather) ?> </p>
    <!-- <p> <?= json_encode($WeatherDescriprion) ?> </p> -->
    <p>Temperatur: <?= json_encode($selectedtemp) ?> </p>
    <p>Vind: <?= json_encode($selectedtwind) ?> </p>
<?php endif; ?>


<?php if ($weatherHistorydata) : ?>
    <p>Plats:  <?= $city ?>, <?= $coordinates ?> </p>
    <?php foreach ($weatherHistorydata as $data) : ?>
        <p>Datum:  </p>
        <p>Väder: <?= json_encode($data->selectedWeather) ?> </p>
        <!-- <p> <?= json_encode($data->WeatherDescriprion) ?> </p> -->
        <p>Temperatur: <?= json_encode($data->selectedtemp) ?> </p>
        <p>Vind: <?= json_encode($data->selectedtwind) ?> </p>
    <?php endforeach;?>
<?php endif; ?>

