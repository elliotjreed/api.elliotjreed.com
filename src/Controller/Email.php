<?php

declare(strict_types=1);

namespace App\Controller;

use App\Response\ApiJsonResponse;
use App\Response\ApiResponseData;
use App\Service\ContactForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class Email extends AbstractController
{
    #[Route('/api/v1/email/send', methods: ['POST', 'OPTIONS'])]
    public function send(Request $request, ContactForm $contactForm): ApiJsonResponse
    {
        $contactForm->sendEmail(
            $request->request->get('name'),
            $request->request->get('email'),
            $request->request->get('message')
        );

        return new ApiJsonResponse((new ApiResponseData())->setData(['status' => 'sent']));
    }
}
