<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="dark" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<!-- Favicon icon-->
<script src="https://cdn.tiny.cloud/1/ucbbhja701oxqnbdgr0j3pabzgks4lk6simsn0047qsyv61m/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<link
  rel="shortcut icon"
  type="image/png"
  href="{{ asset('storage/images/logos/favicon.png') }}"
/>

<!-- Core Css -->
<link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />

  <title>Spike Bootstrap Admin</title>
  <!-- jvectormap  -->
  <link rel="stylesheet" href="{{ asset('assets/libs/jvectormap/jquery-jvectormap.css') }}">
</head>
<body>
    @include('Backend.components.preloader')

    <div id="main-wrapper">
        @include('Backend.includes.sidebar_1')

        <div class="page-wrapper">
            @include('Backend.includes.sidebar_2')

            <div class="body-wrapper">
                <div class="container-fluid">
                    @include('Backend.includes.header')

                    @yield('content')
                </div>
            </div>
            <script>
                function handleColorTheme(e) {
                $("html").attr("data-color-theme", e);
                $(e).prop("checked", !0);
                }
            </script>

            @include('Backend.components.setting_button')

            @include('Backend.components.customize_layout_table')
        </div>

        <div class="dark-transparent sidebartoggler"></div>
    </div>

    

    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <!-- Import Js Files -->
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.dark.init.js') }}"></script>
    <script src="{{ asset('assets/js/theme/theme.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/theme/feather.min.js') }}"></script>

    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script src="{{ asset('assets/libs/jvectormap/jquery-jvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/extra-libs/jvectormap/jquery-jvectormap-us-aea-en.js') }}"></script>
    <script src="{{ asset('assets/js/dashboards/dashboard.js') }}"></script>

    <script>
tinymce.init({
    selector: '#mytextarea',
    apiKey: 'ucbbhja701oxqnbdgr0j3pabzgks4lk6simsn0047qsyv61m',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker code',
    toolbar: 'undo redo | formatselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | image media link | code',
    height: 400,
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
    image_caption: true,
    image_advtab: true,
    media_live_embeds: true,
    automatic_uploads: true,
    images_upload_handler: function (blobInfo, success, failure) {
        let formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());

        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/admin/blog/upload_image', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        xhr.onload = function() {
            if (xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);
                let imageUrl = response.location; // URL của ảnh sau khi upload

                // Gọi hàm success với URL của ảnh đã upload
                success(imageUrl);
            } else {
                failure('Error uploading image: ' + xhr.statusText);
            }
        };

        xhr.onerror = function() {
            failure('Network error while uploading image.');
        };

        xhr.send(formData);
    },
    file_picker_callback: function(callback, value, meta) {
        if (meta.filetype === 'image') {
            let input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function() {
                let file = this.files[0];
                let reader = new FileReader();

                reader.onload = function(e) {
                    let base64 = e.target.result; // Chuỗi base64 của ảnh

                    // Gọi callback với base64 của ảnh
                    callback(base64, { title: file.name });
                };

                reader.readAsDataURL(file); // Đọc file dưới dạng base64
            };
            input.click();
        }
    }
});
    </script>
</body>
</html>