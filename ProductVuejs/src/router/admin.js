const admin = [
    {
        path: "",
        component: () => import("../layouts/admin.vue"),
        children: [
            // quản lý users
            {
                path: "",
                name: "admin-users",
                component: () => import("../pages/admin/users/index.vue")
            },

            //quản lý posts
            {
                path: "product",
                name: "admin-posts",
                component: () => import("../pages/admin/product/index.vue")
            },
            {
                path: "product/add",
                name: "admin-posts-add",
                component: () => import("../pages/admin/product/add.vue")
            },
            {
                path: "product/:id/edit",
                name: "admin-posts-edit",
                component: () => import("../pages/admin/product/edit.vue")
            },
            {
                path: "product/:id/delete",
                name: "admin-posts-delete",
                component: () => import("../pages/admin/product/index.vue")
            },

            {
                path: "login",
                name: "admin-login",
                component: () => import("../pages/admin/product/login.vue")
            },

            {
                path: "dangki",
                name: "admin-dangki",
                component: () => import("../pages/admin/product/dangki.vue")
            }
        ]
    }
];

export default admin;