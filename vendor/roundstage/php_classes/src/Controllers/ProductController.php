<?php
    namespace Roundstage\Controllers;
    use \Roundstage\Models\Product;
    use \Roundstage\Page;
    class ProductController {
        public static function ListAll(){
            $products = Product::Read();
            $page = new Page();
            $page->setTpl("products", ["products"=>$products]);
        }
        public static function Create(array $data = []){
            if(empty($data)){
                $page = new Page();
                $page->setTpl("products-create");
                return;
            }
            $product = new Product();
            $product->setData($_POST);
            $product->Create();
            header("/app/product");
            exit;
        }
    }









?>