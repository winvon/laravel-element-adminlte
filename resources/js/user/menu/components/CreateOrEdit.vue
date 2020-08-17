<template>
    <div class="row">
        <el-dialog :title="title" :visible.sync="dialogFormVisible">
            <el-form :model="form">
                <el-form-item label="活动名称" :label-width="formLabelWidth">
                    <el-input v-model="form.name" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item label="活动区域" :label-width="formLabelWidth">
                    <el-select v-model="form.region" placeholder="请选择活动区域">
                        <el-option label="区域一" value="shanghai"></el-option>
                        <el-option label="区域二" value="beijing"></el-option>
                    </el-select>
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

        data() {
            return {
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
        }
    }
</script>

<style scoped>

</style>
