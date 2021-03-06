<?php

namespace App\Controller;

use App\Entity\AdminUser;
use App\Entity\Positions;
use App\Repository\AdminUserRepository;
use App\Repository\AnnouncementsRepository;
use App\Repository\PositionsRepository;
use App\Repository\ShiftsRepository;
use App\Service\EmployeeNormalize;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
    public function index(Request $request, AdminUserRepository $employeeRepository, EmployeeNormalize $employeeNormalize): Response
    {
        if($request->query->has('term')) {
            $result = $employeeRepository->findByTerm($request->query->get('term'));
            $data = [];

            foreach($result as $employee) {
                $data[] = $employeeNormalize->employeeNormalize($employee);   
            }

            return $this->json($data);
        }

        $result = $employeeRepository->findAll();

        $data = [];

        foreach($result as $employee) {
            $data[] = $employeeNormalize->employeeNormalize($employee); 
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
     * @IsGranted("ROLE_ADMIN")
     */
    public function show(
        AdminUser $employee,
        EmployeeNormalize $employeeNormalize
    ): Response
    {
        dump($this->getUser());
        // $announcements = $announcementsRepository->find($data->get('announcements_id'));
        // $shifts = $shiftsRepository->find($data->get('shifts_id'));
        return $this->json($employeeNormalize->employeeNormalize($employee));
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
        PositionsRepository $positionsRepository,
        AnnouncementsRepository $announcementsRepository,
        ShiftsRepository $shiftsRepository,
        EmployeeNormalize $employeeNormalize,
        SluggerInterface $slug,
        UserPasswordHasherInterface $hasher
    ): Response {
        $data = json_decode($request->getContent());
   
        // dump($data);
        // dump($data->email);
        // die(
        // dump($request->files);

        // $announcements = $announcementsRepository->find($data->get('announcements_id'));
        // $shifts = $shiftsRepository->find($data->get('shifts_id'));

        $employee = new AdminUser();

        $employee->setEmail($data->email);
        $employee->setFirstName($data->first_name);
        $employee->setLastName($data->last_name);
        $employee->setPhone($data->phone);
        $employee->setClassShift($data->class_shift);
        $employee->setShiftDuration($data->shift_duration);

        $passwordHashed = $hasher->hashPassword($employee, $data->password);
        $employee->setPassword($passwordHashed);
        // $employee->setAnnouncements($announcements);
        // $employee->setShifts($shifts);

        if($request->files->has('avatar')) {
            $avatarFile = $request->files->get('avatar');

            $avatarOginalFilename = pathinfo($avatarFile->getClientOriginalName(), PATHINFO_FILENAME);
            dump($avatarOginalFilename);

            $safeFilename = $slug->slug($avatarOginalFilename);
            $avatarNewFilename = $safeFilename.'-'.uniqid().'.'.$avatarFile->guessExtension();
            dump($avatarNewFilename);

            try {
                $avatarFile->move(
                    $request->server->get('DOCUMENT_ROOT') . DIRECTORY_SEPARATOR . 'adminuser/avatar',
                    $avatarNewFilename
                );
            } catch (FileException $e) {
                throw new \Exception($e->getMessage());
            }
            
            $employee->setAvatar($avatarNewFilename);
        }

        //die();

        $errors = $validator->validate($employee);

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

        $entityManager->persist($employee);
        
        // $employee no tiene id.

        $entityManager->flush();

        return $this->json(
            $employeeNormalize->employeeNormalize($employee),
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
        Request $request,
        UserPasswordHasherInterface $hasher
    ): Response
    {
        $employee = $employeeRepository->find($id);

        if(!$employee) {
            return $this->json([
                'message' => sprintf('No he encontrado el empleado con id.: %s', $id)
            ], Response::HTTP_NOT_FOUND);
        }
        // Obtienes el contenido de la petici??n en formato JSON
        $data = json_decode($request->getContent(), true);
        $unhashedPassword = $data['password'];
        $hashedPassword = $hasher->hashPassword($employee, $unhashedPassword);


        $employee->setEmail($data['email']);
        $employee->setFirstName($data['first_name']);
        $employee->setLastName($data['last_name']);
        $employee->setPhone($data['phone']);
        $employee->setPassword($hashedPassword);
        $employee->setClassShift($data['class_shift']);
        $employee->setShiftDuration($data['shift_duration']);

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
