<?php

namespace ArticleBundle\Entity;

use ArticleBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use ArticleBundle\Entity\ArticleLike;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="ArticleBundle\Repository\ArticleRepository")
 */
class Article
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
     * @ORM\Column(name="titre", type="string", length=255)
     
     */
    private $titre;

    /**
     * @var string
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;
    
     /**
     * @var User
     * 
     * @ORM\ManyToOne(targetEntity="User")
     *  @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    private $author;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     *
     * @ORM\OneToMany(targetEntity="ArticleLike",mappedBy="article")
     */
    private $likes;



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
     * Set titre
     *
     * @param string $titre
     *
     * @return Article
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Article
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Article
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * Set author
     *
     * @param User $author
     */
    public function setUser($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return User
     */
    public function getUser()
    {
        return $this->author;
    }
    /**
     * Get author
     *
     * @return Collection|ArticleLike
     */
    public function getLikes():Collection
    {
        return $this->likes;
    }
    
     /**
     * Article constructor.
     */
    public function __construct()
    {
        $this->updatedAt = new \DateTimeImmutable();
        $this->likedBy = new ArrayCollection();
    }
   
}

