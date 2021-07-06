<?php

namespace App\Service;
use Symfony\Component\HttpFoundation\UrlHelper;

use App\Entity\Announcements;

class AnnouncementsNormalize {
    private $urlHelper;

    public function __construct(UrlHelper $constructorDeURL)
    {
        $this->urlHelper = $constructorDeURL;
    }

    /**
     * Normalize an announcements.
     * 
     * @param Announcements $announcements
     * 
     * @return array|null
     */
    public function announcementsNormalize (Announcements $announcements): ?array {

        return [
            'id' => $announcements->getId(),
            'date' => $announcements->getDate(),
            // 'title' => $announcements->getTitle(),
            'content' => $announcements->getContent(),
        ];    
    }
}