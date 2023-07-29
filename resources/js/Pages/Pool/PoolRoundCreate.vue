<script setup>
const emit = defineEmits(['createdPoolRound', 'cancelCreatePoolRound'])

const createPoolRound = () => {

    alert("se ha creado el pool round");

    console.log("hacer fetch al backend para crear pool round");

    emit("createdPoolRound");
};

</script>

<template>
    <v-container>
        <v-card>
            <v-card-title>
                <span class="text-h5">Crear Round Pool</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>

                        <v-col cols="12" sm="12">
                            <v-select :items="['Barcelona vs Real Madrid', 'Alt Madrid vs Betis']" variant="outlined"
                                label="Partidos a seleccionar" required multiple chips></v-select>
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
</template>  