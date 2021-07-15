<?php
namespace App\Controller;



use App\Entity\Recettes;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class IndexController extends AbstractController
{

  /**
    *@Route("/Recettes/recherche",name="recherche")
    */
  public function recherhe(Request $request)
  {
  $propertySearch = new PropertySearch();
  $form = $this->createForm(PropertySearchType::class,$propertySearch);
  $form->handleRequest($request);
  //initialement le tableau des recettes est vide,
  //c.a.d on affiche les recettes que lorsque l'utilisateur
  //clique sur le bouton rechercher
  $recettes= [];
 
  if($form->isSubmitted() && $form->isValid()) {
  //on récupère le nom de la recette tapé dans le formulaire
 
  $nom = $propertySearch->getNom();
  if ($nom!="")
  //si on a fourni un nom d'une recette, on affiche tous les recettes ayant ce nom
  $recettes= $this->getDoctrine()->getRepository(Recettes::class)->findBy(['nom' => $nom] );
  else
  //si si aucun nom n'est fourni on affiche tous les recettes
  $recettes= $this->getDoctrine()->getRepository(Recettes::class)->findAll();
  }
  return $this->render('recettes/recherche.html.twig',[ 'form' =>$form->createView(), 'recettes' => $recettes]);
  }




    /**
    *@Route("/",name="recettes_list")
    */
    public function home()
    {
        //récupérer tous les recettees de la table recettes de la BD
        // et les mettre dans le tableau $recettes
        $Recettes= $this->getDoctrine()->getRepository(Recettes::class)->findAll();
    return $this->render('Recettes/index.html.twig',['Recettes'=> $Recettes]);
    }

  

    /**
     * @Route("/Recettes/new", name="new_Recettes")
     * Method({"GET", "POST"})
     */
    public function new(Request $request) {
        $Recettes = new Recettes();
        $form = $this->createFormBuilder($Recettes)
          ->add('nom', TextType::class)
          ->add('description', TextType::class)
          ->add('Temps_de_preparation', TextType::class)
          ->add('Materiel', TextType::class)
          ->add('Temps_de_preparation', TextType::class)

          ->add('Niveau', ChoiceType::class, array( 'choices'  => array( 
               'Facile' => 'Facile', 
               'Moyen' => 'Moyen',
               'Difficile' =>'Difficile',
            ), 
         )) 

          ->add('Instructions', TextType::class)
          ->add('save', SubmitType::class, array(
            'label' => 'Créer')
          )->getForm();
          
  
        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
          $Recettes = $form->getData();
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($Recettes);
          $entityManager->flush();
  
          return $this->redirectToRoute('recettes_list');
        }
      return $this->render('Recettes/new.html.twig',['form' => $form->createView()]);
    }
  /**
     * @Route("/Recettes/{id}", name="recette_show")
     */
    public function show($id) {
      $Recettes = $this->getDoctrine()->getRepository(Recettes::class)->find($id);

      return $this->render('Recettes/show.html.twig', array('Recettes' => $Recettes));
    }


  /**
     * @Route("/Recettes/edit/{id}", name="edit_Recettes")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
      $Recettes = new Recettes();
      $Recettes = $this->getDoctrine()->getRepository(Recettes::class)->find($id);
      $form = $this->createFormBuilder($Recettes)
      ->add('nom', TextType::class)
      ->add('description', TextType::class)
      ->add('Temps_de_preparation', TextType::class)
      ->add('Materiel', TextType::class)
      ->add('Temps_de_preparation', TextType::class)
      ->add('Niveau', ChoiceType::class, array( 'choices'  => array( 
        'Facile' => 'Facile', 
        'Moyen' => 'Moyen',
        'Difficile' =>'Difficile',
     ), 
  )) 
      ->add('Instructions', TextType::class)
      ->add('save', SubmitType::class, array(
      'label' => 'Modifier'
      ))->getForm();
      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        return $this->redirectToRoute('recettes_list');
      }
     return $this->render('Recettes/edit.html.twig', ['form' => $form->createView()]);
    }



  /**
     * @Route("/Recettes/delete/{id}",name="delete_Recettes")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id) {
      $Recette = $this->getDoctrine()->getRepository(Recettes::class)->find($id);

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($Recette);
      $entityManager->flush();

      $response = new Response();
      $response->send();

      return $this->redirectToRoute('recettes_list');
    }

}
