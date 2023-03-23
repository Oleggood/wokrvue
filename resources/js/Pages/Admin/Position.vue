<template>
    <admin-main>
        <div class="max-w-[60%] flex justify-center">
            <h3 class="text-lg font-semibold">Должности</h3>
        </div>


        <!--index-->
        <div v-if="positions.length > 0" class="mt-6">
            <table class="border-collapse border border-slate-500 min-w-[60%]">
                <thead class="bg-gray-200">
                <th class="border border-slate-600 py-3">ID</th>
                <th class="border border-slate-600 py-3">Должность</th>
                <th class="border border-slate-600 py-3">Руководитель</th>
                <th class="border border-slate-600 py-3">Зам.руководителя</th>
                <th class="border border-slate-600 py-3">Действия</th>
                </thead>
                <tbody>
                <tr v-for="pos in positions" :key="pos.id">
                    <td class="border border-slate-700 text-center">{{ pos.id }}</td>
                    <td class="border border-slate-700 text-center text-justify indent-4">{{ pos.position }}</td>
                    <td class="border border-slate-700 text-center text-justify indent-4">{{ pos.is_director ? "да" : "нет" }}</td>
                    <td class="border border-slate-700 text-center text-justify indent-4">{{ pos.is_deputy_director ? "да" : "нет" }}</td>

                    <td class="border border-slate-700 text-center py-2">
                        <secondary-button @click.prevent="showUpdateDialog(pos)" class="mr-2">
                            изменить
                        </secondary-button>
                        <danger-button @click.prevent="showDeleteDialog(pos)" class="ml-2">
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
                <InputLabel for="new_position" value="Наименование:"/>
                <TextInput
                    id="new_position"
                    type="text"
                    class="mt-1 block w-full"
                    minlength="2"
                    maxlength="100"
                    required
                    v-model="formLocalCreate.position"
                />

                <div class="block mt-4">
                    <label class="flex items-center">
                        <Checkbox name="is_director" v-model:checked="formLocalCreate.is_director" value=""/>
                        <span class="ml-2 text-sm text-gray-600">Руководитель</span>
                    </label>
                </div>
                <div class="block mt-4">
                    <label class="flex items-center">
                        <Checkbox name="is_deputy_director" v-model:checked="formLocalCreate.is_deputy_director" value=""/>
                        <span class="ml-2 text-sm text-gray-600">Заместитель руководителя</span>
                    </label>
                </div>

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
                <form @submit.prevent="update(pos, id)" class="flex flex-col mt-6">
                    <div>
                        <InputLabel for="current_position" value="Должность:"/>
                        <TextInput
                            id="current_position"
                            type="text"
                            class="mt-1 mb-4 block w-full"
                            autofocus
                            minlength="2"
                            maxlength="100"
                            required
                            v-model="pos.position"
                        />

                        <div class="block mt-4">
                            <label class="flex items-center">
                                <Checkbox name="is_director" v-model:checked="pos.is_director" />
                                <span class="ml-2 text-sm text-gray-600">Руководитель</span>
                            </label>
                        </div>
                        <div class="block mt-4">
                            <label class="flex items-center">
                                <Checkbox
                                    name="is_deputy_director"
                                    v-model:checked="pos.is_deputy_director"
                                />
                                <span class="ml-2 text-sm text-gray-600">Заместитель руководителя</span>
                            </label>
                        </div>
<!-- <p>{{ this.checked }}</p>-->
<!-- <p>{{ pos.is_director ? true : '' }}</p>-->
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
                <div class="m-6"><span>Вы уверены, что хотите удалить {{ pos.position }}</span></div>
                <text-input autofocus class="w-0"></text-input> <!--нужен для закрытия модалки при нажатии ESC-->
                <div class="flex justify-around mb-4">
                    <secondary-button @click="hiddenDeleteDialog">отмена</secondary-button>
                    <danger-button @click="del(pos)">удалить</danger-button>
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
import position from "@/Pages/Admin/Position.vue";
import Checkbox from "@/Components/Checkbox.vue";

export default {
    name: 'Position',
    components: {
        Checkbox,
        //MyTextArea,
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
            formLocalCreate: {'id': '', 'position': '', 'is_director': false, 'is_deputy_director': false},
            updCheck: 'checked',
        }
    },

    props: [
        'positions',
        //'position',
    ],
    methods: {
        store() {
            this.isLoading = true;
            this.form = this.$inertia.form(this.formLocalCreate);
            this.form.post('/admin/position', {
                onFinish: () => {
                    this.isLoading = false;
                    this.formLocalCreate = '';
                }
            });
        },

        showUpdateDialog(pos) {
            this.updateDialogVisible = true;
            this.pos = pos;
            this.id = pos.id;
            this.pos.is_director === 1 ? this.pos.is_director = true : this.pos.is_director = false;
            this.pos.is_deputy_director === 1 ? this.pos.is_deputy_director = true : this.pos.is_deputy_director = false;

        },

        hiddenUpdateDialog() {
            this.updateDialogVisible = false;
            this.pos.is_director ? this.pos.is_director = 1 : this.pos.is_director = 0;
            this.pos.is_deputy_director ? this.pos.is_deputy_director = 1 : this.pos.is_deputy_director = 0;
            // location.reload();
        },

        update(pos, id) {
            this.isLoading = true;
            this.form = this.$inertia.form(this.pos);
            this.form.patch(`/admin/position/${id}`, {
                onFinish: () => {
                    this.updateDialogVisible = false;
                    this.isLoading = false;
                }
            });
        },

        showDeleteDialog(pos) {
            this.deleteDialogVisible = true;
            this.pos = pos;
        },

        hiddenDeleteDialog() {
            this.deleteDialogVisible = false;
        },

        del(pos) {
            this.isLoading = true;
            this.form = this.$inertia.form(this.pos);
            this.form.delete(`/admin/position/${pos.id}`, {
                onFinish: () => {
                    this.deleteDialogVisible = false;
                    this.isLoading = false;
                }
            });
        },
    }
}


</script>

