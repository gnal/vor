<?php

namespace Vor\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('VorCoreBundle:Home:index.html.twig');
    }
}
