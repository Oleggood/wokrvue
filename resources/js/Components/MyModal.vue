<template>
    <div v-if="show" @click="hideDialog" @keyup.esc="hideDialog" class="dialog inset-0 fixed flex">
        <div @click.stop class="flex bg-gray-200 rounded-md md:w-1/3 sm:w-full m-auto pt-6 pb-10">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: "MyModal",
    props: {
        show: {
            type: Boolean,
            deafult: false,
        }
    },
    methods: {
        hideDialog() {
            this.$emit('update:show', false); // закрытие диалогового окна при клике в область рядом
        },
    }
}
</script>

<style scoped>
.dialog {
    background: rgba(0, 0, 0, 0.7);
}
</style>
