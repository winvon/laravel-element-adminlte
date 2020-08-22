<template>
    <div class="row mt-2">
        <div class="col-12">
            <el-card>
                <div slot="header" v-if="$slots.header">
                    <slot name="header">
                    </slot>
                </div>

                <slot><span>nothing</span></slot>
            </el-card>
        </div>
    </div>
</template>

<script>
    export default {
        name: "VCard"
    }
</script>

<style scoped>

</style>
