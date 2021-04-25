<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ContactForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class Email extends AbstractController
{
    #[Route('/email/send', methods: ['POST', 'OPTIONS'])]
    public function index(Request $request, ContactForm $contactForm): JsonResponse
    {
        $contactForm->sendEmail(
            $request->request->get('name'),
            $request->request->get('email'),
            $request->request->get('message'),
            $request->request->get('captcha')
        );

        return new JsonResponse();
    }
}
