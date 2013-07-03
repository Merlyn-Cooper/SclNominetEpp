<?php

namespace SclNominetEpp\Request\Update;

use SclNominetEpp\Response\Update\Domain as UpdateDomainResponse;
use SclNominetEpp\Domain as DomainObject;
use SclNominetEpp\Request\Update\Field\UpdateFieldInterface;

/**
 * This class build the XML for a Nominet EPP domain:update command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Domain extends AbstractUpdate
{
    const TYPE = 'domain'; //For possible Abstracting later
    const UPDATE_NAMESPACE = 'urn:ietf:params:xml:ns:domain-1.0';
    const UPDATE_EXTENSION_NAMESPACE = 'http://www.nominet.org.uk/epp/xml/domain-nom-ext-1.1';
    const VALUE_NAME = 'name';

    /**
     *
     * @var type
     */
    protected $domain = null;

    /**
     * Identifying value
     * @var type
     */
    protected $value;

    /**
     * An array of elements that will be added during the update command.
     *
     * @var array
     */
    private $add = array();

    /**
     * An array of elements that will be removed during the update command.
     *
     * @var array
     */
    private $remove = array();

    /**
     * Constructor
     *
     * @param string $value
     */
    public function __construct(DomainObject $domain)
    {
        parent::__construct(
                self::TYPE, 
                new UpdateDomainResponse(), 
                self::UPDATE_NAMESPACE, 
                self::VALUE_NAME, 
                self::UPDATE_EXTENSION_NAMESPACE
        );
        $this->domain = $domain;
    }

    /**
     * {@inheritDoc}
     *
     * @param \SimpleXMLElement $updateXML
     */
    public function addContent(\SimpleXMLElement $updateXML)
    {
        $domainNS    = self::UPDATE_NAMESPACE;
        $extensionNS = self::UPDATE_EXTENSION_NAMESPACE;

        $domainXSI    =    $domainNS . ' ' . 'domain-1.0.xsd';
        $extensionXSI = $extensionNS . ' ' . 'domain-nom-ext-1.1.xsd';

        $update = $updateXML->addChild('domain:update', '', $domainNS);
        $update->addAttribute('xsi:schemaLocation', $domainXSI);
        $update->addChild(self::VALUE_NAME, $this->domain, $domainNS);

        /**
         * 
         * 
         * 
         */

        if (!empty($this->change)) {
            $change = $update->addChild('chg');
            foreach ($this->change as $change) {
                
            }
                $change->addChild('registrant');
            $authInfo = $change->addChild('authInfo');
                $authInfo->addChild('pw');
        }

        $extensionXML = $this->xml->command->addChild('extension');
        $extension = $extensionXML->addChild('domain-nom-ext:update', '', $extensionNS);
            $extension->addAttribute('xsi:schemaLocation', $extensionXSI);

            $extension->addChild('first-bill');
            $extension->addChild('recur-bill');
            $extension->addChild('auto-bill');
            $extension->addChild('next-bill');
            $extension->addChild('notes');
        //@todo implement all variables, also, fix the extension data.

    }

    /**
     * Setter
     *
     * @param type $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }
       
    public function getName()
    {
        return $this->domain->getName();
    }

    protected function getObject()
    {
        
    }

    /**
     * An Exception is thrown if the object is not of type \SclNominetEpp\Domain
     *
     * @throws Exception
     */
    protected function objectValidate( $domain )
    {
        if (!$domain instanceof DomainObject) {
            $exception = sprintf('A valid contact object was not passed to UpdateDomain, Ln:%d', __LINE__);
            throw new Exception($exception);
        }
        return true;
    }
}
