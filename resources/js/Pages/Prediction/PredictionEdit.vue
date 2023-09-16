<script setup lang="ts">
import {ref} from 'vue';
import Prediction from "@/Models/Prediction";
import {Link, router} from "@inertiajs/vue3"
import HttpClient from '@/Shared/HttpClient';
import {isMandatoryField, formValidate} from '@/Shared/validateForms';
import {useToast} from 'vue-toast-notification';

const $toast = useToast();

const formEditPrediction = ref(null)

interface Props {
    prediction: Prediction,
    pool_round_id: string,
}

const editPredictions = async () => {

    let validForm: boolean = await formValidate(formEditPrediction)

    if (!validForm)
        return

    try {

        const json = await HttpClient.patch(route('predictions.put', props.prediction.id), {
            prediction: props.prediction,
            id_pool_round: props.pool_round_id
        });

        $toast.success("Se han editado las predicciones con éxito")

        router.visit(route('pool-round.indiviual-view', props.pool_round_id), {method: 'get'})

    } catch (e) {

    }
};


const props = defineProps<Props>()

const score_local = ref(null)
const score_away = ref(null)

const ruleFieldScorePredictions = [
    isMandatoryField
];

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
        <v-form @submit.prevent ref="formEditPrediction">
            <v-card>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="4">
                                <span>{{ prediction.team_local }}</span>
                                <v-text-field v-model="prediction.score_local"
                                              single-line type="number" :rules="ruleFieldScorePredictions"/>
                            </v-col>
                            <v-col cols="4">
                                <span>{{ prediction.team_away }}</span>
                                <v-text-field v-model="prediction.score_away"
                                              single-line type="number" :rules="ruleFieldScorePredictions"/>
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

                    <v-btn color="blue-darken-1" type="submit" variant="text" @click="editPredictions()">
                        Guardar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-form>
    </v-card>
</template>
