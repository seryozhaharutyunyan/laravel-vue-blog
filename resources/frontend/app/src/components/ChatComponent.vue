<template>
    <div class="col-sm-3 col-10  bg-secondary m-auto mt-3 chat radius border-warning">
        <div class="m-auto col-11 messages mt-2 mb-2 pt-2 pb-2 radius">
            <div>
                <div class="radius message col-11 m-auto mb-2" v-for="(m, key) in messages" :key="key">
                    <p class="text-start m-0 ms-1 me-1 p-1 fs-5">Email: {{ m.email }}</p>
                    <p class="text-start m-0 ms-1 me-1 p-1">{{ m.message }}</p>
                </div>
            </div>
        </div>
        <div class="col-11 m-1 m-auto">
            <div v-show="$store.getters.getAuth" class="fs-3 text-start col-12">{{ email }}</div>
            <input v-show="!$store.getters.getAuth" v-model="email" type="email" placeholder="Email"
                   class="form-control mt-1 p-2">
            <div class="text-danger col-12 text-start">{{ err.email[0] }}</div>
            <textarea v-model="message" placeholder="Message" class="p-1 radius col-12 mt-1"></textarea>
            <div class="text-danger col-12 text-start">{{ err.message[0] }}</div>
            <button class="btn btn-info mb-2" @click="send">Send</button>
        </div>
    </div>
</template>

<script>
import api from "@/assets/axios/api";
import Echo from "laravel-echo"

window.Pusher = require('pusher-js')
window.Echo= new Echo({
    broadcaster: 'pusher',
    key: 'da59a59bb45188b8e938',
    wsHost: "127.0.0.1",
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
});



export default {
    name: "ChatComponent",
    data() {
        return {
            email: '',
            message: '',
            user: {},
            err: {
                email: [''],
                message: ['']
            },
            messages: [],

        }
    },

    computed: {
        url() {
            return this.$store.getters.getUrl;
        }
    }
    ,

    methods: {
        connect() {
            window.Echo.channel('chat')
                .listen('NewMessage', (e) => {
                    this.messages=e.messages;
                })
        },

        send() {
            this.err = {
                email: [''],
                message: ['']
            };


            api.post(this.url + '/chat', {
                email: this.email,
                message: this.message,
            })
                .then(() => {
                    this.message='';
                })
                .catch(e => {
                    console.log(e)
                    this.err = Object.assign(this.err, e.response.data.errors);
                })
        }
        ,
        getUser() {
            if (localStorage.getItem('token')) {
                api.post(this.url + '/auth/me')
                    .then(r => {
                        console.log(r)

                        this.user = r.data;
                        this.email = this.user.email;
                    })
                    .catch(e => {
                        console.log(e);
                    });
            } else {
                this.user = {};
            }

        },

        getMessages() {
            api.get(this.url + '/chat')
                .then(r => {
                    console.log(r)
                    this.messages = r.data;
                })
                .catch(e => {
                    console.log(e);
                });
        }
    }
    ,

    watch: {
        '$store.state.auth'() {
            if (!this.$store.getters.getAuth) {
                this.email = '';
                this.err = {
                    email: [''],
                    message: ['']
                }
            }
        }
    }
    ,

    created() {
        this.getUser()
        this.getMessages();
        this.connect();
    },
}
</script>

<style scoped>
.chat {
    height: auto;
}

.messages {
    min-height: 400px;
    background-color: #bebebf;
}

.message {
    border: 1px solid rosybrown;
}


textarea {
    min-height: 100px;
}
</style>
