<?php 

    require_once("vendor/autoload.php");
    
    #Lib para rotas.
    use \Slim\Slim;
    #Minha lib pra usar o raintpl.
    use \Roundstage\Page;
    #Minha lib pra usar o controller.
    use \Roundstage\Controllers\ProductController;

    
    $app = new Slim();

    $app->config('debug', true);

    $app->get('/', function() {
        $page = new Page();
        $page->setTpl("index");
        exit;
    });

    #Listar todos os produtos.
    $app->get("/app/product", function(){
        ProductController::ListAll();
        exit;
    });

    #Criação de produtos.
    $app->get("/app/product/create", function(){
        ProductController::Create();
        exit;
    });
    $app->post("/app/product/create", function(){
        ProductController::Create();
        exit;
    });

    #Editar um produto.
    $app->get("/app/product/:idProduto", function($idProduto){
        ProductController::Update($idProduto);
        exit;
    });
    $app->post("/app/product/:idProduto", function($idProduto){
        
        ProductController::Update($idProduto);
        exit;
    });

    #Deletar um produto.
    $app->get("/app/product/:idProduto/delete", function($idProduto){
        ProductController::Delete($idProduto);
        exit;
    });

    $app->run();

?>