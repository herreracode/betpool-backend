<script setup lang="ts">
import {ref, watch } from 'vue';
import Game from "@/Models/Games";
import {Link, router} from "@inertiajs/vue3"
import HttpClient from '@/Shared/HttpClient';
import {useToast} from 'vue-toast-notification';
const $toast = useToast();

interface Props {
    games: Game[],
    pool_round_id: string,
}

const summaryCreations = ref([])

const haveSummary = ref(false)

const props = defineProps<Props>()

const predictions = ref(
    JSON.parse(
        JSON.stringify(
            props.games.filter((game: Game) => game.status != '_FINISH_'))
    )
);

const createPredictions = async () => {

    try {

        const json = await HttpClient.post(route('predictions.store'), {
            predictions: predictions.value,
            id_pool_round: props.pool_round_id
        });

        summaryCreations.value = json.data.items;

    } catch (e) {

    }
};

const backToPoolRound = () => {
    router.visit(route('pool-round.indiviual-view', props.pool_round_id), {method: 'get'});
}

const tryAgain = () => {
    summaryCreations.value = []
}

watch(summaryCreations, (newName, oldName) => {

    haveSummary.value = newName.length > 0

});
</script>

<template>
    <v-toolbar dark color="info">
        <v-toolbar-title>Crear Predicciones</v-toolbar-title>
        <v-spacer></v-spacer>
    </v-toolbar>
    <div>
        <v-card v-show="haveSummary">
            <v-card-text v-for="summaryCreation in summaryCreations">
                <v-alert
                    :type="summaryCreation.status ? 'success' : 'error'"
                    variant="outlined"
                >
                    La prediccion {{ summaryCreation.description }}
                    {{ summaryCreation.status ? 'se creó con exito' : "no se pudo crear. " + summaryCreation.message  }}
                </v-alert>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>

                <v-btn color="blue-darken-1" variant="text" @click="tryAgain()">
                    intentarlo de nuevo
                </v-btn>
                <v-btn color="blue-darken-1" variant="text" @click="backToPoolRound()">
                    Volver al pool round
                </v-btn>
            </v-card-actions>
        </v-card>
        <v-card v-show="!haveSummary">
            <v-card-text>
                <v-container>
                    <v-row v-for="prediction in predictions" :key="predictions.id">
                        <v-col cols="4">
                            <span>{{ prediction.team_local }}</span>
                            <v-text-field v-model="prediction.score_local"
                                          hide-details single-line type="number"/>
                        </v-col>
                        <v-col cols="4">
                            <span>{{ prediction.team_away }}</span>
                            <v-text-field v-model="prediction.score_away"
                                          hide-details single-line type="number"/>
                        </v-col>
                    </v-row>
                </v-container>
                <small>*indicates required field</small>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <Link :href="route('pool-round.indiviual-view', pool_round_id)"
                      class="v-btn v-btn--elevated v-theme--light bg-error v-btn--density-default v-btn--size-default v-btn--variant-elevated">
                    Cancelar
                </Link>

                <v-btn color="blue-darken-1" variant="text" @click="createPredictions()">
                    Guardar
                </v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>

