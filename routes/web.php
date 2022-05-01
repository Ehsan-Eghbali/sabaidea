<?php

use Slim\App;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteCollectorProxy;

require_once '../app/users.php';
require_once '../app/domains.php';
session_start();
return function (App $app) {

    $app->get('/user/{id}', function (Request $request, Response $response, $args) {
        $id = $args['id'];
        $user = new users();
        $insert = $user->find($id);
        $response->getBody()->write($insert);
        return $response;
    });
    $app->post('/user', function (Request $request, Response $response) {
        $input = $request->getParsedBody();
        $name = $input['name'];
        if (!is_null($name) && $name !==''){
            $user = new users();
            $insert = $user->insert($name);

            $response->getBody()->write($insert);
        }
        else {
            $response->getBody()->write('خطا');
        }
        return $response;
    });

    if (isset($_SESSION['user'])){
        $app->group('/domain',function (RouteCollectorProxy $group){
            $group->post('', function (Request $request, Response $response) {
                $input = $request->getParsedBody();
                $url = $input['url'];
                if (!is_null($url) && $url !==''){
                    $domain = new domains();
                    $insert = $domain->insert($url);
                    $response->getBody()->write($insert);
                }
                else {
                    $response->getBody()->write('خطا');
                }
                return $response;
            });
            $group->put('/{id}', function (Request $request, Response $response) {

                $id = $request->getAttribute('id');
                $input = $request->getParsedBody();
                $url = $input['url'];
                if (!is_null($id) && !is_null($url) && $url !==''){
                    $domain = new domains();
                    $update = $domain->update($id,$url);
                    $response->getBody()->write($update);
                }
                else {
                    $response->getBody()->write('خطا');
                }
                return $response;
            });
            $group->delete('/{id}', function (Request $request, Response $response) {

                $id = $request->getAttribute('id');

                if (!is_null($id)){
                    $domain = new domains();
                    $delete = $domain->delete($id);
                    $response->getBody()->write($delete);
                }
                else {
                    $response->getBody()->write('خطا');
                }
                return $response;
            });
        });
    }

    $authMiddleware = function($request, $response, $next) {
        return $next($request, $response);
    };
};