<?php

namespace Common\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

abstract class AbstractController extends AbstractActionController
{

    protected $documentManager = null;

    public function __construct()
    {
        $class = get_called_class();
        $this->document = str_replace('\Controller\\', '\Model\\Document\\', $class);
        $this->form = str_replace('\Controller\\', '\Form\\', $class);
        $this->controller = trim(strtolower(preg_replace('@([A-Z])@', "-$1", explode('\\', $class)[2])), '-');
    }

    protected function getRepository($document = null)
    {
        if (null == $this->documentManager) {
            $this->documentManager = $this->getService('doctrine.documentmanager.odm_default');
        }
        if (null == $document) {
            $document = $this->document;
        } else {
            $document = strstr($document, '\\') === false ? "Diarias\\Model\\Document\\{$document}" : $document;
        }

        return $this->documentManager->getRepository($document);
    }

    protected function getService($service)
    {
        return $this->getServiceLocator()->get($service);
    }
}
