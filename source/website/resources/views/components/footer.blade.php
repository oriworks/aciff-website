<footer class="bg-secondary text-secondary text-sm shadow-md">
    <div class="container mx-auto flex flex-wrap justify-between px-3 py-8 gap-y-4">
        <div class="w-2/4 xl:w-3/12 pr-3">
            <h1>Siga a {{ $entity->friendly_name }} em:</h1>
            <p class="flex gap-2">
                @if ($entity->twitter)
                <a class="hover:text-twitter" target="_blank" href="https://twitter.com/{{$entity->twitter}}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                        <path
                            d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-.139 9.237c.209 4.617-3.234 9.765-9.33 9.765-1.854 0-3.579-.543-5.032-1.475 1.742.205 3.48-.278 4.86-1.359-1.437-.027-2.649-.976-3.066-2.28.515.098 1.021.069 1.482-.056-1.579-.317-2.668-1.739-2.633-3.26.442.246.949.394 1.486.411-1.461-.977-1.875-2.907-1.016-4.383 1.619 1.986 4.038 3.293 6.766 3.43-.479-2.053 1.08-4.03 3.199-4.03.943 0 1.797.398 2.395 1.037.748-.147 1.451-.42 2.086-.796-.246.767-.766 1.41-1.443 1.816.664-.08 1.297-.256 1.885-.517-.439.656-.996 1.234-1.639 1.697z" />
                    </svg>
                </a>
                @endif
                @if ($entity->facebook)
                <a class="hover:text-facebook" target="_blank" href="https://www.facebook.com/{{$entity->facebook}}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                        <path
                            d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-3 7h-1.924c-.615 0-1.076.252-1.076.889v1.111h3l-.238 3h-2.762v8h-3v-8h-2v-3h2v-1.923c0-2.022 1.064-3.077 3.461-3.077h2.539v3z" />
                    </svg>
                </a>
                @endif
                @if ($entity->instagram)
                <a class="fill-current hover:instagram" target="_blank" href="https://www.instagram.com/{{$entity->instagram}}">
                    <svg style="width:0;height:0;position:absolute;" aria-hidden="true" focusable="false">
                        <linearGradient id="instagram-gradient" x1="0%" y1="100%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="#f09433" />
                            <stop offset="25%" stop-color="#e6683c" />
                            <stop offset="50%" stop-color="#dc2743" />
                            <stop offset="75%" stop-color="#cc2366" />
                            <stop offset="100%" stop-color="#bc1888" />
                        </linearGradient>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24">
                        <path
                            d="M15.233 5.488c-.843-.038-1.097-.046-3.233-.046s-2.389.008-3.232.046c-2.17.099-3.181 1.127-3.279 3.279-.039.844-.048 1.097-.048 3.233s.009 2.389.047 3.233c.099 2.148 1.106 3.18 3.279 3.279.843.038 1.097.047 3.233.047 2.137 0 2.39-.008 3.233-.046 2.17-.099 3.18-1.129 3.279-3.279.038-.844.046-1.097.046-3.233s-.008-2.389-.046-3.232c-.099-2.153-1.111-3.182-3.279-3.281zm-3.233 10.62c-2.269 0-4.108-1.839-4.108-4.108 0-2.269 1.84-4.108 4.108-4.108s4.108 1.839 4.108 4.108c0 2.269-1.839 4.108-4.108 4.108zm4.271-7.418c-.53 0-.96-.43-.96-.96s.43-.96.96-.96.96.43.96.96-.43.96-.96.96zm-1.604 3.31c0 1.473-1.194 2.667-2.667 2.667s-2.667-1.194-2.667-2.667c0-1.473 1.194-2.667 2.667-2.667s2.667 1.194 2.667 2.667zm4.333-12h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm.952 15.298c-.132 2.909-1.751 4.521-4.653 4.654-.854.039-1.126.048-3.299.048s-2.444-.009-3.298-.048c-2.908-.133-4.52-1.748-4.654-4.654-.039-.853-.048-1.125-.048-3.298 0-2.172.009-2.445.048-3.298.134-2.908 1.748-4.521 4.654-4.653.854-.04 1.125-.049 3.298-.049s2.445.009 3.299.048c2.908.133 4.523 1.751 4.653 4.653.039.854.048 1.127.048 3.299 0 2.173-.009 2.445-.048 3.298z" />
                    </svg>
                </a>
                @endif
                @if ($entity->linked_in)
                <a class="hover:text-linkedIn" target="_blank" href="https://www.linkedin.com/company/aciff-associa%C3%A7%C3%A3o-comercial-e-industrial-da-figueira-da-foz/">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                        <path
                            d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                    </svg>
                </a>
                @endif
            </p>
        </div>
        <div class="w-2/4 xl:w-3/12 pr-3">
            <h1>Inscreva-se na nossa newsletter:</h1>
            <form id="newsletter-signup" action="{{ route('newsletter.signup') }}" method="post"
                class="flex flex-col gap-2 items-start">
                @csrf
                <label class="self-stretch">
                    <input type="email"
                        class="block w-full rounded-md bg-gray-100 text-aciff border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
                        name="email" placeholder="oseu@email.com">
                </label>
                <button type="submit" class="bg-gray-100 text-gray-600 py-2 px-4 rounded self-end">Inscrever</button>
            </form>
        </div>
        <div class="w-2/4 xl:w-3/12 pr-3">
            <a href="https://www.livroreclamacoes.pt/" target="_blank" class="hover:text-aciff">
                <img src="{{ asset('img/livro-reclamacoes-170x70-w.png') }}" alt="Livro de Reclamações">
            </a>
        </div>
        <div class="w-2/4 xl:w-3/12 pr-3">
            <h1>Copyright © {{ $entity->friendly_name }}</h1>
            <p>Desenvolvido por:<br>
                <a href="https://oriworks.com">
                    <img src="https://www.oriworks.com/img/oriworks.png" alt="[oriworks]" width="100">
                </a>
            </p>
        </div>
    </div>
    @push('scripts')
    <script>
        function makeSVG(tag, attrs) {
            var el = $(document.createElementNS('http://www.w3.org/2000/svg', tag));

            for (var k in attrs)
                el.attr(k, attrs[k]);
            return el;
        }

        $('#newsletter-signup').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: event.target.action,
                type: event.target.method,
                data: $(this).serializeArray().reduce((agg, {
                    name,
                    value
                }) => ({
                    ...agg,
                    [name]: value
                }), {}),
                success: function(xhr) {
                    console.log('success: ', xhr);
                    $('#toasts')
                        .append(
                            $('<div>', {
                                class: "bg-green-400 text-green-900 flex gap-2 justify-between items-center w-96 p-2 border-l-4 border-green-900"
                            })
                            .append(
                                $('<div>', {
                                    class: "flex gap-2 items-center"
                                })
                                .append(
                                    makeSVG('svg', {
                                        class: "h-5 w-5",
                                        'viewBox': "0 0 20 20",
                                        fill: "currentColor"
                                    }).append(
                                        makeSVG('path', {
                                            'fill-rule': "evenodd",
                                            d: "M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z",
                                            'clip-rule': "evenodd"
                                        })
                                    )
                                )
                                .append('<p />', {
                                    class: "cursor-default"
                                }).append(xhr.success))
                            .append(
                                makeSVG('svg', {
                                    'class': "h-6 w-6 cursor-pointer items-end",
                                    'fill': "none",
                                    'viewBox': "0 0 24 24",
                                    'stroke': "currentColor",
                                }).append(makeSVG('path', {
                                    'stroke-linecap': "round",
                                    'stroke-linejoin': "round",
                                    'stroke-width': "2",
                                    'd': "M6 18L18 6M6 6l12 12",
                                }))
                                .on('click', function(event) {
                                    $(this).parent().remove();
                                })
                            )
                        );
                },
                error: function(xhr) {
                    $('#toasts')
                        .append(
                            $('<div>', {
                                class: "bg-red-400 text-red-900 flex gap-2 justify-between items-center w-96 p-2 border-l-4 border-red-900"
                            })
                            .append(
                                $('<div>', {
                                    class: "flex gap-2 items-center"
                                })
                                .append(
                                    makeSVG('svg', {
                                        class: "h-5 w-5",
                                        'viewBox': "0 0 20 20",
                                        fill: "currentColor"
                                    }).append(
                                        makeSVG('path', {
                                            'fill-rule': "evenodd",
                                            d: "M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z",
                                            'clip-rule': "evenodd"
                                        })
                                    )
                                )
                                .append('<p />', {
                                    class: "cursor-default"
                                }).append(xhr.responseJSON.errors.email[0]))
                            .append(
                                makeSVG('svg', {
                                    'class': "h-6 w-6 cursor-pointer items-end",
                                    'fill': "none",
                                    'viewBox': "0 0 24 24",
                                    'stroke': "currentColor",
                                }).append(makeSVG('path', {
                                    'stroke-linecap': "round",
                                    'stroke-linejoin': "round",
                                    'stroke-width': "2",
                                    'd': "M6 18L18 6M6 6l12 12",
                                }))
                                .on('click', function(event) {
                                    $(this).parent().remove();
                                })
                            )
                        );
                }
            });
        });
    </script>
    @endpush
</footer>
