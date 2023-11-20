<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- UIkit CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.6.21/dist/css/uikit.min.css" />

        <!-- UIkit JS -->
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.6.21/dist/js/uikit.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.6.21/dist/js/uikit-icons.min.js"></script>
    </head>
    <body>
        <header uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky">
            <div class="uk-navbar-container uk-padding uk-padding-remove-vertical" uk-navbar='mode: hover'>
                <div class="uk-navbar-left">
                    <a class="uk-navbar-item uk-logo uk-padding-remove" href="/">
                        <img src="{{$entity->getFirstMediaUrl('logo')}}" height="100" alt="[{{$entity->name}}]" uk-img>
                    </a>
                </div>
                <div class="uk-navbar-right">
                    <x-side-menu />
                    <x-menu />
                </div>
            </div>
        </header>
        <div>
            <div class="uk-padding">
                {{ $slot }}
            </div>
            <footer class="uk-background-secondary uk-flex-center uk-padding" uk-grid>
                <div class="uk-width-1-4">
                    <h1 class="uk-light uk-text-small">Siga a {{ $entity->friendly_name }} em:</h1>
                </div>
                <div class="uk-width-1-4">
                    <h1 class="uk-light uk-text-small">Inscreva-se na nossa newsletter:</h1>
                    <form class="uk-form-stacked" id="newsletter-signup" method="POST" action="/newsletter/signup">
                        @csrf
                        <div class="uk-inline uk-light">
                            <span class="uk-form-icon" uk-icon="icon: mail"></span>
                            <input class="uk-input" name="email" type="text" placeholder="oseu@email.com">
                        </div>
                        <button class="uk-button uk-button-default uk-light">Inscrever</button>
                        <div class="uk-margin-small uk-margin-remove-horizontal">
                            <div id="newsletter-signup-error" class="uk-alert-danger">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="uk-width-1-4">
                    <h1 class="uk-light uk-text-small">Para resolução de conflitos de consumo contacte:</h1>
                    <p class="uk-light uk-text-small">Centro de Arbitragem de Conflitos de Consumo da Região de Coimbra<br>
                    Site: <a href="https://cacrc.pt/" target="blank">cacrc.pt</a></p>
                </div>
                <div class="uk-width-1-4">
                    <h1 class="uk-light uk-text-small">Copyright © {{ $entity->friendly_name }}</h1>
                    <p class="uk-light uk-text-small">Desenvolvido por:<br>
                        <a href="https://oriworks.com">
                            <img src="https://www.oriworks.com/img/oriworks.png" alt="[oriworks]" width="100">
                        </a>
                    </p>
                </div>
            </footer>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
        <script type="text/javascript">
            $('#newsletter-signup').on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    url: event.target.action,
                    type: event.target.method,
                    data: $(this).serializeArray().reduce((agg, {name, value}) => ({ ...agg, [name]: value}),{}),
                    error: function(response) {
                        UIkit.alert($('#newsletter-signup-error'), {
                            animation: true,
                            duration: 10,
                            'sel-close': '.uk-alert-close'
                        });
                    }
                });
            });
        </script>
    </body>
</html>