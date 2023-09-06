<script setup lang="ts">
import { ref } from 'vue';
import Prediction from "@/Models/Prediction";
import { Link, router } from "@inertiajs/vue3"
import HttpClient from '@/Shared/HttpClient';

interface Props {
    prediction: Prediction,
    pool_round_id: string,
}

const editPredictions = async () => {

    const json = await HttpClient.patch(route('predictions.put', props.prediction.id), {
        prediction: props.prediction,
        id_pool_round: props.pool_round_id
    });

    alert("se han creado las predicciones")

    router.visit(route('pool-round.indiviual-view', props.pool_round_id), { method: 'get' })
};


const props = defineProps<Props>()

const score_local = ref(null)
const score_away = ref(null)

</script>

<template>
    <v-toolbar dark color="info">
        <v-toolbar-title>Editar Predicciones</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
            <v-btn variant="text">
                Guardar
            </v-btn>
        </v-toolbar-items>
    </v-toolbar>
    <v-card>
        <v-card>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="4">
                            <span>{{ prediction.team_local }}</span> <v-text-field v-model="prediction.score_local"
                                hide-details single-line type="number" />
                        </v-col>
                        <v-col cols="4">
                            <span>{{ prediction.team_away }}</span> <v-text-field v-model="prediction.score_away"
                                hide-details single-line type="number" />
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

                <v-btn color="blue-darken-1" variant="text" @click="editPredictions()">
                    Guardar
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-card>
</template>
