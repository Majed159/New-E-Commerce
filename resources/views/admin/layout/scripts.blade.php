<!--begin::Script-->
<!--begin::Third Party Plugin(OverlayScrollbars)-->
<script
    src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
    crossorigin="anonymous"
></script>
<!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
<script
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    crossorigin="anonymous"
></script>
<!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
    crossorigin="anonymous"
></script>
<!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
<script src="{{asset('admin/js/adminlte.js')}}"></script>
<!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
<script>
    const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
    const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
    };
    document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined) {
            OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                scrollbars: {
                    theme: Default.scrollbarTheme,
                    autoHide: Default.scrollbarAutoHide,
                    clickScroll: Default.scrollbarClickScroll,
                },
            });
        }
    });
</script>
<!--end::OverlayScrollbars Configure-->
<!-- OPTIONAL SCRIPTS -->
<!-- sortablejs -->
<script
    src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"
    crossorigin="anonymous"
></script>
<!-- sortablejs -->
<script>
    const sortableEl = document.querySelector('.connectedSortable');
    if (sortableEl && window.Sortable) {
        new Sortable(sortableEl, {
            group: 'shared',
            handle: '.card-header',
        });

        const cardHeaders = document.querySelectorAll('.connectedSortable .card-header');
        cardHeaders.forEach((cardHeader) => {
            cardHeader.style.cursor = 'move';
        });
    }
</script>
<!-- apexcharts -->
<script
    src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
    integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8="
    crossorigin="anonymous"
></script>
<!-- ChartJS -->
<script>
    // NOTICE!! DO NOT USE ANY OF THIS JAVASCRIPT
    // IT'S ALL JUST JUNK FOR DEMO
    // ++++++++++++++++++++++++++++++++++++++++++

    const sales_chart_options = {
        series: [
            {
                name: 'Digital Goods',
                data: [28, 48, 40, 19, 86, 27, 90],
            },
            {
                name: 'Electronics',
                data: [65, 59, 80, 81, 56, 55, 40],
            },
        ],
        chart: {
            height: 300,
            type: 'area',
            toolbar: {
                show: false,
            },
        },
        legend: {
            show: false,
        },
        colors: ['#0d6efd', '#20c997'],
        dataLabels: {
            enabled: false,
        },
        stroke: {
            curve: 'smooth',
        },
        xaxis: {
            type: 'datetime',
            categories: [
                '2023-01-01',
                '2023-02-01',
                '2023-03-01',
                '2023-04-01',
                '2023-05-01',
                '2023-06-01',
                '2023-07-01',
            ],
        },
        tooltip: {
            x: {
                format: 'MMMM yyyy',
            },
        },
    };

    const revenueChartEl = document.querySelector('#revenue-chart');
    if (revenueChartEl && window.ApexCharts) {
        const sales_chart = new ApexCharts(
            revenueChartEl,
            sales_chart_options,
        );
        sales_chart.render();
    }
</script>
<!-- jsvectormap -->
<script
    src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"
    integrity="sha256-/t1nN2956BT869E6H4V1dnt0X5pAQHPytli+1nTZm2Y="
    crossorigin="anonymous"
></script>
<script
    src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js"
    integrity="sha256-XPpPaZlU8S/HWf7FZLAncLg2SAkP8ScUTII89x9D3lY="
    crossorigin="anonymous"
></script>
<!-- jsvectormap -->
<script>
    // World map by jsVectorMap
    const worldMapEl = document.querySelector('#world-map');
    if (worldMapEl && window.jsVectorMap) {
        new jsVectorMap({
            selector: '#world-map',
            map: 'world',
        });
    }

    // Sparkline charts
    const option_sparkline1 = {
        series: [
            {
                data: [1000, 1200, 920, 927, 931, 1027, 819, 930, 1021],
            },
        ],
        chart: {
            type: 'area',
            height: 50,
            sparkline: {
                enabled: true,
            },
        },
        stroke: {
            curve: 'straight',
        },
        fill: {
            opacity: 0.3,
        },
        yaxis: {
            min: 0,
        },
        colors: ['#DCE6EC'],
    };

    const sparkline1El = document.querySelector('#sparkline-1');
    if (sparkline1El && window.ApexCharts) {
        const sparkline1 = new ApexCharts(sparkline1El, option_sparkline1);
        sparkline1.render();
    }

    const option_sparkline2 = {
        series: [
            {
                data: [515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921],
            },
        ],
        chart: {
            type: 'area',
            height: 50,
            sparkline: {
                enabled: true,
            },
        },
        stroke: {
            curve: 'straight',
        },
        fill: {
            opacity: 0.3,
        },
        yaxis: {
            min: 0,
        },
        colors: ['#DCE6EC'],
    };

    const sparkline2El = document.querySelector('#sparkline-2');
    if (sparkline2El && window.ApexCharts) {
        const sparkline2 = new ApexCharts(sparkline2El, option_sparkline2);
        sparkline2.render();
    }

    const option_sparkline3 = {
        series: [
            {
                data: [15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21],
            },
        ],
        chart: {
            type: 'area',
            height: 50,
            sparkline: {
                enabled: true,
            },
        },
        stroke: {
            curve: 'straight',
        },
        fill: {
            opacity: 0.3,
        },
        yaxis: {
            min: 0,
        },
        colors: ['#DCE6EC'],
    };

    const sparkline3El = document.querySelector('#sparkline-3');
    if (sparkline3El && window.ApexCharts) {
        const sparkline3 = new ApexCharts(sparkline3El, option_sparkline3);
        sparkline3.render();
    }
