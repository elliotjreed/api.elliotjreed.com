<?php
declare(strict_types=1);

namespace ElliotJReed\Retrievers;

interface Retriever
{
    public function retrieve(): Retriever;
    public function getPosts(): array;
    public function getCategories(): array;
}
