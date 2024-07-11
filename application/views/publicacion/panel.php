
	
<div class="content box-body">

	<?= $this->session->userdata('s_nomusuario'); ?>	
	<div class="col-sm-12 box-body">		
		
            <div class="box-header with-border">
              <h3 class="box-title">Publicaciones</h3>

            </div>


		      <div class="input-group input-group-sm">
                <input type="text" class="form-control" id="txtBuscarPublicacion" name="txtBuscarPublicacion">
                    <span class="input-group-btn">
                      <button type="button" id="btnBuscarPublicacion" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button>
                    </span>
              </div>
             <!--  <button type="button" id="btnBuscarPublicacion" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button> -->
              <br> 
               <label >Palabra Buscada:</label><label id="txtBuscado">hoola</label>

            <!-- /.box-header -->
            <div class="box box-danger">
            <div class="box-body">

              <table id="tblPublicaciones" class="table table-bordered">
                <!-- <tr>
                  <th style="width: 10px">#</th>
                  <th>Categoria</th>
                  <th>Titulo</th>
                  <th>Resumen</th>
                  <th>Fecha</th>
                  <th style="width: 40px">imagen</th>
                </tr> -->
               
                
                
              </table>
            </div>
        	</div>
    </div>
</div>
		<script type="text/javascript">
			var baseurl= "<?= base_url(); ?>";
		</script>