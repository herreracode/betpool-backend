<script setup lang="ts">

import {computed, reactive, ref} from "vue";
import {router} from "@inertiajs/vue3";
import {isMandatoryField, formValidate} from '@/Shared/validateForms';
import HttpClient from "../Shared/HttpClient";

interface Props {
    showDialog: boolean,
    pool_id : number
}

const props = defineProps<Props>()

const emit = defineEmits(['input'])

const formAddUsers = reactive({
    guests: null,
})

const form = ref(null)

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

    let validForm :boolean = await formValidate(form)

    if(!validForm)
        return

    try {

        let response = await HttpClient.post(route('pool.post.invite-user', props.pool_id), formAddUsers)

        $toast.success("Se ha agregado a los usuarios con éxito")

        router.visit(route('dashboard'), {method: 'get'})

    } catch (e) {

    }
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
                <v-card-text>
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

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        text="Cancelar"
                        variant="plain"
                        @click="showInterDialog = false"
                    ></v-btn>

                    <v-btn
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
