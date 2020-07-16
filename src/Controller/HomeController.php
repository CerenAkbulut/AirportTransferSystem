<?php

namespace App\Controller;

use App\Entity\Admin\Comment;
use App\Entity\Admin\Messages;
use App\Entity\Cars;
use App\Entity\Setting;
use App\Form\Admin\CommentType;
use App\Form\Admin\MessagesType;
use App\Repository\Admin\CommentRepository;
use App\Repository\Admin\VehiclesRepository;
use App\Repository\CarsRepository;
use App\Repository\ImageRepository;
use App\Repository\SettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(SettingRepository $settingRepository,CarsRepository $carsRepository)
    {
        $setting = $settingRepository->findAll();
        $slider = $carsRepository->findBy(['status'=>'True'],['title'=>'ASC'],3);
        $cars= $carsRepository->findBy(['status'=>'True'],['title'=>'DESC'],4);
        $newcars= $carsRepository->findBy(['status'=>'True'],['title'=>'DESC'],10);
        //array findBy(array $criteria, array $orderBy = null, int|null $limit = null, int|null $offset = null)
        //dump($slider);  //gelenlerin kontrolünü göstermek için kullandık.
        //die();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'setting' => $setting,
            'slider' => $slider,
            'cars' => $cars,
            'newcars' => $newcars,
        ]);
    }

    /**
     * @Route("/cars/{id}", name="cars_show", methods={"GET","POST"})
     */
    public function show(Request $request,Cars $cars,$id,ImageRepository $imageRepository,CommentRepository $commentRepository,VehiclesRepository $vehiclesRepository): Response
    {
        $vehicles=$vehiclesRepository->findAll();
        $images=$imageRepository->findAll();
        $comments=$commentRepository->findBy(['carid'=>$id,'status'=>'New']);
       //dump($vehicles);
        //die();
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $submittedToken = $request->request->get('token');

        if ($form->isSubmitted()) {

            if ($this->isCsrfTokenValid('comment', $submittedToken)){
               // dump($form);
               // die();
                $entityManager = $this->getDoctrine()->getManager();
                $comment->setStatus('New');
                $comment->getIp($_SERVER['REMOTE_ADDR']);
                //$comment->setIlanid($id); // bunedir
                $user=$this->getUser();
                $comment->setUserid($user->getId());
                $comment->setCarid($id);
                $entityManager->persist($comment);
                $entityManager->flush();
                $this->addFlash('success', 'Your Comment Has Been Sent Succesfully');

                return $this->redirectToRoute('cars_show', ['id'=>$id]);
            }
        }
        //bu mu?
        return $this->render('home/carsshow.html.twig', [
            'car' => $cars,
            'vehicles' => $vehicles,
            'images'=>$images,
            'comments'=>$comments,
        ]);
    }


    /**
     * @Route("/about", name="home_about")
     */
    public function about(SettingRepository $settingRepository): Response
    {
        $setting = $settingRepository->findAll();
        return $this->render('home/aboutus.html.twig', [
            'setting' => $setting,

        ]);
    }


    /**
     * @Route("/contact", name="home_contact",methods={"GET","POST"})
     */
    public function contact(SettingRepository $settingRepository,Request $request): Response
    {


        $message = new Messages();
        $form = $this->createForm(MessagesType::class, $message);
        $form->handleRequest($request);
        $submittedToken=$request->request->get('token');

        if ($form->isSubmitted()) {
            //fakat buraya giriyor yani formdan veri geliyor
            //dump($form->get('name'));
           // die();
           // if($this->isCsrfTokenValid('form-message', $submittedToken)){
                //sorun buraya girmemesi
                //dump($form);
               // die();
            $entityManager = $this->getDoctrine()->getManager();
            $message->setStatus('New');
            $message->setIp($_SERVER['REMOTE_ADDR']);


            $entityManager->persist($message);
            $entityManager->flush();
            $this->addFlash('success','Your message has been sent succesfully');

            return $this->redirectToRoute('home_contact');
           // }
        }



        $setting = $settingRepository->findAll();
        return $this->render('home/contact.html.twig', [
            'setting' => $setting,
            'form' => $form->createView(),

        ]);
    }




}