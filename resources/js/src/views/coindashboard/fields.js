const data = [
    {
        key: 'market_cap_rank',
        index: 0,
        label: '',
        stickyColumn: false,
        sortable: false,
        filterColumn:true,
        canHide:true,
        visible: 3
    },
    {
        key: 'name',
        index: 1,
        thStyle: {
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
        label: 'Price($)',
        stickyColumn: false,
        filterColumn:true, canHide:true,
        visible: 1
    },
    {
        key: 'price_change_percentage_24h',
        index: 3,
        label: '24h %',
        stickyColumn: false,
        filterColumn:true, canHide:true,
        visible: 1
    },
    {
        key: 'price_change_percentage_7d_in_currency',
        index: 4,
        label: '7D %',
        stickyColumn: false,
        filterColumn:true, canHide:true,
        visible: 1
    },
    {
        key: 'market_cap',
        index: 5,
        label: 'MC',
        stickyColumn: false,
        filterColumn:true, canHide:true,
        visible: 1
    },
    {
        key: 'coin_description',
        index: 6,
        label: 'Desc',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 1
    },

    {
        key: 'coin_platform',
        index: 7,
        label: 'Platform',
        stickyColumn: false,
        filterColumn:false,
        visible: 1
    },
    {
        key: 'total_volume',
        index: 8,
        label: 'VOL(24h)',
        stickyColumn: false,
        filterColumn:true, canHide:true,
        visible: 1
    },
    {
        key: 'high_24h',
        index: 9,
        label: 'High $(24h)',
        stickyColumn: false,
        filterColumn:false,
        visible: 1
    },
    {
        key: 'low_24h',
        index: 10,
        label: 'Low $(24h)',
        stickyColumn: false,
        filterColumn:false,
        visible: 1
    },
    
    {
        key: 'ath',
        index: 11,
        label: 'ATH($)',
        stickyColumn: false,
        filterColumn:false,
        visible: 1
    },
    {
        key: 'atl',
        index: 12,
        label: 'ATL($)',
        stickyColumn: false,
        filterColumn:false,
        visible: 1
    },
    {
        key: 'roi_times',
        index: 13,
        label: `ROI in X's`,
        stickyColumn: false,
        filterColumn:false,canHide:true,
        visible: 1,
    },
    {
        key: 'coin_category',
        index: 14,
        label: `Category`,
        stickyColumn: false, canHide:true,
        filterColumn:false,
        visible: 1,
    },

    

    {
        key: 'roi_percentage',
        index: 15,
        label: 'ROI %',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 1
    },

    {
        key: 'total_supply_percent',
        index: 16,
        label: 'Total Supply %',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 1
    },
    {
        key: 'circulating_supply',
        index: 17,
        label: 'Circulating Supply',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 1,
    },
    {
        key: 'seed_price',
        index: 18,
        label: 'Seed Price',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 1
    },
   
    {
        key: 'roi_seed',
        index: 19,
        label: 'ROI Seed',
        stickyColumn: false,
        filterColumn:false,
        visible: 1
    },
    {
        key: 'total_locked',
        index: 20,
        label: 'Total Locked',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 2
    },
    {
        key: 'next_unlock_date_text',
        index: 21,
        label: 'Next Unlock Date',
        stickyColumn: false,
        filterColumn:false,canHide:true,
        visible: 3,
    },
    {
        key: 'next_unlock_status',
        index: 22,
        label: 'Next Unlock Status',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 2
    },

    {
        key: 'next_unlock_number_of_tokens',
        index: 23,
        label: 'Next Unlock # of Tokens',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 2
    },{
        key: 'next_unlock_percent_of_tokens',
        index: 24,
        label: 'Next Unlock Token %',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 2
    },{
        key: 'next_unlock_size',
        index:25,
        label: 'Next Unlock Size',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 2
    },{
        key: 'first_vc_unlock',
        index: 26,
        label: 'First VC Unlock',
        stickyColumn: false,
        filterColumn:false,
        visible: 1
    },{
        key: 'end_vc_unlock',
        index: 27,
        label: 'End VC Unlock',
        stickyColumn: false,
        filterColumn:false,
        visible: 1
    },{
        key: 'three_months_unlock_number_of_tokens',
        index: 28,
        label: '3 Months Unlock # of Tokens',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 2
    },{
        key: 'three_months_unlock_percent_of_tokens',
        index: 29,
        label: '3 Months Unlock Tokens %',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 2
    },{
        key: 'three_months_unlock_size',
        index: 30,
        label: '3 Months Unlock Size',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 2
    },
    {
        key: 'six_months_unlock_number_of_tokens',
        index: 31,
        label: '6 Months Unlock # of Tokens',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 2
    },{
        key: 'six_months_unlock_percent_of_tokens',
        index: 32,
        label: '6 Months Unlock Tokens %',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 2
    },{
        key: 'six_months_unlock_size',
        index: 33,
        label: '6 Months Unlock Size',
        stickyColumn: false, canHide:true,
        filterColumn:false,
        visible: 2
    },
    {
        key: 'social_mentions_change',
        index: 34,
        label: 'Social Mentions Change',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 1,
    },
    {
        key: 'social_engagement_change',
        index: 35,
        label: 'Social Engagement Change',
        stickyColumn: false,
        filterColumn:false, canHide:true,
        visible: 1,
    },
    {
        key: 'average_sentiment',
        index: 36,
        label: 'Average Sentiment',
        stickyColumn: false, canHide:true,
        filterColumn:false,
        visible: 1,
    },
    {
        key: 'average_sentiment_change',
        index: 37,
        label: 'Average Sentiment Change',
        stickyColumn: false,
        filterColumn:false,
        visible: 1,
    }
]
export default data;
