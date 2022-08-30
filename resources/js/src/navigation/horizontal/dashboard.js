export default [
  {
    header: 'Dashboards',
    icon: 'HomeIcon',
    children: [
      {
        title: 'eCommerce',
        route: 'dashboard-ecommerce',
        icon: 'ShoppingCartIcon',
          resource: 'Invoice',
        action: 'read',
      },
      {
        title: 'Analytics',
        route: 'dashboard-analytics',
        icon: 'ActivityIcon',
      },
    ],
  
  },
]
