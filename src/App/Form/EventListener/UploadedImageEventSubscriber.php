<?php

declare(strict_types=1);

namespace App\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvents;

class UploadedImageEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [FormEvents::SUBMIT   => 'onSubmit'];
    }

    public function onSubmit(SubmitEvent $event): void
    {
        $data = $event->getData();

        if (null === $data['image_upload'] && null === $data['image']) {
            $event->getForm()->get('image_upload')->addError(
                new FormError('Zdjęcie jest wymagane.')
            );
        }
    }
}
