<?php
namespace BlogAdmin\Controller;

use Zend\View\Model\ViewModel;
use Zend\EventManager\EventManagerInterface;
use Doctrine\ORM\EntityManager;
use BlogAdmin\Controller\BaseAdminController;

class IndexController extends BaseAdminController
{

    public function indexAction()
    {
        return new ViewModel(array());
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
}
