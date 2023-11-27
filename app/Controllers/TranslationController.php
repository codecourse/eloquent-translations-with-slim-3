<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Psr\Http\Message\{
    ServerRequestInterface as Request,
    ResponseInterface as Response
};

class TranslationController extends Controller
{
    public function switch(Request $request, Response $response, $args)
    {
        if (isset($args['lang'])) {
            $_SESSION['lang'] = $args['lang'];
        }

        return $response->withRedirect($this->c->router->pathFor('home'));
    }
}
