<template>
    <admin-main>
        <div class="max-w-[60%] flex justify-center">
            <h3 class="text-lg font-semibold">Статусы задач</h3>
        </div>

        <!--preloader-->
        <div v-if="isLoading" class="inset-0 fixed flex">
            <div class="m-auto text-red-700 text-xl">
                <svg xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="64px" height="64px"
                     viewBox="0 0 128 128" xml:space="preserve"><g><path d="M82.4 32.2a37.52 37.52 0 0 0-55 25.13L16.97 42.97.92 52.44A64.42 64.42 0 0 1 101.07 12.2l-.26 17.93z" fill="#ff8600"/><path
                    d="M82.4 32.2a37.52 37.52 0 0 0-55 25.13L16.97 42.97.92 52.44A64.42 64.42 0 0 1 101.07 12.2l-.26 17.93z"
                    fill="#ff8600" transform="rotate(120 64 64)"/><path
                    d="M82.4 32.2a37.52 37.52 0 0 0-55 25.13L16.97 42.97.92 52.44A64.42 64.42 0 0 1 101.07 12.2l-.26 17.93z"
                    fill="#ff8600" transform="rotate(240 64 64)"/><animateTransform attributeName="transform"
                                                                                    type="rotate" from="0 64 64"
                                                                                    to="120 64 64" dur="720ms"
                                                                                    repeatCount="indefinite"></animateTransform></g></svg>
            </div>
        </div>
        <!--/preloader-->

        <!--index-->
        <div v-if="statuses.length > 0" class="mt-6">
            <table class="border-collapse border border-slate-500 min-w-[60%]">
                <thead class="bg-gray-200">
                <th class="border border-slate-600 py-3">ID</th>
                <th class="border border-slate-600 py-3">Статус</th>
                <th class="border border-slate-600 py-3">Действия</th>
                </thead>
                <tbody>
                <tr v-for="stat in statuses" :key="stat.id">
                    <td class="border border-slate-700 text-center">{{ stat.id }}</td>
                    <td class="border border-slate-700 text-center">{{ stat.status }}</td>
                    <td class="border border-slate-700 text-center py-2">
                        <secondary-button @click.prevent="showUpdateDialog(stat)" class="mr-2">
                            изменить
                        </secondary-button>
                        <danger-button @click.prevent="showDeleteDialog(stat)" class="ml-2">
                            удалить
                        </danger-button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <h3 v-else class="mt-6 text-gray-900">Здесь пока пусто, добавьте запись...</h3>
        <!--/index-->

        <!--create-->
        <div class="max-w-[40%]">
            <form class="flex flex-col mt-6" @submit.prevent="store">
                <InputLabel for="new_status" value="Добавить новый статус:"/>
                <TextInput
                    id="new_status"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="formLocal.status"
                />
                <div class="mt-6">
                    <primary-button>
                        Добавить статус
                    </primary-button>
                </div>
            </form>
        </div>
        <!--/create-->

        <!--update Modal-->
        <my-modal v-model:show="updateDialogVisible">
            <div class="md:ml-16 sm:ml-4 min-w-[80%]">
                <div class="flex flex-col mt-6">
                    <InputLabel for="current_status" value="Изменить статус:"/>
                    <TextInput
                        id="current_status"
                        type="text"
                        class="mt-1 block w-full"
                        autofocus
                        v-model="currentStatus"
                    />
                    <div class="flex justify-around mt-6">
                        <primary-button type="submit" @click="update(currentStatus, id)">
                            сохранить
                        </primary-button>
                        <secondary-button @click="hiddenUpdateDialog">отмена</secondary-button>
                    </div>
                </div>
            </div>
        </my-modal>
        <!--/update Modal-->

        <!--delete Modal-->
        <my-modal v-model:show="deleteDialogVisible">
            <div class="flex mx-auto flex-col">
                <div class="my-6"><span>Вы уверены, что хотите удалить {{ stat.status }}</span></div>
                <div class="flex justify-around mb-4">
                    <text-input autofocus class="w-0"></text-input> <!--нужен для закрытия модалки при нажатии ESC-->
                    <secondary-button autofocus @click="hiddenDeleteDialog">отмена</secondary-button>
                    <danger-button @click="del(stat.id)">удалить</danger-button>
                </div>
            </div>
        </my-modal>
        <!--/delete Modal-->

    </admin-main>
</template>

<script>
import AdminMain from "@/Layouts/AdminMain.vue";
import {Link} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import NavLink from "@/Components/NavLink.vue";
import TextInput from "@/Components/TextInput.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Modal from "@/Components/Modal.vue";
import MyModal from "@/Components/MyModal.vue";
// import {reactive} from "vue";

export default {
    name: 'Status',
    components: {
        MyModal,
        Modal,
        DangerButton,
        SecondaryButton,
        AdminMain,
        Link,
        PrimaryButton,
        InputLabel,
        NavLink,
        TextInput,
    },

    data() {
        return {
            currentStatus: '',
            updateDialogVisible: false,
            deleteDialogVisible: false,
            isLoading: false,
            form: this.$inertia.form({}),
            formLocal: {'id': '', 'status': ''},
        }
    },

    props: [
        'statuses',
        'status',
    ],
    methods: {
        store() {
            this.isLoading = true;
            this.form = this.$inertia.form(this.formLocal);
            this.form.post('/admin/status', {
                onFinish: () => {
                    this.isLoading = false;
                    this.formLocal = '';
                }
            });
        },

        showUpdateDialog(stat) {
            this.updateDialogVisible = true;
            this.stat = stat;
            this.currentStatus = stat.status;
            this.id = stat.id;
        },

        hiddenUpdateDialog() {
            this.updateDialogVisible = false;
        },

        update(currentStatus, id) {
            this.isLoading = true;
            this.$inertia.patch(`/admin/status/${id}`, {status: this.currentStatus}); //!!!!КАВЫЧКИ - на Ё!!!!
            this.updateDialogVisible = false;
            this.isLoading = false;
        },

        showDeleteDialog(stat) {
            this.deleteDialogVisible = true;
            this.stat = stat;
        },

        hiddenDeleteDialog() {
            this.deleteDialogVisible = false;
        },

        del(id) {
            this.isLoading = true;
            this.$inertia.delete(`/admin/status/${id}`);  //!!!!КАВЫЧКИ - на Ё!!!!
            this.deleteDialogVisible = false;
            this.isLoading = false;
        },
    }
}


</script>

