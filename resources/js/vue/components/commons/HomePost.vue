<template>
    <div class="post post__big" v-if="index < 2">
        <div class="content">
            <router-link :to="{ name: 'post', params: { slug: post.slug } }">
                <div class="background">
                    <img class="img" :src="post.image ? 'storage/' + post.image : 'http://placehold.jp/606060/ffffff/800x500.png?text=Image%20preview&css=%7B%22border-radius%22%3A%2215px%22%7D'" :alt="post.title + ' cover'">
                </div>
                <div class="text">
                    <h3 class="title">{{ post.title }}</h3>
                    <div class="content-info">
                        <div class="category">
                            <span>{{ post.category ? post.category.name : 'Nessuna categoria' }}</span>
                        </div>
                        <div class="tags" v-if="tags.length > 0">
                            <p>Tags: {{ tags.join(', ') }}</p>
                        </div>
                    </div>
                </div>
            </router-link>
        </div>
    </div>
    <div class="post post__small" v-else>
        <div class="content">
            <router-link :to="{ name: 'post', params: { slug: post.slug } }">
                <div class="cover">
                    <img class="img" :src="post.image ? 'storage/' + post.image : 'http://placehold.jp/606060/ffffff/400x250.png?text=Image%20preview&css=%7B%22border-radius%22%3A%2215px%22%7D'" :alt="post.title + ' cover'">
                </div>
                <div class="text">
                    <h3 class="title">{{ post.title }}</h3>
                    <div class="content-info">
                        <div class="category">
                            <span>{{ post.category ? post.category.name : 'Nessuna categoria' }}</span>
                        </div>
                        <div class="tags" v-if="tags.length > 0">
                            <p>Tags: {{ tags.join(', ') }}</p>
                        </div>
                    </div>
                </div>
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: 'HomePost',
    props: { index: Number, post: Object },
    data() {
        return {
            tags: []
        }
    },
    created() {
        this.post.tags.forEach(tag => {
            this.tags.push(tag.name)
        })
    }
}
</script>

<style lang="scss" scoped>
@import '../../../../sass/_variables.scss';
.post {
    flex-shrink: 0;
    padding: .5rem;
    .content {
        width: 100%;
        height: 100%;
        .img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }
    }
    &.post__big {
        width: 100%;
        height: 400px;
        @media screen and (min-width: 992px) {
            width: 50%;
        }
        .content {
            position: relative;
            background-color: black;
            .background {
                position: absolute;
                width: 100%;
                height: 100%;
                opacity: .7;
                transition: opacity .4s;
            }
            .text {
                position: absolute;
                bottom: 0;
                left: 0;
                padding: 1rem;
                width: 100%;
                .title {
                    color: $_white;
                    font-weight: 200;
                    font-size: 1.5rem;
                    margin-bottom: 1rem;
                }
                .content-info {
                    font-weight: 200;
                    color: #eee;
                    display: flex;
                    justify-content: space-between;
                }
            }
            &:hover {
                .background {
                    opacity: .9;
                }
            }
        }
    }
    &.post__small {
        width: 100%;
        height: 300px;
        margin-bottom: 3rem;
        @media screen and (min-width: 576px) {
            width: 50%;
        }
        @media screen and (min-width: 992px) {
            width: 25%;
        }
        .content {
            * {
                color: black;
            }
            .cover {
                width: 100%;
                height: 200px;
            }
            .text {
                .title {
                    font-weight: 200;
                    font-size: 1.2rem;
                    margin: 1rem 0;
                }
                .content-info {
                    font-weight: 200;
                    color: #eee;
                    .category {
                        padding-bottom: .5rem;
                    }
                }
            }
            a:hover .title {
                text-decoration: underline;
            }
        }
    }
}
</style>