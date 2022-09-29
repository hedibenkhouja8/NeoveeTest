<?php

namespace ArticleBundle\Controller;


use ArticleBundle\Entity\User;
use ArticleBundle\Entity\Article;
use ArticleBundle\Form\ArticleType;
use ArticleBundle\Service\Validate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ArticleBundle\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class UserController extends Controller
{
}
