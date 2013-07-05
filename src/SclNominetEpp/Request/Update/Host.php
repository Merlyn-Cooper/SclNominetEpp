<?php

namespace SclNominetEpp\Request\Update;

use SclNominetEpp\Response\Update\Host as UpdateHostResponse;
use SclNominetEpp\Nameserver;
use SclNominetEpp\Request\Update\Field\UpdateFieldInterface;

/**
 * This class build the XML for a Nominet EPP contact:update command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Host extends AbstractUpdate
{
    const TYPE = 'host'; //For possible Abstracting later
    const UPDATE_NAMESPACE = 'urn:ietf:params:xml:ns:host-1.0';

    const VALUE_NAME = 'name';

    protected $host = null;
    protected $value;

    public function __construct(Nameserver $host)
    {
        parent::__construct(
            self::TYPE,
            new UpdateHostResponse(),
            self::UPDATE_NAMESPACE,
            self::VALUE_NAME
        );
        $this->host = $host;
    }

    /**
     * {@inheritDoc}
     *
     * @param \SimpleXMLElement $updateXML
     */
    public function addContent(\SimpleXMLElement $updateXML)
    {
        $hostNS  = self::UPDATE_NAMESPACE;

        $hostXSI = $hostNS . ' ' . 'host-1.0.xsd';

        $update = $updateXML->addChild('host:update', '', $hostNS);
        $update->addAttribute('xsi:schemaLocation', $hostXSI);
        $update->addChild(self::VALUE_NAME, $this->value, $hostNS);

        if (!empty($this->change)) {

        }

    }

    public function setHost($host)
    {
        $this->host = $host;
    }

    public function getName()
    {
        return $this->host->getHostName();
    }

    /**
     * An Exception is thrown if the object is not of type \SclNominetEpp\Nameserver
     *
     * @throws Exception
     */
    protected function objectValidate($host)
    {
        if (!$host instanceof Nameserver) {
            $exception = sprintf('A valid contact object was not passed to UpdateHost, Ln:%d', __LINE__);
            throw new Exception($exception);
        }
        return true;
    }
}
