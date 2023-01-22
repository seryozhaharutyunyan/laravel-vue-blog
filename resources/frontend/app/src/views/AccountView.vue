<template>
    <div>
        <div>
            <header>
                <h2>Account</h2>
                <div>
                    <router-link class="m-1 fs-3 text-muted" :to="{name: 'home'}">Home</router-link>
                </div>
            </header>

            <div class="d-flex col-12 flex-row text-center justify-content-center ">
                <div v-if="success" class="row m-3 p-3 col-10 col-sm-6">
                    <span class="display-6">{{ success }}</span>
                </div>
            </div>
            <div class="d-flex col-12 flex-row text-center justify-content-center ">
                <button class="btn border-warning m-1" @click="showPassword">
                    Password
                    update
                </button>
                <button class="btn border-warning m-1" @click="showAccount">
                    Account
                    update
                </button>
            </div>
            <div v-if="passwordUpdate" class="d-flex col-12 flex-row text-center justify-content-center">
                <div class="m-3 p-3 col-10 col-sm-6">
                    <div class="col-3 m-auto btn">
                        <div class="form-control  mt-2 p-1">
                            <img :src="$store.getters.getURL+'/'+user.img">
                        </div>
                    </div>

                    <input :type="check ? 'text' : 'password'" class="form-control m-3 mb-0  p-3" name="name"
                           v-model.trim="userData.password"
                           placeholder="Yor password">
                    <div class="text-danger text-start m-o ps-3">{{ err.password[0] }}</div>
                    <div class="mt-2">
                        <label class="pe-2 text-dark" for="password">Show password </label>
                        <input id="password" type="checkbox" v-model="check">
                    </div>

                    <input :type="checkNew ? 'text' : 'password'" class="form-control m-3 mb-0  p-3" name="name"
                           v-model.trim="userData.passwordNew"
                           placeholder="New password">
                    <div class="text-danger text-start m-o ps-3">{{ err.passwordNew[0] }}</div>
                    <input :type="checkNew ? 'text' : 'password'" class="form-control m-3 mb-0  p-3" name="name"
                           v-model.trim="userData.passwordNew_confirmation"
                           placeholder="New password">
                    <div class="mt-2">
                        <label class="pe-2" for="passwordNew">Show password </label>
                        <input id="passwordNew" type="checkbox" v-model="checkNew">
                    </div>


                    <button @click="update()" class="btn btn-info m-3 p-3">
                        Update
                    </button>

                </div>
            </div>
            <div v-if="accountUpdate" class="d-flex col-12 flex-row text-center justify-content-center">

                <div class="m-3 p-3 col-10 col-sm-6">
                    <div class="col-3 m-auto btn">
                        <div class="form-control  mt-2 p-1">
                            <img :src="$store.getters.getURL+'/'+user.img">
                        </div>
                    </div>

                    <input :type="check ? 'text' : 'password'" class="form-control m-3 mb-0  p-3" name="name"
                           v-model.trim="userData.password"
                           placeholder="Yor password">
                    <div class="text-danger text-start m-o ps-3">{{ err.password[0] }}</div>
                    <div class="mt-2">
                        <label class="pe-2 text-dark" for="password">Show password </label>
                        <input id="password" type="checkbox" v-model="check">
                    </div>

                    <select v-model="userData.country_id" class="form-select m-3 mb-0  p-3">
                        <option disabled value="">Country</option>
                        <option v-for="(c, k) in data" :value="c.id" :key="k">
                            {{ c.name }}
                        </option>
                    </select>
                    <div class="text-danger text-start m-o ps-3">{{ err.country_id[0] }}</div>


                    <div @click="removeImg()" class="col-3 m-auto btn">
                        <div v-show="image" class="form-control  mt-2 p-1">
                            <img :src="image">
                            <span class="text-danger">Remove image</span>
                        </div>
                    </div>

                    <input ref="image" id="formFile" type="file" class="form-control m-3 mb-0  p-3" accept="image/*"
                           @input="fileUpload($event)" placeholder="Image">
                    <div name="image" class="text-danger text-start m-o ps-3">{{ err.img[0] }}</div>

                    <button @click="update()" class="btn btn-info m-3 p-3">
                        Update
                    </button>

                </div>
            </div>
        </div>
    </div>

