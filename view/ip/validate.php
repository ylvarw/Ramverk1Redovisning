<?php

namespace Anax\View;

/**
 * Render page for ip validation.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?>
<h1>Validera IP-adresser</h1>
<br>
<p> <?= $content ?> </p>

<form method="post">
    IP: <input type="text" name="ip">
    <input type="submit" name="doValidate" value="Validera">
</form>



<?php if ($ipAddress) : ?>
    <h3>Valideringsresultat: </h3>

    <p><b>Ip-adress: </b> <?= $ipAddress ?> </p>

    <p><b>IPv4: </b>  <?= $ipv4 ?> </p>
    <p><b>IPv6: </b>  <?= $ipv6 ?> </p>


    <?php if ($domainName) : ?>
        <p><b>Domännamn: </b> <?= $domainName ?> </p>
    <?php else : ?>
        <p><b>Domännamn: </b> inget domännamn funnet </p>
    <?php endif; ?>
<?php endif; ?>
