<template>
    <header-component></header-component>
    <div class="row bg-stat">
        <show-posts :path="path"/>
        <chat></chat>
    </div>
</template>

<script>
import HeaderComponent from "@/components/HeaderComponent";
import ShowPostsComponent from "@/components/ShowPostsComponent";
import ChatComponent from "@/components/ChatComponent";

export default {
    name: 'HomeView',

    components: {
        HeaderComponent: HeaderComponent,
        ShowPosts: ShowPostsComponent,
        Chat: ChatComponent,
    },


    data(){
        return {
            path:'/home'
        }
    }

}
</script>
