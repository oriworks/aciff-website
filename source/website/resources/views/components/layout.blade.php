<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @stack('meta')

    <title>{{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js','resources/js/standalone.js',])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="flex h-screen overflow-hidden bg-gray-100">
    <x-side-menu :menu="$menu" />
    <div class="flex flex-col flex-grow flex-shrink overflow-auto">
        <x-menu :menu="$menu" :entity="$entity" />
        <div class="flex-grow bg-gray-50">
            <div class="sticky container mx-auto top-18 px-3 flex flex-col items-end z-10">
                <div class="absolute top-3 right-3 flex flex-col gap-2" id="toasts">
                    @if(session()->has('success'))
                    <div
                        class="bg-green-400 text-green-900 flex gap-2 justify-between items-center w-96 p-2 border-l-4 border-green-900">
                        <div class="flex gap-2 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <p class="cursor-default">{{ session('success') }}</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer items-end alert-close"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    @endif
                </div>
            </div>
            {{ $slot }}
        </div>
        <x-footer :entity="$entity" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        {{-- <script>
            {!! Vite::content('resources/js/app.js') !!}
        </script> --}}
        <script>
            $('.share_popup').click(function (event) {
                event.preventDefault();
                const href = $(this).attr('href');
                window.open(href, '', 'height=400,width=600').focus();
            });
        </script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-198792183-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'UA-198792183-1');
        </script>
        <script>
            var alert_del = document.querySelectorAll('.alert-close');
            alert_del.forEach((x) =>
                x.addEventListener('click', function () {
                    x.parentElement.classList.add('hidden');
                })
            );
        </script>
        @stack('scripts')
</body>

</html>
