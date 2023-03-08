<?php

namespace App\Controller;

use App\Entity\Citoyen;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Repository\UserRepository;
use App\Repository\CitoyenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\ORM\Mapping\DiscriminatorMap;

class UtilisateurApiController extends AbstractController
{
    #[Route('/user/signup', name: 'app_api_register')]
    public function signupAction (Request $request , UserPasswordEncoderInterface $passwordEncoder)
    {
       $email=$request->query->get(key:"email");
       $password=$request->query->get(key:"password");
       $confirm_password=$request->query->get(key:"confirm_password");
       $nom=$request->query->get(key:"nom");
       $prenom=$request->query->get(key:"prenom");
       $tel=$request->query->get(key:"tel");
       $adresse=$request->query->get(key:"adresse");
       $roles[]='ROLE_CITOYEN';

       // controle de saisie le mail doit contenir le caractère 
       if(!filter_var($email,filter:FILTER_VALIDATE_EMAIL)){
        return new Response(content:"email invalide.");
       }

       $user=new Citoyen();
       $user->setEmail($email);
       $user->setRoles($roles);// array car roles par défaut le security type est array
       $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $password
                    )

       );
       $user->setConfirmPassword(
        $passwordEncoder->encodePassword(
            $user,
            $confirm_password
        )

);
       $user->setNom($nom);
       $user->setPrenom($prenom);
       $user->setTel($tel);
       $user->setAdresse($adresse);
    
    

       try {
        $em=$this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return new JsonResponse(data:"Account is created",status:200);//200 : Http result of server = ok

       }catch(\Exception $ex){
        return new Response(content:"exception".$ex->getMessage());



       }


    }

    #[Route('/user/signin', name: 'app_api_login')]
    public function signinAction(Request $request){

            $email=$request->query->get(key:"email");
            $password=$request->query->get(key:"password");

            $em=$this->getDoctrine()->getManager();
         $user=$em->getRepository(User::class)->findOneby(['email'=>$email]);// chercher un utilisateur avec son username dans la BD

            // Si user exsite dans la BD
            if($user){
                // Comparer password aussi car il est crypté avec password_verify
                if(password_verify($password,$user->getPassword())){
                    $serializer=new Serializer([new ObjectNormalizer()]);
                    $formatted=$serializer->normalize($user);
            
                        return new JsonResponse($formatted);
                }
            else{
                return new Response(content:"passowrd not found");
            } 

            }
        else
        {
            return new Response(content:"user not found");
        }

    
    }

    #[Route('/user/editUser', name: 'app_gestion_profile')]

    public function editUser(Request $request){
            $id=$request->get(key:"id");
            $email=$request->query->get(key:"email");
            $nom=$request->query->get(key:"nom");
            $prenom=$request->query->get(key:"prenom");
            $tel=$request->query->get(key:"tel");
            $adresse=$request->query->get(key:"adresse");

            $em=$this->getDoctrine()->getManager();
            $user=$em->getRepository(User::class)->find($id);


            $user->setNom($nom);
            $user->setPrenom($prenom);
            $user->setTel($tel);
            $user->setAdresse($adresse);



           
            try {
                $em=$this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                return new JsonResponse(data:"Success",status:200);//200 : Http result of server = ok
        
               }catch(\Exception $ex){

                return new Response(content:"failed".$ex->getMessage());
        
        
        
               }

                             
                             
                         
                               





    }

      #[Route('/user/updatepassword', name: 'updatepassword')]
      public function updatepassword(Request $request,UserPasswordEncoderInterface $passwordEncoder) :JsonResponse
      {
        $user = new User();
          $email = $request->query->get("email");
          $password = $request->query->get("password");


          
          $rep = $this->getDoctrine()->getManager();
       //   $Checkuser = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);
  
          // Check if the user exists to prevent Integrity constraint violation error in the insertion
  
        
          $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);

          $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                $password
            )

);


     
         
          $rep->flush();
          $serializer = new Serializer([new ObjectNormalizer()]);
          $formatted = $serializer->normalize("Mot de passe a ete changer");
          return new JsonResponse($formatted);
          
        }

      #[Route('/user/checkemail', name: 'checkemail')]
      public function checkemail(Request $request):JsonResponse
      {
        $user = new User();
          $email = $request->query->get("email");
   


          
          $rep = $this->getDoctrine()->getManager();
       //   $Checkuser = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);
  
          // Check if the user exists to prevent Integrity constraint violation error in the insertion
  
        
          $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);

    
if($user){

    $serializer = new Serializer([new ObjectNormalizer()]);
    $formatted = $serializer->normalize("email exist");
    return new JsonResponse($formatted);

}

      

          
        }
}
