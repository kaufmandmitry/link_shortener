<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Link
 *
 * @ORM\Table(name="link")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LinkRepository")
 * @UniqueEntity("originalLink")
 * @UniqueEntity("shortLink")
 */
class Link
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="originalLink", type="string", length=1024, unique=true)
     * @Assert\Url()
     */
    private $originalLink;

    /**
     * @var string
     *
     * @ORM\Column(name="shortLink", type="string", length=30, unique=true)
     */
    private $shortLink;
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set originalLink
     *
     * @param string $originalLink
     *
     * @return Link
     */
    public function setOriginalLink($originalLink)
    {
        $this->originalLink = $originalLink;

        return $this;
    }

    /**
     * Get originalLink
     *
     * @return string
     */
    public function getOriginalLink()
    {
        return $this->originalLink;
    }

    /**
     * Set shortLink
     *
     * @param string $shortLink
     *
     * @return Link
     */
    public function setShortLink($shortLink)
    {
        $this->shortLink = $shortLink;

        return $this;
    }

    /**
     * Get shortLink
     *
     * @return string
     */
    public function getShortLink()
    {
        return $this->shortLink;
    }
}

