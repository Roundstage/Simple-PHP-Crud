<?php if(!class_exists('Rain\Tpl')){exit;}?><form class="row g-3" action="" enctype="multipart/form-data" >
    <div class="col-md-6">
      <label for="description" class="form-label">Descrição </label>
      <input type="text" class="form-control" id="description" name="description">
    </div>
    <div class="col-md-6">
      <label for="sale_value" class="form-label">Valor de venda</label>
      <input type="number" step="0.01" class="form-control" id="sale_value" name="sale_value">
    </div>
    <div class="col-12">
      <label for="stock" class="form-label">Estoque</label>
      <input type="number" class="form-control" id="stock" name="stock" >
    </div>
    <div class="col-md-2">
      <label for="inputZip" class="form-label">Zip</label>
      <input type="text" class="form-control" id="inputZip">
    </div>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary">Cadastrar</button>
    </div>
  </form>