@inject('service', 'App\Services\AdminPanel\SiteSettingService')

@if ($service->getValueVariable('redaktor-tiny-url'))
    <script>
        tinymce.init({
            selector: '#page_description',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight numlist bullist indent outdent | emoticons charmap | removeformat',
            language_url: '/vendor/tinymce/lang/ru.js',
            language: 'ru',
        });
    </script>
@endif
