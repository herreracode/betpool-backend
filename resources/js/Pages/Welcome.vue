<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />

    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">


            <v-card
                class="mx-auto"
                max-width="344"
            >
                <v-card-text>
                    <p class="text-h4 text--primary">
                        Betpool
                    </p>
                    <div class="text--primary">
                        App de predicciones deportivas
                    </div>
                </v-card-text>
                <v-card-actions>
                    <div v-if="canLogin">
                        <Link v-if="$page.props.user" :href="route('dashboard')" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</Link>

                        <template v-else>
                            <Link :href="route('login')" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</Link>

                            <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</Link>
                        </template>
                    </div>
                </v-card-actions>
            </v-card>
        </div>
    </div>
</template>
