<?php 

    require_once("vendor/autoload.php");
    use \Slim\Slim;
    use \Roundstage\Page;
    use \Roundstage\Models\Product;
    #Lib para rotas, não gosto de usar as rotas do PHP base, muito trabalho pra pouca coisa.
    $app = new Slim();

    $app->config('debug', true);

    $app->get('/', function() {
        $page = new Page();
        $page->setTpl("index");
    });
    

    require_once("ProductsRoutes.php");

    $app->run();

?>