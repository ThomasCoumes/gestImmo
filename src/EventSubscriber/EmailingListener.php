<?php
/**
 * Created by PhpStorm.
 * User: thocou
 * Date: 24/04/19
 * Time: 15:11
 */

namespace App\EventSubscriber;

use App\Events;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Filesystem\Filesystem;

class EmailingListener implements EventSubscriberInterface
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var ParameterBagInterface
     */
    private $bag;

    /**
     * EmailingListener constructor.
     * @param ObjectManager $manager
     * @param ParameterBagInterface $bag
     */
    public function __construct(ObjectManager $manager, ParameterBagInterface $bag)
    {
        $this->manager = $manager;
        $this->bag = $bag;
    }

    /**
     * @param EmailingEvent $emailingEvent
     */
    public function onEmailSent(EmailingEvent $emailingEvent)
    {
        $filesystem = new Filesystem();

        $rentRelease = $emailingEvent->getRentRelease();

        $pdfFile = $rentRelease->getPdf();
        $filesystem->remove("generated/pdf/$pdfFile");

        $rentRelease->setPdf(null);
        $this->manager->persist($rentRelease);
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents(): array
    {
        return [
          Events::EMAIL_SENT => 'onEmailSent',
        ];
    }
}
