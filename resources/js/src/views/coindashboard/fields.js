const data = [
    {
        key: 'market_cap_rank',
        index: 0,
         thStyle: {
            'width':'50px',
            
            
        },
        label: '',
        stickyColumn: false,
        sortable: false,
        filterColumn:true,
        canHide:true,
        visible: 3,
    },
    
    {
        key: 'name',
        index: 1,
         thStyle: {
            'width':'50px',
            
        },
       
        tdStyle: {
        },
        thClass: '',
        label: 'Token',
        stickyColumn: false,
        filterColumn:true,
        visible: 3
    },
    
    {
        key: 'current_price',
        index: 2,
         thStyle: {
            'width':'50px',
            
        },
        label: 'Price($)',
        stickyColumn: false,
        filterColumn:true, canHide:true,
        visible: 1
    },
    {
        key: 'price_change_percentage_24h',
        index: 3,
         thStyle: {
            'width':'50px',
            
        },
        label: '24h %',
        stickyColumn: false,
        filterColumn:true, canHide:true,
        visible: 1
    },
    {
        key: 'price_change_percentage_7d_in_currency',
        index: 4,
         thStyle: {
            'width':'50px',
            
        },
        label: '7D %',
        stickyColumn: false,
        filterColumn:true, canHide:true,
        visible: 1
    },
    {
        key: 'market_cap',
        index: 5,
         thStyle: {
            'width':'50px',
            
        },
        label: 'MC',
        stickyColumn: false,
        filterColumn:true, canHide:true,
        visible: 1
    },
    {
        key: 'coin_description',
        index: 6,
         thStyle: {
            'width':'50px',
            
        },
        label: 'Desc',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 1
    },

    {
        key: 'coin_platform',
        index: 7,
         thStyle: {
            'width':'50px',
            
        },
        label: 'Platform',
        stickyColumn: false,
        filterColumn:false,
        visible: 1
    },
    {
        key: 'total_volume',
        index: 8,
         thStyle: {
            'width':'50px',
            
        },
        label: 'VOL(24h)',
        stickyColumn: false,
        filterColumn:true, canHide:true,
        visible: 1
    },
    {
        key: 'high_24h',
        index: 9,
         thStyle: {
            'width':'50px',
            
        },
        label: 'High $(24h)',
        stickyColumn: false,
        filterColumn:false,
        visible: 1
    },
    {
        key: 'low_24h',
        index: 10,
         thStyle: {
            'width':'50px',
            
        },
        label: 'Low $(24h)',
        stickyColumn: false,
        filterColumn:false,
        visible: 1
    },
    
    {
        key: 'ath',
        index: 11,
         thStyle: {
            'width':'50px',
            
        },
        label: 'ATH($)',
        stickyColumn: false,
        filterColumn:false,
        visible: 1
    },
    {
        key: 'atl',
        index: 12,
         thStyle: {
            'width':'50px',
            
        },
        label: 'ATL($)',
        stickyColumn: false,
        filterColumn:false,
        visible: 1
    },
    {
        key: 'roi_times',
        index: 13,
         thStyle: {
            'width':'50px',
            
        },
        label: `ROI in X's`,
        stickyColumn: false,
        filterColumn:false,canHide:true,
        visible: 1,
    },
    {
        key: 'coin_category',
        index: 14,
         thStyle: {
            'width':'50px',
            
        },
        label: `Category`,
        stickyColumn: false, canHide:true,
        filterColumn:false,
        visible: 1,
    },

    

    {
        key: 'roi_percentage',
        index: 15,
         thStyle: {
            'width':'50px',
            
        },
        label: 'ROI %',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 1
    },

    {
        key: 'total_supply_percent',
        index: 16,
         thStyle: {
            'width':'50px',
            
        },
        label: 'Total Supply %',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 1
    },
    {
        key: 'circulating_supply',
        index: 17,
         thStyle: {
            'width':'50px',
            
        },
        label: 'Circulating Supply',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 1,
    },
    {
        key: 'seed_price',
        index: 18,
         thStyle: {
            'width':'50px',
            
        },
        label: 'Seed Price',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 1
    },
   
    {
        key: 'roi_seed',
        index: 19,
         thStyle: {
            'width':'50px',
            
        },
        label: 'ROI Seed',
        stickyColumn: false,
        filterColumn:false,
        visible: 1
    },
    {
        key: 'total_locked',
        index: 20,
         thStyle: {
            'width':'50px',
            
        },
        label: 'Total Locked',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 2
    },
    {
        key: 'next_unlock_date_text',
        index: 21,
         thStyle: {
            'width':'50px',
            
        },
        label: 'Next Unlock Date',
        stickyColumn: false,
        filterColumn:true,canHide:true,
        visible: 3,
    },
    {
        key: 'next_unlock_status',
        index: 22,
         thStyle: {
            'width':'50px',
            
        },
        label: 'Next Unlock Status',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 2
    },

    {
        key: 'next_unlock_number_of_tokens',
        index: 23,
         thStyle: {
            'width':'50px',
            
        },
        label: 'Next Unlock # of Tokens',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 2
    },{
        key: 'next_unlock_percent_of_tokens',
        index: 24,
         thStyle: {
            'width':'50px',
            
        },
        label: 'Next Unlock Token %',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 2
    },{
        key: 'next_unlock_size',
        index:25,
         thStyle: {
            'width':'50px',
            
        },
        label: 'Next Unlock Size',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 2
    },{
        key: 'first_vc_unlock',
        index: 26,
         thStyle: {
            'width':'50px',
            
        },
        label: 'First VC Unlock',
        stickyColumn: false,
        filterColumn:true,canHide:true,
        visible: 2
    },{
        key: 'end_vc_unlock',
        index: 27,
         thStyle: {
            'width':'50px',
            
        },
        label: 'End VC Unlock',
        stickyColumn: false,
        filterColumn:true,canHide:true,
        visible: 2
    },{
        key: 'three_months_unlock_number_of_tokens',
        index: 28,
         thStyle: {
            'width':'50px',
            
        },
        label: '3 Months Unlock # of Tokens',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 2
    },{
        key: 'three_months_unlock_percent_of_tokens',
        index: 29,
         thStyle: {
            'width':'50px',
            
        },
        label: '3 Months Unlock Tokens %',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 2
    },{
        key: 'three_months_unlock_size',
        index: 30,
         thStyle: {
            'width':'50px',
            
        },
        label: '3 Months Unlock Size',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 2
    },
    {
        key: 'six_months_unlock_number_of_tokens',
        index: 31,
         thStyle: {
            'width':'50px',
            
        },
        label: '6 Months Unlock # of Tokens',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 2
    },{
        key: 'six_months_unlock_percent_of_tokens',
        index: 32,
         thStyle: {
            'width':'50px',
            
        },
        label: '6 Months Unlock Tokens %',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 2
    },{
        key: 'six_months_unlock_size',
        index: 33,
         thStyle: {
            'width':'50px',
            
        },
        label: '6 Months Unlock Size',
        stickyColumn: false, canHide:true,
        filterColumn:false,
        visible: 2
    },
    {
        key: 'social_mentions_change',
        index: 34,
         thStyle: {
            'width':'50px',
            
        },
        label: 'Social Mentions Change',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 1,
    },
    {
        key: 'social_engagement_change',
        index: 35,
         thStyle: {
            'width':'50px',
            
        },
        label: 'Social Engagement Change',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 1,
    },
    {
        key: 'average_sentiment',
        index: 36,
         thStyle: {
            'width':'50px',
            
        },
        label: 'Average Sentiment',
        stickyColumn: false, canHide:true,
        filterColumn:false,
        visible: 1,
    },
    {
        key: 'average_sentiment_change',
        index: 37,
         thStyle: {
            'width':'50px',
            
        },
        label: 'Average Sentiment Change',
        stickyColumn: false,
        filterColumn:false,
        visible: 1,
    },
    {
        key: 'sparkline_in_7d',
        index: 38,
        label: '7d chart', 
        stickyColumn: false,
        filterColumn:true,
        visible: 3
    },
    {
        key: 'empty',
        index: 39,
        
        label: '',
        stickyColumn: false,
        filterColumn:true,
        visible: 3
    }
    

]
export default data;
