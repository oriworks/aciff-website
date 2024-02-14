<script setup>
    const props = defineProps({
        document: {
            id: String
        }
    });
</script>

<template>
    <button class="flex gap-2 items-center rounded bg-gray-600 px-2 py-1 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600" @click="toggle">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        </svg>
        <span>Ver</span>
    </button>
    <div v-if="open">
        <ComponentA :pages="pages" :close="close"/>
    </div>
</template>

<script>
    import ComponentA from './ComponentA.vue';

    export default {
        components: {
            ComponentA,
        },
        data() {
            return {
                open: false,
                pages: [],
            };
        },
        methods: {
            toggle: async function () {
                if (!this.open) {
                    await axios
                        .get(import.meta.env.VITE_APP_URL + '/historia/documentos/' + this.document.id)
                        .then(response => (this.pages = response.data))
                    this.open = !this.open;
                }
            },
            close: function () {
                this.open = false;
            },
        },
        mounted() {},
    };
</script>
