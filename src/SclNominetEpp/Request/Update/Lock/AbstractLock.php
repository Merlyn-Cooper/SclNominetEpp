<?php

namespace SclNominetEpp\Request\Update\Lock;

use SclNominetEpp\Request;

/**
 * 
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
abstract class AbstractLock extends Request
{
    /**
     * The domain name.
     *
     * @var string
     */
    protected $contactId;

    /**
     * The expiry date.
     *
     * @var string
     */
    protected $domainName;

    /**
     * Either a "contact" or a "domain"
     *
     * @var string 
     */
    protected $object;
    
    /**
     * Either "investigation" or "opt-out"
     * 
     * @var string 
     */
    protected $type;
    
    /**
     * Initialises the object string, and type string. 
     * Feeds the expected response to the request class.
     * 
     * @param string $object
     * @param string $type
     * @param object $response
     */
    public function __construct($object, $type, $response = null)
    {
        parent::__construct('update', $response);
        $this->object = $object;
        $this->type   = $type;
        
    }

    /**
     * Set the contact id
     * 
     * @param string $contactId
     * @return AbstractLock
     */
    public function setContactId($contactId)
    {
        $this->contactId = (string)$contactId;

        return $this;
    }
    
    /**
     * Set the domain name
     * 
     * @param string $domainName
     * @return AbstractLock
     */
    public function setDomainName($domainName)
    {
        $this->domainName = $domainName;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see SclNominetEpp\Request.AbstractRequest::addContent()
     */
    protected function addContent(\SimpleXMLElement $xml)
    {
        $lockNS  = 'http://www.nominet.org.uk/epp/xml/std-locks-1.0';
        $lockXSI = $lockNS . ' std-locks-1.0.xsd';

        //$domainNS  = 'urn:ietf:params:xml:ns:domain-1.0';
        //$domainXSI = 'urn:ietf:params:xml:ns:domain-1.0 domain-1.0.xsd';

        $lock = $xml->addChild('l:lock', '', $lockNS);
        $lock->addAttribute('xsi:schemaLocation', $lockXSI, $lockNS);
        $lock->addAttribute('object', $this->object);   //Can be contact or domain
        $lock->addAttribute('type', $this->type); //Can be opt-out or investigate
        
        $lock->addChild('contactId', $this->contactId);
        $lock->addChild('domainName', $this->domainName);
    }
}
