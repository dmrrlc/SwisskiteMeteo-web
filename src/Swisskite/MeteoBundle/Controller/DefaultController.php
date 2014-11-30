<?php

namespace Swisskite\MeteoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SwisskiteMeteoBundle:Default:index.html.twig');
    }
}
