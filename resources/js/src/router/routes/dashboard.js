export default [
  {
    path: '/dashboard/analytics',
    name: 'dashboard-analytics',
    component: () => import('@/views/dashboard/analytics/Analytics.vue'),
    meta: {
      resource: 'Dashboard',
      action: 'read',
    },
  },
  {
    path: '/dashboard/ecommerce',
    name: 'dashboard-ecommerce',
    component: () => import('@/views/dashboard/ecommerce/Ecommerce.vue'),
    meta: {
      resource: 'Dashboard',
      action: 'read',
    },
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: () => import('@/views/coindashboard/Dashboard.vue'),
    meta: {
      resource: 'Dashboard',
      action: 'read',
    },
  }, {
    path: '/wallet',
    name: 'wallet',
    component: () => import('@/views/wallet/Wallet.vue'),
    meta: {
      resource: 'Dashboard',
      action: 'read',
    },
  },
]
