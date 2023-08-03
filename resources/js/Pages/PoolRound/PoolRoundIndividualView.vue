<script lang="ts" setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import { Link } from "@inertiajs/vue3";

//todo: changes types
interface Games {
    name: string;
    calories: string;
}

interface Props {
    number: number | string,
    games: Games[],
    predictions: [] | null
}

const props = defineProps<Props>()

const tab = ref(null);

</script>

<template>
    <AppLayout title="PoolRound">
        <template #header>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Pool Round {{ number }}
                </h2>
            </div>
            <div>
                    <Link :href="route('predictions.create-view')"
                        class="v-btn v-btn--elevated v-theme--light bg-info v-btn--density-default v-btn--size-default v-btn--variant-elevated">
                    Crear Predicciones
                    </Link>

            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <v-card>
                        <v-tabs v-model="tab" bg-color="info">
                            <v-tab value="one">Partidos</v-tab>
                            <v-tab value="two">Predicciones</v-tab>
                        </v-tabs>

                        <v-card-text>
                            <v-window v-model="tab">
                                <v-window-item value="one">
                                    <v-table>
                                        <thead>
                                            <tr>
                                                <th class="text-left">
                                                    Partidos
                                                </th>
                                                <th class="text-left">
                                                    Fecha
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item in games" :key="item.name">
                                                <td>{{ item.name }}</td>
                                                <td>{{ item.calories }}</td>
                                            </tr>
                                        </tbody>
                                    </v-table>
                                </v-window-item>

                                <v-window-item value="two">
                                    Se veran las predicciones de los demas cuando venza el plazos
                                </v-window-item>
                            </v-window>
                        </v-card-text>
                    </v-card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>