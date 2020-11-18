<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

// Prepare classes
// $classes[] = "article";
// if (isset($class)) {
//     $classes[] = $class;
// }


?>
<h1>validera ip adresser</h1>

<form method="post">
    ip: <input type="text" name="ip">
    <input type="submit" name="validate" value="Validera">
</form>





<?php if ($ipToValidate) : ?>
    <h3>valideringsresultat: </h3>

    <p><b>Ipv4: </b>
    <?php if ($ipv4 == true) : ?>
        Validerar
    <?php else : ?>
        Validerar ej
    <?php endif; ?>
    </p>

    <p><b>Ipv6: </b>
    <?php if ($ipv6 == true) : ?>
        Validerar
    <?php else : ?>
        Validerar ej
    <?php endif; ?>
    </p>

    <?php if ($domainName) : ?>
        <p>Domännamn: <?= $domainName ?> </p>
    <?php else : ?>
        <p>Domännamn: inget domännamn funnet </p>
    <?php endif; ?>
<?php endif; ?>


