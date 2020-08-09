<?php

namespace Application\Controller\Factory;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Application\Service\MailSender;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Controller\NotificationController;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver\TemplateMapResolver;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;

class NotificationControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $em = $container->get(EntityManager::class);
        $mailSender = $container->get(MailSender::class);
        $render = $container->get(PhpRenderer::class);
        $templateResolver = $container->get(TemplateMapResolver::class);
        $flashMessenger = $container->get(FlashMessenger::class);

        return new NotificationController($em,$mailSender,$render,$templateResolver,$flashMessenger);
    }
}
