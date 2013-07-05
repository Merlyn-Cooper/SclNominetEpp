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
//$_REQUEST['dname']
$domainObject = $nominet->domainInfo('caliban-scl.sch.uk');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <form action="index.php" method="post">
            <?php if (null != $domainObject->getName()) :?>
                <label>Domain Name :</label>
                <input type="text" name="domainName" value="<?php echo $domainObject->getName()?>"><br />
            <?php endif; ?>
            <?php if (null != $domainObject->getRegistrant()) :?>
                <label>Registrant :</label>
                <input type="text" name="registrant" value="<?php echo $domainObject->getRegistrant()?>"><br />
            <?php endif;?>
            <?php if (null != $domainObject->getClientID()) :?>
                <label>Client Id :</label>
                <input type="text" name="clientId" value="<?php echo $domainObject->getClientID()?>"><br />
            <?php endif;?>
                
                
            <?php if (null != $domainObject->getCreated()) :?>
                <label>Created Date :</label>
                <input type="text" name="createdDate" value="<?php echo $domainObject->getCreated()->format('Y-m-d H:i:s')?>"><br />
            <?php endif;?>
            <?php if (null != $domainObject->getExpired()) : ?>
                <label>Expired Date :</label>
                <input type="text" name="expiredDate" value="<?php echo $domainObject->getExpired()->format('Y-m-d H:i:s')?>"><br />
            <?php endif; ?>
                
                
            <?php if (null != $domainObject->getClientID()) :?>
                <label>Last Update Client Id :</label>
                <input type="text" name="lastUpdateClientId" value="<?php echo $domainObject->getClientID()?>"><br />
            <?php endif; ?>
            <?php if (null != $domainObject->getUpDate()) : ?>
                <label>Last Update Date :</label>
                <input type="text" name="lastUpdateDate" value="<?php echo $domainObject->getUpDate()->format('Y-m-d H:i:s') ?>"><br />
            <?php endif; ?>
                
            <?php if (null != $domainObject->getFirstBill()) :?>
                <label>First Bill Setting :</label>
                <input type="text" name="firstBill" value="<?php echo $domainObject->getFirstBill() ?>"> <br />
            <?php endif; ?>
            <?php if (null != $domainObject->getRecurBill()) :?>
                <label>Recur Bill Setting :</label>
                <input type="text" name="recurBill" value="<?php echo $domainObject->getRecurBill() ?>"><br />
            <?php endif;?>
                <p>"th" bill the registrar, "bc" bill the customer.</p>
            <?php 
                $contacts = $domainObject->getContacts();
                if (!empty($contacts)) :
                    ?><label>Contacts</label><br /><?php
                    foreach ($contacts as $contact) :
                    ?>
                        <label>Contact Id </label> 
                        <input type="text" value="<?php echo $contact->getId();?>"><br />
                        <label>Contact Type</label>
                        <input type="text" value="<?php echo $contact->getType();?>"><br />
                    <?
                    endforeach;
                endif; 
                
                $nameservers = $domainObject->getNameservers();
                if (!empty($nameservers)) :
                    ?><br /><label>Nameservers</label><br /><?php
                    foreach ($nameservers as $nameserver) :
                    ?>
                        <label>Nameserver name</label>
                        <input type="text" value="<?php echo $nameserver->getHostName();?>"><br />
                    <?
                    endforeach;
                endif; 
            
                $statuses = $domainObject->getStatuses();
                if (!empty($statuses)) :
                    foreach ($statuses as $status) :
                    ?>
                        
                    <?
                    endforeach;
                endif; 
            ?>   
            <?php if (((null == $domainObject->getRecurBill())||(null == $domainObject->getNextBill()))&&(null != $domainObject->getAutoBill())) :?>
            	<label>Auto Bill Setting :</label>
            	<input type="text" name="autoBill" value="<?php echo $domainObject->getNextBill()?>"><br />
            <?php endif; ?>
            <?php if (((null == $domainObject->getRecurBill())||(null == $domainObject->getAutoBill()))&&(null != $domainObject->getNextBill())) :?>
            	<label>Next Bill Setting :</label>
                <input type="text" name="nextBill" value="<?php echo $domainObject->getAutoBill() ?>"><br />
            <?php endif; ?>
            <input type="submit" value="Submit">
        </form>
    </body>
</html>
