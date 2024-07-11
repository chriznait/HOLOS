

<section class="content">
	<h1>registrar publicacion</h1>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
 
		  	<form action="<?= base_url(); ?>cpublicacion/guardar" method="POST">
		  	  <div class="form-group">
			   <label >Categoria</label>
                  <select id="cboCat" name="txtCategoria"class="form-control">

                  </select>
			  </div>
			  <div class="form-group">
			    <label for="titulo">Titulo</label>
			    <input type="text" class="form-control" id="titulo" name="txtTitulo">
			  </div>
			  <div class="form-group">
			    <label for="resumen">Resumen</label>
			    <textarea class="form-control" rows="3" name="txtResumen" placeholder="Enter ..."></textarea>
			  </div>
			   <div class="form-group">
			    <label for="contenido">Contenido</label>
			    <textarea class="form-control" rows="10" name="txtContenido" placeholder="Enter ..."></textarea>
			  </div>
			   <div class="form-group">
                  <label for="foto">foto</label>
                  <input type="file" id="foto">

                </div>
			  <button type="submit" class="btn btn-primary">Publicar</button>
			</form>
		</div>
		<div class="col-md-4"></div>
		<script type="text/javascript">
			var baseurl= "<?= base_url(); ?>";
		</script>
	</div>
</section>	

