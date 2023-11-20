<x-layout>
    <div class="container mx-auto p-3 flex flex-col gap-4" x-data="setup()">
        <div class="flex flex-col my-4 gap-4 text-content">
            <div class="flex-grow flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-aciff">{{ $page->subject }}</h1>
                @auth
                <a href="/nova/resources/pages/{{$page->id}}/edit" target="_blank"
                    class="bg-aciff rounded text-white no-underline p-2 hover:text-white">Editar</a>
                @endauth
            </div>
            <div>
                <div class="sm:hidden">
                    <label for="tabs" class="sr-only">Select a tab</label>
                    <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                    <select id="tabs" name="tabs" x-model="activeTab"
                        class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <template x-for="(tab, index) in tabs" :key="index">
                            <option x-text="tab"></option>
                        </template>
                    </select>
                </div>
                <div class="hidden sm:block">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                            <template x-for="(tab, index) in tabs" :key="index">
                                <p class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm cursor-pointer"
                                    :class="activeTab===tab ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    @click="activeTab = tab" x-text="tab"></p>
                            </template>
                            <!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" -->
                        </nav>
                    </div>
                </div>
                <div class="w-full bg-white p-16 text-center mx-auto border">
                    <x-protocols-and-partnerships tab="Parcerias" :protocols="$partnerships" />
                    <x-protocols-and-partnerships tab="Protocolos" :protocols="$protocols" />
                </div>
            </div>
        </div>

        <div @keydown.window.escape="open = false" x-show="open" class="opacity-0"
            :class="open && 'fixed z-10 inset-0 overflow-y-auto opacity-100'" aria-labelledby="modal-title"
            x-ref="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    x-description="Background overlay, show/hide based on modal state."
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="open = false"
                    aria-hidden="true">
                </div>
                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
                <div x-show="open" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-description="Modal panel, show/hide based on modal state."
                    class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle w-2/3 sm:p-6">
                    <div>
                        <img :src="modalData.img" class="mx-auto max-w-xs" />
                        <div class="mt-3 sm:mt-5">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title"
                                x-text="modalData.name">
                            </h3>
                            <div class="grid grid-cols-table gap-2">
                                @for ($i = 0; $i < 5; $i++) <b x-show="modalData.contacts && modalData.contacts[{{$i}}]"
                                    x-text="modalData.contacts && modalData.contacts[{{$i}}] && modalData.contacts[{{$i}}].name">
                                    </b>
                                    <p x-show="modalData.contacts && modalData.contacts[{{$i}}]"
                                        x-text="modalData.contacts && modalData.contacts[{{$i}}] && modalData.contacts[{{$i}}].value">
                                    </p>
                                    @endfor
                                    @for ($i = 0; $i < 5; $i++) <b
                                        x-show="modalData.addresses && modalData.addresses[{{$i}}]"
                                        x-text="modalData.addresses && modalData.addresses[{{$i}}] && modalData.addresses[{{$i}}].name">
                                        </b>
                                        <p x-show="modalData.addresses && modalData.addresses[{{$i}}]"
                                            x-html="modalData.addresses && modalData.addresses[{{$i}}] && modalData.addresses[{{$i}}].value">
                                        </p>
                                        @endfor
                                        <b x-show="modalData.benefits">Benefício:</b>
                                        <p x-show="modalData.benefits" x-html="modalData.benefits"></p>
                                        <b x-show="modalData.comments">Obs:</b>
                                        <p x-show="modalData.comments" x-html="modalData.comments"></p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6">
                        <button type="button"
                            class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm"
                            @click="open = false">
                            Fechar
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        function setup() {
            return {
                open: false,
                activeTab: "Protocolos",
                tabs: [
                    "Protocolos",
                    "Parcerias",
                ],
                modalData: {}
            };
        };
    </script>
    @endpush
</x-layout>
