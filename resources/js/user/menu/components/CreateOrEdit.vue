<template>
    <div class="row">
        <el-dialog :title="title" :visible.sync="dialogFormVisible">
            <el-form :model="form">
                <el-form-item label="菜单路由:" :label-width="formLabelWidth">
                    <el-select v-model="form.uri" filterable placeholder="请选择">
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
                    <el-popover
                        v-model="popoverVisible"
                        placement="bottom"
                        width="800"
                        trigger="click">
                        <el-tree
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
                <el-form-item label="类型:" :label-width="formLabelWidth">
                    <template>
                        <el-radio v-model="form.is_ajax" :label="0">菜单</el-radio>
                        <el-radio v-model="form.is_ajax" :label="1">权限</el-radio>
                    </template>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible = false">取 消</el-button>
                <el-button type="primary" @click="submit">提 交</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    export default {
        name: "CreateOrEdit",
        data() {
            return {
                popoverVisible: false,
                form: {
                    uri: '',
                    name: '',
                    pname: '',
                    pid: 0,
                    icon: '',
                    guard_name: '',
                    sort: 0,
                    is_ajax: 0,
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
            tree:{
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
                    return "新增权限"
                }
                this.form = _.cloneDeep(this.item)
                return "编辑权限"
            },
            treeData(){
                return [{id:0,name:'根目录',children:this.tree}]
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
                axios.post(routeList.menuStore, this.form).then(response => {
                    this.menuList = response.data
                })
            }
        }
    }
</script>

<style scoped>

</style>
