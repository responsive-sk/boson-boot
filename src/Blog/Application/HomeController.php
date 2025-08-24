<?php

declare(strict_types=1);

namespace Boson\Blog\Application;

use Boson\Shared\Infrastructure\TemplateEngine;

class HomeController
{
    public function __construct(
        private $templateEngine
    ) {}

    public function index(array $params = []): string
    {
        return $this->templateEngine->render('pages::home');
    }
}
