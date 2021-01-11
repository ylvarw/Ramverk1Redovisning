<?php

namespace Anax\View;

/**
 * render ip validation with json
 */
// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?>
<h1>validera ip adresser</h1>
<br>
<h3>Validera en IP-adress med JSON </h3>

<form method="post">
    ip: <input type="text" name="ip">
    <input type="submit" name="doValidate" value="Validera">
</form>

<p> <?= json_encode($json) ?> </p>
