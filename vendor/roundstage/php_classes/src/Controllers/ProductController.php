<?php
    namespace Roundstage\Controllers;
    use \Roundstage\Models\Product;
    use \Roundstage\Page;
    class ProductController {
        public static function ListAll()
        #Lê os produtos e retorna a view com os dados dos produtos.
        {
            $products = Product::Read();
            $page = new Page();
            $page->setTpl("products", ["products"=>$products]);
        }
        public static function Create()
        #Cria novos produtos, images no banco de dados e os respectivos arquivos das imagens.
        {
            if(empty($_POST)){
                $page = new Page();
                $page->setTpl("products-create");
                return;
            }
            $product = new Product();
            $product->setData($_POST);      
            $product->setPhoto($_FILES['image']);  
            $product->Create();
            header("Location: /app/product");
            return;
        }
        public static function Update(int $id)
        #Atualiza os dados no banco de dados e excluí os arquivos antigos.
        {
            if(!empty($_POST)){
                $product = new Product();
                $product->get((int)$id);
                $product->setData($_POST); 
                $product_values = $product->getValues();
                
                foreach($product_values['images'] as $value){
                    if($_FILES[$value['id']]['size'][0] > 0){
                        $product->deleteFile($value['image']);
                        $product->setPhoto($_FILES[$value['id']], true, $value['id']);
                        $product->updatePhoto();
                    }
                }
                if($_FILES['images']['size'][0] > 0){
                    $product->setPhoto($_FILES['images']);
                    $product->Update(true);
                }else {
                    $product->Update();  
                }
                header("Location: /app/product");
                return;
            }                
            $product = new Product();
            $product->get((int)$id);
            $page = new Page();
            $page->setTpl("products-update", ["product"=>$product->getValues()]);
            return;

        }
        public static function Delete(int $id)
        #Deleta as informações no banco de dados e os arquivos.
        {
            $product = new Product();
            $product->get((int)$id);
            $product->delete();
            header("Location: /app/product");
            return;
        }
    }









?>