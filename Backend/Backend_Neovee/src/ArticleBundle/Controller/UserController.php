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
     /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/login",name="log")
     * @Method({"POST"})
     */
    public function Login(Request $request)
    {
        $donnees = json_decode($request->getContent());
        $email=$donnees->email;
        $password=$donnees->password;
      
        $user=$this->getDoctrine()->getRepository('ArticleBundle:User')
        ->findOneBy(array('email' => $email, 'password' => $password));
      if(!$user){
        
        return new JsonResponse(array('status' => 404));
      }

        return new JsonResponse(array('status' => 201, 'id' => $user->getId(),'nom'=>$user->getNom()));
    } 

    

}
