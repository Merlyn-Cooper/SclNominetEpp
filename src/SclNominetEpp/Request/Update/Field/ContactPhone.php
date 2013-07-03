<?php
namespace SclNominetEpp\Request\Update\Field;

/**
 * UpdateContact "chg" uses "voice" as a field
 *
 * @author merlyn
 */
class ContactPhone implements UpdateFieldInterface
{
    /**
     *
     * @var type
     */
    private $phone;
    
    /**
     * 
     * @param type $voice
     */
    public function __construct($voice)
    {
        $this->phone     = $phone;
    }
    
    /**
     * 
     * 
     * @param \SimpleXMLElement $xml
     * @param type $namespace
     */
    public function fieldXml(\SimpleXMLElement $xml, $namespace)
    {
        $xml->addChild('voice', $this->phone, $namespace);

    }
}
