<?php
    namespace Roundstage\Models;
    use \Roundstage\Database\Sql;
    use \Roundstage\Model;
    class Product extends Model {
        public function Create()
        #Cria um produto no banco de dados, todos os produtos terão uma imagem padrão.
        {
            $sql = new Sql();
            #Registrando os dados no banco de dados, uso procedures para performance.
            $results = $sql->select("CALL crud_products_save(:description, :sale_value, :stock)", [
                ":description"=>$this->getdescription(),
                ":sale_value"=>$this->getsale_value(),
                ":stock"=>$this->getstock()
            ]);
            foreach($this->getimages() as $image)
            {
                $results[0]['images'] = $this->createImage($results[0]['id'], $image);
            }
            $this->setData($results[0]);

        }
        public function createImage($id, $image)
        #Cria uma nova imagem pro produto
        {
            $sql = new Sql();
            return $sql->select("CALL crud_products_image_save(:image, :id_product)", [
                ":image"=>$image,
                ":id_product"=>$id
            ]);
            
        }
        public static function Read()
        #Lê todos os produtos e imagens do bando de dados e retorna um array formatado com eles.
        {
            $sql = new Sql();
            $result =  $sql->select("SELECT id, description, sale_value, stock FROM product_products");
            $products = [];
            $i = 0;
            foreach($result as $product){
                $images = $sql->select("SELECT id, image FROM product_images WHERE id_product = :id_product", [
                    ":id_product"=>$product['id']
                ]);
                $products[$i] = [
                    'id'=>$product['id'],
                    'description'=>$product['description'],
                    'sale_value'=>$product['sale_value'],
                    'stock'=>$product['stock'],
                    'images'=>$images
                ];
                $i++;
            }
            return $products;
        }
        public function Update(bool $havePhoto = false)
        #Registra o produto e adiciona novas imagens, o update de imagens é uma ação separada.
        {
            $sql = new Sql();
            #Registrando o produto.
            $sql->query("UPDATE product_products SET description = :description, sale_value = :sale_value, stock = :stock WHERE id = :id", [
                ":id"=>$this->getid(),
                ":description"=>$this->getdescription(),
                ":sale_value"=>$this->getsale_value(),
                ":stock"=>$this->getstock()
            ]);
            if($havePhoto){
                foreach($this->getimages() as $image)
                {
                    $this->createImage($this->getid(), $image);
                }  
            }

            
        }
        public function Delete()
        #Deleta os dados do banco de dados e deleta as imagens.
        {
            $sql = new Sql();
            $images = $sql->select("SELECT image FROM product_images WHERE id_product = :id_product", [
                ":id_product"=>$this->getid()
            ]);
            foreach($images as $image){
                $this->deleteFile($image['image']);
            }
            $sql->query("CALL crud_products_delete(:id)", [
                ":id"=>$this->getid()
            ]);
            
            
 
        }
        public function updatePhoto()
        #Atualiza as fotos no banco de dados.
        {
            $sql = new Sql();
            $image = $this->getimageupdate();
            $id = $this->getimage_id();
            $sql->query("UPDATE product_images SET image = :image WHERE id = :id", [
                ":id"=>$id,
                ":image"=>$image[0]
            ]);
        }
        public function checkPhoto(bool $isUpdate = false)
        #Checa se a foto existe e retorna a url, se não existe, ele coloca uma foto em cinza.
        {
            if($isUpdate){
                $image_names = $this->getimage_name_update();
            }else{
                $image_names = $this->getimage_names();
            }
            $images = [];
            foreach($image_names as $image_name){
                if (file_exists($_SERVER["DOCUMENT_ROOT"]. DIRECTORY_SEPARATOR ."resources" . DIRECTORY_SEPARATOR ."product-images" . DIRECTORY_SEPARATOR .$image_name.".jpg")){
                    $url = "/resources/product-images/". $image_name.".jpg";
                }else{
                    $url = "/resources/product-images/product.jpg";
                }
                array_push($images, $url);  
                
            }
            if($isUpdate){
                $this->setimageupdate($images);
            }
            return $this->setimages($images);
        }
        public function getValues()
        #Obtém os valores guardados no model.
        {
            $values = parent::getValues();
            return $values;
        }            
        public function getRandomWord($len = 10) 
            #Gera um nome aleatório para a foto
            {
                $word = array_merge(range('a', 'z'), range('A', 'Z'));
                shuffle($word);
                return substr(implode($word), 0, $len);
            }

        public function setPhoto($file, bool $isUpdate = false, int $id = null)
        #Recebe as fotos do $_FILES, manda pro caminho final e chama a função pra checagem.
        {
            $image_names = [];               
            
            for($i = 0; $i < count($file['name']); $i++){
                $extension = explode('.', $file['name'][$i]);
                $extension = end($extension);
                
                switch($extension){
                    case 'jpeg':
                    case 'jpg':
                        $image = imagecreatefromjpeg($file['tmp_name'][$i]);
                        break;
                    case 'png':
                        $image = imagecreatefrompng($file['tmp_name'][$i]);
                        break;
                    case 'gif':
                        $image = imagecreatefromgif($file['tmp_name'][$i]);
                        break;
                    default:
                        $image = "";
                        break;
                } 
                if($image != ""){
                    $word = $this->getRandomWord(10);
                    $dist = $_SERVER["DOCUMENT_ROOT"]. DIRECTORY_SEPARATOR .
                    "resources" . DIRECTORY_SEPARATOR .
                    "product-images" . DIRECTORY_SEPARATOR .
                    $word.".jpg";                
                    imagejpeg($image, $dist);
                    imagedestroy($image); 
                }else {
                    $word = $this->getRandomWord(10);
                    $dist = $_SERVER["DOCUMENT_ROOT"]. DIRECTORY_SEPARATOR .
                    "resources" . DIRECTORY_SEPARATOR .
                    "product-images" . DIRECTORY_SEPARATOR . "product.jpg"; 
                } 
                array_push($image_names,$word);
            }
            if(!$isUpdate){
                $this->setimage_names($image_names);
                $this->checkPhoto();
                return;
            }
            $this->setimage_id($id);
            $this->setimage_name_update($image_names);
            $this->checkPhoto($isUpdate);
            
        }
        public function get($id)
        #Carrega os dados do produto.
        {
            $sql = new sql();
            $result = $sql->select("SELECT * FROM product_products WHERE id = :id_product", [
                ":id_product"=>$id
            ]);
            $result[0]['images'] = $sql->select("SELECT id, image FROM product_images WHERE id_product = :id_product", [
                                        ":id_product"=>$id
                                   ]);
            $this->setData($result[0]);
        }
        public function deleteFile(string $url)
        #Deleta o arquivo ou não dependendo se for a imagem padrão de produtos que não tiveram imagens.
        {

            $image_name = explode('/', $url);
            $image_name = end($image_name);

            if($image_name == "product.jpg"){
                return;
            }

            $dist = $_SERVER["DOCUMENT_ROOT"]. DIRECTORY_SEPARATOR ."resources" . DIRECTORY_SEPARATOR ."product-images" . DIRECTORY_SEPARATOR .$image_name;
            unlink($dist);
        }
    }
