import { createRouter, createWebHistory } from 'vue-router';
import { checkPermission, redirectIfAuthenticated, redirectIfNotAuthenticated } from './guards';
import { useMeStore } from '../store/me';

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/:pathMatch(.*)*',
            name:"error404",
            meta: {
                title: 'Error 404',
                public: true
            },
            component: () => import('../ui/pages/errors/Error.vue'),
            props: {
                title: 'Erro 404',
                message: 'Página não encontrada.',
                code: 404
            }
        },
        {
            path: '/403',
            name:"error403",
            component: () => import('../ui/pages/errors/Error.vue'),
            props: {
              title: 'Erro 403',
              message: 'Acesso negado.',
              code: 403
            }
        },
        {
            path: '/login',
            component: () => import('../ui/layouts/Auth.vue'),
            beforeEnter: redirectIfAuthenticated,
            meta: {
                title: 'Login',
                public: true
            },
            children: [
                {
                    path: '',
                    name: 'login',
                    component: () => import('../ui/pages/Auth/Login.vue')
                }
            ],
        },
        {
            path: '/',
            beforeEnter: redirectIfNotAuthenticated,
            component: () => import('../ui/layouts/Default.vue'),
            children: [
                {
                    path: '',
                    name: 'home',
                    component: () => import('../ui/pages/Home/Index.vue')
                }
            ]
        },
        {
            path: '/produtos',
            beforeEnter: redirectIfNotAuthenticated,
            component: () => import('../ui/layouts/Default.vue'),
            children: [
                {
                    path: '',
                    name: 'products.index',
                    component: () => import('../ui/pages/Products/Index.vue')
                },
                {
                    path: ':id',
                    name: 'products.show',
                    component: () => import('../ui/pages/Products/Single.vue')
                },
            ]
        },
        {
            path: '/categorias/',
            beforeEnter: redirectIfNotAuthenticated,
            meta: {
                can: 'list_categories'
            },
            component: () => import('../ui/layouts/Default.vue'),
            children: [
                {
                    name: 'categories.index',
                    path: '',
                    component: () => import('../ui/pages/Categories/Index.vue')
                },
            ]
        },
        {
            path: '/roles/',
            beforeEnter: redirectIfNotAuthenticated,
            component: () => import('../ui/layouts/Default.vue'),
            children: [
                {
                    name: 'roles.index',
                    path: '',
                    component: () => import('../ui/pages/ACL/Roles/Index.vue')
                }
            ]
        },
        {
            path: '/permissions/',
            beforeEnter: redirectIfNotAuthenticated,
            component: () => import('../ui/layouts/Default.vue'),
            children: [
                {
                    name: 'permissions.index',
                    path: '',
                    component: () => import('../ui/pages/ACL/Permissions/Index.vue')
                }
            ]
        }
    ]
});

router.beforeEach(async (_to, _from, next) => {
    const meStore   = useMeStore();

    const token = localStorage.getItem(import.meta.env.VITE_APP_TOKEN_NAME);
    if(token) {
        await meStore.getMe(); // Aguarde a conclusão da ação getMe
    }

    checkPermission(_to, _from, next);

    next();
})

export default router;