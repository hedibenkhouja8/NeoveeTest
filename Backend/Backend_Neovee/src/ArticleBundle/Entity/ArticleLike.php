<?php

namespace ArticleBundle\Entity;

use ArticleBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use ArticleBundle\Entity\Article;

/**
 * ArticleLike
 *
 * @ORM\Table(name="article_like")
 * @ORM\Entity(repositoryClass="ArticleBundle\Repository\ArticleLikeRepository")
 */
class ArticleLike
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
     *
     * @ORM\ManyToOne(targetEntity="Article",inversedBy="likes")
     */
    private $article;

    /**
     *
     * @ORM\ManyToOne(targetEntity="User",inversedBy="likes")
     */
    private $user;


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
     * Set article
     *
     */
    public function setArticle(?Article $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *

     */
    public function getArticle() :?Article
    {
        return $this->article;
    }

    /**
     * Set user
     *
     */
    public function setUser(?User $User)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     */
    public function getUser():?User
    {
        return $this->user;
    }
}

