<div class="w-9/12 mx-auto">
    <form class="grid grid-cols-2 gap-x-6 gap-y-2 p-3" method="POST" action="{{ route('suggestion.store') }}">
        @csrf
        <h2 class="text-xl font-semibold text-aciff col-span-2">Deixe o seu comentário ou sugestão:</h2>
        <x-input :required="true" label="Nome" name="name"></x-input>
        <x-input type="tel" :required="true" label="Contacto telf." name="phone"></x-input>
        <x-input :full="true" type="email" :required="true" label="Email" name="email"></x-input>
        @php
            $options = $departments->map(function ($department, $key) {
                return [
                    'name' => $department->friendly_name,
                    'value' => $department->id
                ];
            });
        @endphp
        <x-select :full="true" :required="true" label="Para" name="department_id" :options="$options">
        </x-select>
        <x-input :full="true" :required="true" label="Assunto" name="subject"></x-input>
        <x-textarea :full="true" :required="true" label="Mensagem" name="content"></x-textarea>
        <button type="submit"
            class="col-span-2 bg-white text-aciff border border-aciff rounded hover:bg-aciff hover:text-white py-2 mt-4">Enviar</button>
    </form>
</div>
