<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from "@inertiajs/vue3";
import Pool from "@/Models/Pool";

interface Props {
    pools: Pool[],
}

const props = defineProps<Props>()

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
                        <Link :href="route('pool.create-view')"
                            class="v-btn v-btn--elevated v-theme--light bg-info v-btn--density-default v-btn--size-default v-btn--variant-elevated">
                        Crear Pool
                        </Link>
                    </v-toolbar>
                    <v-container class="pools_container">
                        <v-row>
                            <v-col v-for=" pool in props.pools" :key="pool.id" cols="12" sm="4">
                                <v-card>
                                    <v-card-title class="text-h5">
                                        {{ pool.name }}
                                    </v-card-title>
                                    <v-card-actions>
                                        <v-btn color="info" prepend-icon="$vuetify">
                                            <Link :href="route('pool.indiviual-view', pool.id)"
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
            </div>
        </div>
    </AppLayout>
</template>
