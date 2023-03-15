<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Produtos
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Editar Produto</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="/app/product/<?php echo htmlspecialchars( $product["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="form-group">
              <label for="description">Nome da produto</label>
              <input type="text" class="form-control" id="description" name="description" placeholder="Digite o nome do produto" value="<?php echo htmlspecialchars( $product["description"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" required>
            </div>
            <div class="form-group">
              <label for="sale_value">Preço</label>
              <input type="number" class="form-control" id="sale_value" name="sale_value" step="0.01" placeholder="0.00" value="<?php echo htmlspecialchars( $product["sale_value"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" required>
            </div>
            <div class="form-group">
              <label for="stock">Stock</label>
              <input type="number" class="form-control" id="stock" name="stock" step="0.01" placeholder="0.00" value="<?php echo htmlspecialchars( $product["stock"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" required>
            </div>
            <?php $counter1=-1;  if( isset($product["images"]) && ( is_array($product["images"]) || $product["images"] instanceof Traversable ) && sizeof($product["images"]) ) foreach( $product["images"] as $key1 => $value1 ){ $counter1++; ?>

            <div class="form-group">
              <label for="file<?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">Imagem</label>
              <input type="file" class="form-control" id="file<?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" name="<?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>[]">
              <div class="box box-widget">
                <div class="box-body">
                    <img height="100px" widht="100px"  id="image-preview" src="<?php echo htmlspecialchars( $value1["image"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" alt="Photo">
                </div>
              </div>
            </div>
            <?php } ?>

            <div class="form-group">
              <label for="fileNew">Imagens Novas</label>
              <input type="file" class="form-control" id="fileNew" name="images[]" multiple="multiple">
            </div>
          </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>
        </form>
      </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
document.querySelector('#file').addEventListener('change', function(){
  
  var file = new FileReader();

  file.onload = function() {
    
    document.querySelector('#image-preview').src = file.result;

  }

  file.readAsDataURL(this.files[0]);

});
</script>