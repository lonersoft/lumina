import Permissions from '@/lumina/Permissions';
import Session from '@/lumina/Session';
import type { RouteRecordRaw } from 'vue-router';

const locationRoutes: RouteRecordRaw[] = [
    {
        path: '/mc-admin/backups',
        name: 'Backups',
        component: () => import('@/views/admin/backups/Index.vue'),
        meta: {
            requiresAuth: true,
            requiresAdmin: true,
        },
        beforeEnter: (to, from, next) => {
            if (Session.hasOrRedirectToErrorPage(Permissions.ADMIN_BACKUPS_LIST)) {
                next();
            } else {
                next('/errors/403');
            }
        },
    },
];

export default locationRoutes;
