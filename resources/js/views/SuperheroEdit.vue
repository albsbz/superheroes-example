<template>
    <div>
        <div v-if="message" class="alert">{{ message }}</div>
        <div v-if="errors">
            <div v-for="(error, k) in errors" :key="k" class="alert">
                {{ error[0] }}
            </div>
        </div>
        <div v-if="!loaded">Loading...</div>
        <form @submit.prevent="onSubmit($event)" v-else>
            <v-text-field
                label="Nickname *"
                hide-details="auto"
                v-model="superhero.nickname"
                :error="errors['nickname'] !== undefined"
            >
            </v-text-field>
            <v-text-field
                label="Real name *"
                hide-details="auto"
                v-model="superhero.real_name"
                :error="errors['real_name'] !== undefined"
            >
            </v-text-field>
            <v-text-field
                label="Catch phrase *"
                hide-details="auto"
                v-model="superhero.catch_phrase"
                :error="errors['catch_phrase'] !== undefined"
            >
            </v-text-field>
            <v-textarea
                label="Origin description *"
                hide-details="auto"
                v-model="superhero.origin_description"
                :error="
                    errors['origin_description'] &&
                        errors['origin_description'].length
                "
                rows="3"
            >
            </v-textarea>

            <!-- <div > -->
            <v-btn
                @click="toggleImageCatalog = !toggleImageCatalog"
                class="img-btn"
                >Select images
            </v-btn>
            <v-card class="wrapper" v-if="toggleImageCatalog">
                <v-card class="form-group img-wrapper">
                    <div v-for="image in superhero.allImages" :key="image.id">
                        <input
                            type="checkbox"
                            :id="'image_' + image.id"
                            :value="image.id"
                            v-model="checkedImages"
                        />
                        <label for="'image_'+image.id">
                            <img
                                :src="image.url"
                                :alt="'image_' + image.id"
                                class="photo"
                            />
                        </label>
                    </div>
                </v-card>
            </v-card>

            <v-select
                v-model="selectedSuperpowers"
                :items="superhero.allSuperpowers"
                item-value="id"
                attach
                chips
                item-text="name"
                multiple
            >
            </v-select>

            <div class="form-group">
                <v-btn type="submit" color="primary" :disabled="saving">
                    Update
                </v-btn>
                <v-btn
                    color="error"
                    :disabled="saving"
                    @click.prevent="onDelete($event)"
                >
                    Delete
                </v-btn>
            </div>
        </form>
    </div>
</template>
<script>
import requestSuperhero from "../assets/api/superhero.js";
export default {
    data() {
        return {
            message: null,
            errors: [],
            loaded: false,
            saving: false,
            superhero: {
                id: null,
                nickname: "",
                real_name: "",
                catch_phrase: "",
                origin_description: "",
                images: [],
                allImages: [],
                superpowers: [],
                allSuperpowers: []
            },
            toggleImageCatalog: false,
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
                origin_description: this.superhero.origin_description,
                images: this.checkedImages,
                superpowers: this.selectedSuperpowers
            };

            requestSuperhero
                .update(this.superhero.id, updatedData)
                .then(response => {
                    this.errors = [];
                    this.message = "Superhero updated";
                    setTimeout(() => {
                        this.message = null;
                    }, 2000);
                    this.superhero = { ...this.superhero, ...response.data };
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                })
                .then(_ => (this.saving = false));
        },
        onDelete() {
            this.saving = true;
            requestSuperhero
                .delete(this.superhero.id)
                .then(response => {
                    this.message = "Superhero deleted";
                    setTimeout(
                        () => this.$router.push({ name: "superhero.index" }),
                        2000
                    );
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                    setTimeout(() => (this.errors = null), 2000);
                });
        }
    },
    created() {
        requestSuperhero
            .find(this.$route.params.id)
            .then(response => {
                this.loaded = true;
                this.superhero = { ...this.superhero, ...response.data };
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
        requestSuperhero
            .createData()
            .then(response => {
                this.loaded = true;
                // console.log({ ...response.data });
                this.superhero = {
                    ...this.superhero,
                    ...{ ...response.data }
                };
            })
            .catch(error => {
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
    height: 150px;
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
.red-border {
    border-color: red;
}
.img-btn {
    margin: 10px;
}
</style>
