<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

import {ref} from 'vue';

const desserts = ref([
          {
            name: 'Frozen Yogurt',
            puntos: 159,
          },
          {
            name: 'Ice cream sandwich',
            puntos: 237,
          },
          {
            name: 'Eclair',
            puntos: 262,
          },
          {
            name: 'Cupcake',
            puntos: 305,
          },
          {
            name: 'Gingerbread',
            puntos: 356,
          },
          {
            name: 'Jelly bean',
            puntos: 375,
          },
          {
            name: 'Lollipop',
            puntos: 392,
          },
          {
            name: 'Honeycomb',
            puntos: 408,
          },
          {
            name: 'Donut',
            puntos: 452,
          },
          {
            name: 'KitKat',
            puntos: 518,
          },
        ]);
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
                <v-btn color="info">
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
                                        <v-btn color="info" prepend-icon="$vuetify">
                                            <Link :href="route('pool.indiviual-view', n)"
                                                class="text-indigo-600 hover:text-indigo-800 w-fit self-end font-semibold">
                                            view
                                            </Link>
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
            </div>
        </div>
    </AppLayout>
</template>