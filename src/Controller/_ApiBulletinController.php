<?php
namespace App\Controller;
use App\Entity\AdminUser;
use App\Service\EmployeeNormalize;
use App\Repository\AnnouncementsRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BulletinController
 * @package App\Controller
 *
 * @Route(path="/api/")
 */
class BulletinController
{
    private $announcementsRepository;

    public function __construct(AnnouncementsRepository $announcementsRepository)
    {
        $this->announcementsRepository = $announcementsRepository;
    }

    /**
     * @Route("bulletin", name="add_bulletin", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $content = $data['content'];
        $date = $data['date'];

        $this->announcementsRepository->saveBulletin($content, $date);

        return new JsonResponse(['status' => 'Buelletin created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("bulletin/{id}", name="get_one_bulletin", methods={"GET"})
     */

  
    public function get($id): JsonResponse          
    {
        $announcements = $this->announcementsRepository->find($id);

        $data = [
            'id' => $announcements->getId(),
            'content' => $announcements->getContent(),
            'date' => $announcements->getDate(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("bulletins", name="get_all_bulletins", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $bulletins = $this->petRepository->findAll();
        $data = [];

        foreach ($bulletins as $bulletin) {
            $data[] = [
                'id' => $bulletin->getId(),
                'content' => $bulletin->getContent(),
                'date' => $bulletin->getDate(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }


    /**
     * @Route("bulletin/{id}", name="delete_bulletin", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $bulletin = $this->announcementsRepository->findOneBy(['id' => $id]);

        $this->announcementsRepository->removePet($bulletin);

        return new JsonResponse(['status' => 'Bulletin deleted'], Response::HTTP_OK);
    }
}

?>