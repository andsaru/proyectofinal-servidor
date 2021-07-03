<?php

namespace App\Controller;

use App\Entity\AdminUser;
use App\Repository\AdminUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/amazing-employees", name="api_employees_")
 */
class ApiEmployeesController extends AbstractController
{
    /**
     * @Route(
     *      "",
     *      name="cget",
     *      methods={"GET"}
     * )
     */
    public function index(): Response
    {
        return $this->json([
            'method' => 'CGET',
            'description' => 'Devuelve el listado del recurso empleados.',
        ]);
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
     */
    public function show(int $id): Response
    {
        return $this->json([
            'method' => 'GET',
            'description' => 'Devuelve un solo recurso empleado con id: '.$id.'.',
        ]);
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
        EntityManagerInterface $entityManager
    ): Response {
        $data = $request->request;

        $employee = new AdminUser();

        $employee->setEmail($data->get('email'));
        $employee->setFirstName($data->get('first_name'));
        $employee->setLastName($data->get('last_name'));
        $employee->setPhone($data->get('phone'));
        $employee->setPassword($data->get('password'));
        $employee->setClassShift($data->get('class_shift'));
        $employee->setShiftDuration($data->get('shift_duration'));

        $entityManager->persist($employee);
        
        // $employee no tiene id.

        $entityManager->flush();

        dump($employee);

        return $this->json(
            $employee,
            Response::HTTP_CREATED,
            [
                'Location' => $this->generateUrl(
                    'api_employees_get',
                    [
                        'id' => $employee->getId()
                    ]
                )
            ]
        );
    }

    /**
     * @Route(
     *      "/{id}",
     *      name="put",
     *      methods={"PUT"},
     *      requirements={
     *          "id": "\d+"
     *      }
     * )
     */
    public function update(
        int $id,
        EntityManagerInterface $entityManager,
        AdminUserRepository $employeeRepository,
        Request $request
    ): Response
    {
        $employee = $employeeRepository->find($id);

        if(!$employee) {
            return $this->json([
                'message' => sprintf('No he encontrado el empledo con id.: %s', $id)
            ], Response::HTTP_NOT_FOUND);
        }
        $data = $request->request;

        $employee->setEmail($data->get('email'));
        $employee->setFirstName($data->get('first_name'));
        $employee->setLastName($data->get('last_name'));
        $employee->setPhone($data->get('phone'));
        $employee->setPassword($data->get('password'));
        $employee->setClassShift($data->get('class_shift'));
        $employee->setShiftDuration($data->get('shift_duration'));

        $entityManager->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
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
        AdminUserRepository $employeeRepository
    ): Response
    {
        $employee = $employeeRepository->find($id);

        if(!$employee) {
            return $this->json([
                'message' => sprintf('No he encontrado el empledo con id.: %s', $id)
            ], Response::HTTP_NOT_FOUND);
        }

        dump($employee);

        // remove() prepara el sistema pero NO ejecuta la sentencia.
        $entityManager->remove($employee);
        $entityManager->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
