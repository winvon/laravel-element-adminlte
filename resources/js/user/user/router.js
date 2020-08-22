import VueRouter from "vue-router"

Vue.use(VueRouter)

const routes = [
    {
        name: "Index",
        path: '/user/user',
        component: () => import("./Index.vue")
    },
    {
        name: "Create",
        path: '/user/user/create',
        component: () => import("./Edit.vue")
    },
    {
        name: "Edit",
        path: '/user/user/:id',
        component: () => import("./Edit.vue")
    },
]

const router = new VueRouter({
    routes,
    mode: 'history'
})


export default router
