<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue'
import {Link, router} from "@inertiajs/vue3"
import {reactive, ref} from 'vue'
import HttpClient from '@/Shared/HttpClient.ts';
import {isMandatoryField, moreThanCharateres} from '@/Shared/validateForms';
import Competition from '@/Models/Competition';
import {useToast} from 'vue-toast-notification';

const $toast = useToast();

interface Props {
    competitions: Competition[],
}

const props = defineProps<Props>()

const formCreatePool = ref(null)

const createPool = async () => {

    let validForm = await formCreatePool.value.validate()

    if(!validForm.valid){
        $toast.warning("Revise los campos de su formulario")
        return
    }

    try {

        const json = await HttpClient.post(route('pool.store'), formPool);

        $toast.success("Se ha creado el pool con éxito")

        router.visit(route('dashboard'), {method: 'get'})

    } catch (e) {

    }

};

const formPool = reactive({
    name: null,
    competitions: null,
    guests: null,
})

const ruleFieldNamePool = [
    isMandatoryField,
    moreThanCharateres(3)
];

const ruleFieldCompetitions = [
    isMandatoryField
];

</script>

<template>
    <AppLayout title="Creacion Pool">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Creación Pool
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <v-form @submit.prevent ref="formCreatePool">
                        <v-container>
                            <v-card>
                                <v-card-text>
                                    <v-container>
                                        <v-row>
                                            <v-col cols="12" sm="12" md="12">
                                                <v-text-field v-model="formPool.name" variant="outlined"
                                                              label="Nombre del pool" :rules="ruleFieldNamePool"
                                                              required></v-text-field>
                                            </v-col>
                                            <v-col cols="12" sm="12">
                                                <v-select :items="competitions" :item-title="'name'" :item-value="'id'"
                                                          v-model="formPool.competitions" :rules="ruleFieldCompetitions" variant="outlined"
                                                          label="Competiciones favoritas" required multiple
                                                          chips></v-select>
                                            </v-col>
                                            <v-col cols="12" sm="12">
                                                <v-combobox :hide-no-data="false" hide-selected hint="Maximum of 5 tags"
                                                            label="Usuarios a invitar" multiple variant="outlined" chips
                                                            v-model="formPool.guests">
                                                </v-combobox>
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                    <small>*indicates required field</small>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <Link :href="route('dashboard')"
                                          class="v-btn v-btn--elevated v-theme--light bg-error v-btn--density-default v-btn--size-default v-btn--variant-elevated">
                                        Cancelar
                                    </Link>
                                    <v-btn color="blue-darken-1" type="submit" variant="text" @click="createPool()">
                                        Guardar
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-container>
                    </v-form>
                </div>
            </div>
        </div>

    </AppLayout>
</template>

<style scoped></style>
