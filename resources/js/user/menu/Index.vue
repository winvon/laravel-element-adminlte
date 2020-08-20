<template>
    <div class="row mt-5">
        <div class="col-12">
            <el-button type="primary" @click="add">新增</el-button>
            <template>
                <create-or-edit @updateList="getMenuList" :visible.sync="visibleDialog" :item="item" :tree="tree" :node="node"></create-or-edit>
            </template>
        </div>
        <div class="col-12 mt-3">
            <el-tree
                :data="tree"
                node-key="id"
                :expand-on-click-node="false"
                default-expand-all
                :props="defaultProps">
                <span class="custom-tree-node" slot-scope="{ node, data }">
                    <span>{{ node.label }}</span>
                    <span>
                      <el-button
                          type="text"
                          size="mini"
                          @click="() => append(data)">
                        添加
                          <i class="el-icon-circle-plus"></i>
                      </el-button>
                      <el-button
                          type="text"
                          size="mini"
                          @click="() => edit(node,data)">
                        编辑
                         <i class="el-icon-edit"></i>
                         <i class="eel-icon-info"></i>
                      </el-button>
                      <el-button
                          type="text"
                          size="mini"
                          @click="() => remove(node, data)">
                        删除<i class="el-icon-remove"></i>
                      </el-button>
                      <el-button
                          type="text"
                          size="mini">
                        <i class="el-icon-info" style="color: #409EFF"></i></i>
                      </el-button>
                    </span>
                  </span>
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
                menuList: [],
                item: {},
                tree: [],
                node: {},
                defaultProps: {
                    children: 'children',
                    label: 'name'
                }
            };
        },
        computed:{

        },
        created() {
            this.getMenuList()
        },
        methods: {
            append(data) {

            },

            edit(node,data) {
                this.item = data
                this.node = node
                this.visibleDialog = true
            },

            remove(node, data) {

            },

            add() {
                this.visibleDialog = true
            },
            getMenuList() {
                axios.get(routeList.menuList).then(response => {
                    this.bindData(response.data)
                })
            },
            bindData(data) {
                this.menuList=data
                this.tree=data
            }
        }
    }
</script>

<style scoped>

</style>
