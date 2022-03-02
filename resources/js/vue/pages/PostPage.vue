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
            <div class="comments-section">
                <p class="comments-number" v-if="post.comments">{{ post.comments.length + ( post.comments.length != 1 ? ' Commenti' : ' Commento' )}}</p>
                <div class="new-comment">
                    <form @submit.prevent="addComment()">
                        <div class="comment-input">
                            <textarea v-model="formData.content" name="content" class="textarea" :class="{ error : formErrors.content }" rows="2" placeholder="Partecipa alla discussione..."></textarea>
                        </div>
                        <div class="bottom-form">
                            <div class="name-input">
                                <input v-model="formData.name" type="text" name="name" class="name" placeholder="Nome">
                            </div>
                            <button class="send-btn" type="submit" title="Aggiungi commento">Commenta</button>
                        </div>
                    </form>
                    <div v-if="commentSent" class="success">
                        <p>Il tuo commento è in fase di approvazione.</p>
                    </div>
                </div>
                <div class="all-comments" v-if="post.comments && post.comments.length > 0">
                    <div class="comment" v-for="comment in post.comments" :key="comment.id">
                        <div class="comment-avatar">
                            BP
                        </div>
                        <div class="comment-content">
                            <div class="comment-name">
                                <h4>{{ comment.name }}</h4>
                            </div>
                            <div class="comment-text">
                                <p>{{ comment.content }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="no-comments" v-else>
                    <p>Non ci sono commenti.</p>
                </div>
            </div>
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
            posts: [],
            formData: {
                post_id: null,
                name: '',
                content: ''
            },
            formErrors: {},
            commentSent: false
        }
    },
    mounted() {
        axios.get('/api/posts/' + this.$route.params.slug)
            .then( response => {
                this.post = response.data
                this.formData.post_id = this.post.id
            } )
            .catch( () => {
                this.$router.push( { name: '404-page' } )
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
    },
    methods: {
        addComment() {
            axios.post('/api/comments', this.formData)
                .then( response => {
                    this.formData.name = ''
                    this.formData.content = ''
                    this.commentSent = true
                    this.formErrors = {}
                } )
                .catch( error => {
                    this.formErrors = error.response.data.errors
                } )
        }
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
        padding-bottom: 2rem;
        margin-bottom: 2rem;
        border-bottom: .5px solid rgba(0,0,0,0.5);
    }
    .comments-section {
        .comments-number {
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .new-comment {
            margin-bottom: 2rem;
            border: 2px solid rgba(0,0,0,0.1);
            border-radius: 6px;
            background-color: rgba(0,0,0,.01);
            padding: 1rem;
            .comment-input {
                .textarea {
                    letter-spacing: 1px;
                    font-weight: 300;
                    line-height: 1.5rem;
                    width: 100%;
                    padding: .5rem;
                    font-size: 1rem;
                    border: 2px solid rgba(0,0,0,0.1);
                    border-radius: 3px;
                    resize: none;
                    margin-bottom: 1rem;
                    &.error {
                        border: 2px solid rgba(255,0,0,0.4);
                    }
                }
            }
            .bottom-form {
                display: flex;
                .name-input {
                    .name {
                        padding: .4rem;
                        font-size: .8rem;
                        letter-spacing: 1px;
                        font-weight: 300;
                        border: 2px solid rgba(0,0,0,0.1);
                        border-radius: 3px;
                    }
                }
                .send-btn {
                    padding: .4rem;
                    font-size: .8rem;
                    letter-spacing: 1px;
                    font-weight: 500;
                    border: none;
                    border-radius: 3px;
                    margin-left: 2rem;
                    background-color: rgb(0, 162, 255);
                    box-shadow: none;
                    color: white;
                    cursor: pointer;
                }
            }
            .success {
                border: 2px solid rgba(0,255,0,0.3);
                border-radius: 3px;
                padding: .5rem;
                text-align: center;
                background-color: rgba(0,255,0,0.1);
                color: rgba(0,0,0,0.6);
                font-size: .8rem;
                letter-spacing: 1px;
                font-weight: 500;
                margin-top: 1rem;
            }
        }
        .all-comments {
            .comment {
                margin-bottom: 1rem;
                padding-bottom: 1rem;
                display: flex;
                &-avatar {
                    width: 50px;
                    height: 50px;
                    border-radius: 3px;
                    background-color: rgba(0,0,0,0.2);
                    margin-right: 1rem;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 1.7rem;
                    font-weight: 200;
                    color: rgba(255,255,255,0.8);
                }
                &-content {
                    .comment-name {
                        margin-bottom: .5rem;
                    }
                    .comment-text {
                        font-weight: 200;
                    }
                }
            }
        }
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