</template>

<script>
import mixin from "@/mixins/mixin";
import api from "@/assets/axios/api";


export default {
    name: "ModalRegComponent",

    mixins:[mixin],

    data() {
        return {
            check: false,
            checkNew: false,
            passwordUpdate: false,
            accountUpdate: false,
            err: {
                password: [''],
                passwordNew: [''],
                passwordNew_confirmation: [''],
                country_id: [''],
                img: [''],
            },
            userData: {
                password: '',
                passwordNew: '',
                passwordNew_confirmation: '',
                country_id: '',
                img: '',

            },
            success: '',
            image: '',
        }
    },

    computed: {
        url() {
            return this.$store.getters.getUrl;
        }
    },

    methods: {

        close() {
            this.$emit('close');
        },

        showPassword() {
            this.err = {
                password: [''],
                passwordNew: [''],
                passwordNew_confirmation: [''],
                country_id: [''],
                img: [''],
            };
            this.userData = {
                password: '',
                passwordNew: '',
                passwordNew_confirmation: '',
                country_id: '',
                img: '',

            };
            this.image='';
            this.success='';

            this.passwordUpdate=!this.passwordUpdate;
            this.accountUpdate=false

        },

        showAccount() {
            this.err = {
                password: [''],
                passwordNew: [''],
                passwordNew_confirmation: [''],
                country_id: [''],
                img: [''],
            };
            this.userData = {
                password: '',
                passwordNew: '',
                passwordNew_confirmation: '',
                country_id: this.user.country_id,
                img: '',

            };
            this.image='';
            this.success='';

            this.accountUpdate=!this.accountUpdate;
            this.passwordUpdate=false
        },

        fileUpload(event) {
            this.userData.img = event.target.files[0];

            const reader = new FileReader();

            reader.addEventListener("load", function () {

                this.image = reader.result;

            }.bind(this), false);

            if (this.userData.img) {
                if (this.userData.img.name) {
                    reader.readAsDataURL(this.userData.img);
                }
            }
        },

        removeImg() {
            this.image = '';
            this.userData.img = '';
            this.$refs.image.value = '';
        },

        update() {
            this.err = {
                password: [''],
                passwordNew: [''],
                passwordNew_confirmation: [''],
                country_id: [''],
                img: [''],
            }
            let url = '';
            const data = new FormData();

            if (this.passwordUpdate) {
                data.append('password', this.userData.password);
                data.append('passwordNew', this.userData.passwordNew);
                data.append('passwordNew_confirmation', this.userData.passwordNew_confirmation);
                url = this.url + '/registration/password';
            } else if (this.accountUpdate) {
                data.append('password', this.userData.password);
                data.append('country_id', this.userData.country_id);
                data.append('img', this.userData.img);
                url = this.url + '/registration/account';
            } else {
                return;
            }

            api.post(url,
                data)
                .then(() => {
                    this.userData = {
                        password: '',
                        passwordNew: '',
                        passwordNew_confirmation: '',
                        country_id: '',
                        img: '',
                    };

                    this.getUser();
                    this.passwordUpdate=false;
                    this.accountUpdate=false;

                    this.success = 'You successfully upgraded';
                })
                .catch((err) => {
                    console.log(err)
                    if (err.response) {
                        this.err = Object.assign(this.err, err.response.data.errors);
                        this.removeImg();
                    }
                });

        },

    },

    created() {
        this.query(this.url + '/registration');
    },


}
</script>

<style scoped>
header {
    border-bottom: 3px solid #696969;
    color: #4AAE9B;
    justify-content: space-between;
}
img {
    border-radius: 5px;
    width: 100%;
    max-height: 170px;
}
</style>