</script>
<script src="{{url('admin/js/jquery-3.7.1.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script src="{{url('admin/js/Custom.js')}}"></script>
<!--Datatable -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css"/>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>


<script>
    $(document).ready(function (){
        $("#Category").DataTable();

       $("#subadmins").DataTable();
       $("#products").DataTable();
    });

</script>
<!-- Dropzone CSS-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" rel="stylesheet">

<!-- Dropzone JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        // Prevent the browser from opening a file when it is dropped on the page.
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(function (eventName) {
            document.addEventListener(eventName, function (event) {
                if (event.dataTransfer && Array.from(event.dataTransfer.types || []).includes('Files')) {
                    event.preventDefault();
                }
            });
        });

        function escapeHtml(value) {
            return String(value).replace(/[&<>"']/g, function (char) {
                return ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                })[char];
            });
        }

        function getZoneContent(zone) {
            let content = zone.querySelector('[data-upload-content="true"]');
            if (!content) {
                content = document.createElement('div');
                content.setAttribute('data-upload-content', 'true');
                zone.appendChild(content);
            }
            return content;
        }

        function renderIdleState(zone, message) {
            const content = getZoneContent(zone);
            content.innerHTML = '<div class="dz-message needsclick text-muted">' + escapeHtml(message) + '</div>';
        }

        function renderUploadedState(zone, file, type, hiddenInput, message) {
            const objectUrl = URL.createObjectURL(file);
            const content = getZoneContent(zone);
            const preview = type === 'image'
                ? '<img src="' + objectUrl + '" alt="" style="max-width: 100%; max-height: 180px; border-radius: 8px; margin-bottom: 12px;">'
                : '<video controls style="max-width: 100%; max-height: 180px; border-radius: 8px; margin-bottom: 12px;"><source src="' + objectUrl + '"></video>';

            content.innerHTML = [
                '<div class="text-center p-3">',
                preview,
                '<div class="fw-semibold mb-2">' + escapeHtml(file.name) + '</div>',
                '<div class="small text-success mb-3">' + escapeHtml(message) + '</div>',
                '<button type="button" class="btn btn-sm btn-outline-secondary" data-remove-upload="true">Remove</button>',
                '</div>'
            ].join('');

            const removeButton = content.querySelector('[data-remove-upload="true"]');
            if (removeButton) {
                removeButton.addEventListener('click', function (event) {
                    event.stopPropagation();
                    if (hiddenInput) {
                        hiddenInput.value = '';
                    }
                    renderIdleState(zone, type === 'image'
                        ? 'Drag & drop product image or click to upload'
                        : 'Drag & drop product video or click to upload');
                });
            }
        }

        function showUploadingState(zone, fileName) {
            const content = getZoneContent(zone);
            content.innerHTML = '<div class="text-center text-muted p-4">Uploading ' + escapeHtml(fileName) + '...</div>';
        }

        function uploadFile(config, file) {
            const zone = document.getElementById(config.zoneId);
            const hiddenInput = document.getElementById(config.hiddenInputId);

            if (!zone || !hiddenInput || !file) {
                return;
            }

            if (config.acceptPrefix && !file.type.startsWith(config.acceptPrefix)) {
                alert(config.invalidTypeMessage);
                return;
            }

            if ((file.size / 1024 / 1024) > config.maxFileSizeMb) {
                alert(config.maxSizeMessage);
                return;
            }

            const formData = new FormData();
            formData.append('file', file);

            showUploadingState(zone, file.name);

            fetch(config.uploadUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
                .then(function (response) {
                    if (!response.ok) {
                        return response.json().catch(function () {
                            return {};
                        }).then(function (data) {
                            throw new Error(data.error || data.message || 'Upload failed.');
                        });
                    }

                    return response.json();
                })
                .then(function (data) {
                    hiddenInput.value = data.fileName || '';
                    renderUploadedState(zone, file, config.type, hiddenInput, 'Upload completed');
                })
                .catch(function (error) {
                    hiddenInput.value = '';
                    renderIdleState(zone, config.idleMessage);
                    alert(error.message || 'Upload failed.');
                });
        }

        function setupNativeDropArea(config) {
            const zone = document.getElementById(config.zoneId);
            const hiddenInput = document.getElementById(config.hiddenInputId);

            if (!zone || !hiddenInput) {
                return;
            }

            zone.style.cursor = 'pointer';
            zone.style.transition = 'border-color 0.2s ease, background-color 0.2s ease';
            renderIdleState(zone, config.idleMessage);

            let fileInput = zone.querySelector('[data-upload-input="true"]');
            if (!fileInput) {
                fileInput = document.createElement('input');
                fileInput.type = 'file';
                fileInput.accept = config.accept;
                fileInput.hidden = true;
                fileInput.setAttribute('data-upload-input', 'true');
                zone.appendChild(fileInput);
            }

            function activateZone() {
                zone.style.borderColor = '#0d6efd';
                zone.style.backgroundColor = '#f4f8ff';
            }

            function resetZone() {
                zone.style.borderColor = '';
                zone.style.backgroundColor = '';
            }

            zone.addEventListener('click', function (event) {
                if (event.target.closest('[data-remove-upload="true"]')) {
                    return;
                }

                fileInput.click();
            });

            zone.addEventListener('dragenter', function (event) {
                event.preventDefault();
                activateZone();
            });

            zone.addEventListener('dragover', function (event) {
                event.preventDefault();
                activateZone();
            });

            zone.addEventListener('dragleave', function (event) {
                event.preventDefault();
                if (!zone.contains(event.relatedTarget)) {
                    resetZone();
                }
            });

            zone.addEventListener('drop', function (event) {
                event.preventDefault();
                resetZone();

                const files = event.dataTransfer?.files;
                if (files && files.length > 0) {
                    uploadFile(config, files[0]);
                    fileInput.value = '';
                }
            });

            fileInput.addEventListener('change', function () {
                if (fileInput.files && fileInput.files.length > 0) {
                    uploadFile(config, fileInput.files[0]);
                }
                fileInput.value = '';
            });
        }

        setupNativeDropArea({
            zoneId: 'mainImageDropzone',
            hiddenInputId: 'main_image_hidden',
            uploadUrl: "{{ route('product.upload.image') }}",
            accept: 'image/*',
            acceptPrefix: 'image/',
            type: 'image',
            maxFileSizeMb: 1,
            idleMessage: 'Drag & drop product image or click to upload',
            invalidTypeMessage: 'Please upload an image file only.',
            maxSizeMessage: 'Image must be 1 MB or smaller.'
        });

        setupNativeDropArea({
            zoneId: 'productVideoDropzone',
            hiddenInputId: 'product_video_hidden',
            uploadUrl: "{{ route('product.upload.video') }}",
            accept: 'video/*',
            acceptPrefix: 'video/',
            type: 'video',
            maxFileSizeMb: 10,
            idleMessage: 'Drag & drop product video or click to upload',
            invalidTypeMessage: 'Please upload a video file only.',
            maxSizeMessage: 'Video must be 10 MB or smaller.'
        });
        let productImagesDropzone = new Dropzone("#productImagesDropzone",{
            url: "{{route('product.upload.image')}}",
            maxFiles:10,
            acceptedFiles:"image/*",
            paralleUploads:10,
            uploadMultiple:false,
            maxFilesize: 1,
            addRemoveLinks: true,
            dictDefaultMessage:"Drag & drop product images or click to upload",
            headers:{
                'X-CSRF-TOKEN':"{{csrf_token()}}"
            },
            init:function () {
                this.on("success",function (file,response) {
                    let hiddenInput = document.getElementById('product_images_hidden');
                    let currentVal = hiddenInput.value;

                    if(currentVal ===''){
                        hiddenInput.value = response.fileName;
                    }else{
                     hiddenInput.value = currentVal +','+response.fileName;
                    }
                    file.uploadedFileName = response.fileName;
                });
                this.on("removedfile",function (file){
                    if(file.uploadedFileName){
                        let hiddenInput = document.getElementById('product_images_hidden');
                        let currentVal = hiddenInput.value;
                        let files = currentVal.split(',');

                        files = files.filter(name =>name !== file.uploadedFileName);
                        hiddenInput.value = files.join(',');

                        $.ajax({
                            url: "{{route('product.delete.temp.image')}}",
                            type: 'POST',
                            data: {filename: file.uploadedFileName},
                            headers: {
                                'X-CSRF-TOKEN':"{{csrf_token()}}"
                            }
                        });
                    }
                });
            }
        });
    });
</script>
