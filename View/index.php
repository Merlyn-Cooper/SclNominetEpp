<?php

use \SclNominetEpp\Nominet;
use \SclNominetEpp\Communicator;
use \SclSocket\Socket;

require_once(__DIR__ . "/../vendor/autoload.php");

$config = include __DIR__ . '/../bin/test_epp.config.php';

$communicator = new Communicator(new Socket);
$communicator->connect($config['live']);

$nominet = new Nominet();
$nominet->setCommunicator($communicator);

$nominet->login($config['username'], $config['password']);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <form action="" method="post">
        Domain:<input type="text" name="dname">
        <input type="submit" value="Submit">
        </form>
        <?php
        // put your code here
        ?>
    </body>
</html>
