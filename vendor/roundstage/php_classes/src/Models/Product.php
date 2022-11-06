<?php
    namespace Roundstage\Models;
    use \Roundstage\Database\Sql;
    use \Roundstage\Model;
    class Product extends Model {
        public static function Create()
        {
            $sql = new Sql();
            #Registrando os dados no banco de dados, uso procedures para performance.
            $results = $sql->select("CALL crud_products_save(:description, :sale_value, :stock, :image)", [
                ":description"=>$this->getdescription(),
                ":sale_value"=>$this->getsalevalue(),
                ":stock"=>$this->getstock(),
                ":image"=>$this->getimage()
            ]);
            $this->setData($results[0]);

        }
        public static function Read()
        {
            $sql = new Sql();
            return $sql->select("SELECT A.description, A.sale_value, A.stock, A.created_at, A.updated_at, B.image FROM product_products A INNER JOIN product_images B ON A.id = B.id_product ORDER BY A.id");
        }
        public static function Update(int $id, array $data)
        {
            $sql = new Sql();
            #Registrando o produto.
            $sql->query("UPDATE product_products SET description = :description, sale_value = :sale_value, stock = :stock WHERE id = :id", [
                ":id"=>$data["id"],
                ":description"=>$data['description'],
                ":sale_value"=>$data['sale_value'],
                ":stock"=>$data['stock']
            ]);
            if(!empty($data['images'])){
                $sql->query("UPDATE product_products SET description = :description, sale_value = :sale_value, stock = :stock WHERE id = :id", [
                    ":id"=>$data["id"],
                    ":description"=>$data['description'],
                    ":sale_value"=>$data['sale_value'],
                    ":stock"=>$data['stock']
                ]);
            }
            
        }
        public static function Delete()
        {

        }
        public function checkPhoto()
        #Checa se a foto existe e retorna a url, se não existe, ele coloca uma foto em cinza.
        {
            if (file_exists($_SERVER["DOCUMENT_ROOT"]. DIRECTORY_SEPARATOR .
            "resources" . DIRECTORY_SEPARATOR .
            "product-images" . DIRECTORY_SEPARATOR .
            $this->getidproduct()."jpg")){
                $url = "resources/product-images/". $this->getidproduct()."jpg";
            }else{
                $url = "resources/product-images/product.jpg";
            }
            return $this->setimage($url);
        }
        public function getValues()
        #Obtém os valores guardados no model.
        {
            $this->checkPhoto();
            $values = parent::getValues();
            return $values;
        }
    }















?>