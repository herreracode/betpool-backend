<script setup>
const emit = defineEmits(['createdPool', 'cancelCreatePool'])

const createPool = () => {
    
    alert("se ha creado el pool");
    
    console.log("hacer fetch al backend para crear pool");
    
    emit("createdPool");
};

</script>

<template>
    <v-container>
        <v-card>
            <v-card-title>
                <span class="text-h5">Crear Pool</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="12" sm="12" md="12">
                            <v-text-field variant="outlined" label="Nombre del pool" required></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="12">
                            <v-select :items="['Liga Española', 'Premier League', 'Serie A']"
                            variant="outlined" label="Competiciones favoritas" required multiple chips></v-select>
                        </v-col>
                        <v-col cols="12" sm="12">
                            <v-combobox  :hide-no-data="false" :items="['hola','chao']"
                                hide-selected 
                                hint="Maximum of 5 tags" 
                                label="Usuarios a invitar" 
                                multiple
                                variant="outlined"
                                chips>
                            </v-combobox>
                        </v-col>
                    </v-row>
                </v-container>
                <small>*indicates required field</small>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue-darken-1" variant="text" @click="$emit('cancelCreatePool')">
                    Cancelar 
                </v-btn>
                <v-btn color="blue-darken-1" variant="text" @click="createPool()">
                    Guardar
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-container>
</template>

<style scoped></style>
