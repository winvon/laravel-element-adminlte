<template>
    <div class="row">
        <el-dialog :title="title" :visible.sync="dialogFormVisible">
            <el-form :model="form">
                <el-form-item label="菜单路由:" :label-width="formLabelWidth">
                    <el-select v-model="form.uri" placeholder="请选择">
                        <el-option
                            v-for="item in routeList"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="菜单名称:" :label-width="formLabelWidth">
                    <el-input v-model="form.name" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item label="父级菜单:" :label-width="formLabelWidth">
                    <el-input v-model="form.pid" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item label="菜单图标:" :label-width="formLabelWidth">
                    <el-input v-model="form.icon" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item label="类型:" :label-width="formLabelWidth">
                    <template>
                        <el-radio v-model="form.is_ajax" :label="0">菜单</el-radio>
                        <el-radio v-model="form.is_ajax" :label="1">权限</el-radio>
                    </template>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible = false">取 消</el-button>
                <el-button type="primary" @click="dialogFormVisible = false">确 定</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    export default {
        name: "CreateOrEdit",
        data() {
            return {
                model: {
                    uri: '',
                    name: '',
                    pid: 0,
                    icon: '',
                    guard_name: '',
                    sort: 0,
                    is_ajax: 0,
                },
                routeList:[],
                formLabelWidth: "120px",
                dialogFormVisible: this.visible,
                form: {
                    name: '',
                    region: '',
                    date1: '',
                    date2: '',
                    delivery: false,
                    type: [],
                    resource: '',
                    desc: ''
                },
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
                },
                required: false
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
                    return "新增权限"
                }
                return "编辑权限"
            }
        },
        mounted() {
            this.getRouteList()
        },
        methods: {
            getRouteList() {
                axios.get(routeList.routeList).then(response=>{
                    this.routeList=response.data
                })

            }
        }
    }
</script>

<style scoped>

</style>
