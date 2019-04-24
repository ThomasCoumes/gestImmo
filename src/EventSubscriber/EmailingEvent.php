<?php
/**
 * Created by PhpStorm.
 * User: thocou
 * Date: 24/04/19
 * Time: 15:08
 */

namespace App\EventSubscriber;

use App\Entity\RentRelease;
use Symfony\Component\EventDispatcher\Event;

class EmailingEvent extends Event
{
    /**
     * @var RentRelease
     */
    private $rentRelease;

    /**
     * EmailingEvent constructor.
     * @param RentRelease $rentRelease
     */
    public function __construct(RentRelease $rentRelease)
    {
        $this->rentRelease = $rentRelease;
    }

    /**
     * @return RentRelease
     */
    public function getRentRelease()
    {
        return $this->rentRelease;
    }
}
