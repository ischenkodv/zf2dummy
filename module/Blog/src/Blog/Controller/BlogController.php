<?php
namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\EventManager\EventManagerInterface;
use Doctrine\ORM\EntityManager;

class BlogController extends AbstractActionController
{
    /**             
     * @var Doctrine\ORM\EntityManager
     */                
    protected $em;

    public function __construct()
    {
    }
 
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    public function setEventManager(EventManagerInterface $events)
    {
        parent::setEventManager($events);

        $controller = $this;
        $events->attach('dispatch', function ($e) use ($controller) {
            if (is_callable(array($controller, 'init'))) {
                call_user_func(array($controller, 'init'));
            }
        }, 100);
    }


    public function init()
    {
    }

    private function _getCurrentUser()
    {
        $authService = $this->getServiceLocator()->get('zfcuser_auth_service');
        $currentUser = $authService->getIdentity();

        return $currentUser;
    }

    public function indexAction()
    {
        return new ViewModel(array(
            'posts' => $this->getEntityManager()->getRepository('Blog\Entity\Post')->findAll(),
            'user'  => $this->_getCurrentUser()
        ));
    }

}
