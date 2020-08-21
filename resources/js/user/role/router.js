import VueRouter from "vue-router";

Vue.use(VueRouter)
const routes = [
    {
        name: "Index",
        path: "/user/role",
        component: () => import("./Index.vue")
    }
]
const router = new VueRouter({
    routes,

    mode: 'history'
})
export default router
