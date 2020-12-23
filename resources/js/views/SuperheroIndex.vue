<template>
    <div>
        <div v-if="error" class="error">
            <p>{{ error }}</p>
        </div>
        <v-card>
            <v-card-title>Select superpower</v-card-title>
            <v-card-text>
                <form class="wrapper" @change="filterBySuperpower($event)">
                    <div
                        v-for="superpower in allSuperpowers"
                        :key="superpower.id"
                    >
                        <input
                            type="checkbox"
                            :id="superpower.id"
                            :value="superpower.id"
                            v-model="checkedSuperpowers"
                        />
                        <label for="superpower.id">{{ superpower.name }}</label>
                    </div>
                </form></v-card-text
            >
        </v-card>

        <div v-if="superheroes">
            <v-card
                class="mx-auto"
                max-width="344"
                outlined
                v-for="{ nickname, url, id } in superheroes"
                :key="id"
            >
                <router-link :to="{ name: 'superhero.show', params: { id } }">
                    <v-list-item three-line>
                        <v-list-item-content>
                            <div class="overline mb-4">
                                Nickname
                            </div>
                            <v-list-item-title class="headline mb-1">
                                {{ nickname }}
                            </v-list-item-title>
                        </v-list-item-content>

                        <v-list-item-avatar tile size="80" color="grey">
                            <img
                                class="photo"
                                v-if="url[0]"
                                :src="url[0]"
                                :alt="nickname"
                            />
                        </v-list-item-avatar>
                    </v-list-item>
                </router-link>

                <v-card-actions>
                    <v-btn outlined rounded text>
                        <router-link
                            :to="{ name: 'superhero.edit', params: { id } }"
                            >Edit
                        </router-link>
                    </v-btn>
                </v-card-actions>
            </v-card>
        </div>

        <v-btn outlined rounded text>
            <router-link :to="{ name: 'superhero.create' }"
                >Add superhero</router-link
            >
        </v-btn>
        <div class="pagination">
            <v-pagination
                class="my-4"
                :value="currentPage"
                :length="pagesLength"
                @input="goToPage"
                total-visible="5"
            ></v-pagination>
        </div>
    </div>
</template>
<script>
import requestSuperhero from "../assets/api/superhero.js";

export default {
    data() {
        return {
            superheroes: null,
            allSuperpowers: null,
            checkedSuperpowers: [],
            meta: null,
            links: {
                first: null,
                last: null,
                next: null,
                prev: null
            },
            error: null
        };
    },
    computed: {
        currentPage() {
            return this.meta?.current_page;
        },
        pagesLength() {
            return this.meta?.last_page;
        }
    },
    beforeRouteEnter(to, from, next) {
        requestSuperhero.getIndexData(
            {
                page: to.query.page
            },
            (err, data) => {
                next(vm => vm.setData(err, data));
            }
        );
    },
    created() {
        requestSuperhero.createData().then(response => {
            this.allSuperpowers = response.data.allSuperpowers;
        });
    },

    beforeRouteUpdate(to, from, next) {
        this.superheroes = this.links = this.meta = null;
        requestSuperhero.getIndexData(
            {
                page: to.query.page,
                superpower: this.checkedSuperpowers
            },
            (err, data) => {
                this.setData(err, data);
                next();
            }
        );
    },
    methods: {
        goToPage(pageToGo, reload = false) {
            if (pageToGo === this.meta.current_page && !reload) {
                return;
            }
            this.$router.push({
                query: {
                    page: pageToGo
                }
            });
        },

        setData(err, { data: data, links, meta }) {
            if (err) {
                this.error = err.toString();
            } else {
                // console.log(data);
                this.superheroes = data;
                this.links = links;
                this.meta = meta;
            }
        },
        filterBySuperpower() {
            if (this.meta.current_page === 1) {
                this.superheroes = this.links = this.meta = null;
                requestSuperhero.getIndexData(
                    {
                        superpower: this.checkedSuperpowers
                    },
                    (err, data) => {
                        this.setData(err, data);
                        // next();
                    }
                );
            } else {
                setTimeout(() => this.goToPage(1, true), 2000);
            }
        }
    }
};
</script>
<style scoped>
.photo {
    width: 128px;
}
</style>
