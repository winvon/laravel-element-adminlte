import VueRouter from "vue-router";

Vue.use(VueRouter)
const routes = [
    {
        name: "Index",
        path: "/user/role",
        component: () => import("./Index.vue")
    },{
        name: "Create",
        path: "/user/role/create",
        component: () => import("./CreateOrEdit.vue")
    },{
        name: "Edit",
        path: "/user/role/:id",
        component: () => import("./CreateOrEdit.vue")
    },
]
const router = new VueRouter({
    routes,

    mode: 'history'
})
export default router
