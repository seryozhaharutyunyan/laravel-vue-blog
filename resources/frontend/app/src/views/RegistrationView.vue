<template>
    <div>
        <div>
            <header >
                <h2>Registration</h2>
                <div>
                    <router-link class="m-1 fs-3 text-muted" :to="{name: 'home'}">Home</router-link>
                    <router-link class="m-1 fs-3 text-muted" :to="{name: 'login'}">Login</router-link>
                </div>
            </header>

            <div class="d-flex col-12 flex-row text-center justify-content-center">
                <div v-if="success" class="m-3 p-3 col-10 col-sm-6">
                    <span class="display-6">{{ success }}</span>
                </div>
                <div v-else class="m-3 p-3 col-10 col-sm-6">
                    <input type="text" class="form-control m-3 mb-0  p-3" name="name" v-model.trim="requestData.nik_name"
                           placeholder="Name">
                    <div class="text-danger text-start m-o ps-3">{{ err.nik_name[0] }}</div>
                    <input type="email" class="form-control m-3 mb-0  p-3" name="email" v-model.trim="requestData.email"
                           placeholder="Email">
                    <div class="text-danger text-start m-o ps-3">{{ err.email[0] }}</div>
                    <select v-model="requestData.country_id" class="form-select m-3 mb-0  p-3">
                        <option disabled value="">Country</option>
                        <option v-for="(c, k) in countries" :value="c.id" :key="k">
                            {{ c.name }}
                        </option>
                    </select>

                    <div class="text-danger text-start m-o ps-3">{{ err.country_id[0] }}</div>

                    <input type="date" class="form-control m-3 mb-0  p-3" v-model="requestData.age"
                           max="2006-01-01">
                    <div class="text-danger text-start m-o ps-3">{{ err.age[0] }}</div>

                    <div @click="removeImg()" class="col-3 m-auto btn">
                        <div v-show="image" class="form-control  mt-2 p-1">
                            <img :src="image">
                            <span class="text-danger">Remove image</span>
                        </div>
                    </div>

                    <input ref="image" id="formFile" type="file" class="form-control m-3 mb-0  p-3" accept="image/*"
                           @input="fileUpload($event)" placeholder="Image">
                    <div name="image" class="text-danger text-start m-o ps-3">{{ err.img[0] }}</div>


                    <div>
                        <label class="p-3">Gender</label><br>
                        <input class="form-check-input" type="radio" name="gender" v-model="requestData.gender"
                               value="male">
                        <label class="form-check-label p-3 pt-0">Male</label><br>
                        <input class="form-check-input" type="radio" name="gender" v-model="requestData.gender"
                               value="female">
                        <label class="form-check-label p-3 pt-0">Female</label>
                    </div>
                    <div class="text-danger text-start m-o ps-3">{{ err.gender[0] }}</div>
                    <button @click="registration()" class="btn btn-info m-3 p-3">
                        Registration
                    </button>

                </div>
            </div>
        </div>
    </div>

</template>

<script>
import axios from "axios";
import mixin from "@/mixins/mixin";

export default {
    name: "ModalRegComponent",

    mixins:[mixin],

    data() {
        return {
            err: {
                nik_name: [''],
                email: [''],
                country_id: [''],
                age: [''],
                gender: [''],
                img: [''],
            },
            requestData: {
                nik_name: '',
                email: '',
                country_id: '',
                age: '',
                img: '',
                gender: '',
            },
            countries: '',
            success: '',
            image: '',
        }
    },

    computed: {
        url() {
            return this.$store.getters.getUrl + '/registration'
        }
    },

    methods: {
        fileUpload(event) {
            this.requestData.img = event.target.files[0];

            const reader = new FileReader();

            reader.addEventListener("load", function () {

                this.image = reader.result;

            }.bind(this), false);

            if (this.requestData.img) {
                if (this.requestData.img.name) {
                    reader.readAsDataURL(this.requestData.img);
                }
            }
        },

        removeImg(){
            this.image='';
            this.requestData.img='';
            this.$refs.image.value='';
        },

        registration() {
            this.err = {
                nik_name: [''],
                email: [''],
                country_id: [''],
                age: [''],
                gender: [''],
                img: [''],
            }

            const data = new FormData();
            data.append('nik_name', this.requestData.nik_name);
            data.append('email', this.requestData.email);
            data.append('country_id', this.requestData.country_id);
            data.append('img', this.requestData.img);
            data.append('gender', this.requestData.gender);
            data.append('age', this.requestData.age);

            axios.post(this.url,
                data)
                .then((r) => {

                    this.requestData = {
                        nik_name: '',
                        email: '',
                        country_id: '',
                        age: '',
                        img: '',
                        gender: '',
                    };

                    this.success = r.data;
                })
                .catch((err) => {
                    console.log(err)
                    if (err.response) {
                        this.err = Object.assign(this.err, err.response.data.errors);
                    }
                });

        },

        query() {
            axios.get(this.url)
                .then(r => {
                    this.countries = r.data
                })
                .catch(err => {
                    console.log(err);
                });
        },
    },

    created() {
        this.query();
    }
}
</script>

<style scoped>
img {
    border-radius: 5px;
    width: 100%;
    max-height: 170px;
}

header {
    border-bottom: 3px solid #696969;
    color: #4AAE9B;
    justify-content: space-between;
}
</style>
