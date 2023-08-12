<script setup lang="ts">
import { Link, router } from "@inertiajs/vue3"
import AppLayout from '@/Layouts/AppLayout.vue'
import { reactive } from 'vue'
import HttpClient from '@/Shared/HttpClient';

const emit = defineEmits(['createdPoolRound', 'cancelCreatePoolRound'])

const createPoolRound = async () => {

    formPoolRound.id_pool = props.id_pool

    const json = await HttpClient.post(route('pool-round.store'), formPoolRound);

    alert("se ha creado el pool roud")

    router.visit(route('pool.indiviual-view', props.id_pool), { method: 'get' })
};

interface Props {
    games: [],
    id_pool: string,
}

const props = defineProps<Props>()

const formPoolRound = reactive({
    games: [],
    id_pool: ''
})

</script>

<template>
    <AppLayout title="Creacion Pool Round">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Round Pool
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
                                        <v-col cols="12" sm="12">
                                            <v-select :items="games" :item-title="'description'" :item-value="'id'"
                                                v-model="formPoolRound.games" variant="outlined" label="Partidos" required
                                                multiple chips closable-chips>
                                            </v-select>
                                        </v-col>
                                    </v-row>
                                </v-container>
                                <small>* Indica campos requeridos</small>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <Link :href="route('pool.indiviual-view', id_pool)"
                                    class="v-btn v-btn--elevated v-theme--light bg-error v-btn--density-default v-btn--size-default v-btn--variant-elevated">
                                Cancelar
                                </Link>
                                <v-btn color="blue-darken-1" variant="text" @click="createPoolRound()">
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