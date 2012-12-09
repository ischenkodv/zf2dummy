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

    public function indexAction()
    {
        return new ViewModel(array(
            'posts' => $this->getEntityManager()->getRepository('Blog\Entity\Post')->findAll() 
        ));
    }

    public function addAction()
    {
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }

    /*public function setPostTable(PostTable $postTable)
    {
        $this->postTable = $postTable;
        return $this;
    }

    public function getPostTable()
    {
        if (!$this->postTable) {
            $sm = $this->getServiceLocator();
            $this->postTable = $sm->get('post-table');
        }
        return $this->postTable;
    }*/
}
