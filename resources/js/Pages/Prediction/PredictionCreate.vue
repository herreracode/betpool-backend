<script setup lang="ts">
import {ref, computed} from 'vue';
import Game from "@/Models/Games";
import {Link, router} from "@inertiajs/vue3"
import HttpClient from '@/Shared/HttpClient';

interface Props {
    games: Game[],
    pool_round_id: string,
}

const createPredictions = async () => {

    const json = await HttpClient.post(route('predictions.store'), {
        predictions: predictions.value,
        pool_round_id: props.pool_round_id
    });

    summaryCreations.value = json.data.items;

};

const backToPoolRound = () => {
    router.visit(route('pool-round.indiviual-view', props.pool_round_id), {method: 'get'});
}

const haveSummary = computed(() => {
    return summaryCreations.length > 0;
})

const props = defineProps<Props>()

const predictions = ref(JSON.parse(JSON.stringify(props.games.filter((game: Game) => game.status != '_FINISH_'))));

const summaryCreations = ref([])

</script>

<template>
    <v-toolbar dark color="info">
        <v-toolbar-title>Crear Predicciones</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
            <v-btn variant="text">
                Guardar
            </v-btn>
        </v-toolbar-items>
    </v-toolbar>
    <div>
        <v-card v-if="haveSummary">
            <v-card-text v-for="summaryCreation in summaryCreations">
                <v-alert
                    :type="summaryCreation.status ? 'success' : 'error'"
                    variant="outlined"
                >
                    La prediccion {{ summaryCreation.description }}
                    {{ summaryCreation.status ? 'se creo con exito' : 'no se pudo crear' }}
                </v-alert>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>

                <v-btn color="blue-darken-1" variant="text" @click="backToPoolRound()">
                    Volver al pool round
                </v-btn>
            </v-card-actions>
        </v-card>
        <v-card v-else>
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
