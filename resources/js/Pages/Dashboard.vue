<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from "@inertiajs/vue3";
import Pool from "@/Models/Pool";
import HttpClient from '@/Shared/HttpClient';

interface Props {
    pools: Pool[],
    invitations_pools: [],
}

const props = defineProps<Props>()

const acceptInvitation = async (invitationId) => {

    const json = await HttpClient.patch(route('pools-invitations-emails.patch', invitationId), {
        accepted : 1
    });

    router.reload({ only: ['pools', 'invitations_pools'] })

    alert("se ha aceptado la invitacion")

}

const rejectInvitation = async (invitationId) => {

    const json = await HttpClient.patch(route('pools-invitations-emails.patch', invitationId), {
        accepted : 0
    });

    router.reload({ only: ['invitations_pools'] })

    alert("se ha rechazado la invitacion")

}

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="container-principal max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="container-principal--item container-pools bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <v-toolbar color="blue" title="Pools">
                        <Link :href="route('pool.create-view')"
                            class="v-btn v-btn--elevated v-theme--light bg-info v-btn--density-default v-btn--size-default v-btn--variant-elevated">
                        Crear Pool
                        </Link>
                    </v-toolbar>
                    <v-container class="pools_container">
                        <v-row>
                            <v-alert
                                v-if="props.pools.length == 0"
                                variant="outlined"
                                type="warning"
                                border="start"
                                prominent
                            >
                                Aún no forma parte de ningún pool
                            </v-alert>
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
                <div class="container-principal--item container-invitations bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <v-toolbar color="blue" title="Invitaciones a pool">
                    </v-toolbar>
                    <v-container class="invitations_container">
                        <v-row>
                            <v-alert
                                v-if="props.invitations_pools.length == 0"
                                variant="outlined"
                                type="warning"
                                prominent
                                border="top"
                            >
                                No tiene invitaciones pendientes
                            </v-alert>
                            <v-col v-for=" invitation_pool in props.invitations_pools" :key="invitation_pool.id" cols="12" sm="4">
                                <v-card>
                                    <v-card-title class="text-h5">
                                        Invitacion al pool {{ invitation_pool.pool_id }}
                                    </v-card-title>
                                    <v-card-actions>
                                        <v-btn color="danger" prepend-icon="$vuetify" @click="rejectInvitation(invitation_pool.id)">
                                            rechazar
                                        </v-btn>
                                        <v-btn color="success" prepend-icon="$vuetify" @click="acceptInvitation(invitation_pool.id)">
                                            aceptar
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

<style lang="scss" scoped>

.container-principal{

    display: flex;
    flex-direction: column;

    .container-principal--item{

        margin : 1%;

    }
}

</style>
