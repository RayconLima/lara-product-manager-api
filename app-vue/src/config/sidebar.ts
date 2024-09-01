export default {
    menu: {
        geral: {
            icon: null,
            items: [
                {
                    title: 'Dashboard',
                    icon: 'fa-solid fa-dashboard',
                    to: 'hello.world',
                },
                {
                    title: 'Produtos',
                    icon: 'fa-solid fa-users',
                    to: 'products.index',
                    // can: null
                },    
                {
                    title: 'Categorias',
                    icon: 'fa-solid fa-store',
                    to: 'categories.index',
                    // can: null
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