<script lang="ts" setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed } from 'vue';
import { Link } from "@inertiajs/vue3";
import Game from "@/Models/Games";
import Prediction from "@/Models/Prediction";

interface Props {
    pool_round: {},
    games: Game[],
    own_predictions: Prediction[] | null,
    can_create_predictions: boolean,
}

const props = defineProps<Props>()

const tab = ref(null);


</script>

<template>
    <AppLayout title="PoolRound">
        <template #header>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Pool Round {{ pool_round.id }} | {{ pool_round.status }}
                </h2>
            </div>
            <div>
                <Link v-if="can_create_predictions" :href="route('predictions.create-view', pool_round.id)"
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
                            <v-tab value="two">Tus Predicciones</v-tab>
                            <v-tab value="three">Predicciones de tus compañeros</v-tab>
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
                                                    Resultado
                                                </th>
                                                <th class="text-left">
                                                    Fecha
                                                </th>
                                                <th class="text-left">
                                                    Status
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item in games" :key="item.id">
                                                <td>{{ item.description }}</td>
                                                <td>{{ item.score_local }} - {{ item.score_away }}</td>
                                                <td>{{ item.date_start }}</td>
                                                <td>{{ item.status }}</td>
                                            </tr>
                                        </tbody>
                                    </v-table>
                                </v-window-item>

                                <v-window-item value="two">
                                    <v-table>
                                        <thead>
                                            <tr>
                                                <th class="text-left">
                                                    Partidos
                                                </th>
                                                <th class="text-left">
                                                    Resultado
                                                </th>
                                                <th class="text-left">
                                                    Status
                                                </th>
                                                <th class="text-left">
                                                    Puntos obtenidos
                                                </th>
                                                <th class="text-left">
                                                    acciones
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item in own_predictions" :key="item.id">
                                                <td>{{ item.description }}</td>
                                                <td>{{ item.score_local }} - {{ item.score_away }}</td>
                                                <td>{{ item.status }}</td>
                                                <td>{{ item.points_earned ? item.points_earned : '-' }}</td>
                                                <td>  
                                                    <Link v-if="item.status !== '_CLOSE_'" :href="route('predictions.edit-view', item.id)"
                                                        class="v-btn v-btn--elevated v-theme--light bg-info v-btn--density-default v-btn--size-default v-btn--variant-elevated">
                                                    Editar
                                                    </Link>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </v-table>
                                </v-window-item>
                                <v-window-item value="three">
                                    Se veran las predicciones de los demas cuando venza el plazos
                                </v-window-item>
                            </v-window>
                        </v-card-text>
                    </v-card>
                </div>
            </div>
        </div>
    </AppLayout></template>