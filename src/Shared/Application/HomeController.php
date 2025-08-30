<?php

declare(strict_types=1);

namespace Boson\Shared\Application;

use Boson\Shared\Application\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function index(array $params = []): string
    {
        return $this->render('pages::home');
    }

    protected function getCurrentRoute(): string
    {
        return 'home';
    }

    protected function getDefaultTitle(): string
    {
        return 'Boson PHP - Go Native. Stay PHP.';
    }

    protected function getDefaultDescription(): string
    {
        return 'Turn your PHP project into cross-platform, compact, fast, native applications.';
    }
}
