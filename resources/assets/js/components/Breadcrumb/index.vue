<template>
  <el-breadcrumb separator-class="el-icon-arrow-right">
    <el-breadcrumb-item :to="{ path: '/' }"  >控制台</el-breadcrumb-item>
    <el-breadcrumb-item v-for = "(item,index) in breadlist" :key = 'index' :to="{path: item.path}" >{{item.meta.title}}
    </el-breadcrumb-item>
  </el-breadcrumb>
</template>


<script>
    export default {
        data(){
            return {
                breadlist: ''
            }
        },
        created() {
            this.getBread();
        },
        methods:{
            getBread(){
                this.breadlist = this.$route.matched;
                this.$route.matched.forEach((item,index)=>{
                    //先判断父级路由是否是空字符串或者meta是否为首页，直接复写路径到根路径
                    item.meta.title === '首页' ? item.path = '/' : this.$route.path === item.path;
                });
            }
        },
        watch:{
            $route(){
                this.getBread();
            }
        }
    }
</script>