<template>
<div class="row justify-content-center">
    <div class="col-md-5 ">
        <div class="card mb-4">
            <div class="card-header">Post</div>
                <div class="card-body">
                    <form @submit.prevent="createPost" action="/posts" method="post">
                        <div class="form-group">
                            <label for="">Title</label>
                            <input v-model="form.title" type="text" name="title" class="form-control" placeholder="Title here...">
                        </div>
                        <div class="form-group">
                            <label for="">Text</label>
                            <textarea v-model="form.text" name="text" class="form-control" placeholder="text here..."></textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-block btn-secondary">Submit</button>
                        </div>
                    </form>        
                </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card mb-4" v-for="post in posts" :key="post.id">
            <div class="card-header">
                <strong>
                    <h4>
                        {{ post.user.profile.first_name }} {{ post.user.profile.last_name }} 
                        <span style="
                        font-family: monospace;
                        font-size: 13px;
                        color: #b5a1a1;">posted something
                        </span>
                    </h4>
                </strong>
                <span style="color: rgb(105, 105, 105);"><small>posted at:</small></span>
                <strong style="color: #8c8a8a;">
                     {{ post.created_at }}
                </strong>
                
                <span class="float-right">
                    <a @click="deletePost(post.id)" href="javascript:void(0)">X</a>
                </span>
            </div>
            <div class="card-body">
                <h4><strong style="text-transform: uppercase; color:#444"> {{ post.title }}</strong></h4>{{ post.text }}
            </div>
            <div class="card-footer">
                <ul class="list-group" style="margin-bottom: 10px">
                    <li class="list-group-item" v-for="comment in post.comments" :key="comment.id">
                        <span style="
                        background: #fff;
                        width: 30px;
                        height: 30px;
                        border-radius: 80%;
                        padding-left: 8px;
                        border: solid 2px #17a2b8;
                        color: #fff;
                        cursor: pointer;">o</span> 
                        <strong style="color: rgb(23, 162, 184); margin-left: 5px">
                            {{ comment.user.profile.first_name }} {{ comment.user.profile.last_name }}
                        </strong>  
                            {{ comment.text }}
                    </li>
                </ul>
                <input v-model="post.comment_text" type="text" class="form-control" placeholder="Say something about this post...">

                <button @click="comment(post)" class="btn btn-block btn-sm btn-info float-right mt-2">Comment</button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data () {
        return {
            posts: [],
            form: {}
        }
    },
    created () {
        this.getPosts()
    },
    methods: {
        createPost () {
            axios.post('/posts', this.form).then(response => {
                this.form = {}
                this.getPosts()
            })
        },
        getPosts () {
            axios.get('/posts').then(response => {
                this.posts = response.data
            })
        },
        comment (post) {
            const form = {
                post_id: post.id ,
                text: post.comment_text
            }
            axios.post('/comments', form).then(response => {
                this.getPosts()
            })
        },
        deletePost (id) {
            axios.delete('/posts/' + id).then(response => {
                this.getPosts()
            })
        }
    }
}
</script>
