<?php

namespace App\Controller;

use App\Entity\Announcements;
use App\Repository\AnnouncementsRepository;
use App\Service\AnnouncementsNormalize;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/api/announcements", name="api_announcements_")
*/
class ApiAnnouncementsController extends AbstractController
{

    /**
     * @Route(
     *      "",
     *      name="cget",
     *      methods={"GET"}
     * )
     */
    public function index(Request $request, AnnouncementsRepository $announcementsRepository, AnnouncementsNormalize $announcementsNormalize): Response
    {
        if($request->query->has('term')) {
            $result = $announcementsRepository->findByTerm($request->query->get('term'));
            $data = [];

            foreach($result as $announcements) {
                $data[] = $announcementsNormalize->announcementsNormalize($announcements);   
            }

            return $this->json($data);
        }

        $result = $announcementsRepository->findAll();

        $data = [];

        foreach($result as $announcements) {
            $data[] = $announcementsNormalize->announcementsNormalize($announcements); 
        }
        return $this->json($data);
    }

    /**
     * @Route(
     *      "/{id}",
     *      name="get",
     *      methods={"GET"},
     *      requirements={
     *          "id": "\d+"
     *      }
     * )
     * 
     */
    public function show(
        Announcements $announcements,
        AnnouncementsRepository $announcementsRepository,
        AnnouncementsNormalize $announcementsNormalize
    ): Response
    {
        dump($this->getUser());
        return $this->json($announcementsNormalize->announcementsNormalize($announcements));
    }

    /**
     * @Route(
     *      "",
     *      name="post",
     *      methods={"POST"}
     * )
     */
    public function add(
        Request $request,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        AnnouncementsNormalize $announcementsNormalize
    ): Response {
        $data = json_decode($request->getContent());

        // dump($data);
        // dump($data->email);
        // die();
        // dump($request->files);

        $announcements = new Announcements();

        $announcements->setDate(new \DateTimeImmutable());
        $announcements->setContent($data->content);
        $announcements->setAdminUser($this->getUser());

        $errors = $validator->validate($announcements);

        if (count($errors) > 0) {
            $dataErrors = [];

            /** @var \Symfony\Component\Validator\ConstraintViolation $error */
            foreach ($errors as $error) {
                $dataErrors[] = $error->getMessage();
            }

            return $this->json([
                'status' => 'error',
                'data' => [
                    'errors' => $dataErrors
                    ]
                ],
                Response::HTTP_BAD_REQUEST);
        } 

        $entityManager->persist($announcements);
        
        // $announcements no tiene id.

        $entityManager->flush();

        return $this->json(
            $announcementsNormalize->announcementsNormalize($announcements),
            Response::HTTP_CREATED,
            [
                'Location' => $this->generateUrl(
                    'api_announcements_get',
                    [
                        'id' => $announcements->getId()
                    ]
                )
            ]
        );
    }

    /**
     * @Route(
     *      "/{id}",
     *      name="delete",
     *      methods={"DELETE"},
     *      requirements={
     *          "id": "\d+"
     *      }
     * )
     */
    public function remove(
        int $id,
        EntityManagerInterface $entityManager,
        AnnouncementsRepository $announcementsRepository
    ): Response
    {
        $announcements = $announcementsRepository->find($id);

        if(!$announcements) {
            return $this->json([
                'message' => sprintf('No he encontrado el comentario con id.: %s', $id)
            ], Response::HTTP_NOT_FOUND);
        }

        dump($announcements);

        // remove() prepara el sistema pero NO ejecuta la sentencia.
        $entityManager->remove($announcements);
        $entityManager->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
