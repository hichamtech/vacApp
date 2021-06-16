<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class CryptPasswordSubscriber
 * @package App\EventSubscriber
 */
class CryptPasswordSubscriber implements EventSubscriberInterface
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * CryptPasswordSubscriber constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['cryptPasswordOnPost'],
            BeforeEntityUpdatedEvent::class => ['cryptPasswordOnPut']
        ];    }

    /**
     * @param BeforeEntityPersistedEvent $event
     */
    public function cryptPasswordOnPost(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof User)) {
            return;
        }
        $entity->setPassword($this->passwordEncoder->encodePassword(
            $entity,
            $entity->getPassword()
        ));
    }

    /**
     * @param BeforeEntityUpdatedEvent $event
     */
    public function cryptPasswordOnPut(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof User)) {
            return;
        }
        $entity->setPassword($this->passwordEncoder->encodePassword(
            $entity,
            $entity->getPassword()
        ));
    }

}
