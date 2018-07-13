<template>
    <div class="container cache">
        <el-row>
            <el-button type="success" @click="handleCache">清除缓存</el-button>
        </el-row>
    </div>
</template>

<script>
import { removeCache } from '../api/cache'
    export default {
        name: 'cache',
        data() {
            return {
                
            }
        },
        methods: {
            handleCache() {
                removeCache().then(res => {
                    if (res.data.response_status === 'success') {
                        this.$message({
                            type: 'success',
                            showClose: true,
                            message: res.data.msg
                        })
                    }
                })
            }
        }
    }
</script>

