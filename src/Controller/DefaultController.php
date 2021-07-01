<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController 
{
    /**
     * @Route("/default", name="default_index")
     * 
     * La clase ruta debe estar precedida en los comentario por una arroba.
     * El primer parámetro de Route es la URL a la que queremos asociar la acción.
     * El segundo parámetro de Route es el nombre que queremos dar a la ruta.
     */
    public function index(): Response
    {
        // Una acción siempre debe devolver una respesta.
        // Por defecto deberá ser un objeto de la clase,
        // Symfony\Component\HttpFoundation\Response
        return new Response('hola');
    }

    // Redirige a la URL del back o puede redirigir al front?
    // public function redirectToHome(): RedirectResponse {
    //     // Redirigir a la URL /
    //     // return $this->redirect('/');

    //     // Redirigir a una ruta utilizando su nombre.
    //     // return $this->redirectToRoute('default_show', ['id' => 1]);

    //     // Devolver directamente un objeto RedirectResponse.
    //     return new RedirectResponse('/', Response::HTTP_TEMPORARY_REDIRECT);
    // }
}