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
     * @Route("/likes/{id}", name="get_all")
     * @Method({"GET"})
     */
    /*
    public function getLikes($id)
    {
          $likes = $this->get('doctrine.orm.entity_manager')
                        ->getRepository('ArticleBundle:ArticleLike')
                        ->findBy(['article' => $id]);
                        
                        $size = count($likes);
dump($size);
        $formatted = [];
        
             foreach ($likes as $like) {
                     $formatted[] = [
                            'user_id'=> $like->getUser()->getId(),
                            'article_id'=> $like->getArticle()->getId(),
                                    ];
                                        }
                                        $size = count($formatted);
        return new JsonResponse($size);
        
    }*/
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
      
        $user=$this->getDoctrine()->getRepository('ArticleBundle:User')->find($user_id);

        $article=$this->getDoctrine()->getRepository('ArticleBundle:Article')->find($article_id);
        
        $l=$this->getDoctrine()
                ->getRepository('ArticleBundle:ArticleLike')
                ->findOneBy(array('user' => $user_id, 'article' => $article_id));
        if($l){
         
        return new JsonResponse("like existe déja");

        }
        else{
      
         $like = new ArticleLike();
      
        $like->setUser($user);

        $like->setArticle($article);

        $em = $this->get('doctrine.orm.entity_manager');

        $em->persist($like);

        $em->flush();

        return new JsonResponse("like ajouté");}
    } 
    
    
}
