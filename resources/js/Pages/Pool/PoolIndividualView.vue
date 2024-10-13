<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from "@inertiajs/vue3";
import { computed, ref } from 'vue';
import Pool from "@/Models/Pool";
import PoolRound from "@/Models/PoolRound";
import InviteGuestToPoolModal from "../../CustomComponents/InviteGuestToPoolModal.vue";

interface Props {
    pool: Pool,
    pool_rounds: PoolRound[],
    positions_table: []
}

const props = defineProps<Props>()

const viewModelAddUsersToPool = ref(false);

const positionTableOrder = computed(() => {
  return props.positions_table.sort((a, b) => a.total_points_earned < b.total_points_earned ? 1 : -1)
})


</script>

<template>
    <AppLayout title="Pool">
        <template #header>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Pool {{ pool.name }}
                </h2>
            </div>
            <div class="container-button-actions">
                <Link :href="route('pool-round.create-view', pool.id)"
                    class="v-btn v-btn--elevated v-theme--light bg-info v-btn--density-default v-btn--size-default v-btn--variant-elevated">
                    Crear Round
                </Link>
                <v-btn color="info" @click="viewModelAddUsersToPool = true" >
                    Invitar Usuario
                </v-btn>
                <invite-guest-to-pool-modal :show-dialog="viewModelAddUsersToPool"
                                   @input="viewModelAddUsersToPool = false"
                                   :pool-id="pool.id"
                >
                </invite-guest-to-pool-modal>
            </div>
        </template>
        <div class="py-12">
            <div class="container-principal max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="container-principal--item bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <v-toolbar color="blue" title="Round Pools">
                    </v-toolbar>
                    <v-container class="round_Zpools_container">
                        <v-row>
                            <v-alert
                                v-if="props.pool_rounds.length == 0"
                                variant="outlined"
                                type="warning"
                                prominent
                                border="top"
                            >
                                Aún no se ha creado ningún round dentro del pool
                            </v-alert>
                            <v-col v-for=" poolRound in props.pool_rounds" :key="poolRound.id" cols="12" sm="4">
                                <v-card>
                                    <v-card-title>
                                        Round Pools {{ poolRound.id }} | {{ poolRound.status }}
                                    </v-card-title>
                                    <v-card-actions>
                                        <Link as="button" :href="route('pool-round.indiviual-view', poolRound.id)"
                                            class="text-indigo-600 hover:text-indigo-800 w-fit self-end font-semibold">
                                        ver
                                        </Link>
                                    </v-card-actions>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-container>
                </div>
                <div class="container-principal--item bg-white overflow-hidden shadow-xl sm:rounded-lg">
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
                            <tr v-for="item in positionTableOrder">
                                <td>{{ item.user_name }}</td>
                                <td>{{ item.total_points_earned }}</td>
                            </tr>
                        </tbody>
                    </v-table>
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

.container-button-actions{

    display: flex;
    gap:0.5%;
}

</style>
