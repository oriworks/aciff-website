    @csrf
    <h2 class="text-xl font-semibold text-aciff col-span-2">Preencha o seguinte formulário com o seu pedido:</h2>
    <x-input :required="true" label="Nome" name="name"></x-input>
    <x-input type="tel" :required="true" label="Contacto telf." name="phone"></x-input>
    <x-input :full="true" type="email" :required="true" label="Email" name="email"></x-input>
    <x-textarea :full="true" :required="true" label="Mensagem" name="content"></x-textarea>
