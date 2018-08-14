<?php
declare(strict_types=1);

namespace ElliotJReed\Retrievers;

class ApcuCache implements Retriever
{
    private $posts = [];
    private $categories = [];

    public function retrieve(): Retriever
    {
        $this->categories = apcu_fetch('categories');
        $this->posts = apcu_fetch('posts');
        return $this;
    }

    public function getPosts(): array
    {
        return $this->posts;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }
}
