export default {
    menu: {
        geral: {
            icon: null,
            items: [
                {
                    title: 'Dashboard',
                    icon: 'fa-solid fa-dashboard',
                    to: 'home',
                    can: null
                },
                {
                    title: 'Produtos',
                    icon: 'fa-solid fa-users',
                    to: 'products.index',
                    can: 'list_products'
                },    
                {
                    title: 'Categorias',
                    icon: 'fa-solid fa-store',
                    to: 'categories.index',
                    can: 'list_categories'
                },    
            ]
        },
        accessControl: {
            icon: 'fa-solid fa-shield-halved',
            title: 'Controle de acesso',
            can: 'super-admin',
            items: [
                {
                    title: 'Cargos',
                    to: 'roles.index',
                    can: null
                },
                {
                    title: 'Permissões',
                    to: 'permissions.index',
                    can: null
                },
            ]
        }
    }
}