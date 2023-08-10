<script setup lang="ts">

import AppLayout from '@/Layouts/AppLayout.vue'
import { reactive } from 'vue'

const emit = defineEmits(['createdPoolRound', 'cancelCreatePoolRound'])

const createPoolRound = () => {

    alert("se ha creado el pool round");

    console.log("hacer fetch al backend para crear pool round");

    emit("createdPoolRound");
};

interface Props {
    games: [],
}


const props = defineProps<Props>()

const formPoolRound = reactive({
    games: [],
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
                                            <v-select :items="games" :item-title="'name'" :item-value="'id'"
                                                v-model="formPoolRound.games" variant="outlined"
                                                label="Partidos" required multiple chips></v-select>
                                        </v-col>
                                    </v-row>
                                </v-container>
                                <small>* Indica campos requeridos</small>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue-darken-1" variant="text" @click="$emit('cancelCreatePoolRound')">
                                    Cancelar
                                </v-btn>
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