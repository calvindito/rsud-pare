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
    formatInputNumber();
    select2Basic();
    setBaseUrl();
    lightBox();
    initSwitcher();

    $('.sidebar-control').on('click', function() {
        if(window.gDataTable) {
            gDataTable.columns.adjust().draw();
        }
    });
});

function initSwitcher() {
    $('input[data-toggle="switcher"]').bootstrapToggle();
}

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
            searchPlaceholder: 'Kata kunci ...',
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
            loadingRecords: 'Memuat ...',
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

function formatInputNumber() {
    $('.number-format').number(true);
}

function select2Basic() {
    $('.select2-basic').select2({
        placeholder: '-- Pilih --',
        dropdownParent: $('.modal')
    });
}

function select2Ajax(selector, endpoint, onModal = true) {
    $(selector).select2({
        placeholder: '-- Pilih --',
        dropdownParent: onModal == true ? $('.modal') : '',
        minimumInputLength: 2,
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

function lightBox() {
    GLightbox({
        selector: '[data-bs-popup="lightbox"]',
        loop: false
    });
}

function dragAndDropFile(config = {}) {
    const previewZoomButtonClasses = {
        rotate: 'btn btn-light btn-icon btn-sm',
        toggleheader: 'btn btn-light btn-icon btn-header-toggle btn-sm',
        fullscreen: 'btn btn-light btn-icon btn-sm',
        borderless: 'btn btn-light btn-icon btn-sm',
        close: 'btn btn-light btn-icon btn-sm'
    };

    const previewZoomButtonIcons = {
        prev: document.dir == 'rtl' ? '<i class="ph-arrow-right"></i>' : '<i class="ph-arrow-left"></i>',
        next: document.dir == 'rtl' ? '<i class="ph-arrow-left"></i>' : '<i class="ph-arrow-right"></i>',
        rotate: '<i class="ph-arrow-clockwise"></i>',
        toggleheader: '<i class="ph-arrows-down-up"></i>',
        fullscreen: '<i class="ph-corners-out"></i>',
        borderless: '<i class="ph-frame-corners"></i>',
        close: '<i class="ph-x"></i>'
    };

    const fileActionSettings = {
        zoomClass: '',
        zoomIcon: '<i class="ph-magnifying-glass-plus"></i>',
        dragClass: 'p-2',
        dragIcon: '<i class="ph-dots-six"></i>',
        removeClass: '',
        removeErrorClass: 'text-danger',
        removeIcon: '<i class="ph-trash"></i>',
        indicatorNew: '<i class="ph-file-plus text-success"></i>',
        indicatorSuccess: '<i class="ph-check file-icon-large text-success"></i>',
        indicatorError: '<i class="ph-x text-danger"></i>',
        indicatorLoading: '<i class="ph-spinner spinner text-muted"></i>'
    };

    $('.file-input').fileinput({
        browseLabel: 'Browse',
        browseOnZoneClick: true,
        autoReplace: true,
        maxFileCount: config.maxFile,
        allowedFileExtensions: config.allowFile,
        browseIcon: '<i class="ph-file-plus me-2"></i>',
        uploadIcon: '<i class="ph-file-arrow-up me-2"></i>',
        removeIcon: '<i class="ph-x fs-base me-2"></i>',
        layoutTemplates: {
            icon: '<i class="ph-check"></i>'
        },
        uploadClass: 'btn btn-light',
        removeClass: 'btn btn-light',
        initialCaption: "No file selected",
        initialPreview: config.preview,
        initialPreviewConfig: config.previewConfig,
        initialPreviewAsData: true,
        overwriteInitial: true,
        previewZoomButtonClasses: previewZoomButtonClasses,
        previewZoomButtonIcons: previewZoomButtonIcons,
        fileActionSettings: fileActionSettings
    });
}

function textEditor(selector = '.text-editor', placeholder = 'Masukan sesuatu ...') {
    $(selector).summernote({
        placeholder: placeholder,
        height: 400,
        lang: 'id-ID',
        fontNames: ['Arial', 'Arial Black'],
        addDefaultFonts: false,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
}
