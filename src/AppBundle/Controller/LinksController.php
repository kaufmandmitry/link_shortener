<?php

namespace AppBundle\Controller;
use AppBundle\Controller\AdvancedControllers\ApiController;
use AppBundle\Entity\Link;
use AppBundle\Service\ShortLinkGenerator;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LinksController extends ApiController
{

    /**
     * Add link
     * @Route("/links", name="linksAdd")
     * @Method("POST")
     *
     * @return Response
     */
    public function linkAddAction(Request $request)
    {
        $requestDecoded = json_decode($request->getContent());
        if (!property_exists($requestDecoded, 'originalLink')) {
            throw new BadRequestHttpException('OriginalLink field was not found.');
        }

        /* @var ShortLinkGenerator $shortLinkGenerator */
        $shortLinkGenerator = $this->get('short_link_generator');

        $validator = $this->get('validator');

        $link = new Link();

        $link->setOriginalLink($requestDecoded->originalLink);
        $link->setShortLink($shortLinkGenerator->getNewShortVersionLink());

        $errors = $validator->validate($link);

        if (count($errors) > 0) {
            throw new BadRequestHttpException($errors[0]->getMessage());
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($link);
        $entityManager->flush();

        return $this->renderData([
            'originalLink' => $link->getOriginalLink(),
            'shortLink' => $this->generateUrl('redirectRoute',
                ['shortLink' => $link->getShortLink()],
                UrlGeneratorInterface::ABSOLUTE_URL)
        ]);
    }
}
