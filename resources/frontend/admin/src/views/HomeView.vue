<template>
    <header-component></header-component>
    <div class="row">

        <nav-component></nav-component>

        <div class="col-9 col-sm-9 p-3 mt-5">
            <h2>Statistics</h2>
            <div class="row justify-content-center">
                <div class="col-12 col-sm-4 m-3 mt-5 p-3 bg-secondary radius text-start">
                    <span class="display-6">User count:<br> <i>{{ data.usersCount }}</i></span>
                </div>
                <div class="col-12 col-sm-4 m-3 mt-5 p-3 bg-secondary radius text-start">
                    <span class="display-6">Categories count:<br> <i>{{ data.categoriesCount }}</i></span>
                </div>
            </div>

            <div class="row justify-content-center ">
                <div class="col-12 col-sm-4 m-3 mt-5 p-3 bg-secondary radius text-start">
                    <span class="display-6">Posts count:<br> <i>{{ data.postsCount }}</i></span>
                </div>
                <div class="col-12 col-sm-4 m-3 mt-5 p-3 bg-secondary radius text-start">
                    <span class="display-6">Countries count:<br> <i>{{ data.countriesCount }}</i></span>
                </div>
            </div>

        </div>


    </div>
</template>

<script>
import HeaderComponent from "@/components/HeaderComponent";
import NavComponent from "@/components/NavComponent";
import mixin from "@/mixins";

export default {
    name: 'HomeView',
    components: {
        HeaderComponent,
        NavComponent
    },
    mixins: [mixin],

    computed: {
        url() {
            return this.$store.getters.getUrl;
        }
    },

    created() {
        this.query(this.url);
    }

}
</script>
