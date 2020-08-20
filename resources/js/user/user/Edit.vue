<template>
    <div class="row">
        <div class="col-12 mt-3">
            <el-card>
                <div slot="header" class="clearfix">
                    <span>账号编辑</span>
                </div>
                <el-form :model="form" status-icon ref="form" label-width="100px" class="demo-ruleForm">
                    <el-form-item label="账号" prop="name" :rules="[
      { required: true, message: '请填写账号', trigger: 'blur' }
    ]">
                        <el-input type="text" v-model="form.name"></el-input>
                    </el-form-item>
                    <el-form-item label="邮箱" prop="email" :rules="[
      { required: true, message: '请填写邮箱', trigger: 'blur' }
    ]">
                        <el-input type="email" v-model="form.email"></el-input>
                    </el-form-item>
                    <el-form-item label="密码" prop="password">
                        <el-input type="password" v-model="form.password"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="submitForm('form')">修改</el-button>
                        <el-button @click="cancel">取消</el-button>
                    </el-form-item>
                </el-form>
            </el-card>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Edit",
        data() {
            return {
                id: this.$route.params.id,
                form: {
                    name: "",
                    email: "",
                    password: "",
                }
            }
        },
        created() {
            this.fetch()
        },
        methods: {
            fetch() {
                let url = helper.bind_str(routeList.userInfo, {id:this.id})
                ajax.get(url).then(res => {
                    this.form = res
                })
            },
            cancel(){
                this.$router.push({name:"Index"})
            },
            submitForm(){
                this.$refs['form'].validate((valid) => {
                    if (valid) {
                        let url=helper.bind_str(routeList.userUpdate,{id:this.id})
                        axios.put(url, this.form).then(response => {
                            helper.alert('编辑成功', {type: "success"})
                            this.$router.push({name:"Index"})
                        })
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
        }
    }
</script>

<style scoped>

</style>
