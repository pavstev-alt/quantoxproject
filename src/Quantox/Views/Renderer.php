<?php

namespace Quantox\Views;

use Twig_Loader_Filesyste;
use Twig_Environment;

class Renderer
{
    public static function render(string $file, array $data): string
    {
        $loader = new Twig_Loader_Filesystem('./resources/views');
        $twig = new Twig_Environment($loader, []);
        $template = $twig->load($file);

        return $template->render($data);
    }
}
