<?php

namespace Anax\View;

/**
 * Render page for ip geolocation.
 */

?>

<h1>Se din plats med IP-adresser</h1>
<br>
<p> <?= $content ?> </p>

<form method="post">
    IP: <input type="text" name="ip" placeholder="<?= $ipAddress ?>" required>
    <input type="submit" name="doLocate" value="Hitta plats">
</form>

<?php if ($ipPosition) : ?>
    <?php if ($ipAddress) : ?>
        <p><b>Ip-adress: </b> <?= $ipAddress ?> </p>
        <p><b>IPv4: </b> <?= $ipv4 ?> </p>
        <p><b>IPv6: </b> <?= $ipv6 ?> </p>
        <p><b>Latitud: </b> <?= $latitude ?> </p>
        <p><b>Longitud: </b> <?= $longitude ?> </p>
        <p><b>Stad: </b> <?= $city ?> </p>
    <?php endif; ?>
<?php endif; ?>
