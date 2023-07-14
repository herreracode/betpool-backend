<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PoolIndividualView from '@/Pages/Pool/PoolIndividualView.vue';
import { Link } from "@inertiajs/vue3";
import {ref} from 'vue';
import PoolCreate from "@/Pages/Pool/PoolCreate.vue";

const dialog = ref(false);

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <v-toolbar color="blue" title="Pools">
                        <v-btn @click="dialog = !dialog" prepend-icon="$vuetify">
                            crear pool
                        </v-btn>
                    </v-toolbar>
                    <v-container class="pools_container">
                        <v-row>
                            <v-col v-for="n in 10" :key="n" cols="12" sm="4">
                                <v-card>
                                    <v-card-title class="text-h5">
                                        Pools {{ n }}
                                    </v-card-title>
                                    <v-card-actions>
                                        <v-btn color="info" prepend-icon="$vuetify">
                                            <Link :href="route('pool.indiviual-view',  n)"
                                                class="text-indigo-600 hover:text-indigo-800 w-fit self-end font-semibold">
                                            view
                                            </Link>
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-container>
                    <div class="text-center">
                        <v-dialog
                            v-model="dialog"
                            width="auto"
                        >
                            <v-card>
                                <PoolCreate/>
                            </v-card>
                        </v-dialog>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
