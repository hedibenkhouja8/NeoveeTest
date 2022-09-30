<?php

namespace ArticleBundle\Controller;
use ArticleBundle\Entity\User;
use ArticleBundle\Entity\Article;
use ArticleBundle\Form\ArticleType;
use ArticleBundle\Service\Validate;
use ArticleBundle\Entity\ArticleLike;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ArticleBundle\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class ArticleController extends Controller
{
    
   
    
     /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/articles/{id}",name="show_article_by_user")
     * @Method("GET")
     */
    public function ArticleByUser($id){

         $articles=$this->getDoctrine()
                        ->getRepository('ArticleBundle:Article')
                        ->findBy(['author' => $id], array('updatedAt' => 'DESC'));

        $formatted = [];

        foreach ($articles as $article) {
            $formatted[] = [
                'id'=>$article->getId(),
               'titre' => $article->getTitre(),
               'contenu' => $article->getContenu(),
               'updated_at' => $article->getUpdatedAt(),
               'likes' => $article->getLikes(),
            ];
        }

        return new JsonResponse($formatted);
    }


     /** 
     * @param Request $request
     * @return JsonResponse
     * @Route("/articles", name="articles_list")
     * @Method({"GET"})
     */
    public function getAllarticles(Request $request)
    {
           $articles = $this->get('doctrine.orm.entity_manager')
                            ->getRepository('ArticleBundle:Article')
                            ->findAll();
           

        $formatted = [];
        foreach ($articles as $article) {
            $likes = $this->get('doctrine.orm.entity_manager')
            ->getRepository('ArticleBundle:ArticleLike')
            ->findBy(['article' => $article->getId()]);
            
            $size = count($likes);
            $formatted[] = [
               'id' => $article->getId(),
               'titre' => $article->getTitre(),
               'contenu' => $article->getContenu(),
               'user_name'=> $article->getUser()->getNom(),
               'user_id'=> $article->getUser()->getId(),
               'updated_at' => $article->getUpdatedAt(),
               'likes' => $size,
            ];
        }

        return new JsonResponse($formatted);
        
    }
    
    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/ajouter",name="create_article")
     * @Method({"POST"})
     */
    public function createArticle(Request $request)
    {
        $donnees = json_decode($request->getContent());

        $id=$donnees->user_id;
      
        $user=$this->getDoctrine()->getRepository('ArticleBundle:User')->find($id);
      
        $article = new Article();

        $article->setTitre($donnees->titre)
                ->setContenu($donnees->contenu)
                ->setUser($user);

            
        $em = $this->get('doctrine.orm.entity_manager');

        $em->persist($article);

        $em->flush();

        return new JsonResponse("article ajouté");
    } 

    
      /**
     * @Route("/modifier/{id}",name="edit_article")
     * @Method("PUT")
     */
    public function editArticle(?Article $article, Request $request)
    {
 

        // On décode les données envoyées
        $donnees = json_decode($request->getContent());

        // On initialise le code de réponse
        $code = 200;

        // Si l'article n'est pas trouvé
        if(!$article){
            // On instancie un nouvel article
            $article = new Article();
            // On change le code de réponse
            $code = 201;
        }

        // On hydrate l'objet
        $article->setTitre($donnees->titre);

        $article->setContenu($donnees->contenu);

        $article->setUpdatedAt(new \DateTimeImmutable());

        // On sauvegarde en base
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($article);

        $entityManager->flush();

        // On retourne la confirmation
        return new Response('article modifié avec succès', $code);
    
}
   


        /**
        * @Route("/supprimer/{id}", name="supprimer")
        * @Method("DELETE")
        */
    public function deleteArticle(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $article = $em->getRepository('ArticleBundle:Article')
                      ->find($request->get('id'));
      

        if ($article) {

            $em->remove($article);

            $em->flush();
            
        }
        
        return new JsonResponse("article supprimé avec succès");
    }

   
}


