<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, router } from "@inertiajs/vue3"
import { reactive } from 'vue'
import HttpClient from '@/Shared/HttpClient.ts';

const emit = defineEmits(['createdPool', 'cancelCreatePool'])

interface Props {
    competitions: [],
}


const props = defineProps<Props>()

const createPool = async () => {

    const json = await HttpClient.post(route('pool.store'), formPool);

    alert("se ha creado el pool")

    console.log(json)

    console.log("hacer fetch al backend para crear pool")

    router.visit(route('dashboard'), { method: 'get' })
};

const formPool = reactive({
    name: null,
    competitions: null,
    guests: null,
})

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
                    <v-container>
                        <v-card>
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="12" sm="12" md="12">
                                            <v-text-field v-model="formPool.name" variant="outlined" label="Nombre del pool"
                                                required></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="12">
                                            <v-select :items="competitions" :item-title="'name'" :item-value="'id'"
                                                v-model="formPool.competitions" variant="outlined"
                                                label="Competiciones favoritas" required multiple chips></v-select>
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
                                <v-btn color="blue-darken-1" variant="text" @click="createPool()">
                                    Guardar
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-container>
                </div>
            </div>
        </div>

    </AppLayout>
</template>

<style scoped></style>
