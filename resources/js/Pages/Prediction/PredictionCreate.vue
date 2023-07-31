<script setup>

</script>

<template>
    <v-toolbar dark color="info">
        <v-toolbar-title>Crear Predicciones</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
            <v-btn variant="text">
                Guardar
            </v-btn>
        </v-toolbar-items>
    </v-toolbar>
    <v-card>
        <v-card>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="12" sm="12" md="12">
                            <v-text-field variant="outlined" label="Nombre del pool" required></v-text-field>
                        </v-col>
                    </v-row>
                </v-container>
                <small>*indicates required field</small>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue-darken-1" variant="text" >
                    Cancelar 
                </v-btn>
                <v-btn color="blue-darken-1" variant="text">
                    Guardar
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-card>
</template>