<?php

namespace Eva\EvaCommon\Controllers\Admin;

use Eva\EvaEngine\Mvc\Controller\AdminControllerBase as AdminControllerBase;
use Eva\EvaEngine\Mvc\Controller\SessionAuthorityControllerInterface;

/**
*/
class IndexController extends AdminControllerBase
{

    /**
    */
    public function indexAction()
    {
        $this->view->disable();

        return $this->response->redirect('/admin/login');
    }


}
