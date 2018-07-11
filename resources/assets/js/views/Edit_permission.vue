<template>
    <div class="container">
        <el-checkbox :indeterminate="isIndeterminate" v-model="checkAll" @change="handleCheckAllChange">企业人员库</el-checkbox>
        <div style="margin: 15px 0;"></div>
        <el-checkbox-group v-model="checkedCities" @change="handleCheckedCitiesChange">
            <el-checkbox v-for="city in cities" :label="city" :key="city">{{city}}</el-checkbox>
        </el-checkbox-group>
    </div>
</template>

<script>
    const cityOptions = ['建筑工人库', '管理人员库', '实名制统计', '企业管理','部门管理'];
    export default {
        name: 'edit_permission',
        data() {
            return {
                checkAll: false,
                checkedCities: ['建筑工人库'],
                cities: cityOptions,
                isIndeterminate: true
            }
        },
        created() {
            console.log(this.$route.params)
        },
        methods: {
            handleCheckAllChange(val) {
                this.checkedCities = val ? cityOptions : [];
                this.isIndeterminate = false;
            },
            handleCheckedCitiesChange(value) {
                let checkedCount = value.length;
                this.checkAll = checkedCount === this.cities.length;
                this.isIndeterminate = checkedCount > 0 && checkedCount < this.cities.length;
            }
        }
    }
</script>