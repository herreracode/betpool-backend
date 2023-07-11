<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                sasdadsssdasdasd
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <v-toolbar color="blue" title="Pools"></v-toolbar>
                    <v-container class="pools_container">
                        <v-row>
                            <v-col v-for="n in 10" :key="n" cols="12" sm="4">
                                <v-card>
                                    <v-card-title class="text-h5">
                                        Pools {{ n }}
                                    </v-card-title>
                                    <v-card-actions>
                                        <v-btn color="info" prepend-icon="$vuetify">
                                            view
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-container>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
