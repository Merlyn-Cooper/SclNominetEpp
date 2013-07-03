<?php

namespace SclNominetEpp;

/**
 * Nominet Class for a postal address using postalInfo
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Address extends \SclContact\Address
{
    protected $type;

    public function setLines(array $lines)
    {
        if (count($lines) === 3) {
            $this->setLine1($lines[0] . ', ' . $lines[1]);
            $this->setLine2($lines[2]);
        }

        $this->setLine1($lines[0]);

        if (isset($lines[1])) {
            $this->setLine2($lines[1]);
        }
    }

    /**
     * @todo swap all references of state/province to county
     * KEEP FOR REFERENCE!
     */

    /**
     * @todo swap all references of countryCode to country
     * KEEP FOR REFERENCE!
     */
}
