<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
// echo showEnvironment(get_defined_vars(), get_defined_functions());

?>

<h1>validera ip adresser</h1>

<form method="post">
    ip: <input type="text" name="ip">
    <input type="submit" name="validate" value="Validera">
</form>


<p>valideringsresultat: </p>
<!-- <?= $ipv4 ?> -->
<!-- <?= $ipv6 ?> -->


<?php if ($domain) : ?>
    <p>Domännamn: <?= $domain ?> </p>
<?php else : ?>
    <p>Domännamn: inget domännamn funnet </p>
<?php endif; ?>