<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from "@inertiajs/vue3";
import { ref } from 'vue';
import PoolCreate from "@/Pages/Pool/PoolCreate.vue";
import Pool from "@/Models/Pool";

interface Props {
    pools: Pool[],
}

const dialog = ref(false);

const props = defineProps<Props>()

const onCancelCreatePool = () => {

    toogleDialogCreatePool();
};

const onCreatedPool = () => {

    toogleDialogCreatePool();
};

const toogleDialogCreatePool = () => {

    //close modal
    dialog.value = !dialog.value;
};

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
                            class="text-indigo-600 hover:text-indigo-800 w-fit self-end font-semibold">
                        viewdasdasdas
                        </Link>
                    </v-toolbar>
                    <v-container class="pools_container">
                        <v-row>
                            <v-col v-for=" pool in props.pools" :key="pool.uuid" cols="12" sm="4">
                                <v-card>
                                    <v-card-title class="text-h5">
                                        {{ pool.name }}
                                    </v-card-title>
                                    <v-card-actions>
                                        <v-btn color="info" prepend-icon="$vuetify">
                                            <Link :href="route('pool.indiviual-view', pool.uuid)"
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
