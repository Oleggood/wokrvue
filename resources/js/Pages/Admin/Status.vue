<template>
    <admin-main>

        <!--index-->
        <div class="flex justify-around">
            <div v-if="statuses.length > 0" class="mt-6 w-[40%]">
                <div class="flex justify-center mb-4 w-full">
                    <h3 class="text-lg font-semibold">Статусы задач</h3>
                </div>
                <table class="border-collapse border border-slate-500 w-full">
                    <thead class="bg-gray-200">
                    <th class="border border-slate-600 py-3">ID</th>
                    <th class="border border-slate-600 py-3">Статус</th>
                    </thead>
                    <tbody>
                    <tr v-for="stat in statuses" :key="stat.id">
                        <td class="border border-slate-700 text-center">{{ stat.id }}</td>
                        <td class="border border-slate-700 text-center">{{ stat.status }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <h3 v-else class="mt-6 text-gray-900">Здесь пока пусто, добавьте запись...</h3>

            <div v-if="roles.length > 0" class="mt-6 w-[40%]">
                <div class="flex justify-center mb-4 w-full">
                    <h3 class="text-lg font-semibold">Роли пользователей</h3>
                </div>
                <table class="border-collapse border border-slate-500 w-full">
                    <thead class="bg-gray-200">
                    <th class="border border-slate-600 py-3">ID</th>
                    <th class="border border-slate-600 py-3">Роль</th>
                    </thead>
                    <tbody>
                    <tr v-for="role in roles" :key="role.id">
                        <td class="border border-slate-700 text-center">{{ role.id }}</td>
                        <td class="border border-slate-700 text-center">{{ role.role }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <h3 v-else class="mt-6 text-gray-900">Здесь пока пусто, добавьте запись...</h3>
        </div>
        <!--/index-->

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

        }
    },

    props: [
        'statuses',
        'roles',
    ],

    methods: {

    },
}


</script>

