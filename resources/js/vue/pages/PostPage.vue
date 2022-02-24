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
            <h3>Gli ultimi articoli</h3>
            <div class="post-small" v-for="sidePost in posts" :key="sidePost.id">
                <div class="content">
                    <router-link :to="{ name: 'post', params: { slug: sidePost.slug } }">
                        <div class="cover">
                            <img class="img" :src="sidePost.image ? '/storage/' + sidePost.image : 'http://placehold.jp/606060/ffffff/400x250.png?text=Image%20preview&css=%7B%22border-radius%22%3A%2215px%22%7D'" :alt="sidePost.title + ' cover'">
                        </div>
                        <div class="text">
                            <h3 class="title">{{ sidePost.title }}</h3>
                            <div class="content-info">
                                <div class="category">
                                    <span>{{ sidePost.category ? sidePost.category.name : 'Nessuna categoria' }}</span>
                                </div>
                                <div class="tags" v-if="sidePost.tagNames.length > 0">
                                    <p>Tags: {{ sidePost.tagNames.join(', ') }}</p>
                                </div>
                            </div>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'PostPage',
    data() {
        return {
            post: {},
            posts: []
        }
    },
    created() {
        axios.get('/api/posts/' + this.$route.params.slug)
            .then( response => {
                this.post = response.data
            } )
        axios.get('/api/posts')
            .then( response => {
                this.posts = response.data
                this.posts.forEach(post => {
                    post.tagNames = []
                    post.tags.forEach(tag => {
                        post.tagNames.push(tag.name)
                    })
                })
            } )
    }
}
</script>

<style lang="scss" scoped>
.post {
    margin-bottom: 2rem;
    .title {
        font-size: 1.7rem;
    }
    .cover {
        margin: 2rem 0;
        width: 100%;
        height: 50vw;
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
    @media screen and (min-width: 768px) {
        width: 70%;
        padding-right: 2rem;
        .cover {
            height: 30vw;
        }
    }
}
.side-posts {
    border-top: .5px solid rgba(0,0,0,0.5);
    .post-small {
        margin-bottom: 1.5rem;
        * {
            color: black;
        }
        .cover {
            width: 100%;
            height: 40vw;
            .img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center;
            }
        }
        .text {
            .title {
                font-size: 1.2rem;
                margin: .8rem 0 .5rem;
            }
            .content-info {
                .category {
                    line-height: 1.7rem;
                }
            }
        }
        a:hover .title {
            text-decoration: underline;
        }
    }
    @media screen and (min-width: 768px) {
        width: 30%;
        padding-left: 2rem;
        border-top: none;
        border-left: .5px solid rgba(0,0,0,0.5);
        .cover {
            max-height: 15vw;
        }
    }
}
</style>