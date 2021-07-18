<?php

namespace App\Service;
use Symfony\Component\HttpFoundation\UrlHelper;

use App\Entity\AdminUser;

class EmployeeNormalize {
    private $urlHelper;

    public function __construct(UrlHelper $constructorDeURL)
    {
        $this->urlHelper = $constructorDeURL;
    }

    /**
     * Normalize an employee.
     * 
     * @param AdminUser $employee
     * 
     * @return array|null
     */
    public function employeeNormalize (AdminUser $employee): ?array {

        $avatar = '';
        if($employee->getAvatar()) {
            $avatar = $this->urlHelper->getAbsoluteUrl('/adminuser/avatar/'.$employee->getAvatar());
        }

        // $announcements = [];
        // foreach($employee->getAnnouncements() as $announcement) {
        //     array_push($announcements, [
        //         'id' => $announcement->getId(),
        //         'date' => $announcement->getDate(),
        //         'title' => $announcement->getTitle(),
        //         'content' => $announcement->getContent(),
        //     ]);
        // }

        $shifts = [];
        foreach($employee->getShifts() as $shift) {
            $shiftData = [
                'id' => $shift->getId(),
                'date' => $shift->getDate(),
            ];

            if ($shift->getPositions()) {
                $shiftData['position'] = [
                    'id' => $shift->getPositions()->getId(),
                    'name' => $shift->getPositions()->getName(),
                ];
            }
            array_push($shifts, $shiftData);
        }

        return [
            'id' => $employee->getId(),
            'first_name' => $employee->getFirstName(),
            'last_name' => $employee->getLastName(),
            'email' => $employee->getEmail(),
            'phone' => $employee->getPhone(),
            'class_shift' => $employee->getClassShift(),
            'shift_duration' => $employee->getShiftDuration(),
            //'announcements' => $announcements,
            'shifts' => $shifts,

            'avatar' => $avatar
        ];    
    }
}