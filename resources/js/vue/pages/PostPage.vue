<template>
    <div class="page-wrapper">
        <div class="post">
            <div class="title">
                <h2>{{post.title}}</h2>
            </div>
            <div class="cover">
                <img class="img" :src="'/storage/' + post.image" :alt="post.title + ' cover'">
            </div>
            <div class="content" v-html="post.content"></div>
        </div>
        <div class="side-posts">

        </div>
    </div>
</template>

<script>
export default {
    name: 'PostPage',
    data() {
        return {
            post: {}
        }
    },
    created() {
        axios.get('/api/posts/' + this.$route.params.slug)
            .then( response => {
                this.post = response.data
            } )
    }
}
</script>

<style lang="scss" scoped>
.post {
    width: 70%;
    padding-right: 2rem;
    .title {
        font-size: 1.7rem;
    }
    .cover {
        margin: 2rem 0;
        width: 100%;
        height: 30vw;
        .img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
    }
    .content {
        letter-spacing: 1px;
        font-weight: 200;
        line-height: 1.5rem;
    }
}
.side-posts {
    width: 30%;
    height: 800px;
    background-color: grey;
}
</style>