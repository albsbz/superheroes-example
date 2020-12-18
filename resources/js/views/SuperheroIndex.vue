<template>
    <div>
        <div v-if="error" class="error">
            <p>{{ error }}</p>
        </div>

        <ul v-if="superheroes">
            <li v-for="{ nickname, url, id } in superheroes" :key="id">
                <img
                    class="photo"
                    v-if="url[0]"
                    :src="url[0]"
                    :alt="nickname"
                />
                <strong>Nickname:{{ nickname }}</strong>
                <router-link :to="{ name: 'superhero.edit', params: { id } }"
                    >Edit</router-link
                >
            </li>
        </ul>
        <div>
            <router-link :to="{ name: 'superhero.create' }"
                >Add superhero</router-link
            >
        </div>
        <div class="pagination">
            <button :disabled="!prevPage" @click.prevent="goToPrev">
                Previous
            </button>
            <button
                v-for="page in allPages"
                :key="page"
                @click.prevent="goToPage(page)"
                :disabled="page === meta.current_page"
            >
                {{ page }}
            </button>
            <!-- {{ paginatonCount }} -->
            <button :disabled="!nextPage" @click.prevent="goToNext">
                Next
            </button>
        </div>
    </div>
</template>
<script>
import axios from "axios";

const getData = (page, callback) => {
    const params = { page };

    axios
        .get("/api/superheroes", { params })
        .then(response => {
            callback(null, response.data);
        })
        .catch(error => {
            callback(error, error.response.data);
        });
};

export default {
    data() {
        return {
            superheroes: null,
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
        allPages() {
            return Array.from(
                { length: this.meta ? this.meta.last_page : 0 },
                (v, i) => i + 1
            );
        },

        nextPage() {
            if (!this.meta || this.meta.current_page === this.meta.last_page) {
                return;
            }

            return this.meta.current_page + 1;
        },
        prevPage() {
            if (!this.meta || this.meta.current_page === 1) {
                return;
            }

            return this.meta.current_page - 1;
        },
        paginatonCount() {
            if (!this.meta) {
                return;
            }

            const { current_page, last_page } = this.meta;

            return `${current_page} of ${last_page}`;
        }
    },
    beforeRouteEnter(to, from, next) {
        getData(to.query.page, (err, data) => {
            next(vm => vm.setData(err, data));
        });
    },
    // when route changes and this component is already rendered,
    // the logic will be slightly different.
    beforeRouteUpdate(to, from, next) {
        this.superheroes = this.links = this.meta = null;
        getData(to.query.page, (err, data) => {
            this.setData(err, data);
            next();
        });
    },
    methods: {
        goToPage(pageToGo) {
            if (pageToGo === this.meta.current_page) {
                return;
            }
            this.$router.push({
                query: {
                    page: pageToGo
                }
            });
        },
        goToNext() {
            this.$router.push({
                query: {
                    page: this.nextPage
                }
            });
        },
        goToPrev() {
            this.$router.push({
                name: "superhero.index",
                query: {
                    page: this.prevPage
                }
            });
        },
        setData(err, { data: data, links, meta }) {
            if (err) {
                this.error = err.toString();
            } else {
                this.superheroes = data;
                this.links = links;
                this.meta = meta;
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
