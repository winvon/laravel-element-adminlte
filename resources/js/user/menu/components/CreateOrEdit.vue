<template>
    <div class="row">
        <el-dialog :title="title" :visible.sync="dialogFormVisible">
            <el-form :model="form" ref="form">
                <el-form-item label="菜单路由:" :label-width="formLabelWidth" prop="uri"
                              :rules="[
      { required: true, message: '请输入菜单路由', trigger: 'blur' }
    ]"
                >
                    <el-select v-model="form.uri" filterable placeholder="请选择">
                        <el-option
                            v-for="item in routeList"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="菜单名称:" :label-width="formLabelWidth" prop="name" :rules="[
      { required: true, message: '请输入菜单名称', trigger: 'blur' }
    ]">
                    <el-input v-model="form.name" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item label="父级菜单:" :label-width="formLabelWidth" prop="pname" :rules="[
      { required: false, message: '请选择父级菜单', trigger: 'blur' }
    ]">
                    <el-popover
                        v-model="popoverVisible"
                        placement="bottom"
                        width="800"
                        trigger="click">
                        <el-tree
                            v-model="form.pid"
                            :data="treeData"
                            @node-click="nodeClick"
                            :expand-on-click-node="false"
                            node-key="id"
                            default-expand-all
                            :props="defaultProps">
                        </el-tree>
                        <el-input v-model="form.pname" slot="reference" autocomplete="off"></el-input>
                        <el-input v-model="form.pid" type="hidden" autocomplete="off"></el-input>
                    </el-popover>
                </el-form-item>
                <el-form-item label="菜单图标:" :label-width="formLabelWidth">
                    <el-input v-model="form.icon" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item label="类型:" :label-width="formLabelWidth" prop="is_ajax" :rules="[
      { required: true, message: '请选择类型', trigger: 'blur' }
    ]">
                    <template>
                        <el-radio v-model="form.is_ajax" :label="false">菜单</el-radio>
                        <el-radio v-model="form.is_ajax" :label="true">ajax</el-radio>
                    </template>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible = false">取 消</el-button>
                <el-button type="primary" v-if="!edit" @click="submit">提 交</el-button>
                <el-button type="primary" v-if="edit" @click="submitEdte">编 辑</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    export default {
        name: "CreateOrEdit",
        data() {
            return {
                edit: false,
                popoverVisible: false,
                form: {
                    uri: '',
                    name: '',
                    pname: '',
                    pid: 0,
                    icon: '',
                    guard_name: '',
                    sort: 0,
                    is_ajax: false,
                },
                routeList: [],
                menuList: [],
                formLabelWidth: "120px",
                dialogFormVisible: this.visible,
                defaultProps: {
                    children: 'children',
                    label: 'name'
                }
            }
        },
        props: {
            visible: {
                type: Boolean,
                default: false
            },
            item: {
                type: Object,
                default: () => {
                    return {}
                }
            },
            node: {
                type: Object,
                default: () => {
                    return {}
                }
            },
            tree: {
                type: Array,
                default: () => {
                    return []
                }
            }
        },
        watch: {
            dialogFormVisible(val) {
                this.$emit('update:visible', val)
            },
            visible(val) {
                if (val !== this.dialogFormVisible) {
                    this.dialogFormVisible = val
                }
            }
        },
        computed: {
            title() {
                if (Object.keys(this.item).length === 0) {
                    this.edit = false
                    return "新增权限"
                }
                this.form = _.cloneDeep(this.item)
                console.log( this.form )
                this.form.pname=_.get( this.form,'parent.name')?_.get( this.form,'parent.name'):"根目录"
                this.form.pid=_.get( this.form,'parent.id')?_.get( this.form,'parent.id'):0
                this.edit = true
                return "编辑权限"
            },
            treeData() {
                return [{id: 0, name: '根目录', children: this.tree}]
            }
        },

        mounted() {
            this.getRouteList()
        },
        methods: {
            nodeClick(data, node, object) {
                this.form.pid = data.id
                this.form.pname = data.name
                this.popoverVisible = false
            },
            getRouteList() {
                axios.get(routeList.routeList).then(response => {
                    this.routeList = response.data
                })
            },
            submit() {
                this.$refs['form'].validate((valid) => {
                    if (valid) {
                        axios.post(routeList.menuStore, this.form).then(response => {
                            this.menuList = response.data
                            this.dialogFormVisible = false
                            helper.alert('新增成功', {type: "success"})
                            this.$emit('updateList')
                        })
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            submitEdte() {
                this.$refs['form'].validate((valid) => {
                    if (valid) {
                        let url = helper.bind_str(routeList.menuEdit, {id: this.form.id});
                        ajax.put(url, this.form).then(response => {
                            this.menuList = response.data
                            this.dialogFormVisible = false
                            helper.alert('编辑成功', {type: "success"})
                            this.$emit('updateList')
                        })
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>
