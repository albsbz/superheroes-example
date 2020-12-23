<template>
    <div>
        <div class="subtitle-1">
            You may also like:
            <span v-for="(rec, index) in superhero.recomended" :key="rec.id">
                <router-link
                    :to="{ name: 'superhero.show', params: { id: rec.id } }"
                    >{{ rec.nickname }}</router-link
                ><span
                    v-if="index != Object.keys(superhero.recomended).length - 1"
                    >,
                </span>
            </span>
        </div>

        <template>
            <v-card>
                <div class="carousel-wrapper">
                    <v-carousel
                        value="0"
                        class="carousel"
                        height="auto"
                        hide-delimiters
                    >
                        <v-carousel-item
                            v-for="image in superhero.images"
                            :key="image.id"
                            class="img-wrapper"
                        >
                            <v-img
                                contain
                                :src="image.url"
                                :alt="'image_' + image.id"
                                class="photo"
                            />
                        </v-carousel-item>
                    </v-carousel>
                </div>

                <v-card-title> {{ superhero.nickname }}</v-card-title>
                <v-card-text>
                    <div class="my-4 subtitle-1">
                        Real name: {{ superhero.real_name }}"
                    </div>
                    <div>Catch phrase: {{ superhero.catch_phrase }}</div>
                    Superpowers:
                    <span
                        v-for="(superpower, index) in superhero.superpowers"
                        :key="superpower.id"
                    >
                        {{ superpower.name
                        }}<span
                            v-if="
                                index !=
                                    Object.keys(superhero.superpowers).length -
                                        1
                            "
                        >
                            ,
                        </span>
                    </span>
                    Origin description: {{ superhero.origin_description }}
                </v-card-text>

                <v-card-actions>
                    <v-btn color="error" text @click="deleteSuperhero">
                        Delete superhero
                    </v-btn>
                </v-card-actions>
            </v-card>
        </template>
    </div>
</template>
<script>
import requestSuperhero from "../assets/api/superhero.js";
export default {
    data() {
        return {
            superhero: {
                id: null,
                nickname: "",
                real_name: "",
                catch_phrase: "",
                origin_description: "",
                images: [],
                superpowers: []
            }
        };
    },
    watch: {
        $route(to, from) {
            requestSuperhero
                .find(to.params.id)
                .then(response => {
                    this.loaded = true;
                    this.superhero = { ...this.superhero, ...response.data };
                })
                .catch(err => {
                    this.$router.push({ name: "404" });
                });
        }
    },
    methods: {
        deleteSuperhero() {
            requestSuperhero
                .delete(this.$route.params.id)
                .then(response => {
                    this.$router.push({ name: "superhero.index" });
                })
                .catch(err => {
                    this.$router.push({ name: "404" });
                });
        }
    },
    created() {
        requestSuperhero
            .find(this.$route.params.id)
            .then(response => {
                this.loaded = true;
                this.superhero = { ...this.superhero, ...response.data };
            })
            .catch(err => {
                this.$router.push({ name: "404" });
            });
    }
};
</script>
<style lang="scss" scoped>
.photo {
    height: 200px;
}
.carousel-wrapper {
    max-width: 50vw;
    margin: 0 auto;
}
</style>
