<?php
namespace SclNominetEpp\Request\Update\Field;

use SimpleXMLElement;

/**
 * UpdateDomain "add" and "remove" both use "status" as a field
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Status implements UpdateFieldInterface
{
    private $message;
    private $status;

    public function __construct($message, $status)
    {
        $this->message = $message;
        $this->status  = $status;
    }

    /**
     * function fieldXml allows dynamic child and attribute association with a SimpleXMLElement.
     * @param SimpleXMLElement $xml
     * @param type $namespace
     * 
     */
    public function fieldXml(SimpleXMLElement $xml, $namespace)
    {
        $status = $xml->addChild('status', $this->message, $namespace);
        $status->addAttribute('s', $this->status);
    }
}
