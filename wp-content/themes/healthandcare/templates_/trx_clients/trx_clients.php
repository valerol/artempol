<?php
// Autoload layouts in this folder
$name = pathinfo(__FILE__);
healthandcare_autoload_folder( 'templates/'.trim($name['filename']) );
?>