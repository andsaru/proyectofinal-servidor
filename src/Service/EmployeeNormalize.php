<?php

namespace App\Service;

use App\Entity\AdminUser;

class EmployeeNormalize {
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

        ];    
    }
}