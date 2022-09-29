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
     * @Route("/ArticleByUser/{id}",name="show_article")
     * @Method("GET")
     */
    public function ArticleByUser($id){
        $articles=$this->getDoctrine()->getRepository('ArticleBundle:Article')->findBy(['author' => $id], array('updatedAt' => 'DESC'));
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
     * @Route("/articles", name="articles_list")
     * @Method({"GET"})
     */
    public function getPlacesAction(Request $request)
    {
        $articles = $this->get('doctrine.orm.entity_manager')
                ->getRepository('ArticleBundle:Article')
                ->findAll();
        

        $formatted = [];
        foreach ($articles as $article) {
            $formatted[] = [
               'id' => $article->getId(),
               'titre' => $article->getTitre(),
               'contenu' => $article->getContenu(),
               'user_name'=> $article->getUser()->getNom(),
               'updated_at' => $article->getUpdatedAt(),
               'likes' => $article->getLikes(),
            ];
        }

        return new JsonResponse($formatted);
        
    }
    
    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/Articles",name="create_article")
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
     * @Route("/article/edit/{id}",name="edit_article")
     * @Method("PUT")
     */
    public function editsArticle(?Article $article, Request $request)
{
    // On vérifie si la requête est une requête Ajax
 

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
        return new Response('ok', $code);
    
}
   


        /**
        * @Route("/article/supprimer/{id}", name="edit", methods={"DELETE"})
        */
    public function removeUserAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $article = $em->getRepository('ArticleBundle:Article')
                    ->find($request->get('id'));
        /* @var $user User */

        if ($article) {
            $em->remove($article);
            $em->flush();
            
        }
        
        return new JsonResponse(['msg'=>'supprimé avec succés',200]);
    }

   
         /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/like",name="lik")
     * @Method({"POST"})
     */
    public function createlike(Request $request)
    {
        $donnees = json_decode($request->getContent());

        $id=$donnees->user_id;
        $article_id=$donnees->article_id;
      
        $user=$this->getDoctrine()->getRepository('ArticleBundle:User')->find($id);
        $article=$this->getDoctrine()->getRepository('ArticleBundle:Article')->find($article_id);
      
      $like = new ArticleLike();
        $like
            ->setUser($user)
            ->setArticle($article);

            
        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($like);
        $em->flush();
        return new JsonResponse("article ajouté");
    }
}


