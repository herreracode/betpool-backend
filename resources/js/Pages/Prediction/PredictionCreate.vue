<script setup lang="ts">

import { ref } from 'vue';
import { Link } from "@inertiajs/vue3";

//todo: changes types
interface Games {
    id: string;
    team_local: string;
    team_away: string;
    date_start: string;
}

interface Props {
    games: Games[],
}


const props = defineProps<Props>()

const predictions = ref(JSON.parse(JSON.stringify(props.games)));

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
    <v-card>
        <v-card>
            <v-card-text>
                <v-container>
                    <v-row v-for="prediction in predictions" :key="predictions.id">
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
                <v-btn color="blue-darken-1" variant="text">
                    Cancelar
                </v-btn>

                <Link :href="route('pool-round.indiviual-view',  1)"
                    class="v-btn v-btn--elevated v-theme--light bg-info v-btn--density-default v-btn--size-default v-btn--variant-elevated">
                Guardar
                </Link>
            </v-card-actions>
        </v-card>
    </v-card>
</template>