<x-modal :modalTitulo="$tituloModal" :modalId="$idModal">
    <form wire:submit="guardarArchivo">
        <input type="file" wire:model="archivo" class="form-control">
     
        @error('archivo') <span class="error">{{ $message }}</span> @enderror
    </form>
    @if (!empty($errores))
        <div class="alert alert-danger" role="alert">
            <div class="alert-body">
                @foreach ($errores as $error)
                    <span>{{ $error }}</span>
                @endforeach
            </div>
        </div>
    @endif
    @slot('modalFooter')
        <button class="btn btn-relief-primary" wire:click="guardarArchivo" wire:loading.attr="disabled">
            <span wire:loading wire:target="guardarArchivo" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <i class="fa fa-check"></i>
            Guardar
        </button>
    @endslot
</x-modal>