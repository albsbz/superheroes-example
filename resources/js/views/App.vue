<template>
    <div>
        <h1>Superheroes App</h1>

        <p>
            <router-link :to="{ name: 'superhero.index' }"
                >All superheroes</router-link
            >
            |
            <router-link :to="{ name: 'superhero.favorites' }"
                >Favorite superheroes</router-link
            >
            |
            <router-link :to="{ name: 'superhero.compare' }"
                >Compare superheroes</router-link
            >
        </p>

        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
export default {};
</script>
