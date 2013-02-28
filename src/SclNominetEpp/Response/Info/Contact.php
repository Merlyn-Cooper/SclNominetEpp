<?php

namespace SclNominetEpp\Response\Info;

use SimpleXMLElement;
use SclNominetEpp\Contact as ContactObject;
use SclNominetEpp\Address;

/**
 * This class interprets XML for a Nominet EPP contact:info command response.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Contact extends AbstractInfo
{
    const TYPE = 'contact';
    const VALUE_NAME = 'id';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(
            self::TYPE,
            new ContactObject(),
            self::VALUE_NAME
        );
    }

    /**
     *
     * @param \SclNominetEpp\Response\Info\SimpleXMLElement $infData
     */
    public function addInfData(SimpleXMLElement $infData)
    {
        $postalInfo = $infData->postalInfo;
        $addrXml    = $postalInfo->addr;

        //toString ADDRESS XML
        $streets = $addrXml->street;

        //ADDRESS SETTING
        $address = new Address();
        $address->setLine1($streets[0]);
        $address->setLine2($streets[1]);
        $address->setLine3($streets[2]);
        $address->setCity($addrXml->city);
        $address->setCountry($addrXml->cc);
        $address->setCounty($addrXml->sp);
        $address->setPostCode($addrXml->pc);

        //NORMAL DATA
        $this->contact->setEmail($infData->email);
        $this->contact->setFax($infData->fax);
        $this->contact->setPhone($infData->voice); //optional
        //
            //Postal Info
        $this->contact->setName($postalInfo->name); //Postal Info
        $this->contact->setCompany($postalInfo->org);
        $this->contact->setAddress($address);         //Postal Info
    }
    /**
     *
     * @param SimpleXMLElement $extension
     */
    protected function addExtensionData(SimpleXMLElement $extension)
    {
        //EXTENSION DATA

        $this->contact->setCompanyNumber($extension->{'co-no'});
        $optOut     = strtolower((string) $extension->{'opt-out'});
        if ('n' === $optOut) {
            $optOut = false;
        } else {
            $optOut = true;
        }
        $this->contact->setOptOut($optOut);
        $this->contact->setTradeName($extension->{'trad-name'});
        $this->contact->setType($extension->{'type'});
    }

    /**
     *
     * @param SimpleXMLElement $id
     */
    protected function setValue(SimpleXMLElement $id)
    {
        $this->contact->setId((string)$id);
    }

    /**
     *
     * @return type
     */
    public function getContact()
    {
        return $this->contact;
    }
}
