<?php

namespace Eva\EvaCommon\Controllers\Admin;

use Eva\EvaEngine\Mvc\Controller\AdminControllerBase as AdminControllerBase;
use Eva\EvaEngine\Mvc\Controller\SessionAuthorityControllerInterface;

/**
* @resourceName("Admin Dashboard")
* @resourceDescription("Admin Dashboard")
*/
class DashboardController extends AdminControllerBase implements SessionAuthorityControllerInterface
{

    /**
    * @operationName("Admin Dashboard")
    * @operationDescription("Admin Dashboard")
    */
    public function indexAction()
    {
        $this->view->setModuleLayout('EvaCommon', '/views/admin/layouts/layout');
        $this->view->setModuleViewsDir('EvaCommon', '/views');
        $this->view->setModulePartialsDir('EvaCommon', '/views');
    }
}
