<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-icon btn-flat-success waves-effect']) }}>
    {{ $slot }}
</button>
