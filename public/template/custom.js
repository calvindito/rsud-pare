const swalInit = Swal.mixin({
    buttonsStyling: false,
    customClass: {
        confirmButton: 'btn bg-primary text-white',
        cancelButton: 'btn bg-danger text-white',
        denyButton: 'btn bg-light text-dark',
        input: 'form-control'
    }
});

Noty.overrideDefaults({
    theme: 'limitless',
    timeout: 2500
});

$(function() {
    configDataTable();
    formatNumber();
});

function configDataTable() {
    $.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        columnDefs: [{
            orderable: false,
            width: 100
        }],
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span class="me-1">Cari:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
            searchPlaceholder: 'Kata kunci...',
            lengthMenu: '<span class="me-1">Tampilkan:</span> _MENU_',
            paginate: {
                'first': 'Halawan Awal',
                'last': 'Halaman Akhir',
                'next': document.dir == "rtl" ? 'Sebelumnya' : 'Selanjutnya',
                'previous': document.dir == "rtl" ? 'Selanjutnya' : 'Sebelumnya'
            },
            emptyTable: 'Tidak ada data',
            info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
            infoEmpty: 'Menampilkan 0 sampai 0 dari 0 data',
            infoFiltered: '(Filtering dari _MAX_ total data)',
            loadingRecords: 'Memuat...',
            zeroRecords: 'Tidak ada data yang ditemukan',
            pageButton: 'btn btn-primary'
        }
    });
}

function onLoading(type, selector) {
    if(type == 'show') {
        $(selector).waitMe({
            effect : 'facebook',
            bg : 'rgba(255,255,255,0.7)',
            color : '#0C83FF',
            waitTime : -1,
            textPos : 'vertical'
        });
    } else if(type == 'close') {
        $(selector).waitMe('hide');
    }
}

function notification(type, text, layout = 'topCenter') {
    new Noty({
        layout: layout,
        text: text,
        type: type
    }).show();
}

function formatNumber() {
    $('.number-format').number(true, 2);
}
