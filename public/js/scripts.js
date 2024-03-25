$(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
});

window.addEventListener('openModal', event => openModal(event.detail[0]))
window.addEventListener('closeModal', event => closeModal(event.detail[0]))
window.addEventListener('alert', event => showAlert(event.detail))

openModal = (idModal) => $(`#${idModal != undefined ? idModal : 'modal-1'}`).modal('show')

closeModal = (idModal) => $(`#${idModal != undefined ? idModal : 'modal-1'}`).modal('hide')

showAlert = (data) => {
    Swal.fire({
        icon: data[0].type,
        html: data[0].message,
        customClass: {
            confirmButton: 'btn btn-primary'
        },
        buttonsStyling: false
    })
}
roundDecinals = (number, decimals) => {
    let numb = Number(number);
    let numeroRegexp = new RegExp('\\d\\.(\\d){' + decimals + ',}');   // Expresion regular para numeros con un cierto numero de decimales o mas
    if (numeroRegexp.test(numb)) {         // Ya que el numero tiene el numero de decimales requeridos o mas, se realiza el redondeo
        return Number(numb.toFixed(decimals));
    } else {
        return Number(numb.toFixed(decimals)) === 0 ? 0 : numb;  // En valores muy bajos, se comprueba si el numero es 0 (con el redondeo deseado), si no lo es se devuelve el numero otra vez.
    }
}
function obtenerFecha(date = "", format=false){
    if(date == "") date = new Date()
    let day = `${(date.getDate())}`.padStart(2,'0');
    let month = `${(date.getMonth()+1)}`.padStart(2,'0');
    let year = date.getFullYear();
    if (!format) return(`${day}/${month}/${year}`)
    else return(`${year}-${month}-${day}`)
}

(function($, window) {
    'use strict';

    var MultiModal = function(element) {
        this.$element = $(element);
        this.modalCount = 0;
    };

    MultiModal.BASE_ZINDEX = 1040;

    MultiModal.prototype.show = function(target) {
        var that = this;
        var $target = $(target);
        var modalIndex = that.modalCount++;

        $target.css('z-index', MultiModal.BASE_ZINDEX + (modalIndex * 20) + 10);

        // Bootstrap triggers the show event at the beginning of the show function and before
        // the modal backdrop element has been created. The timeout here allows the modal
        // show function to complete, after which the modal backdrop will have been created
        // and appended to the DOM.
        window.setTimeout(function() {
            // we only want one backdrop; hide any extras
            if(modalIndex > 0)
                $('.modal-backdrop').not(':first').addClass('hidden');

            that.adjustBackdrop();
        });
    };

    MultiModal.prototype.hidden = function(target) {
        this.modalCount--;

        if(this.modalCount) {
           this.adjustBackdrop();
            // bootstrap removes the modal-open class when a modal is closed; add it back
            $('body').addClass('modal-open');
        }
    };

    MultiModal.prototype.adjustBackdrop = function() {
        var modalIndex = this.modalCount - 1;
        $('.modal-backdrop:first').css('z-index', MultiModal.BASE_ZINDEX + (modalIndex * 20));
    };

    function Plugin(method, target) {
        return this.each(function() {
            var $this = $(this);
            var data = $this.data('multi-modal-plugin');

            if(!data)
                $this.data('multi-modal-plugin', (data = new MultiModal(this)));

            if(method)
                data[method](target);
        });
    }

    $.fn.multiModal = Plugin;
    $.fn.multiModal.Constructor = MultiModal;

    $(document).on('show.bs.modal', function(e) {
        $(document).multiModal('show', e.target);
    });

    $(document).on('hidden.bs.modal', function(e) {
        $(document).multiModal('hidden', e.target);
    });
}(jQuery, window));