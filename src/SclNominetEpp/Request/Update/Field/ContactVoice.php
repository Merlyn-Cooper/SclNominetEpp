<?php
namespace SclNominetEpp\Request\Update\Field;

/**
 * UpdateContact "chg" uses "voice" as a field
 *
 * @author merlyn
 */
class ContactVoice implements UpdateFieldInterface
{
    /**
     *
     * @var type
     */
    private $voice;
    
    /**
     * 
     * @param type $voice
     */
    public function __construct($voice)
    {
        $this->voice     = $voice;
    }
    
    /**
     * 
     * 
     * @param \SimpleXMLElement $xml
     * @param type $namespace
     */
    public function fieldXml(\SimpleXMLElement $xml, $namespace)
    {
        $xml->addChild('voice', $this->voice, $namespace);

    }
}

?>
