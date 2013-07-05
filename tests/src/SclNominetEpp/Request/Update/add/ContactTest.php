<?php
namespace SclNominetEpp\Request\Update;

use SclNominetEpp\Address;

use SclContact\Fax;
use SclContact\Country;
use SclContact\Postcode;
use SclContact\PhoneNumber;
use SclContact\PersonName;
use SclContact\Email;
use SclNominetEpp\Request\Update\Contact as UpdateContact;

class ContactTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $contact = new \SclNominetEpp\Contact();
        $contact->setId('sc2343');

            $personName = new PersonName;
            $personName->setFirstName('first');
            $personName->setLastName('last');
        $contact->setName($personName);

            $email = new Email();
            $email->set('example@email.com');
        $contact->setEmail($email);

        /*
        * The contact address.
        * which comprises of the (Line1, city, cc, Line2, sp, pc);
        *
        */
        $address = new Address();
        $address->setLine1('Bryn Seion Chapel');
        $address->setCity('Cardigan');

            $country = new Country();
            $country->setCode('US');
        $address->setCountry($country);

        $address->setCounty('Ceredigion');

            $postCode = new Postcode();
            $postCode->set('SA43 2HB');
        $address->setPostCode($postCode);
        $contact->setAddress($address);

        $contact->setCompanyNumber('NI65786');

            $phoneNumber = new PhoneNumber();
            $phoneNumber->set('+44.3344555666');
        // The registered company number or the DfES UK school number of the registrant.
        $contact->setPhone($phoneNumber);
        $contact->setCompany('sclMerlyn');
        $this->request = new UpdateContact($contact);
    }
    
    /**
     *
     */
    public function testUpdateContact()
    {
        $xml = <<<EOX
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="urn:ietf:params:xml:ns:epp-1.0" xsi:schemaLocation="urn:ietf:params:xml:ns:epp-1.0 epp-1.0.xsd">
  <command>
    <update>
      <contact:update
       xmlns:contact="urn:ietf:params:xml:ns:contact-1.0">
        <contact:id>sc2343</contact:id>
        <contact:add>
          <contact:status s="ok"/>
        </contact:add>
      </contact:update>
    </update>
    <clTRID>ABC-12345</clTRID>
  </command>
</epp>
               
EOX;
        $expected = new \SclNominetEpp\Contact;

        $expected->setId('sc2343');
        $expected->addStatus('ok');

        $this->response->init($xml);

        $contact = $this->response->getContact();

        $this->assertEquals($expected, $contact);
    }
}
