<?php

namespace App\Controller;

use App\Entity\Admin\Reservation;
use App\Entity\User;
use App\Form\Admin\CommentType;
use App\Form\Admin\ReservationType;
use App\Form\UserType;
use App\Repository\Admin\VehiclesRepository;
use App\Repository\CarsRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use Egulias\EmailValidator\Warning\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\File;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('user/show.html.twig');
    }


    /**
     * @Route("/comments", name="user_comments", methods={"GET"})
     */
    public function comments(): Response
    {
        return $this->render('user/comments.html.twig');
    }


    /**
     * @Route("/cars", name="user_cars", methods={"GET"})
     */
    public function cars(CarsRepository $carsRepository): Response
    {
        $user = $this->getUser();

        return $this->render('user/cars.html.twig', [
            'cars' => $carsRepository->findBy(['userid' => $user->getId()]
            ),
        ]);


    }


    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            //*****************file upload******************>>>>>>>>>>>>

            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );


            /**@var file $file */
            $file = $form['image']->getData();
            if ($file) {
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();  // uniq id ile kaydediyor yüklenen resimleri dosya yolu ile beraber alıyor
                //Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('images_directory'), //Servis.yaml de tanımladığımız resim yolu
                        $fileName
                    );
                } catch (FileException $e) {
                    //... handle exception if something happens during file upload
                }
                $user->setImage($fileName);  //Related upload file name with cars table image field
            }
            //*****************file upload******************>>>>>>>>>>>>
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,

        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, $id, User $user, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getUser();
        if ($user->getId() != $id) {
            return $this->redirectToRoute('home');
        }


        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //*****************file upload******************>>>>>>>>>>>>

            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );


            /**@var file $file */
            $file = $form['image']->getData();
            if ($file) {
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();  // uniq id ile kaydediyor yüklenen resimleri dosya yolu ile beraber alıyor
                //Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('images_directory'), //Servis.yaml de tanımladığımız resim yolu
                        $fileName
                    );
                } catch (FileException $e) {
                    //... handle exception if something happens during file upload
                }
                $user->setImage($fileName);  //Related upload file name with cars table image field
            }
            //*****************file upload******************>>>>>>>>>>>>

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
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
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route("/reservation/{cid}/{vid}", name="user_reservation_new", methods={"GET","POST"})
     */
    public function newreservation(Request $request, $cid, $vid, CarsRepository $carsRepository, VehiclesRepository $vehiclesRepository): Response
    {

        //dump($vehicles);
        //die();

        // $distance=$_REQUEST["distance"];
        // $fromdest=$_REQUEST["fromdest"];
        //dump($_REQUEST["fromdest"]);
        //die();
        $date = $_REQUEST["date"];
        // $todest=$_REQUEST["todest"];
        // $date=Date("Y-m-d H:i:s", strtotime($date . "$date Day" ));

        //$data["total"]=$distance*$vehicles->getPrice();
        //$data["days"]=$days;
        //$data["date"]=$date;
        // $data["fromdest"]=$fromdest;
        //  $data["todest"]=$todest;


        // $total=$distance * $vehicles->getPrice();

        $cars = $carsRepository->findOneBy(['id' => $cid]);
        $vehicles = $vehiclesRepository->findOneBy(['id' => $vid]);

        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        $submittedToken = $request->request->get('token');
        if ($form->isSubmitted()) {
            if ($this->isCsrfTokenValid('form-reservation', $submittedToken)) {
                //dump($form);
                //die();
                $entityManager = $this->getDoctrine()->getManager();
                $reservation->setStatus('New');
                $reservation->setIp($_SERVER['REMOTE_ADDR']);
                $reservation->setCarsid($cid);
                $reservation->setVehicleid($vid);
                $reservation->setTotal($_REQUEST["total"]);
                $user = $this->getUser(); // get login user data
                $reservation->setUserid($user->getId());
                // $reservation->setDistance($distance);
                //$reservation->setTotal($total);


                $entityManager->persist($reservation);
                $entityManager->flush();

                return $this->redirectToRoute('user_reservations', ['id' => $user->getId()]);
            }
        }

        return $this->render('user/newreservation.html.twig', [
            'reservation' => $reservation,
            'vehicles' => $vehicles,
            'fromdest' => $_REQUEST["fromdest"],
            'todest' => $_REQUEST["todest"],
            'date' => $date,
            'cars' => $cars,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/reservations/{id}", name="user_reservations", methods={"GET"})
     */
    public function reservations(ReservationRepository $reservationRepository, $id): Response
    {
        $user = $this->getUser();
        //$reservations=$reservationRepository->findBy(['userid'=>$user->getId()]);
        $reservations = $reservationRepository->getReservation($id);
        //dump($reservations);
        //die();
        return $this->render('user/reservations.html.twig', [
            'reservations' => $reservations,
        ]);

    }
    /**
     * @Route("/showreservation/{id}", name="user_reservation_show", methods={"GET"})
     */
    public function showreservation($id,Reservation $reservation,ReservationRepository $reservationRepository): Response
    {
        $reservation = $reservationRepository->showReservation($id);
        //dump($reservation);
        //die();
        return $this->render('user/reservation_show.html.twig', [
            'reservation' => $reservation,
        ]);
    }


}
