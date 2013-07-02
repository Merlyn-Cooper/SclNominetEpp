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
$domainObject = $nominet->domainInfo($_REQUEST['dname']);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <form action="" method="post">
            <label>Domain Name :</label>
            <input type="text" name="dname">
            <label>Registrant :</label>
            <input type="text" name="registrant">
            <label>Client Id :</label>
            <input type="text" name="clientId">
            <label>Created Date :</label>
            <input type="text" name="createdDate">
            <label>Expired Date :</label>
            <input type="text" name="expiredDate">
            <label>Last Update Client Id :</label>
            <input type="text" name="lastUpdateClientId">
            <label>Last Update Date :</label>
            <input type="text" name="lastUpdateDate">
            <label>First Bill Setting :</label>
            <input type="text" name="firstBill">
            <label>Recur Bill Setting :</label>
            <input type="text" name="recurBill">
            <?php if (((empty($domainObject->recurBill))||(empty($domainObject->nextBill)))&&(!empty($domainObject->autoBill))) :?>
            	<label>Auto Bill Setting :</label>
            	<input type="text" name="autoBill">
            <?php endif; ?>
            <?php if (((empty($domainObject->recurBill))||(empty($domainObject->autoBill)))&&(!empty($domainObject->nextBill))) :?>
            	<label>Next Bill Setting :</label>
            	<input type="text" name="nextBill">
            <?php endif; ?>
            <input type="submit" value="Submit">
        </form>
        <?php
        // put your code here
        ?>
    </body>
</html>
