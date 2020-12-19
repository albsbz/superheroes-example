<template>
    <div>
        <div class="img-wrapper">
            <img
                v-for="image in superhero.images"
                :key="image.id"
                :src="image.url"
                :alt="'image_' + image.id"
                class="photo"
            />
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
        <div>Origin description: {{ superhero.origin_description }}</div>
    </div>
</template>
<script>
// import api from "../assets/api/users";
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
</style>
