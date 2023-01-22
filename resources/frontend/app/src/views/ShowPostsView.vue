<template>
    <header-component></header-component>

    <div class="row bg-stat">
        <show-posts :path="path"/>
        <chat></chat>
    </div>
</template>

<script>
import HeaderComponent from "@/components/HeaderComponent";
import mixin from "@/mixins/mixin";
import ShowPostsComponent from "@/components/ShowPostsComponent";
import ChatComponent from "@/components/ChatComponent";

export default {
    name: 'ShowPostsView',

    components: {
        HeaderComponent: HeaderComponent,
        ShowPosts: ShowPostsComponent,
        Chat: ChatComponent,
    },

    mixins:[mixin],

    data(){
        return {
            path: ''
        }
    },

    created() {
        this.path='/posts/'+this.$route.params.id;
    }


}
</script>
