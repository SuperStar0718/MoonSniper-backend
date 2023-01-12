const data = [
    {
        key: 'alert_name',
        index: 0,
        label: 'Alert name',
        sortable: false,
        filterColumn:true,
    },
    {
        key: 'coin_name',
        index: 1,
        label: 'Coin name',
        sortable: false,
        filterColumn:true,
    },
    {
        key: 'priority',
        index: 2,
        label: 'Priority',
        stickyColumn: false,
        filterColumn:true,
    },
    
    {
        key: 'conditions',
        index: 3,
        label: 'Conditions',
        stickyColumn: false,
        filterColumn:true, canHide:true,
    },
    {
        key: 'actionButton',
        index: 4,
        label: 'Action',
        stickyColumn: false,
        filterColumn:true,
    },
   

]
export default data;
