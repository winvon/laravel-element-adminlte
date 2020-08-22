<template>
    <div class="row">
        <div class="col-12">
            <v-card>
                <template slot="header">
                    <div class="row">
                        <span>{{title}}</span>
                    </div>
                </template>
                <el-form :model="form" status-icon hide-required-asterisk ref="form" label-width="100px"
                         class="demo-ruleForm">
                    <el-form-item label="名称" prop="name" :rules="[
      { required: true, message: '请输入名称', trigger: 'blur' },
    ]">
                        <el-input type="text" v-model="form.name"></el-input>
                    </el-form-item>
                    <el-form-item label="类型" prop="guard_name" :rules="[
      { required: true, message: '请选择类型', trigger: 'blur' },
    ]">
                        <el-input type="text" v-model="form.guard_name"></el-input>
                    </el-form-item>
                    <el-form-item label="权限" prop="permissions" :rules="[
      { required: true, message: '请选择权限', trigger: 'blur' },
    ]">
                        <el-tree
                            ref="tree"
                            @check="setPermissions"
                            :data="menus"
                            v-model="form.permissions"
                            show-checkbox
                            default-expand-all
                            node-key="id"
                            :props="defaultProps">
                        </el-tree>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" v-if="!id" @click="submitForm('ruleForm')">提交</el-button>
                        <el-button type="primary" v-if="id" @click="submit('ruleForm')">编辑</el-button>
                        <el-button @click="$router.push({name:'Index'})">取消</el-button>
                    </el-form-item>
                </el-form>
            </v-card>
        </div>
    </div>
</template>

<script>
    import VCard from "../../components/VCard";

    export default {
        name: "CreateOrEdit",
        components: {VCard},
        data() {
            return {
                id: this.$route.params.id,
                form: {
                    name: '',
                    guard_name: '',
                    permissions: [],
                },
                defaultProps: {
                    children: 'children',
                    label: 'name'
                },
                menus: [],
                checkedKeys: [],
            }
        },
        computed: {
            title() {
                return this.id ? '新增' : '编辑'
            }
        },
        created() {
            this.getPermissions()
            this.fetch()
        },
        methods: {

            fetch() {
                if (!this.id) {
                    return
                }
                let url = helper.bind_str(routeList.update, {id: this.id})
                ajax.get(url).then(re => {
                    this.form = re
                    let permissions = _.get(this.form, 'permissions')
                    this.checkedKeys = _.map(permissions, 'menu_id')
                    this.$refs.tree.setCheckedKeys(this.checkedKeys);
                })
            },
            getPermissions() {
                ajax.get(routeList.menu).then(re => {
                    this.menus = re
                })
            },
            setPermissions() {
                this.form.permissions = this.$refs.tree.getCheckedKeys()
            },
            submitForm() {
                this.$refs.form.validate((valid) => {
                    if (valid) {
                        ajax.post(routeList.store, this.form).then(re => {
                            helper.alert('操作成功', {type: 'success'})
                            this.$router.push({name: "Index"})
                        })
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            submit() {
                this.$refs.form.validate((valid) => {
                    if (valid) {
                        let url = helper.bind_str(routeList.update, {id: this.id})
                        ajax.put(url, this.form).then(re => {
                            helper.alert('操作成功', {type: 'success'})
                            this.$router.push({name: "Index"})
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
