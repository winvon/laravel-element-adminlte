import VueRouter from "vue-router"

Vue.use(VueRouter)

const routes = [
    {
        name:"Index",
        path: '/user',
        component: ()=>import("./Index.vue")
    },{
        name:"Edit",
        path: '/user/:id',
        component: ()=>import("./Edit.vue")
    },
]

const router = new VueRouter({
    routes,
    mode: 'history'
})


export default router
