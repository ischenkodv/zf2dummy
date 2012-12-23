<?php
namespace BlogAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\EventManager\EventManagerInterface;

class BaseAdminController extends AbstractActionController
{
    public function setEventManager(EventManagerInterface $events)
    {
        parent::setEventManager($events);

        $controller = $this;
        $events->attach('dispatch', function ($e) use ($controller) {
            if (is_callable(array($controller, 'checkIdentity'))) {
                call_user_func(array($controller, 'checkIdentity'));
            }
        }, 100);
    }


    public function checkIdentity()
    {
        $user = $this->_getCurrentUser();
        if (!$user) {
            return $this->redirect()->toRoute('zfcuser/login');
        }
    }

    private function _getCurrentUser()
    {
        $authService = $this->getServiceLocator()->get('zfcuser_auth_service');
        $currentUser = $authService->getIdentity();

        return $currentUser;
    }
}
