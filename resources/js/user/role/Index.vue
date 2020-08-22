<template>
    <div class="row">
        <div class="col-12">
            <v-card>
                <template slot="header" class="clearfix">
                    <div class="col-12 ">
                        <el-button type="primary" @click="handleAdd">新增</el-button>
                    </div>
                </template>
                <template v-loading="loading">
                    <el-table
                        :data="tableData"
                        style="width: 100%">
                        <el-table-column
                            prop="name"
                            label="名称"
                            width="180">
                        </el-table-column>
                        <el-table-column
                            prop="guard_name"
                            label="类型"
                            width="180">
                        </el-table-column>
                        <el-table-column
                            label="操作">
                            <template slot-scope="scope">
                                <el-button @click="handleEdit(scope.row)" type="text" size="small">编辑</el-button>
                                <el-button @click="handleDel(scope.row)" type="text" size="small">删除</el-button>
                            </template>
                        </el-table-column>
                    </el-table>
                </template>
            </v-card>
        </div>
    </div>
</template>

<script>
    import VCard from "../../components/VCard";

    export default {
        name: "Index",
        components: {VCard},
        data() {
            return {
                loading: false,
                dialogVisible: false,
                tableData: [],
            }
        },
        created() {
            this.fetch()
        },
        methods: {
            handleClose() {
                this.dialogVisible = false
            },
            handleAdd() {
                this.$router.push({name: "Create"})
            },
            handleEdit(row) {
                this.$router.push({name: "Edit", params: {id: row.id}})
            },
            handleDel(row) {
                this.$confirm('此操作将删除该角色, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    let url = helper.bind_str(routeList.destroy, {id: row.id})
                    ajax.delete(url).then(re => {
                        this.fetch()
                        helper.message('操作成功', {type: "success"})
                    })
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消删除'
                    });
                });
            },
            fetch() {
                this.loading = true
                ajax.get(routeList.index).then(re => {
                    this.tableData = re.data
                }).finally(() => {
                    this.loading = false
                })
            }
        }
    }
</script>

<style scoped>

</style>
