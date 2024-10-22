<div class="row">
    <div class="col-sm-12">
       <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title text-center card-info ">Datos del ticket</h3>
            </div>
            <form wire:submit="store">
                <div class="card-body">
                    <div class="form-group" >
                        <label for="name">Servicio</label>
                        <select class="form-control" wire:model="idServicio"
                         >
                            <option value="">Seleccione un servicio</option>
                            @foreach ($servicio as $serv)
                                <option value="{{$serv->id}}">
                                    {{$serv->descripcion}}
                                </option>
                                
                            @endforeach
                        </select>
                        
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="name">Equipo</label>
                        <input type="text" class="form-control" value="{{$descripcion_equipo}}" id="descripcion_equipo" wire:model="descripcion_equipo" required/>

                    </div>
                    <br>
                    <div class="form-group">
                        <label for="name">Descripcion problema</label>
                        <textarea class="form-control" id="descripcion_problema" wire:model="descripcion_problema" required></textarea>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="name">Anexo telefonico</label>
                        <input type="text" class="form-control" value="{{$anexo_telefonico}}" id="anexo_telefonico" wire:model="anexo_telefonico"/>
                    </div>
                        
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>  
    </div>
       
</div>
