<template>
    <header-component></header-component>
    <div class="row bg-stat">
        <div class="col-sm-8 col-12"></div>
        <chat></chat>
    </div>
</template>

<script>
import HeaderComponent from "@/components/HeaderComponent";
import ChatComponent from "@/components/ChatComponent";

export default {
    name: "InfoView",

    components:{
        HeaderComponent: HeaderComponent,
        Chat:ChatComponent,
    }
}
</script>

<style scoped>

</style>
