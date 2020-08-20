<template>
    <div class="row">
        <div class="col-12">
            <el-table
                :data="tableData"
                style="width: 100%">
                <el-table-column
                    prop="name"
                    label="账号"
                    width="180">
                </el-table-column>
                <el-table-column
                    prop="email"
                    label="邮箱"
                    width="180">
                </el-table-column>
                <el-table-column
                    prop="created_at"
                    label="创建时间">
                </el-table-column>
                <el-table-column
                    fixed="right"
                    label="操作"
                    width="100">
                    <template slot-scope="scope">
                        <el-button @click="handleClick(scope.row)" type="text" size="small">编辑</el-button>
                    </template>
                </el-table-column>
            </el-table>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Index",
        data() {
            return {
                tableData: []
            }
        },
        created() {
            this.fetch()
        },
        methods: {
            fetch() {
                ajax.get(routeList.userList).then(res => {
                    this.tableData = _.get(res, 'data')
                })
            },
            handleClick(row) {
                this.$router.push({name: "Edit", params: {id: row.id}});
            }
        }
    }
</script>

<style scoped>

</style>
