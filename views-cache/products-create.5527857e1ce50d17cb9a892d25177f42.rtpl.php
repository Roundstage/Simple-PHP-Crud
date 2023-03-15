<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Produtos
  </h1>
  <ol class="breadcrumb">
    <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="/app/product">product</a></li>
    <li class="active"><a href="/app/product/create">Cadastrar</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Novo Produto</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="/app/product/create" method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="form-group">
              <label for="description">Nome do produto</label>
              <input type="text" class="form-control" id="description" name="description" placeholder="Digite o nome do produto" required>
            </div>
            <div class="form-group">
              <label for="sale_value">Preço</label>
              <input type="number" class="form-control" id="sale_value" name="sale_value" step="0.01" placeholder="0.00" required>
            </div>
            <div class="form-group">
              <label for="stock">Quantidade</label>
              <input type="number" class="form-control" id="stock" name="stock" placeholder="0" required>
            </div>
            <div class="form-group">
              <label for="image">Image</label>
              <input type="file" class="form-control" id="image" name="image[]" multiple="multiple">
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-success">Cadastrar</button>
          </div>
        </form>
      </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->