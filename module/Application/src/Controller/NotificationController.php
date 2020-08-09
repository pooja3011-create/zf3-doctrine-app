<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Application\Entity\Notify;
use Application\Entity\Subscribers;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;


class NotificationController extends AbstractActionController {

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var MailSender
     */
    private $mailSender;

    /**
     * @var PhpRenderer
     */
    private $render;

    /**
     * @var TemplateMapResolver
     */
    private $templateResolver;
    
    /**
     * @var FlashMessenger
     */
    private $flashMessenger;

    public function __construct(
            $entityManager,
            $mailSender,
            $render,
            $templateResolver,
            $flashMessenger
    ) {
        $this->entityManager = $entityManager;
        $this->mailSender = $mailSender;
        $this->render = $render;
        $this->templateResolver = $templateResolver;
        $this->flashMessenger = $flashMessenger;
    }

    public function SubscriberAction() {
        $subscribers = new Subscribers();
        $viewModel = new ViewModel();
        if (!empty($_POST)) {

            $email = filter_input(INPUT_POST, 'email');
            if (!empty($email)) {
                $subscribers->setEmail($email);
                $subscribers->setDateCreated(new \DateTime());
		 try {
                    $this->entityManager->persist($subscribers);
                    $this->entityManager->flush();
                 } catch (UniqueConstraintViolationException $e) {
                    $this->flashMessenger->addMessage('This email address has already subscribed !', FlashMessenger::NAMESPACE_ERROR, 100);
                    return $this->redirect()->toRoute('home');
                }
                $this->templateResolver->setMap(array(
                    'mailTemplate' => __DIR__ . '/../../view/application/email/subscriber.phtml'
                ));


                $this->render->setResolver($this->templateResolver);
                $viewModel->setTemplate('mailTemplate')
                        ->setVariables(array(
                            'email' => $email,
                ));

                $subject = 'New subscription';
                $bodyPart = new \Zend\Mime\Message();
                $bodyMessage = new \Zend\Mime\Part($this->render->render($viewModel));
                $bodyMessage->type = 'text/html';
                $bodyPart->setParts(array($bodyMessage));
                /* send email to subscriber */
                if (!$this->mailSender->sendMail(
                                'dummy6743@gmail.com',
                                $email,
                                $subject,
                                $bodyPart
                        )
                ) 
                {
                    $this->flashMessenger->addMessage('Emai sent not successfully !', FlashMessenger::NAMESPACE_ERROR, 100);
                    return $this->redirect()->toRoute('home');
                }

                $this->flashMessenger->addMessage('Email sent successfully !', FlashMessenger::NAMESPACE_SUCCESS, 100);
                return $this->redirect()->toRoute('home');
            }
        }
        return new ViewModel;
    }

    public function NotifyAction() 
    {
        $notify = new Notify();
        $viewModel = new ViewModel();
        $subject = 'Inpera Notification';
        $subscribersData = $this->entityManager->getRepository(Subscribers::class)->findAll();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $message = filter_input(INPUT_POST, 'message');

            if (!empty($message)) {
                $notify->setMessage($message);
                $notify->setSubject($subject);
                $notify->setDateCreated(new \DateTime());
                $this->entityManager->persist($notify);
                $this->entityManager->flush();

                $this->templateResolver->setMap(array(
                    'mailTemplate' => __DIR__ . '/../../view/application/email/notify.phtml'
                ));

                $this->render->setResolver($this->templateResolver);
                $viewModel->setTemplate('mailTemplate')->setVariables(array(
                    'message' => $message,
                ));

                $bodyPart = new \Zend\Mime\Message();
                $bodyMessage = new \Zend\Mime\Part($this->render->render($viewModel));
                $bodyMessage->type = 'text/html';
                $bodyPart->setParts(array($bodyMessage));
                $body = $bodyPart;
                $EmailStatus = "";
                /* send notification to all subscribers.. */
                foreach ($subscribersData as $subscriber) {
                    $subscriberEmail = $subscriber->getEmail();
                    $status = $this->mailSender->sendMail(
                            'dummy6743@gmail.com',
                            $subscriberEmail,
                            $subject,
                            $bodyPart
                    );
                    $EmailStatus = $status;
                }
                if ($EmailStatus == 1) {
                    $this->flashMessenger->addMessage('Email sent successfully !', FlashMessenger::NAMESPACE_SUCCESS, 100);
                    return $this->redirect()->toRoute('home');
                } else {
                    $this->flashMessenger->addMessage('Email sent not successfully !', FlashMessenger::NAMESPACE_ERROR, 100);
                    return $this->redirect()->toRoute('home');
                }
            }
        }
        return $viewModel->setTemplate(
                        'application/notification/subscriber'
        );
    }
}
