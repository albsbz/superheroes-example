<template>
    <v-app>
        <v-app-bar app>
            <v-tabs>
                <v-tab :to="{ name: 'superhero.index' }">
                    All superheroes
                </v-tab>
                <v-tab :to="{ name: 'superhero.favorites' }">
                    Favorite superheroes
                </v-tab>
                <v-tab :to="{ name: 'superhero.compare' }">
                    Compare superheroes
                </v-tab>
            </v-tabs>
        </v-app-bar>

        <v-main>
            <v-container fluid> <router-view></router-view></v-container
        ></v-main>
    </v-app>
</template>
<script>
export default {};
</script>
