<template>
    <div class="row mt-5">
        <div class="col-12">
            <el-button type="primary" @click="add">新增</el-button>
            <template>
                <create-or-edit :visible.sync="visibleDialog"></create-or-edit>
            </template>
        </div>
        <div class="col-12 ">
            <el-tree
                :data="data"
                show-checkbox
                node-key="id"
                :default-expanded-keys="[2, 3]"
                :default-checked-keys="[5]"
                :props="defaultProps">
            </el-tree>
        </div>
    </div>
</template>

<script>
    import CreateOrEdit from "./components/CreateOrEdit";

    export default {
        name: "Index",
        components: {CreateOrEdit},
        data() {
            return {
                visibleDialog: false,
                data: [{
                    id: 1,
                    label: '一级 1',
                    children: [{
                        id: 4,
                        label: '二级 1-1',
                        children: [{
                            id: 9,
                            label: '三级 1-1-1'
                        }, {
                            id: 10,
                            label: '三级 1-1-2'
                        }]
                    }]
                }, {
                    id: 2,
                    label: '一级 2',
                    children: [{
                        id: 5,
                        label: '二级 2-1'
                    }, {
                        id: 6,
                        label: '二级 2-2'
                    }]
                }, {
                    id: 3,
                    label: '一级 3',
                    children: [{
                        id: 7,
                        label: '二级 3-1'
                    }, {
                        id: 8,
                        label: '二级 3-2'
                    }]
                }],
                defaultProps: {
                    children: 'children',
                    label: 'label'
                }
            };
        },
        methods: {
            add() {
                this.visibleDialog = true
            }
        }
    }
</script>

<style scoped>

</style>
