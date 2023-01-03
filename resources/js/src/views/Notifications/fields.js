const data = [
    {
        key: 'alert_name',
        index: 0,
        label: 'Alert name',
        sortable: false,
        filterColumn:true,
    },
    {
        key: 'priority',
        index: 1,
        label: 'Priority',
        stickyColumn: false,
        filterColumn:true,
    },
    
    {
        key: 'conditions',
        index: 2,
        label: 'Conditions',
        stickyColumn: false,
        filterColumn:true, canHide:true,
    },
    {
        key: 'actionButton',
        index: 3,
        label: 'Action',
        stickyColumn: false,
        filterColumn:true,
    },
   

]
export default data;
