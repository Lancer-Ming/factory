<template>
    <div class="container manager-page">
        <div class="toolsbar">
            <div class="toolsbar">
                <el-row class="btnBox">
                    <el-button
                            size="mini"
                            type="primary"
                            icon="el-icon-plus"
                            @click="handleAdd">新增
                    </el-button>
                    <el-button
                            size="mini"
                            type="primary"
                            plain
                            icon="el-icon-edit"
                            @click="handleEdit">编辑
                    </el-button>
                    <el-button
                            size="mini"
                            type="danger"
                            icon="el-icon-delete"
                            @click="handleDeleteSeleted">删除
                    </el-button>
                    <el-button
                            size="mini"
                            icon="el-icon-sort"
                            @click="importData">导入
                    </el-button>
                    <el-button
                            size="mini"
                            icon="el-icon-download"
                            @click="downloadTmp">模板下载
                    </el-button>
                    <el-button
                            size="mini"
                            icon="el-icon-download"
                            @click="exportCurrentData">导出当前数据
                    </el-button>
                    <el-button
                            size="mini"
                            icon="el-icon-download"
                            @click="exportAllData">导出全部数据
                    </el-button>
                </el-row>
                <div class="searchBox">
                    <el-row>
                        <el-form :inline="true" size="mini">
                            <el-form-item label="企业名称">
                                <el-input v-model="name" placeholder="请输入内容"></el-input>
                            </el-form-item>
                            <el-form-item label="法人代表">
                                <el-input v-model="leader" placeholder="请输入法人代表"></el-input>
                            </el-form-item>
                            <el-form-item label="单位类型">
                                <el-select v-model="utype_id" multiple filterable placeholder="请选择" value-key="item">
                                    <el-option
                                            v-for="item in options"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                            <el-button type="primary" plain size="mini" @click="search" icon="el-icon-search">搜索</el-button>
                            <el-button>重置</el-button>
                        </el-form>
                    </el-row>
                </div>
            </div>
            <el-row class="searchBox">
                <el-form :inline="true" size="mini">
                    <el-form-item label="编码">
                        <el-input v-model="unit_no" placeholder="编码"></el-input>
                    </el-form-item>
                    <el-form-item label="部门名称">
                        <el-input v-model="name" placeholder="部门名称"></el-input>
                    </el-form-item>
                    <el-form-item label="状态">
                        <el-select v-model="form.status_id" placeholder="请选择单位状态">
                            <el-option
                                    v-for="(item,index) in d_status"
                                    :key="index"
                                    :label="item"
                                    :value="index"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item label="单位名称">
                        <el-input v-model="name" placeholder="单位名称"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="search">搜索</el-button>
                        <el-button>重置</el-button>
                    </el-form-item>
                </el-form>
            </el-row>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {}
        }
    }
</script>