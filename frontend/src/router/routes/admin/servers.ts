import type { RouteRecordRaw } from 'vue-router';
import Session from '@/lumina/Session';
import Permissions from '@/lumina/Permissions';

const serversRoutes: RouteRecordRaw[] = [
    {
        path: '/mc-admin/servers',
        name: 'admin-servers',
        component: () => import('@/views/admin/server/Index.vue'),
        meta: {
            requiresAuth: true,
            requiresAdmin: true,
        },
        beforeEnter: (to, from, next) => {
            if (Session.hasOrRedirectToErrorPage(Permissions.ADMIN_SERVERS_LIST)) {
                next();
            } else {
                next('/errors/403');
            }
        },
    },
];

export default serversRoutes;
