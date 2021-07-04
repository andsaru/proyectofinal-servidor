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
        // $positionss = [];

        // foreach($employee->getPositions() as $position) {
        //     array_push($projects, [
        //         'id' => $position->getId(),    
        //         'name' => $position->getName(),    
        //     ]);
        // }

        $avatar = '';
        if($employee->getAvatar()) {
            $avatar = $this->urlHelper->getAbsoluteUrl('/adminuser/avatar/'.$employee->getAvatar());
        }

        return [
            'first_name' => $employee->getFirstName(),
            'last_name' => $employee->getLastName(),
            'email' => $employee->getEmail(),
            'phone' => $employee->getPhone(),
            'class_shift' => $employee->getClassShift(),
            'shift_duration' => $employee->getShiftDuration(),
            'announcements' => [
                'id' => $employee->getAnnouncements()->getId(),
                'date' => $employee->getAnnouncements()->getDate(),
                'title' => $employee->getAnnouncements()->getTitle(),
                'content' => $employee->getAnnouncements()->getContent(),
            ],
            'shifts' => [
                'id' => $employee->getShifts()->getId(),
                'date' => $employee->getShifts()->getDate(),
            ],
            'avatar' => $avatar
        ];    
    }
}