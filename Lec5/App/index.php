<?php

use App\Models\User as ModelsUser;
use App\Controllers\User as ControllersUser;

// require "Controllers/User.php";
// require "Models/User.php";


spl_autoload_register(function ($class) {
    echo $class;
    require $class . ".php"; 
});


$user = new ModelsUser();
echo "<br>";
echo "<br>";
$user = new ControllersUser();