<?php

namespace App\EventSubscriber;

use App\Event\AfterDtoCreatedEvent;
use App\Service\ServiceException;
use App\Service\ServiceExceptionData;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DtoSubscriber implements EventSubscriberInterface
{
    public function __construct(protected ValidatorInterface $validator)
    {
    }

    public function validateDto(AfterDtoCreatedEvent $event): void
    {
       $dto = $event->getDto();
       $errors = $this->validator->validate($dto);

       if (count($errors)){
           $validationExceptionData = new ServiceExceptionData(422, 'ViolationList', $errors);
           throw new ServiceException($validationExceptionData);
       }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AfterDtoCreatedEvent::NAME => [
                ['validateDto', 100],
                ['doSomethingElse', 1],
            ]

        ];
    }

    public function doSomethingElse()
    {
        
    }
}
