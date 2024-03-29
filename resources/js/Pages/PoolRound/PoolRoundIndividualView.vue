<script lang="ts" setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import {ref} from 'vue';
import {Link} from "@inertiajs/vue3";
import Game from "@/Models/Games";
import Prediction from "@/Models/Prediction";

interface Props {
    pool_round: {},
    games: Game[],
    own_predictions: Prediction[] | null,
    can_create_predictions: boolean,
    others_predictions: [],
}

const props = defineProps<Props>()

const tab = ref(null);

const colorByStatus = (status) => {

    return status == '_FINISH_' || status == '_CLOSE_' ? 'green' : '';

}

const breadcrumbItems = ref([
    {
        title: 'Dashboard',
        disabled: false,
        href: route('dashboard'),
    },
    {
        title: 'Pool',
        disabled: false,
        href: route('pool.indiviual-view', props.pool_round.pool_id),
    },
]);

const getLocalStringDate = (date: string) => {

    let DateOb = new Date(date)

    return DateOb.toLocaleString();

}

</script>

<template>
    <AppLayout title="PoolRound" :breadcrumb="breadcrumbItems">
        <template #header>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Pool Round {{ pool_round.id }}
                    <v-chip class="ma-2" :color="colorByStatus(pool_round.status)">
                        {{ pool_round.status }}
                    </v-chip>
                </h2>
            </div>
            <div>
                <Link v-if="can_create_predictions" :href="route('predictions.create-view', pool_round.id)"
                      class="v-btn v-btn--elevated v-theme--light bg-info v-btn--density-default v-btn--size-default v-btn--variant-elevated">
                    Crear Predicciones
                </Link>

            </div>
        </template>
        <template #breadcrumbs>
        </template>
        <div class="py-12">
            <div class="container-principal max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="container-principal--item bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <v-toolbar color="blue" title="Tus Predicciones">
                    </v-toolbar>
                    <v-alert
                        v-if="props.own_predictions.length == 0"
                        variant="outlined"
                        type="warning"
                        prominent
                        border="top"
                    >
                        Aún no ha creado las predicciones
                    </v-alert>
                    <v-table v-else>
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
                            <td>
                                <v-chip class="ma-2" :color="colorByStatus(item.status)">
                                    {{ item.status }}
                                </v-chip>
                            </td>
                            <td>{{ item.points_earned ? item.points_earned : '-' }}</td>
                            <td>
                                <Link v-if="item.status !== '_CLOSE_'"
                                      :href="route('predictions.edit-view', item.id)"
                                      class="v-btn v-btn--elevated v-theme--light bg-info v-btn--density-default v-btn--size-default v-btn--variant-elevated">
                                    Editar
                                </Link>
                            </td>
                        </tr>
                        </tbody>
                    </v-table>
                </div>
                <div class="container-principal--item bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <v-toolbar color="blue" title="Predicciones de los demas">
                    </v-toolbar>
                    <v-alert
                        v-if="props.others_predictions.length == 0"
                        variant="outlined"
                        type="warning"
                        prominent
                        border="top"
                    >
                        Aún no hay predicciones de los demas participantes
                    </v-alert>
                    <v-expansion-panels class="mb-6" v-else>
                        <v-expansion-panel v-for="other_prediction in props.others_predictions">
                            <v-expansion-panel-title expand-icon="mdi-menu-down">
                                {{ other_prediction.user.name }}
                            </v-expansion-panel-title>
                            <v-expansion-panel-text v-if="other_prediction.predictions.length == 0">
                                <v-alert
                                    variant="outlined"
                                    type="warning"
                                    prominent
                                    border="top"
                                >
                                    Aún el participante no tiene predicciones finalizadas
                                </v-alert>
                            </v-expansion-panel-text>
                            <v-expansion-panel-text v-else
                                                    v-for="prediction in other_prediction.predictions">
                                <div>
                                                    <span>{{ prediction.team_local }} {{
                                                            prediction.score_local
                                                        }} vs {{ prediction.score_away }} {{
                                                            prediction.team_away
                                                        }} </span>
                                    <v-chip class="ma-2" size="small">
                                        puntos ganados: {{ prediction.points_earned }}
                                    </v-chip>
                                </div>
                            </v-expansion-panel-text>
                        </v-expansion-panel>
                    </v-expansion-panels>
                </div>
                <div class="container-principal--item bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <v-toolbar color="blue" title="Partidos del round">
                    </v-toolbar>
                    <v-card>
                        <v-table>
                            <thead>
                            <tr>
                                <th class="text-left">
                                    Equipos
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
                                <td>{{ getLocalStringDate(item.date_start) }}</td>
                                <td>
                                    <v-chip class="ma-2" :color="colorByStatus(item.status)">
                                        {{ item.status }}
                                    </v-chip>
                                </td>
                            </tr>
                            </tbody>
                        </v-table>
                    </v-card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<style lang="scss" scoped>

.container-principal{

    display: flex;
    flex-direction: column;

    .container-principal--item{

        margin : 1%;

    }
}

.container-button-actions{

    display: flex;
    gap:0.5%;
}

</style>
