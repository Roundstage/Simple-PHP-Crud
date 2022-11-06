<?php 
    use \Roundstage\Controllers\ProductController;
    #Listar todos os produtos.
    $app->get("/app/product", function(){ProductController::ListAll();});

    #Criação de produtos.
    $app->get("/app/product/create", function(){
        ProductController::Create();
    });
    $app->post("/app/product/create", function(array $data){
        ProductController::Create($data);
    });

    #Editar um produto.
    $app->get("/app/product/:idProduto", function($idProduto){

    });
    $app->post("/app/product/:idProduto", function($idProduto){

    });

    #Deletar um produto.
    $app->get("/app/product/:idProduto/delete", function($idProduto){

    });
?>