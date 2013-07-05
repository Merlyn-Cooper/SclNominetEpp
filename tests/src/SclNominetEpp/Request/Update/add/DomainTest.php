<?php
namespace SclNominetEpp\Request\Update;

use SclNominetEpp\Nameserver;
use DateTime;
use SclNominetEpp\Request\Update\Domain as UpdateDomain;

class DomainTest extends \PHPUnit_Framework_TestCase
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
        $this->request = new UpdateDomain();
        $this->request->add();
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
      <domain:update
       xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
        <domain:name>example.com</domain:name>
        <domain:add>
          <domain:ns>
            <domain:hostObj>ns2.example.com</domain:hostObj>
          </domain:ns>
          <domain:contact type="tech">mak21</domain:contact>
          <domain:status s="clientHold"
           lang="en">Payment overdue.</domain:status>
        </domain:add>
        <domain:rem>
          <domain:ns>
            <domain:hostObj>ns1.example.com</domain:hostObj>
          </domain:ns>
          <domain:contact type="tech">sh8013</domain:contact>
          <domain:status s="clientUpdateProhibited"/>
        </domain:rem>
        <domain:chg>
          <domain:registrant>sh8013</domain:registrant>
          <domain:authInfo>
            <domain:pw>2BARfoo</domain:pw>
          </domain:authInfo>
        </domain:chg>
      </domain:update>
    </update>
    <clTRID>ABC-12345</clTRID>
  </command>
</epp>
               
EOX;
        $domain = new \SclNominetEpp\Domain;

        $domain->setName('example.com');
        $domain->addStatus('clientHold');

        $domain->setName('caliban-scl.sch.uk');
        $domain->setRegistrant('559D2DD4B2862E89');
        $domain->setClientID('SCL');
        $domain->setCreatorID('psamathe@nominet');
        $domain->setCreated(new DateTime('2013-01-31T00:11:05'));
        $domain->setExpired(new DateTime('2015-01-31T00:11:05'));
        $domain->setUpID('');
        $domain->setUpDate(new DateTime(''));
        $domain->setFirstBill('th');
        $domain->setRecurBill('th');
        $domain->setAutoBill('');
        $domain->setNextBill('');
        $domain->setRegStatus('Registered until expiry date.');
        $nameserver = new Nameserver();
        $nameserver->setHostName('ns1.caliban-scl.sch.uk.');
        $domain->addNameserver($nameserver);
        $this->request->setDomain($domain);

        $this->assertEquals($xml, $this->request->getPacket());
    }
}