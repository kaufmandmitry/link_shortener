<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Link;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/go/{shortLink}", name="redirectRoute")
     */
    public function redirectAction($shortLink)
    {
        /* @var Link $link */
        $link = $this->getDoctrine()->getRepository(Link::class)->findOneBy(['shortLink' => $shortLink]);
        if (!$link) {
            throw new NotFoundHttpException();
        }

        return $this->redirect($link->getOriginalLink());
    }
}
