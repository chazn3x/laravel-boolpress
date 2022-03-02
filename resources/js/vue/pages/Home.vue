<template>
    <div class="posts-wrapper">
        <HomePost v-for="(post, index) in posts" :key="post.id" :index="index" :post="post"/>
    </div>
</template>

<script>

import HomePost from '../components/commons/HomePost.vue'

export default {
    name: 'Home',
    components: { HomePost },
    data() {
        return {
            posts: []
        }
    },
    created() {
        axios.get('api/posts')
            .then(response => {
                this.posts = response.data
            })
    }
}
</script>

<style lang="scss" scoped>
.posts-wrapper {
    padding: .5rem;
    display: flex;
    flex-wrap: wrap;
}
</style>