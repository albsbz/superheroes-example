<template>
    <div class="main-wrapper">
        <v-select
            v-model="superheroesToCompare"
            :items="superheroes"
            label="Superheroes to compare"
            item-value="id"
            item-text="nickname"
            multiple
            size="10"
        >
            <template v-slot:prepend-item>
                <v-list-item ripple @click="toggle">
                    <v-list-item-action>
                        <v-icon
                            :color="
                                superheroesToCompare.length > 0
                                    ? 'indigo darken-4'
                                    : ''
                            "
                        >
                            {{ icon }}
                        </v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>
                            Select All
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-divider class="mt-2"></v-divider>
            </template>
            <template v-slot:append-item>
                <v-divider class="mb-2"></v-divider>
                <v-list-item disabled>
                    <v-list-item-avatar color="grey lighten-3">
                        <v-icon>
                            mdi-alpha-s-circle
                        </v-icon>
                    </v-list-item-avatar>

                    <v-list-item-content v-if="likesAllSuperhero">
                        <v-list-item-title>
                            Holy smokes, someone call the Superhero police!
                        </v-list-item-title>
                    </v-list-item-content>

                    <v-list-item-content v-else-if="likesSomeSuperhero">
                        <v-list-item-title>
                            Superhero Count
                        </v-list-item-title>
                        <v-list-item-subtitle>
                            {{ superheroesToCompare.length }}
                        </v-list-item-subtitle>
                    </v-list-item-content>

                    <v-list-item-content v-else>
                        <v-list-item-title>
                            How could you not like Superhero?
                        </v-list-item-title>
                        <v-list-item-subtitle>
                            Go ahead, make a selection above!
                        </v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </template>
        </v-select>

        <v-simple-table dense>
            <template v-slot:default>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Nickname</th>
                        <th>Real name</th>
                        <th>Catch phrase</th>
                        <th>Origin description</th>
                        <th>Superpowers</th>
                    </tr>
                </thead>
                <tr
                    v-for="superhero in superheroesFiltered"
                    :key="superhero.id"
                >
                    <td>
                        <router-link
                            :to="{
                                name: 'superhero.show',
                                params: { id: superhero.id }
                            }"
                        >
                            <img
                                :src="superhero.images[0].url"
                                :alt="superhero.images[0].name"
                                class="photo"
                            />
                        </router-link>
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
            </template>
        </v-simple-table>
    </div>
</template>
<script>
import requestSuperhero from "../assets/api/superhero.js";
export default {
    data() {
        return {
            superheroes: [],
            superheroesToCompare: []
        };
    },
    methods: {
        toggle() {
            this.$nextTick(() => {
                if (this.likesAllSuperhero) {
                    this.superheroesToCompare = [];
                } else {
                    this.superheroesToCompare = this.superheroes.map(
                        superhero => superhero.id
                    );
                }
            });
        }
    },
    computed: {
        superheroesFiltered() {
            return this.superheroes.filter(superhero =>
                this.superheroesToCompare.includes(superhero.id)
            );
        },

        likesAllSuperhero() {
            return this.superheroesToCompare.length === this.superheroes.length;
        },
        likesSomeSuperhero() {
            return (
                this.superheroesToCompare.length > 0 && !this.likesAllSuperhero
            );
        },
        icon() {
            if (this.likesAllSuperhero) return "mdi-close-box";
            if (this.likesSomeSuperhero) return "mdi-minus-box";
            return "mdi-checkbox-blank-outline";
        }
    },
    created() {
        requestSuperhero
            .getAll()
            .then(response => {
                this.superheroes = response.data;
            })
            .catch(err => {
                this.$router.push({ name: "404" });
            });
    }
};
</script>
<style lang="scss" scoped>
.photo {
    width: 128px;
    margin: 5px 10px;
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
