<template>
    <div class="main-wrapper">
        <div clas="with-border">
            <p>Add superhero to compare:</p>
            <select v-model="superheroesToCompare" multiple size="20">
                <option
                    v-for="superhero in superheroes"
                    v-bind:value="superhero.id"
                    :key="superhero.id"
                >
                    {{ superhero.nickname }}
                </option>
            </select>
        </div>

        <!-- <div class="img-wrapper">
            <img :src="images[0].url" :alt="images[0].name" class="photo" />
        </div>

        <div>
            Superpowers:
            <p v-for="superpower in superhero.superpowers" :key="superpower.id">
                {{ superpower.name }}
            </p>
        </div>
        <div>Nickname: {{ superhero.nickname }}</div>

        <div>Real name: {{ superhero.real_name }}"</div>
        <div>Catch phrase: {{ superhero.catch_phra }}</div>
        <div>Origin description: {{ superhero.origin_description }}</div> -->
        <div>
            <table class="with-border">
                <tr>
                    <th>Image</th>
                    <th>Nickname</th>
                    <th>Real name</th>
                    <th>Catch phrase</th>
                    <th>Origin description</th>
                    <th>Superpowers</th>
                </tr>
                <tr
                    v-for="superhero in superheroesFiltered"
                    :key="superhero.id"
                >
                    <td>
                        <img
                            :src="superhero.images[0].url"
                            :alt="superhero.images[0].name"
                            class="photo"
                        />
                    </td>
                    <td>
                        {{ superhero.nickname }}
                    </td>
                    <td>
                        {{ superhero.real_name }}
                    </td>
                    <td>{{ superhero.catch_phrase }}</td>
                    <td>{{ superhero.origin_description }}</td>
                    <td>
                        <span
                            v-for="(superpower, index) in superhero.superpowers"
                            :key="superpower.id"
                        >
                            {{ superpower.name
                            }}<span
                                v-if="
                                    index !=
                                        Object.keys(superhero.superpowers)
                                            .length -
                                            1
                                "
                                >,
                            </span>
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</template>
<script>
// import api from "../assets/api/users";
import requestSuperhero from "../assets/api/superhero.js";
export default {
    data() {
        return {
            superheroes: [],
            superheroesToCompare: []
        };
    },
    computed: {
        superheroesFiltered() {
            return this.superheroes.filter(superhero =>
                this.superheroesToCompare.includes(superhero.id)
            );
            // "selectedFavorites.includes(superhero.id)"
        }
    },
    created() {
        requestSuperhero.getAll().then(response => {
            this.superheroes = response.data;
        });
        // .catch(err => {
        //     this.$router.push({ name: "404" });
        // });
    }
};
</script>
<style lang="scss" scoped>
.main-wrapper {
    display: inline-flex;
}
.photo {
    width: 128px;
}
.img-wrapper {
    display: flex;
    width: 80vw;
    margin: 0 auto;
    flex-wrap: wrap;
}
.img-wrapper > img {
    margin: 10px;
}
.with-border {
    border: 1px solid black;
}
</style>
