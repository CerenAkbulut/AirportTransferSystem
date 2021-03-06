<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Form\Cars1Type;
use App\Repository\CarsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;

/**
 * @Route("/user/cars")
 */
class CarsController extends AbstractController
{
    /**
     * @Route("/", name="user_cars_index", methods={"GET"})
     */
    public function index(CarsRepository $carsRepository): Response
    {
        $user=$this->getUser(); // Get login user data
        return $this->render('cars/index.html.twig', [
            'cars' => $carsRepository->findBy(['userid'=>$user->getId()]),
        ]);
    }

    /**
     * @Route("/new", name="user_cars_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cars = new Cars();
        $form = $this->createForm(Cars1Type::class, $cars);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            //*****************file upload******************>>>>>>>>>>>>

            /**@var file $file */
            $file = $form['image']->getData();
            if($file){
                $fileName = $this->generateUniqueFileName() . '.' .$file->guessExtension();  // uniq id ile kaydediyor yüklenen resimleri dosya yolu ile beraber alıyor
                //Move the file to the directory where brochures are stored
                try{
                    $file->move(
                        $this->getParameter('images_directory'), //Servis.yaml de tanımladığımız resim yolu
                        $fileName
                    );
                } catch (FileException $e){
                    //... handle exception if something happens during file upload
                }
                $cars->setImage($fileName);  //Related upload file name with cars table image field
            }
            //*****************file upload******************>>>>>>>>>>>>



            $user=$this->getUser(); // get login user data
            $cars->setUserid($user->getId());
            $cars->setStatus('New');

            $entityManager->persist($cars);
            $entityManager->flush();

            return $this->redirectToRoute('user_cars_index');
        }

        return $this->render('cars/new.html.twig', [
            'cars' => $cars,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_cars_show", methods={"GET"})
     */
    public function show(Cars $cars): Response
    {
        return $this->render('cars/show.html.twig', [
            'car' => $cars,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_cars_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cars $cars): Response
    {
        $form = $this->createForm(Cars1Type::class, $cars);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**@var file $file */
            $file = $form['image']->getData();
            if($file){
                $fileName = $this->generateUniqueFileName() . '.' .$file->guessExtension();
                //Move the file to the directory where brochures are stored
                try{
                    $file->move(
                        $this->getParameter('images_directory'), // Servis.yaml de tanımlanan resimler
                        $fileName
                    );
                } catch (FileException $e){
                    //... handle exception if something happens during file upload
                }
                $cars->setImage($fileName);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_cars_index');
        }

        return $this->render('cars/edit.html.twig', [
            'cars' => $cars,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @return string
     */

    private function generateUniqueFileName()
    {
        //md5() reduces the similarity of the file names generated by
        //uniqid(), which is based on timestamps
        return md5(uniqid());
    }







    /**
     * @Route("/{id}", name="user_cars_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Cars $cars): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cars->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cars);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_cars_index');
    }
}
