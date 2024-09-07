import { createRouter, createWebHistory } from 'vue-router';
import { checkIfTokenExists, checkPermission, checkRole, redirectIfAuthenticated, redirectIfNotAuthenticated } from './guards';
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
            path: '/cadastrar',
            component: () => import('../ui/layouts/Auth.vue'),
            beforeEnter: redirectIfAuthenticated,
            name: 'register',
            meta: {
              title: 'Cadastrar',
              public: true
            },
            children: [
              {
                path: '',
                component: () => import('../ui/pages/Auth/Register.vue')
              },
            ]
        },
        {
            path: '/verificar-email',
            component: () => import('../ui/layouts/Auth.vue'),
            beforeEnter: checkIfTokenExists,
            children: [
              {
                path: '',
                name: 'verifyEmail',
                component: () => import('../ui/pages/Auth/VerifyEmail.vue')
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
            path: '/usuarios',
            beforeEnter: redirectIfNotAuthenticated,
            component: () => import('../ui/layouts/Default.vue'),
            children: [
                {
                    path: '',
                    name: 'users.index',
                    component: () => import('../ui/pages/Users/Index.vue')
                },
                {
                    path: ':id',
                    name: 'users.show',
                    component: () => import('../ui/pages/Users/Single.vue')
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
            path: '/cargos/',
            beforeEnter: redirectIfNotAuthenticated,
            meta: {
                role: 'super-admin'
            },
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
            path: '/permissoes/',
            beforeEnter: redirectIfNotAuthenticated,
            meta: {
                role: 'super-admin'
            },
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
    const token     = localStorage.getItem(import.meta.env.VITE_APP_TOKEN_NAME);
    
    if(token) {
        await meStore.getMe();
    }

    checkRole(_to, _from, next);
    checkPermission(_to, _from, next);

    next();
})

export default router;