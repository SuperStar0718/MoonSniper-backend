const data = [{
        key: 'market_cap_rank',
        index: 0,
        title: null,
        thStyle: {
            'width': '50px',


        },
        label: '',
        stickyColumn: false,
        sortable: false,
        filterColumn: true,
        canHide: true,
        visible: 3,
    },

    {
        key: 'name',
        index: 1,
        title: null,
        thStyle: {
            'width': '50px',

        },

        tdStyle: {},
        thClass: '',
        label: 'Token',
        stickyColumn: false,
        filterColumn: true,
        visible: 3
    },

    {
        key: 'current_price',
        index: 2,
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: 'Price($)',
        stickyColumn: false,
        filterColumn: true,
        canHide: true,
        visible: 1
    },
    {
        key: 'price_change_percentage_24h',
        index: 3,
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: '24h %',
        stickyColumn: false,
        filterColumn: true,
        canHide: true,
        visible: 1
    },
    {
        key: 'price_change_percentage_7d_in_currency',
        index: 4,
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: '7D %',
        stickyColumn: false,
        filterColumn: true,
        canHide: true,
        visible: 1
    },
    {
        key: 'market_cap',
        index: 5,
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: 'Marketcap',
        stickyColumn: false,
        filterColumn: true,
        canHide: true,
        visible: 1
    },
    {
        key: 'coin_description',
        index: 6,
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: 'Desc',
        stickyColumn: false,
        filterColumn: false,
        canHide: true,
        visible: 1
    },

    {
        key: 'coin_platform',
        index: 7,
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: 'Platform',
        stickyColumn: false,
        filterColumn: false,
        visible: 1
    },
    {
        key: 'volume_history',
        index: 8,
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: 'Volume(24hrs%)',
        stickyColumn: false,
        filterColumn: true,
        canHide: true,
        visible: 1
    },
    {
        key: 'high_24h',
        index: 9,
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: 'High $(24h)',
        stickyColumn: false,
        filterColumn: false,
        visible: 1
    },
    {
        key: 'low_24h',
        index: 10,
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: 'Low $(24h)',
        stickyColumn: false,
        filterColumn: false,
        canHide: true,
        visible: 1
    },

    {
        key: 'ath',
        index: 11,
        title: null,

        label: 'ATH($)',
        stickyColumn: false,
        filterColumn: false,
        thStyle: {
            'width': '50px',

        },
        canHide: true,
        visible: 1
    },
    {
        key: 'ath_change_percentage',
        index: 12,
        title: null,
        label: 'ATH change %',
        thStyle: {
            'width': '50px',

        },
        stickyColumn: false,
        filterColumn: false,
        canHide: true,
        visible: 1
    },
    {
        key: 'ath_date',
        index: 13,
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: 'ATH Date',
        stickyColumn: false,
        filterColumn: false,
        canHide: true,
        visible: 1
    },

    {
        key: 'atl',
        index: 14,
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: 'ATL($)',
        stickyColumn: false,
        filterColumn: false,
        canHide: true,
        visible: 1
    },
    {
        key: 'atl_change_percentage',
        index: 15,
        title: null,
        label: 'ATL change %',
        thStyle: {
            'width': '50px',

        },
        stickyColumn: false,
        filterColumn: false,
        canHide: true,
        visible: 1
    },
    {
        key: 'atl_date',
        index: 16,
        title: null,
        label: 'ATL Date',
        thStyle: {
            'width': '50px',

        },
        stickyColumn: false,
        filterColumn: false,
        canHide: true,
        visible: 1
    },
    {
        key: 'roi_times',
        index: 17, //13
        title: 'Return on Investment from TGE (Token Generation Event)',
        thStyle: {
            'width': '50px',

        },
        label: `ROI in X's`,
        stickyColumn: false,
        filterColumn: false,
        canHide: true,
        visible: 1,
    },
    {
        key: 'coin_category',
        index: 18, //14
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: `Category`,
        stickyColumn: false,
        canHide: true,
        filterColumn: false,
        visible: 1,
    },



    {
        key: 'roi_percentage',
        index: 19, //15
        thStyle: {
            'width': '50px',

        },
        label: 'ROI %',
        stickyColumn: false,
        filterColumn: true,
        canHide: true,
        visible: 1,
        title: 'Return on Investment from TGE (Token Generation Event)'
    },

    {
        key: 'total_supply_percent',
        index: 20, // 16
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: 'Total Supply %',
        stickyColumn: false,
        filterColumn: true,
        canHide: true,
        visible: 1
    },
    {
        key: 'circulating_supply',
        index: 21, // 17
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: 'Circulating Supply',
        stickyColumn: false,
        filterColumn: false,
        canHide: true,
        visible: 1,
    },
    {
        key: 'seed_price',
        index: 22, // 18
        thStyle: {
            'width': '50px',

        },
        label: 'Public Price',
        stickyColumn: false,
        filterColumn: false,
        canHide: true,
        visible: 1,
        title: 'Earliest investors price'
    },

    {
        key: 'roi_seed',
        index: 23, //19
        thStyle: {
            'width': '50px',

        },
        label: 'ROI Seed',
        stickyColumn: false,
        filterColumn: false,
        visible: 1,
        title: 'Return on Investment from TGE (Token Generation Event)'
    },
    {
        key: 'total_locked_percent',
        index: 24,
        thStyle: {
            'width': '50px',

        },
        title: null,
        label: 'Total Locked%',
        stickyColumn: false,
        filterColumn: false,
        canHide: true,
        visible: 2
    },
    {
        key: 'next_unlock_date',
        index: 25,
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: 'Next Unlock Date',
        stickyColumn: false,
        filterColumn: true,
        canHide: true,
        visible: 3,
    },
    {
        key: 'next_unlock_status',
        index: 26, //22
        title: null,
        thStyle: {
            'width': '50px',
        },
        label: 'Next Unlock Status',
        stickyColumn: false,
        filterColumn: false,
        canHide: true,
        visible: 2
    },

    {
        key: 'next_unlock_number_of_tokens',
        index: 27, //23,
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: 'Next Unlock # of Tokens',
        stickyColumn: false,
        filterColumn: false,
        canHide: true,
        visible: 2
    }, {
        key: 'next_unlock_percent_of_tokens',
        index: 28, //24,
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: 'Next Unlock Token %',
        stickyColumn: false,
        filterColumn: false,
        canHide: true,
        visible: 2
    }, {
        key: 'next_unlock_size',
        index: 29, //25,
        thStyle: {
            'width': '50px',

        },
        label: 'Next Unlock Size',
        stickyColumn: false,
        filterColumn: false,
        canHide: true,
        visible: 2
    }, {
        key: 'first_vc_unlock',
        index: 30, //26,
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: 'First VC Unlock',
        stickyColumn: false,
        filterColumn: true,
        canHide: true,
        visible: 2
    }, {
        key: 'end_vc_unlock',
        index: 31, //27,
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: 'End VC Unlock',
        stickyColumn: false,
        filterColumn: true,
        canHide: true,
        visible: 2
    }, {
        key: 'three_months_unlock_number_of_tokens',
        index: 32, //,
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: '3 Months Unlock # of Tokens',
        stickyColumn: false,
        filterColumn: false,
        canHide: true,
        visible: 2
    }, {
        key: 'three_months_unlock_percent_of_tokens',
        index: 33, //29,
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: '3 Months Unlock Tokens %',
        stickyColumn: false,
        filterColumn: false,
        canHide: true,
        visible: 2
    }, {
        key: 'three_months_unlock_size',
        index: 34, //30,
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: '3 Months Unlock Size',
        stickyColumn: false,
        filterColumn: false,
        canHide: true,
        visible: 2
    },
    {
        key: 'six_months_unlock_number_of_tokens',
        index: 35, //31,
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: '6 Months Unlock # of Tokens',
        stickyColumn: false,
        filterColumn: false,
        canHide: true,
        visible: 2
    }, {
        key: 'six_months_unlock_percent_of_tokens',
        index: 36, //32,
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: '6 Months Unlock Tokens %',
        stickyColumn: false,
        filterColumn: false,
        canHide: true,
        visible: 2
    }, {
        key: 'six_months_unlock_size',
        index: 37, //33,
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: '6 Months Unlock Size',
        stickyColumn: false,
        canHide: true,
        filterColumn: false,
        visible: 2
    },
    {
        key: 'social_mentions_change',
        index: 38, //34,
        thStyle: {
            'width': '50px',

        },
        label: 'Social Mentions 24h%',
        stickyColumn: false,
        filterColumn: false,
        canHide: true,
        visible: 1,
        title: '24hrs Hashtags on social media (negative or positive)'
    },
    {
        key: 'social_engagement_change',
        index: 39, //35,
        thStyle: {
            'width': '50px',

        },
        label: 'Social Engagements 24h%',
        stickyColumn: false,
        filterColumn: false,
        canHide: true,
        visible: 1,
        title: ' 24hrs Interaction in social posts ',

    },
    {
        key: 'average_sentiment',
        index: 40, //36,
        thStyle: {
            'width': '50px',

        },
        label: 'Average Sentiment',
        stickyColumn: false,
        canHide: true,
        filterColumn: false,
        visible: 1,
        title: 'Social media sentiment: Determining whether or not the sentiment is positive or negative. A score of 2.5 is average, 5 is Bullish, and 1 is Bearish',
    },
    {
        key: 'average_sentiment_change',
        index: 41, //37,
        title: null,
        thStyle: {
            'width': '50px',

        },
        label: 'Average Sentiment Change',
        stickyColumn: false,
        filterColumn: false,
        visible: 1,
    },
    {
        key: 'sparkline_in_7d',
        index: 42, //38,
        title: null,
        thStyle: {
            'width': '60px',

        },
        label: '7d chart',
        stickyColumn: false,
        filterColumn: true,
        visible: 3
    },
    {
        key: 'empty',
        index: 43, //39,
        title: null,

        label: '',
        stickyColumn: false,
        filterColumn: true,
        visible: 3
    }


]
export default data;
