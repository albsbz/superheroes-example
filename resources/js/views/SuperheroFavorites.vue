<template>
    <div>
        <div v-if="message" class="alert">{{ message }}</div>
        <div>
            <p>Favorite superheroes:</p>

            <form @submit.prevent="onSubmit($event)">
                <v-select
                    v-model="selectedFavorites"
                    :items="superheroes"
                    item-value="id"
                    attach
                    chips
                    item-text="nickname"
                    multiple
                ></v-select>
                <v-btn color="primary" type="submit" :disabled="saving"
                    >Save</v-btn
                >

                <!-- <button ></button> -->
            </form>
        </div>
    </div>
</template>
<script>
// import api from "../assets/api/users";
import requestSuperhero from "../assets/api/superhero.js";
export default {
    data() {
        return {
            saving: false,
            message: null,
            superheroes: [],
            favorites: [],
            selectedFavorites: []
        };
    },
    computed: {
        superheroesFiltered() {
            return this.superheroes.filter(superhero =>
                this.selectedFavorites.includes(superhero.id)
            );
            // "selectedFavorites.includes(superhero.id)"
        }
    },
    methods: {
        onSubmit($event) {
            this.saving = true;
            requestSuperhero
                .setFavorites(this.selectedFavorites)
                .then(_ => {
                    this.saving = false;
                    this.message = "Favorite superheroes saved";
                    setTimeout(_ => {
                        this.message = null;
                    }, 2000);
                })
                .catch(err => {
                    this.$router.push({ name: "404" });
                });
        }
    },
    created() {
        this.saving = this.message = null;
        requestSuperhero
            .getAll()
            .then(response => {
                this.favorites = response.data.filter(
                    hero => hero.favorites == 1
                );
                this.selectedFavorites = this.favorites.map(h => h.id);
                // console.log(response.data);
                this.superheroes = response.data;
            })
            .catch(err => {
                this.$router.push({ name: "404" });
            });
    }
};
</script>

<style lang="scss" scoped>
$red: lighten(red, 30%);
$darkRed: darken($red, 50%);

.alert {
    background: $red;
    color: $darkRed;
    padding: 1rem;
    margin-bottom: 1rem;
    width: 50%;
    border: 1px solid $darkRed;
    border-radius: 5px;
}
</style>
