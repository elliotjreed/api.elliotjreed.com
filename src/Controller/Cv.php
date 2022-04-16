<?php

declare(strict_types=1);

namespace App\Controller;

use App\Content\Cv as GithubCv;
use App\Response\ApiJsonResponse;
use App\Response\ApiResponseData;
use App\Response\MarkdownResponse;
use Symfony\Component\Routing\Annotation\Route;

final class Cv
{
    #[Route('/cv', methods: ['GET'])]
    public function index(GithubCv $cv): ApiJsonResponse
    {
        return new ApiJsonResponse((new ApiResponseData())->setData($cv->asMarkdown()));
    }

    #[Route('/cv.md', methods: ['GET'])]
    public function markdown(GithubCv $cv): MarkdownResponse
    {
        return new MarkdownResponse($cv->asMarkdown());
    }
}
