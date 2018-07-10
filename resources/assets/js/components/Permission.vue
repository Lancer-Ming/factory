<template>
    <div class="container">
        <el-tree
                :data="data6"
                node-key="id"
                :default-expand-all="false"
                @node-drag-start="handleDragStart"
                @node-drag-enter="handleDragEnter"
                @node-drag-leave="handleDragLeave"
                @node-drag-over="handleDragOver"
                @node-drag-end="handleDragEnd"
                @node-drop="handleDrop"
                draggable
                :allow-drop="allowDrop"
                :allow-drag="allowDrag">
        </el-tree>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                data6: [{
                    id: 1,
                    label: '企业人员库',
                    children: [{
                        id: 8,
                        label: '建筑工人库',
                        children:[{
                            id: 17,
                            label: '新增',
                        },{
                            id: 18,
                            label: '保存',
                        },{
                            id: 19,
                            label: '编辑',
                        },{
                            id: 20,
                            label: '更新',
                        },{
                            id: 21,
                            label: '删除',
                        }]
                    },{
                        id: 9,
                        label: '管理人员库',
                        children: [{
                                id: 22,
                                label: '新增',
                            },{
                                id: 23,
                                label: '保存',
                            },{
                                id: 24,
                                label: '编辑',
                            },{
                                id: 25,
                                label: '更新',
                            },{
                                id: 26,
                                label: '删除',
                            }]

                    },{
                        id: 10,
                        label: '实名制统计',
                        children: [{
                            id: 27,
                            label: '新增',
                        },{
                            id: 28,
                            label: '保存',
                        },{
                            id: 29,
                            label: '编辑',
                        },{
                            id: 30,
                            label: '更新',
                        },{
                            id: 31,
                            label: '删除',
                        }]
                    },{
                        id: 11,
                        label: '企业管理'
                    },{
                        id: 12,
                         label: '部门管理'
            }]
                }, {
                    id: 2,
                    label: '项目管理',
                    children: [{
                        id: 13,
                        label: '现场管理'
                    }, {
                        id: 14,
                        label: '花名册'
                    },{
                        id: 15,
                        label: '同步市级配置'
                    },{
                        id: 16,
                        label: '培训管理'
                    }]
                },
                    ],
                defaultProps: {
                    children: 'children',
                    label: 'label'
                }
            };
        },
        methods: {
            handleDragStart(node, ev) {
                console.log('drag start', node);
            },
            handleDragEnter(draggingNode, dropNode, ev) {
                console.log('tree drag enter: ', dropNode.label);
            },
            handleDragLeave(draggingNode, dropNode, ev) {
                console.log('tree drag leave: ', dropNode.label);
            },
            handleDragOver(draggingNode, dropNode, ev) {
                console.log('tree drag over: ', dropNode.label);
            },
            handleDragEnd(draggingNode, dropNode, dropType, ev) {
                console.log('tree drag end: ', dropNode && dropNode.label, dropType);
            },
            handleDrop(draggingNode, dropNode, dropType, ev) {
                console.log('tree drop: ', dropNode.label, dropType);
            },
            allowDrop(draggingNode, dropNode, type) {
                if (dropNode.data.label === '二级 3-1') {
                    return type !== 'inner';
                } else {
                    return true;
                }
            },
            allowDrag(draggingNode) {
                return draggingNode.data.label.indexOf('三级 3-2-2') === -1;
            }
        }
    };
</script>