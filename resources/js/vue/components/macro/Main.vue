<template>
    <main class="main">
        <div class="container">
            <router-view :key="$route.path"></router-view>
        </div>
    </main>
</template>

<script>
export default {
    name: 'Main'
}
</script>

<style lang="scss" scoped>
.main {
    margin: 1rem 0;
    @media screen and (min-width: 768px) {
        margin: 2rem 0;
    }
}
</style>