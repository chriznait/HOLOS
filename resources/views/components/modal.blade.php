<div wire:ignore.self class="modal fade text-start" id="{{ $modalId }}" tabindex="-1" aria-hidden="true" 
    data-bs-backdrop="static" data-bs-keyboard="false"
    >
    <div class="modal-dialog {{ $tipo }}">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $modalTitulo }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-relief-secondary" data-bs-dismiss="modal">Cerrar</button>
                @isset($modalFooter)
                    {{ $modalFooter }}
                @else
                    <button class="btn btn-relief-primary waves-effect" type="button" wire:click="{{ $guardar }}" wire:loading.attr="disabled">
                        <span wire:loading wire:target="{{ $guardar }}" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="ml-25 align-middle">Guardar</span>
                    </button>
                @endisset
            </div>
        </div>
    </div>
</div>