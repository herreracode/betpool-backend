<script setup lang="ts">

import {computed, reactive, ref} from "vue";
import {router} from "@inertiajs/vue3";
import {isMandatoryField, formValidate} from '@/Shared/validateForms';
import HttpClient from "../Shared/HttpClient";

interface Props {
    showDialog: boolean,
    pool_id: number
}

const props = defineProps<Props>()

const emit = defineEmits(['input'])

const formAddUsers = reactive({
    guests: null,
})

const form = ref(null)
const summaryResult = ref([])

const showInterDialog = computed({
    // getter
    get() {

        return props.showDialog
    },
    // setter
    set(newValue) {

        emit('input', newValue)
    }
});

const ruleFieldGuest = [
    isMandatoryField
];

const addUsersToPool = async () => {

    let validForm: boolean = await formValidate(form)

    if (!validForm)
        return

    try {

        let response = await HttpClient.post(route('pool.post.invite-user', props.pool_id), formAddUsers)

        summaryResult.value = response.data.summary;

        cleanForm();

        $toast.success("Se ha agregado a los usuarios con éxito")

        router.visit(route('dashboard'), {method: 'get'})

    } catch (e) {

    }
}

const cleanForm = () => {
    formAddUsers.guests = null;
    form.value = null;
}

const closeDialog = () => {
    showInterDialog.value = false;
    summaryResult.value = [];
}


</script>

<template>
    <div class="pa-4 text-center">
        <v-dialog
            v-model="showInterDialog"
            max-width="600"
        >
            <v-form @submit.prevent ref="form">
                <v-card
                    prepend-icon="mdi-account"
                    title="Invitar"
                >
                    <v-card-text v-if="summaryResult.length == 0">
                        <v-row dense>
                            <v-col
                                cols="12" sm="12"
                            >
                                <v-combobox :hide-no-data="false" :rules="ruleFieldGuest" v-model="formAddUsers.guests"
                                            label="Usuarios a invitar" multiple variant="outlined" chips>
                                </v-combobox>
                            </v-col>
                        </v-row>
                    </v-card-text>

                    <v-divider></v-divider>
                    <v-table v-if="summaryResult.length > 0">
                        <thead>
                        <tr>
                            <th class="text-left">
                                Email guest
                            </th>
                            <th class="text-left">
                                Result
                            </th>
                            <th class="text-left">
                                Status
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="item in summaryResult"
                            :key="item.name"
                        >
                            <td>{{ item.email }}</td>
                            <td>{{ item.message }}</td>
                            <td>{{ item.status ? "Invitado" : "Hubo un inconveniente"  }}</td>
                        </tr>
                        </tbody>
                    </v-table>
                    <v-divider></v-divider>

                    <v-card-actions>
                        <v-spacer></v-spacer>

                        <v-btn
                            text="Cerrar"
                            variant="plain"
                            @click="closeDialog"
                        ></v-btn>

                        <v-btn v-if="summaryResult.length == 0"
                            color="primary"
                            text="Invitar"
                            variant="tonal"
                            @click="addUsersToPool"
                        ></v-btn>
                    </v-card-actions>

                </v-card>
            </v-form>

        </v-dialog>
    </div>
</template>

<style scoped lang="scss">

</style>
