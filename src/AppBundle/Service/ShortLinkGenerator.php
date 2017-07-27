<?php
namespace AppBundle\Service;

use AppBundle\Entity\Link;
use AppBundle\Repository\LinkRepository;
use Doctrine\ORM\EntityManager;

class ShortLinkGenerator
{
    /* @var EntityManager $entityManager */
    private $entityManager;

    private $lengthShortLink;

    private $allowedSymbols;

    public function __construct($entityManager, $lengthShortLink)
    {
        $this->entityManager = $entityManager;
        $this->lengthShortLink = $lengthShortLink;
        $this->allowedSymbols = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9));
    }

    public function getNewShortVersionLink()
    {
        $linkRepository = $this->entityManager->getRepository(Link::class);

        do {
            $newShortLink = '';
            for ($i = 0; $i < $this->lengthShortLink; $i++) {
                $newShortLink .= $this->allowedSymbols[random_int(0, count($this->allowedSymbols) - 1)];
            }
        } while ($linkRepository->findOneBy(['shortLink' => $newShortLink]));

        return $newShortLink;
    }
}