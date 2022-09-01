export default [
  {
    header: 'Dashboards',
    icon: 'HomeIcon',
    children: [
      {
        title: 'eCommerce',
        route: 'dashboard',
        icon: 'ShoppingCartIcon',
          resource: 'Invoice',
        action: 'read',
      },
      {
        title: 'eCommerce',
        route: 'dashboard-ecommerce',
        icon: 'ShoppingCartIcon',
      },
      {
        title: 'Analytics',
        route: 'dashboard-analytics',
        icon: 'ActivityIcon',
      },
    ],
  
  },
]
