<?php

namespace ArticleBundle\Controller;

use ArticleBundle\Entity\User;
use ArticleBundle\Entity\ArticleLike;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class LikeController extends Controller
{
     /**
     * @Route("/likes", name="places_list")
     * @Method({"GET"})
     */
    public function getLikes(Request $request)
    {
        $likes = $this->get('doctrine.orm.entity_manager')
                ->getRepository('ArticleBundle:ArticleLike')
                ->findAll();
        

        $formatted = [];
        foreach ($likes as $like) {
            $formatted[] = [
               
                'user_id'=> $like->getUser()->getId(),
                'article_id'=> $like->getArticle()->getId(),
            ];
        }

        return new JsonResponse($formatted);
        
    }
     /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/LikeArticles",name="create_like")
     * @Method({"POST"})
     */
    public function LikeArticle(Request $request)
    {
        $donnees = json_decode($request->getContent());

        $user_id=$donnees->user_id;
        $article_id=$donnees->article_id;
      
        $article=$this->getDoctrine()->getRepository('ArticleBundle:Article')->find($article_id);
      
       
      $like = new ArticleLike();
      
      $a=$this->getDoctrine()->getRepository('ArticleBundle:User')->find($user_id);
        $like->setUser($a);
        $like->setArticle($article);
        dump($like);

        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($like);
        $em->flush();
        return new JsonResponse("like ajouté");
    } 
    
    
}
