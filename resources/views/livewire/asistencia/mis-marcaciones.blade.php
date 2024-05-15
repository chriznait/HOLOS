<x-content-body :title='$tituloPagina'>
    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div wire:ignore id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</x-content-body>

@push('scripts')
<script>
    
</script>
<script>
    document.addEventListener('livewire:initialized', () => {
        let events;
        @this.getMarcaciones().then(res => {
            cargarCalendario(res);
        })
        function cargarCalendario(events){

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
            timeZone: 'UTC',
            locale: 'es',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
            },
            editable: false,
            dayMaxEvents: true, // when too many events in a day, show the popover
            events: events
            });

            calendar.render();
        }
    })
</script>
@endpush