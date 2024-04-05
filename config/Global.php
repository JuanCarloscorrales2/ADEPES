<?php
    if (!defined("SITE_URL")) {
        define("SITE_URL", "http://localhost/ADEPES/");
    }
    if (!defined("SERVIDOR")) {
        define("SERVIDOR", "localhost");
    }
    if (!defined("DATABASE")) {
        define("DATABASE", "SistemaWebADEPES");
    }
    if (!defined("USERNAME")) {
        define("USERNAME", "root");
    }
    if (!defined("PASSWORD")) {
        define("PASSWORD", "");
    }
    if (!defined("DSN")) {
        define("DSN", "mysql:host=".SERVIDOR.";dbname=".DATABASE);
    }
    
    


?>