<?php

namespace Anax\View;

/**
 * render ip validation with json
 */
// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?>
<h1>hitta en plats med IP</h1>
<br>

<form method="post">
    ip: <input type="text" name="ip">
    <input type="submit" name="doValidate" value="Hitta plats">
</form>

<p> <?= json_encode($json) ?> </p>
