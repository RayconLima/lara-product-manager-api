import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/:pathMatch(.*)*',
            meta: {
                title: 'Error 404',
                public: true
            },
            component: () => import('../ui/pages/errors/Error.vue')
        },
        {
            name: 'hello.world',
            path: '/',
            component: () => import('../ui/components/HelloWorld.vue')
        },
        {
            path: '/products',
            children: [
                {
                    name: 'products.index',
                    path: '',
                    component: () => import('../ui/pages/Products/Index.vue')
                }
            ]
        }
    ]
});

// router.beforeEach(async (to, from, next) => {
//     const meStore   = useMeStore();

//     const token = localStorage.getItem(import.meta.env.VITE_APP_TOKEN_NAME);
//     if(token) {
//         await meStore.getMe(); // Aguarde a conclusão da ação getMe
//     }

//     next();
// })
export default router;