
<?php
// Iniciar o reanudar la sesión
session_start();

session_destroy();
session_unset();

header("Location: ../../index.php")

?>


