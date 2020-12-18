<template>
    <div>
        <div v-if="message" class="alert">{{ message }}</div>
        <div v-if="!loaded">Loading...</div>
        <form @submit.prevent="onSubmit($event)" v-else>
            <div class="form-group">
                <label for="nickname">Nickname</label>
                <input id="nickname" v-model="superhero.nickname" />
            </div>
            <div class="form-group">
                <label for="real-name">Real name</label>
                <input id="real-name" v-model="superhero.real_name" />
            </div>
            <div class="form-group">
                <label for="catch-phrase">Catch phrase</label>
                <input
                    id="catch-phrase"
                    type="text"
                    v-model="superhero.catch_phrase"
                />
            </div>
            <div class="wrapper">
                <div class="form-group img-wrapper">
                    <div v-for="image in superhero.allImages" :key="image.id">
                        <input
                            type="checkbox"
                            :id="'image_' + image.id"
                            :value="image.id"
                            v-model="checkedImages"
                        />
                        <label for="'image_'+image.id"
                            ><img
                                :src="image.url"
                                :alt="'image_' + image.id"
                                class="photo"
                        /></label>
                    </div>
                </div>
            </div>
            <select v-model="selectedSuperpowers" multiple>
                <option
                    v-for="superpower in superhero.allSuperpowers"
                    v-bind:value="superpower.id"
                    :key="superpower.name"
                >
                    {{ superpower.name }}
                </option>
            </select>

            <div class="form-group">
                <button type="submit" :disabled="saving">Update</button>
                <button :disabled="saving" @click.prevent="onDelete($event)">
                    Delete
                </button>
            </div>
        </form>
    </div>
</template>
<script>
// import api from "../assets/api/users";
import requestSuperhero from "../assets/api/superhero.js";
export default {
    data() {
        return {
            message: null,
            loaded: false,
            saving: false,
            superhero: {
                id: null,
                nickname: "",
                real_name: "",
                catch_phrase: "",
                images: [],
                allImages: [],
                superpowers: [],
                allSuperpowers: []
            },
            checkedImages: [],
            selectedSuperpowers: []
        };
    },

    methods: {
        onSubmit(event) {
            this.saving = true;
            const updatedData = {
                nickname: this.superhero.nickname,
                real_name: this.superhero.real_name,
                catch_phrase: this.superhero.catch_phrase,
                images: this.checkedImages.map(checkedId => {
                    return this.superhero.allImages.filter(
                        image => image.id === checkedId
                    )[0];
                }),
                superpowers: this.selectedSuperpowers
            };
            console.log(updatedData);
            requestSuperhero
                .update(this.superhero.id, updatedData)
                .then(response => {
                    this.message = "Superhero updated";
                    setTimeout(() => (this.message = null), 2000);
                    this.superhero = response.data;
                })
                .catch(error => {
                    console.log(error);
                })
                .then(_ => (this.saving = false));
        },
        onDelete() {
            // this.saving = true;
            // api.delete(this.user.id).then(response => {
            //     this.message = "User Deleted";
            //     setTimeout(
            //         () => this.$router.push({ name: "users.index" }),
            //         2000
            //     );
            // });
        }
    },
    created() {
        // @todo load user details
        requestSuperhero
            .find(this.$route.params.id)
            .then(response => {
                this.loaded = true;
                this.superhero = response.data;
                response.data.images.map(image =>
                    this.checkedImages.push(image.id)
                );
                response.data.superpowers.map(superpower =>
                    this.selectedSuperpowers.push(superpower.id)
                );
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
.form-group label {
    display: block;
}
.alert {
    background: $red;
    color: $darkRed;
    padding: 1rem;
    margin-bottom: 1rem;
    width: 50%;
    border: 1px solid $darkRed;
    border-radius: 5px;
}
.photo {
    width: 128px;
}
.wrapper {
    border: 1px solid black;
    height: 30vh;
    overflow: auto;
}
.img-wrapper {
    display: flex;
    width: 80vw;
    margin: 0 auto;
    flex-wrap: wrap;
}
.img-wrapper > div {
    margin: 10px;
}
</style>
