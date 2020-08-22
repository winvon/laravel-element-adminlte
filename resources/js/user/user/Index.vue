<template>
    <div class="row">
        <div class="col-12">
            <v-card>
                <template  slot="header">
                    <div class="row">
                        <div class="col-12">
                            <el-button @click="handleAdd" type="primary">新增</el-button>
                        </div>
                    </div>
                </template>
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
                        label="角色">
                        <template slot-scope="scope">
                            <el-tag size="small" :key="index" v-for="(role,index) in get(scope.row,'roles')">{{get(role,'name')}}</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column
                        prop="created_at"
                        width="180"
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
                tableData: [],
                get:_.get,
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
            },
            handleAdd() {
                this.$router.push({name: "Create"});
            }
        }
    }
</script>

<style scoped>

</style>
