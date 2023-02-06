window.gBaseUrl = '/';
window.gDataTable = '';

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
    select2Basic();
    setBaseUrl();

    $('.sidebar-control').on('click', function() {
        if(window.gDataTable) {
            gDataTable.columns.adjust().draw();
        }
    });
});

function setBaseUrl() {
    var fileSrc = $('meta[name="url"]').attr('content');

    if(fileSrc) {
        window.gBaseUrl = fileSrc;
    }
}

function configDataTable() {
    $.extend($.fn.dataTable.defaults, {
        autoWidth: false,
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

function select2Basic() {
    $('.select2-basic').select2({
        placeholder: '-- Pilih --',
        dropdownParent: $('.modal')
    });
}

function select2Ajax(selector, endpoint, onModal = true) {
    if(onModal) {
        var dropdownParent = $('.modal');
    } else {
        var dropdownParent = '';
    }

    $(selector).select2({
        placeholder: '-- Pilih --',
        dropdownParent: dropdownParent,
        minimumInputLength: 3,
        allowClear: true,
        cache: true,
        ajax: {
            url: window.gBaseUrl + '/serverside/' + endpoint,
            type: 'GET',
            dataType: 'JSON',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term
                };
            },
            processResults: function(data) {
                return { results: data }
            }
        }
    });
}

function sidebarMini() {
    $('.sidebar-main').addClass('sidebar-main-resized');
}

function onPopover(selector, content, title = '') {
    if($('.popover').length == 0) {
        var myPopover = new bootstrap.Popover($(selector), {
            container: 'body',
            trigger: 'focus',
            html: true,
            content: content,
            title: title,
            placement: 'auto'
        });

        myPopover.enable();
        myPopover.show();
    }
}

function fullWidthAllDevice() {
    $('meta[name="viewport"]').attr('content', 'width=1920, initial-scale=1, shrink-to-fit=no');
}

function listBox(selector, config = {}) {
    const listboxButtonsHiddenElement = document.querySelector(selector);

    new DualListbox(listboxButtonsHiddenElement, config);
}
