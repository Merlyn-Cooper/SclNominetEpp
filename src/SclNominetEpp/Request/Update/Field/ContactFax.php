<?php
namespace SclNominetEpp\Request\Update\Field;

/**
 * UpdateContact "chg" uses "fax" as a field
 *
 * @author merlyn
 */
class ContactFax implements UpdateFieldInterface
{
    /**
     *
     * @var type
     */
    private $fax;
    
    /**
     * 
     * @param type $voice
     */
    public function __construct($fax)
    {
        $this->fax     = $fax;
    }
    
    /**
     * 
     * 
     * @param \SimpleXMLElement $xml
     * @param type $namespace
     */
    public function fieldXml(\SimpleXMLElement $xml, $namespace)
    {
        $xml->addChild('fax', $this->fax, $namespace);

    }
    /**
     *          
             <contact:authInfo>
               <contact:pw>2fooBAR</contact:pw>
             </contact:authInfo>
             <contact:disclose flag="1">
               <contact:voice/>
               <contact:email/>
             </contact:disclose>
     */
}
