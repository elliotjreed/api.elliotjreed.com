<?php

declare(strict_types=1);

namespace App\Controller;

use App\Content\Cv as GithubCv;
use App\Response\MarkdownResponse;
use Symfony\Component\Routing\Annotation\Route;

final class Cv
{
    #[Route('/cv', methods: ['GET'])]
    public function index(GithubCv $cv): MarkdownResponse
    {
        return new MarkdownResponse($cv->asMarkdown());
    }
}
