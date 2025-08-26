<?php

declare(strict_types=1);

namespace Boson\Blog\Application;

use Boson\Shared\Infrastructure\ThemeManager;

class HomeController
{
    public function __construct(
        private $templateEngine,
        private ThemeManager $themeManager
    ) {}

    public function index(array $params = []): string
    {
        return $this->templateEngine->render('pages::home', [
            'themeManager' => $this->themeManager,
            'currentRoute' => 'home'
        ]);
    }
}
