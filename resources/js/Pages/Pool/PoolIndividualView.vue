<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PoolCreateRound from "@/Pages/Pool/PoolRoundCreate.vue";

import { ref } from 'vue';

const desserts = ref([
    {
        name: 'Jhon doe',
        puntos: 25,
    },
    {
        name: 'Test 2',
        puntos: 12,
    },
    {
        name: 'Eclair',
        puntos: 7,
    },
]);

const dialogCreateRound = ref(false);

const onCancelCreatePoolRound = () => {

    toogleDialogCreatePoolRound();
};

const onCreatedPoolRound = () => {

    toogleDialogCreatePoolRound();
};

const toogleDialogCreatePoolRound = () => {

    //close modal
    dialogCreateRound.value = !dialogCreateRound.value;
}; 
</script>

<template>
    <AppLayout title="Pool">
        <template #header>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Pool nombre
                </h2>
            </div>
            <div>
                <v-btn @click="dialogCreateRound = !dialogCreateRound" color="info">
                    Crear Round
                </v-btn>
                <v-btn color="info">
                    Invitar Usuario
                </v-btn>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <v-toolbar color="blue" title="Round Pools">
                    </v-toolbar>
                    <v-container class="round_Zpools_container">
                        <v-row>
                            <v-col v-for="n in 3" :key="n" cols="12" sm="4">
                                <v-card>
                                    <v-card-title>
                                        Round Pools {{ n }}
                                    </v-card-title>
                                    <v-card-actions>
                                        <v-btn color="primary" size="x-small">
                                            partidos
                                        </v-btn>
                                        <v-btn color="primary" size="x-small">
                                            predicciones
                                        </v-btn>
                                        <v-btn color="primary" size="x-small">
                                            crear predicciones
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-container>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <v-toolbar color="blue" title="Tabla de posiciones">
                    </v-toolbar>
                    <v-table density="compact">
                        <thead>
                            <tr>
                                <th class="text-left">
                                    Nombre
                                </th>
                                <th class="text-left">
                                    Puntos
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in desserts" :key="item.name">
                                <td>{{ item.name }}</td>
                                <td>{{ item.puntos }}</td>
                            </tr>
                        </tbody>
                    </v-table>
                </div>
                <div class="text-center">
                    <v-dialog v-model="dialogCreateRound" fullscreen :scrim="false" transition="dialog-bottom-transition">
                        <v-toolbar dark color="info">
                            <v-btn icon dark @click="dialogCreateRound = false">
                                X
                            </v-btn>
                            <v-toolbar-title>Pool Round</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-toolbar-items>
                                <v-btn variant="text" @click="dialogCreateRound = false">
                                    Save
                                </v-btn>
                            </v-toolbar-items>
                        </v-toolbar>
                        <v-card>
                            <PoolCreateRound @cancel-create-pool-round="onCancelCreatePoolRound"
                                @created-pool-round="onCreatedPoolRound">
                            </PoolCreateRound>
                        </v-card>
                    </v-dialog>
                </div>
            </div>
        </div>
    </AppLayout>
</template>