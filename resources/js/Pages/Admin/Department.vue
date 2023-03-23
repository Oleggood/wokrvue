<template>
    <admin-main>
        <div class="flex justify-center">
            <h3 class="text-lg font-semibold">Подразделения</h3>
        </div>


        <!--index-->
        <div v-if="departments.length > 0" class="mt-6">
            <table class="border-collapse border border-slate-500 w-full">
                <thead class="bg-gray-200">
                <th class="border border-slate-600 py-3">ID</th>
                <th class="border border-slate-600 py-3">Подразделение</th>
                <th class="border border-slate-600 py-3 italic">Примечание</th>
                <th class="border border-slate-600 py-3">Действия</th>
                </thead>
                <tbody>
                <tr v-for="depart in departments" :key="depart.id">
                    <td class="border border-slate-700 text-center">{{ depart.id }}</td>
                    <td class="border border-slate-700 indent-4">{{ depart.department }}</td>
                    <td class="border border-slate-700 italic text-sm max-w-3xl indent-4 py-1 px-2">
                        {{ depart.note }}
                    </td>
                    <td class="border border-slate-700 text-center py-2">
                        <secondary-button @click.prevent="showUpdateDialog(depart)" class="mr-2">
                            изменить
                        </secondary-button>
                        <danger-button @click.prevent="showDeleteDialog(depart)" class="ml-2">
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
            <form class="flex flex-col mt-8" @submit="store">
                <hr>
                <div class="flex justify-center mt-6">
                    <p class="font-bold text-xs uppercase text-gray-700 tracking-widest">Создать</p>
                </div>
                <InputLabel for="new_department" value="Наименование:"/>
                <TextInput
                    id="new_department"
                    type="text"
                    class="mt-1 block w-full"
                    minlength="2"
                    maxlength="40"
                    required
                    v-model="formLocalCreate.department"
                />

                <InputLabel class="mt-4" for="new_note" value="Примечание:"/>
                <MyTextArea
                    id="new_note"
                    type="text"
                    class="mt-1 block w-full"
                    maxlength="500"
                    v-model="formLocalCreate.note"
                />

                <div class="mt-6">
                    <primary-button>
                        Добавить
                    </primary-button>
                </div>
            </form>
        </div>
        <!--/create-->

        <!--update Modal-->
        <my-modal v-model:show="updateDialogVisible">
            <div class="mx-auto min-w-[80%]">
                <form @submit.prevent="update(depart, id)" class="flex flex-col mt-6">
                    <div>
                        <InputLabel for="current_department" value="Подразделение:"/>
                        <TextInput
                            id="current_department"
                            type="text"
                            class="mt-1 mb-4 block w-full"
                            autofocus
                            minlength="2"
                            maxlength="40"
                            required
                            v-model="depart.department"
                        />
                        <InputLabel for="current_note" value="Примечание:"/>
                        <MyTextArea
                            id="current_note"
                            type="text"
                            class="mt-1 block w-full"
                            maxlength="500"
                            v-model="depart.note"
                        />
                        <div class="flex justify-around mt-6">
                            <primary-button type="submit">
                                сохранить
                            </primary-button>
                            <secondary-button @click="hiddenUpdateDialog">отмена</secondary-button>
                        </div>
                    </div>
                </form>
            </div>
        </my-modal>
        <!--/update Modal-->

        <!--delete Modal-->
        <my-modal v-model:show="deleteDialogVisible">
            <div class="flex mx-auto flex-col">
                <div class="my-6"><span>Вы уверены, что хотите удалить {{ depart.department }}</span></div>
                <text-input autofocus class="w-0"></text-input> <!--нужен для закрытия модалки при нажатии ESC-->
                <div class="flex justify-around mb-4">
                    <secondary-button @click="hiddenDeleteDialog">отмена</secondary-button>
                    <danger-button @click="del(depart)">удалить</danger-button>
                </div>
            </div>
        </my-modal>
        <!--/delete Modal-->

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
import InputError from "@/Components/InputError.vue";
import MyTextArea from "@/Components/MyTextArea.vue";

export default {
    name: 'Department',
    components: {
        MyTextArea,
        //InputError,
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
            updateDialogVisible: false,
            deleteDialogVisible: false,
            isLoading: false,
            form: this.$inertia.form({}),
            formLocalCreate: {'id': '', 'department': '', 'note': ''},
        }
    },

    props: [
        'departments',
        //'department',
    ],
    methods: {
        store() {
            this.isLoading = true;
            this.form = this.$inertia.form(this.formLocalCreate);
            this.form.post('/admin/department', {
                onFinish: () => {
                    this.isLoading = false;
                    this.formLocalCreate = '';
                }
            });
        },

        showUpdateDialog(depart) {
            this.updateDialogVisible = true;
            this.depart = depart;
            this.id = depart.id;
        },

        hiddenUpdateDialog() {
            this.updateDialogVisible = false;
        },

        update(depart, id) {
            this.isLoading = true;
            this.form = this.$inertia.form(this.depart);
            this.form.patch(`/admin/department/${id}`, {
                onFinish: () => {
                    this.updateDialogVisible = false;
                    this.isLoading = false;
                }
            });


        },

        showDeleteDialog(depart) {
            this.deleteDialogVisible = true;
            this.depart = depart;
        },

        hiddenDeleteDialog() {
            this.deleteDialogVisible = false;
        },

        del(depart) {
            this.isLoading = true;
            this.form = this.$inertia.form(this.depart);
            this.form.delete(`/admin/department/${depart.id}`, {
                onFinish: () => {
                    this.deleteDialogVisible = false;
                    this.isLoading = false;
                }
            });
        },
    }
}


</script>

