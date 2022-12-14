<?php

namespace ArticleBundle\Controller;
use ArticleBundle\Entity\User;
use ArticleBundle\Entity\Article;
use ArticleBundle\Form\ArticleType;
use ArticleBundle\Service\Validate;
use ArticleBundle\Entity\ArticleLike;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ArticleBundle\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


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
                        ->findBy(['user' => $id], array('updatedAt' => 'DESC'));

        $formatted = [];

        foreach ($articles as $article) {
            $formatted[] = [
                'id'=>$article->getId(),
               'titre' => $article->getTitre(),
               'contenu' => $article->getContenu(),
               'updated_at' => $article->getUpdatedAt(),
               
               'user_id'=> $article->getUser()->getId(),
               'likes' =>count( $article->getLikes()),
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

        return new JsonResponse("article ajout??");
    } 

    
      /**
     * @Route("/modifier/{id}",name="edit_article")
     * @Method("PUT")
     */
    public function editArticle(?Article $article, Request $request)
    {
 

        // On d??code les donn??es envoy??es
        $donnees = json_decode($request->getContent());

        // On initialise le code de r??ponse
        $code = 200;

        // Si l'article n'est pas trouv??
        if(!$article){
            // On instancie un nouvel article
            $article = new Article();
            // On change le code de r??ponse
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
        return new Response('article modifi?? avec succ??s', $code);
    
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
        
        return new JsonResponse("article supprim?? avec succ??s");
    }

   
   
    /** 
     * @param Request $request
     * @return JsonResponse
     * @Route("/articless", name="articles_listd")
     * @Method({"GET"})
     */ 
    /*
    public function getAllarticlesserializer(Request $request)
    {
           $articles = $this->get('doctrine.orm.entity_manager')
                            ->getRepository('ArticleBundle:ArticleLike')
                            ->findAll();
                           
                            $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
                            $normalizers = [new ObjectNormalizer()];
                            $serializer = new Serializer($normalizers, $encoders);
                            
                            // Serialize your object in Json
                            $jsonObject = $serializer->serialize($articles, 'json', [
                                'groups' => 'show_article']);
                            
                            // For instance, return a Response with encoded Json
                            return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);

    }*/
}


