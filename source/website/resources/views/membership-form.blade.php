<x-layout>
    @if (isset($page))
    <div class="container mx-auto p-3 flex flex-col gap-4 text-content">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-aciff">{{ $page->subject }}</h1>
            @auth
            <a href="/nova/resources/pages/{{$page->id}}/edit" target="_blank"
                class="bg-aciff rounded text-white no-underline p-2 hover:text-white">Editar</a>
            @endauth
        </div>
        {!! $page->content !!}
        <div class="w-9/12 mx-auto">
            <form class="grid grid-cols-2 gap-x-6 gap-y-2 p-3" method="POST" action="{{ route('associate.store') }}">
                @csrf
                <h2 class="text-xl font-semibold text-aciff col-span-2">Empresa:</h2>
                <x-input :full="true" :required="true" label="Designação Social" name="social_designation">
                </x-input>
                <x-textarea :full="true" :required="true" label="Morada" name="address"></x-textarea>
                <x-input :required="true" label="Concelho" name="county"></x-input>
                <x-input :required="true" label="Freguesia" name="parish"></x-input>
                <x-input :required="true" label="Código Postal" name="zip_code"></x-input>
                <x-input :required="true" label="Localidade" name="locality"></x-input>
                <x-input type="tel" :required="true" label="Contacto telf." name="phone"></x-input>
                <x-input type="tel" :required="false" label="Fax" name="fax"></x-input>
                <x-input :full="true" :required="false" label="Website" name="website"></x-input>
                <x-input :full="true" type="email" :required="true" label="Email" name="email"></x-input>
                <x-input :required="true" label="Nº id fiscal" name="nif"></x-input>
                <x-input :required="true" label="CAE" name="cae"></x-input>
                @php
                    $legal = collect([
                        ['value' => 'plc', 'name' => __('Private limited company') ],
                        ['value' => 'as', 'name' => __('Anonymous society') ],
                        ['value' => 'ip', 'name' => __('Individual entrepreneur') ],
                        ['value' => 'llc', 'name' => __('One-person limited liability company') ],
                    ]);
                @endphp
                <x-select :full="true" :required="true" label="Forma Jurídica" name="legal" :options="$legal">
                </x-select>
                <x-input :required="true" label="Actividade" name="activity"></x-input>
                <x-input :required="true" label="Capital Social" name="joint_stock"></x-input>
                <x-input :required="true" label="Nº de Sócios" name="num_associates"></x-input>
                <x-input :required="true" label="Nº de Func." name="num_employees"></x-input>
                <h2 class="text-xl font-semibold text-aciff col-span-2">Pessoa a Contactar:</h2>
                <x-input :required="true" label="Nome" name="contact_name"></x-input>
                <x-input :required="true" label="Cargo" name="contact_job"></x-input>
                <x-input :required="true" label="Contacto telf." name="contact_phone"></x-input>
                <x-input :required="true" label="Email" name="contact_email"></x-input>
                <h2 class="text-xl font-semibold text-aciff col-span-2">Pagamento de Quotas:</h2>
                @php
                    $paymentPeriodicity = collect([
                        ['value' => 'yearly', 'name' => __('Yearly') ],
                        ['value' => 'semiannual', 'name' => __('Semiannual') ],
                        ['value' => 'quarterly', 'name' => __('Quarterly') ],
                    ]);
                @endphp
                <x-select :required="true" label="Periodicidade" name="payment_periodicity" :options="$paymentPeriodicity">
                </x-select>
                @php
                    $paymentTypes = collect([
                        ['name' => __('In Store'), 'value' => 'in_store'],
                        ['name' => __('Bank Transfer'), 'value' => 'bank_transfer'],
                    ]);
                @endphp
                <x-select :required="true" label="Tipo Pagam." name="payment_type" :options="$paymentTypes"></x-select>

                <div class="col-span-2">
                    <div class="relative flex items-start">
                        <div class="flex items-center h-5">
                            @if (old("consent"))
                                <input id="consent" aria-describedby="consent-description" name="consent" value="1" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" checked>
                            @else
                                <input id="consent" aria-describedby="consent-description" name="consent" value="1" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                            @endif
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="consent" class="font-medium text-gray-700">
                                <p id="consent-description" class="text-gray-500">Autorizo que os dados da empresa que represento (nome, morada, email e telefone) sejam processados informaticamente e utilizados pela ACIFF - Associação Comercial e Industrial da Figueira da Foz para fins informativos e promocionais.</p>
                            </label>
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="col-span-2 bg-white text-aciff border border-aciff rounded hover:bg-aciff hover:text-white py-2 mt-4">Enviar</button>
            </form>
        </div>
    </div>
    @endif
</x-layout>
