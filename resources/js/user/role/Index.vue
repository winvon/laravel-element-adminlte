<template>
    <div class="row">
        <div class="col-12">
            <v-card>
                <div slot="header" class="row">
                    <div class="col-12 ">
                        <el-button type="primary" @click="handleAdd">新增</el-button>
                    </div>
                </div>
                <template>
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
        <template>
            <el-dialog
                title="提示"
                :visible.sync="dialogVisible"
                width="30%"
                :before-close="handleClose">
                <el-form :model="form" status-icon hide-required-asterisk  ref="form" label-width="100px" class="demo-ruleForm">
                    <el-form-item label="名称" prop="name"  :rules="[
      { required: true, message: '请输入名称', trigger: 'blur' },
    ]">
                        <el-input type="text" v-model="form.name"  ></el-input>
                    </el-form-item>
                    <el-form-item label="类型" prop="guard_name"  :rules="[
      { required: true, message: '请选择类型', trigger: 'blur' },
    ]">
                        <el-input type="text" v-model="form.guard_name"  ></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="submitForm('ruleForm')">提交</el-button>
                        <el-button @click="dialogVisible=false">取消</el-button>
                    </el-form-item>
                </el-form>
            </el-dialog>
        </template>
    </div>
</template>

<script>
    import VCard from "../../components/VCard";

    export default {
        name: "Index",
        components: {VCard},
        data() {
            return {
                dialogVisible:false,
                tableData: [],
                form: {
                    name: '',
                    guard_name: '',
                },
            }
        },
        created() {
            this.fetch()
        },
        methods: {
            submitForm(){
                this.$refs.form.validate((valid) => {
                    if (valid) {
                        ajax.post(routeList.store,this.form).then(re => {
                            helper.alert('新增成功',{type:'success'})
                            this.dialogVisible=false
                        })
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });

            },
            handleClose(){
                this.dialogVisible=false
            },
            handleAdd(){
                this.dialogVisible=true
            },
            handleEdit(row){

            },
            handleDel(row){

            },
            fetch() {
                ajax.get(routeList.index).then(re => {
                    this.tableData = re.data
                })
            }
        }
    }
</script>

<style scoped>

</style>
