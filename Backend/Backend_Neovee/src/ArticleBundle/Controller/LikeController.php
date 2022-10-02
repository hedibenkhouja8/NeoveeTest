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
     * @Route("/likes/{user_id}/{article_id}", name="get_all")
     * @Method({"GET"})
     */
    
    public function isLiked($user_id,$article_id)
    {
          $like = $this->get('doctrine.orm.entity_manager')
                        ->getRepository('ArticleBundle:ArticleLike')
                        
        ->findOneBy(array('user' => $user_id, 'article' => $article_id));
                        if($like)
                return new JsonResponse(1);
                else
                
                return new JsonResponse(0);

        
    } /**
    * @Route("/likesByUser/{user_id}", name="get_all_liked")
    * @Method({"GET"})
    */
   
   public function likesByUser($user_id)
   {
         $likes = $this->get('doctrine.orm.entity_manager')
                       ->getRepository('ArticleBundle:ArticleLike')
                       
       ->findBy(['user' => $user_id]);
       $output = array();
       $formatted = [];

        foreach ($likes as $like) {
            
    $output[] = $like->getArticle()->getId();
        }
                    
               return new JsonResponse($output);

       
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
        
        $em = $this->get('doctrine.orm.entity_manager');

        $user_id=$donnees->user_id;

        $article_id=$donnees->article_id;
      
        $user=$this->getDoctrine()->getRepository('ArticleBundle:User')->find($user_id);

        $article=$this->getDoctrine()->getRepository('ArticleBundle:Article')->find($article_id);
        
        $l=$this->getDoctrine()
                ->getRepository('ArticleBundle:ArticleLike')
                ->findOneBy(array('user' => $user_id, 'article' => $article_id));
        if($l){
            $em->remove($l);

            $em->flush();
        return new JsonResponse("like supprimé");

        }
        else{
      
         $like = new ArticleLike();
      
        $like->setUser($user);

        $like->setArticle($article);
        $em->persist($like);

        $em->flush();

        return new JsonResponse("like ajouté");}
    } 
    
    
}
