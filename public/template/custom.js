window.baseUrl = '/';

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
        gDataTable.columns.adjust().draw();
    });
});

function setBaseUrl() {
    var fileSrc = $('meta[name="url"]').attr('content');

    if(fileSrc != undefined) {
        var queryParam = paramFile(fileSrc);

        if(queryParam.length > 0) {
            var domain = queryParam.find(domain => domain.key == 'domain');
            window.baseUrl = domain.value + '/';
        } else {
            return false;
        }
    }
}

function paramFile(url) {
    var vars = [], hash;
    if(url == undefined || url.indexOf('?') ==  -1) {
        return vars;
    }

    var hashes = url.slice(url.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push({key: hash[0], value: hash[1]});
    }

    return vars;
}

function configDataTable() {
    $.extend( $.fn.dataTable.defaults, {
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
            url: window.baseUrl + 'serverside/' + endpoint,
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
