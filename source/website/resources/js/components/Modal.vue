<template>
    <transition name="modal">
        <div class="modal-mask" v-on:click.self="close" v-show="show">
            <div class="modal-container">
                <form class="grid grid-cols-2 gap-x-6 gap-y-2 p-3" v-on:submit="submit">
                    <slot></slot>
                    <button type="submit"
        class="col-span-2 bg-white text-aciff border border-aciff rounded hover:bg-aciff hover:text-white py-2 mt-4">Enviar</button>
                </form>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    props: ['show'],

    mounted: function () {
        document.addEventListener("keydown", (e) => {
            if (this.show && e.keyCode == 27) {
                this.close()
            }
        })
    },
    methods: {
        close: function() {
            this.$emit('close')
        },
        submit: function(e) {
            e.preventDefault()
            const formData = new FormData(event.target);
            // console.log({...formData});
            this.$emit('close')
        }
    }
}
</script>
<style scoped>
* {
    box-sizing: border-box;
}
.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .5);
    transition: opacity .3s ease;
    overflow-x: auto;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.modal-container {
    width: 75%;
    margin: auto;
    padding: 20px 30px;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
    transition: all .3s ease;
}
.modal-body {
    margin: 20px 0;
}
/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */
.modal-enter {
  opacity: 0;
}
.modal-leave-active {
  opacity: 0;
}
.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>
