<template>
    <div id="dashboard">
        <div class="body-content-overlay" />
        <!-- search bar and table -->
        <div class="cardBack" style="
        padding: 20px;
        box-shadow: 0px 0px 20px rgba(19, 20, 37, 0.5);
        backdrop-filter: blur(7.5px);
        border-radius: 30px;
      ">
            <div class="searchbar mt-1">
                <b-row>
                    <b-col cols="8" md="6" xl="6">
                        <b-input-group class="input-group-merge mb-1">
                            <b-form-input v-model="searchValue" placeholder="Search" class="search-product searchdark"
                                style="border-radius: 20px" v-on:input="loadAddressData" />
                        </b-input-group>

                    </b-col>
                    <b-col cols="4" md="2" xl="4">
                        <b-button variant="outline-primary">Follow</b-button>
                    </b-col>
                    <b-col>
                        <!-- <b-button variant="outline-primary">Add Wallet</b-button> -->
                    </b-col>
                </b-row>
            </div>
            <div id="ctable" style="position: relative">
                <div class="opacityGradient" style="
            position: absolute;
            right: 4px;
            top: 0px;
            height: 100%;
            width: 61px;
            z-index: 3;
            background: linear-gradient(
              90deg,
              rgba(248, 248, 248, 0) 0%,
              rgba(248, 248, 248, 1) 100%
            );
          ">
        </div>
                <b-overlay :show="isBusy" rounded="sm">
                    <br />

                    <div style="justify-content: center !important;" id="insideTabs">
                        <b-tabs content-class="mt-3">

                            <b-tab title="History">

                                <b-tabs>
                                    <b-tab title="Etherium">
                                        <b-table hover :items="tokenData" :fields="fields" show-empty>
                                            <template v-if="historyData.length ==0" #empty="scope">
                                                No Etherium Data
                                            </template>
                                        </b-table>
                                    </b-tab>
                                    <b-tab title="Polygon">
                                        <b-table hover :items="historyData" :fields="fields" show-empty>
                                            <template v-if="historyData.length ==0" #empty="scope">
                                                No Polygon data
                                            </template>
                                        </b-table>

                                    </b-tab>
                                </b-tabs>

                            </b-tab>
                            <b-tab title="Favourites">
                                <!-- <b-table striped hover :items="tokenData"></b-table> -->
                                <b-table hover :items="[]" show-empty>
                                    <template #empty="scope">
                                        No Favourites
                                    </template>
                                </b-table>

                            </b-tab>
                            <b-tab title="Notification">
                                <!-- <b-table striped hover :items="tokenData"></b-table> -->
                                <b-table hover :items="[]" show-empty>
                                    <template #empty="scope">
                                        No notifications
                                    </template>
                                </b-table>

                            </b-tab>
                            <b-tab title="Add Wallet">
                                <!-- <b-table striped hover :items="tokenData"></b-table> -->
                                <b-table hover :items="[]" show-empty>
                                    <template #empty="scope">
                                        No wallet
                                    </template>
                                </b-table>

                            </b-tab>
                        </b-tabs>
                    </div>
                </b-overlay>
                <good-table></good-table>
            </div>
        </div>
        <!-- end search and table -->
    </div>
</template>

<script>
    import {
        BTable,
        BTabs,
        BTab,
        BFormCheckbox,
        BAvatar,
        BImg,
        BBadge,
        BPagination,
        BRow,
        BCol,
        BCard,
        BCardHeader,
        BCardBody,
        BModal,
        VBModal,
        BDropdown,
        BDropdownItem,
        BDropdownForm,
        BFormRadioGroup,
        BFormRadio,
        BInputGroup,
        BInputGroupAppend,
        BFormInput,
        BButton,
        BFormGroup,
        BCollapse,
        VBToggle,
        BCardText,
        BFormSelect,
        BFormSelectOption,
        BSpinner,
        BOverlay,
        VBPopover,
        VBTooltip,
    } from "bootstrap-vue";
    import Ripple from "vue-ripple-directive";
    import axios from "@axios";
    import axios2 from "axios"
    import {
        VueSvgGauge
    } from "vue-svg-gauge";
    import VueApexCharts from "vue-apexcharts";
    import platformData from "./platforms";
    import fieldsData from "./fields";
    import categoryData from "./categories";
    import filterFields from "./filterfields";
    import Trend from "vuetrend";
    import AppCollapse from "@core/components/app-collapse/AppCollapse.vue";
    import AppCollapseItem from "@core/components/app-collapse/AppCollapseItem.vue";
    import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
    import VueSlider from "vue-slider-component";
    import store from "@/store/index";
    import GoodTable from "../table/vue-good-table/GoodTableBasic.vue"
    import {
        getUserData
    } from "@/auth/utils";
    import Cleave from "vue-cleave-component";
    // eslint-disable-next-line import/no-extraneous-dependencies
    import "cleave.js/dist/addons/cleave-phone.us";
    import "bootstrap-icons/font/bootstrap-icons";
    import "bootstrap-icons/font/bootstrap-icons.css";

    export default {
        components: {
            BTable,
            BTabs,
            BFormCheckbox,
            BTab,
            BAvatar,
            BBadge,
            BPagination,
            BCard,
            BCardHeader,
            BCardBody,
            BRow,
            BCol,
            VueSvgGauge,
            BModal,
            VueApexCharts,
            BDropdown,
            BDropdownItem,
            BDropdownForm,
            BFormRadioGroup,
            BFormRadio,
            BInputGroup,
            BInputGroupAppend,
            BFormInput,
            BButton,
            BFormGroup,
            BCollapse,
            BCardText,
            BFormSelect,
            Trend,
            BImg,
            BSpinner,
            BOverlay,
            AppCollapse,
            AppCollapseItem,
            BFormSelectOption,
            ToastificationContent,
            VueSlider,
            VBPopover,
            Cleave,
        },
        data() {
            return {
                oBarMinValue: 10,
                oBarMaxValue: 90,
                NumberFormaVal: {
                    numeral: true,
                    numeralThousandsGroupStyle: "thousand",
                },
                stickyHeader: true,
                true: false,
                loaded: false,
                loadedData: false,
                // fields: fieldsData,
                items: [],
                tokenData: [

                ],
                searchValue: "",
                fields: ['blockNumber', 'blockHash'],
                historyData: [],
                pricesWs: null,
                coinsStr: "",
                Cpagpage: 1,
                sortKey: "",
                sortBy: "",
                isBusy: true,
                locked: false,
                value_2: [0, 50],
                params: {
                    filters: [],
                    filters2: "",
                    sort: ["market_cap_rank", "asc"],
                    api_mode: 1,
                    perpage: 50,
                },
                perPageOptions: [5, 6, 8, 9, 10, 20, 30, 50, 100],
                fag: {
                    data: {
                        fear_greed_index: 0,
                        fear_greed_classification: "",
                    },
                },
                selectedContract: null,
                spLineStyles: {
                    stroke: "#c7361c",
                },
                chartOptions: {
                    fill: {
                        colors: ["#F44336", "#E91E63", "#9C27B0"],
                    },

                    chart: {
                        id: "history-chart",
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: "#78909C",
                            },
                        },
                    },

                    xaxis: {
                        categories: [],
                        type: "datetime",
                        tickPlacement: "between",
                        labels: {
                            show: true,
                            rotateAlways: false,
                            maxHeight: 120,
                            style: {
                                colors: "#78909C",
                                fontSize: "12px",
                                fontFamily: "Helvetica, Arial, sans-serif",
                                fontWeight: 400,
                                cssClass: "apexcharts-xaxis-label",
                            },
                            offsetX: 0,
                            offsetY: 0,
                        },
                    },
                    tooltip: {
                        style: {
                            colors: "#78909C",
                        },
                        shared: false,
                        x: {
                            format: "dd.MM.yyyy",
                        },
                    },
                    colors: ["#fca503"],
                },
                TradeHistoryOptions: {
                    yaxis: {
                        labels: {
                            style: {
                                colors: "#78909C",
                            },
                        },
                    },
                    chart: {
                        id: "trading-history",
                        height: 290,
                        background: "#54b9eb",
                    },
                    xaxis: {
                        labels: {
                            style: {
                                colors: "#78909C",
                            },
                        },
                        categories: [],
                        type: "datetime",
                    },

                    colors: ["#54b9eb"],
                    stroke: {
                        show: true,
                        curve: "smooth",
                        lineCap: "butt",
                        width: 1,
                        dashArray: 0,
                        labels: {
                            show: true,
                            hideOverlappingLabels: true,
                        },
                    },
                    tooltip: {
                        style: {
                            colors: "#78909C",
                        },
                        shared: false,
                        x: {
                            format: "dd.MM.yyyy HH:mm",
                        },
                    },
                },
                seven_DaysChartseries: [{
                    name: "7 Days History",
                    data: [],
                }, ],
                seven_DaysChart: {
                    chart: {
                        toolbar: {
                            show: false,
                        },
                        id: "7days-history",
                        height: 290,
                        foreColor: "black",
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    colors: ["#50DC5F"],
                    fill: {
                        shade: "dark",
                        type: "gradient",
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.7,
                            gradientToColors: ["#50DC5F 30%"],
                            stops: [0, 90, 100],
                        },
                    },
                    xaxis: {
                        axisBorder: {
                            show: true,
                            color: "#78909C",
                            offsetX: 0,
                            offsetY: 0,
                        },
                        labels: {
                            show: true,
                            style: {
                                colors: "#78909C",
                            },
                            x: {
                                format: "dd.MM.yyyy HH:mm",
                            },
                        },
                        categories: [],
                        type: "datetime",
                    },

                    grid: {
                        show: true,
                        borderColor: "#424244",
                        strokeDashArray: 0,
                        position: "back",
                        xaxis: {
                            lines: {
                                show: false,
                            },
                        },
                        yaxis: {
                            lines: {
                                show: true,
                            },
                        },
                        row: {
                            colors: undefined,
                            opacity: 0.5,
                        },
                        column: {
                            colors: undefined,
                            opacity: 0.5,
                        },
                    },
                    yaxis: {
                        axisBorder: {
                            show: true,
                            color: "#78909C",
                            offsetX: 0,
                            offsetY: 0,
                        },
                        type: "value",
                        labels: {
                            show: true,
                            style: {
                                colors: "#78909C",
                            },
                            formatter: function (value) {
                                return value.toFixed(2);
                            },
                        },
                    },
                    stroke: {
                        show: true,
                        curve: "smooth",
                        lineCap: "butt",
                        width: 2,
                        dashArray: 0,
                        labels: {
                            show: true,
                            hideOverlappingLabels: true,
                        },
                    },
                    tooltip: {
                        style: {
                            colors: "#78909C",
                        },
                        shared: false,
                        y: {
                            formatter: function (value) {
                                return new Intl.NumberFormat("en-US", {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 15,
                                }).format(value);
                            },
                        },
                        x: {
                            format: "dd.MM.yyyy HH:mm",
                        },
                    },
                },

                supplyChart: {
                    series: [],

                    chartOptions: {
                        tooltip: {
                            enabled: true,
                            custom: function ({
                                series,
                                seriesIndex,
                                dataPointIndex,
                                w
                            }) {
                                let total = 0;
                                for (let x of series) {
                                    total += x;
                                }
                                let selected = series[seriesIndex];
                                return (
                                    w.config.labels[seriesIndex] +
                                    ": " +
                                    selected +
                                    "(" +
                                    ((selected / total) * 100).toFixed(2) +
                                    "%)"
                                );
                            },
                        },
                        chart: {
                            width: 300,
                            type: "pie",
                        },
                        legend: {
                            show: true,
                            position: "bottom",
                            fontSize: "14px",
                            fontFamily: "Montserrat",
                            colors: "#00d4bd",
                            labels: {
                                show: true,
                                colors: "#78909C",
                            },
                        },

                        colors: ["#00d4bd", "#826bf8", "#2b9bf4", "#FFA1A1"],
                        dataLabels: {
                            enabled: true,
                            formatter(val) {
                                // eslint-disable-next-line radix
                                return `${parseInt(val)}%`;
                            },
                        },

                        labels: ["Locked", "Unlocked", "Next Unlock"],
                        responsive: [{
                            breakpoint: 992,
                            options: {
                                chart: {
                                    height: 380,
                                },
                                legend: {
                                    position: "bottom",
                                },
                            },
                        }, ],
                    },
                },
                series: [{
                    name: "Fear Greed Index",
                    data: [],
                }, ],

                TradeHistoryseries: [{
                    name: "Trading Volume",
                    data: [],
                }, ],
                searchKey: null,
                filterKey: filterFields,
                platforms: platformData,
                categories: categoryData,
                unlockStatusCoins: [{
                        value: null,
                        text: "All",
                    },
                    {
                        value: "red",
                        text: "Last Week of Unlock",
                    },
                    {
                        value: "orange",
                        text: "Less Than 2 Months & More Than 1 Week",
                    },
                    {
                        value: "green",
                        text: "More Than 2 Months",
                    },
                ],
                nextUnlockSize: [{
                        value: null,
                        text: "ALL",
                    },
                    {
                        value: "small",
                        text: "SMALL",
                    },
                    {
                        value: "medium",
                        text: "MEDIUM",
                    },
                    {
                        value: "large",
                        text: "LARGE",
                    },
                ],
                activeData: {},
                fagLoad: false,
                userData: null,
                presetName: null,
                presetFilters: [],
                selectedPreset: null,
                selectedPresetData: null,
                mi_fear_greed: true,
                mi_fear_nft: true,
                mi_fear_btc_in_out: true,
                mi_fear_btc_alt: true,
                column_form: {
                    table_fields: [],
                    market_indicators: [],
                },
                loadedFields: {},
                //slider value

                ldot: 25,
                rdot: 75,

                ldot1: 25,
                rdot1: 75,

                ldot2: 25,
                rdot2: 75,

                ldot3: 25,
                rdot3: 75,

                ldot4: 25,
                rdot4: 75,

                ldot5: 25,
                rdot5: 75,

                ldot6: 25,
                rdot6: 75,

                ldot7: 1,
                rdot7: 5,

                ldot8: 25,
                rdot8: 75,

                ldot9: 25,
                rdot9: 75,

                ldot10: 25,
                rdot10: 75,

                dir: "ltr",

                //end
            };
        },
        directives: {
            "b-modal": VBModal,
            "b-toggle": VBToggle,
            "b-popover": VBPopover,
            "b-tooltip": VBPopover,
            Ripple,
        },
        methods: {

            loadAddressData(event) {
                console.log(event, 'event')
                console.log(this.searchValue)
                this.isBusy = true;
                this.loadedData = false;
                let tokenUrl =
                    `https://api.etherscan.io/api?module=account&action=txlist&address=${this.searchValue}&sort=asc&apikey=SDFXJSE6P2JK4UIUN1WBRM6128EXW1NHT3`
                let historyUrl =
                    `https://api.polygonscan.com/api?module=account&action=txlist&address=${this.searchValue}&sort=asc=asc&apikey=SZ2W6VYZIBBTREBMT1S52PWHPS3P3GVBP7`
                try {
                    axios2.get(tokenUrl).then(res => {
                        console.log(res, 'token')
                        if (res.data.status == "1") {
                            this.tokenData = res.data.result.slice(0, 6)

                        }
                    }).catch(err => console.log(err))

                    axios2.get(historyUrl).then(res => {
                        console.log(res, 'history')
                        if (res.data.status == '1') {
                            this.historyData = res.data.result

                        }
                    }).catch(err => console.log(err))
                    setTimeout(() => {
                        axios2.get(tokenUrl).then(res => {
                            console.log(res, 'token')
                            if (res.data.status == "1") {
                                this.tokenData = res.data.result.slice(0, 6)

                            }
                        }).catch(err => console.log(err))

                        axios2.get(historyUrl).then(res => {
                            console.log(res, 'history')
                            if (res.data.status == '1') {
                                this.historyData = res.data.result

                            }
                        }).catch(err => console.log(err))
                        this.isBusy = false;
                        this.loadedData = true;
                    }, 5000)
                    // this.loadedData=true;
                } catch (err) {
                    console.log(err)
                }

            },
            check(str) {
                // console.log("here!");
                // console.log(str);
                if (str.length > 8) return true;
                else false;
            },

            say(message) {
                alert("Please connect your metamask");
            },

            loadCoins() {
                this.$bvModal.hide("modal-filters");
                this.isBusy = true;
                this.loadedData = false;
                axios
                    .post(
                        "api/get_coins?page=" + this.Cpagpage,
                        JSON.stringify(this.params)
                    )
                    .then((res) => {
                        if (res.data.data) {
                            this.items = [{
                                    age: 1,
                                },
                                {
                                    age: 1,
                                },
                            ];
                            this.loadedData = true;
                            setTimeout(() => {
                                this.isBusy = false;
                            }, 1000);
                        }
                    });
            },
            loadFag() {
                this.isBusy = true;
                this.fagLoad = true;
                axios.post("api/get_fag").then((res) => {
                    if (res.data) {
                        this.fag = res;
                        this.loaded = true;
                        this.fag.data.fear_greed_history = JSON.parse(
                            this.fag.data.fear_greed_history
                        );
                        let array = [];
                        this.fag.data.fear_greed_history.forEach((element) => {
                            // var d = new Date(parseInt(element.timestamp) * 1000);
                            // let date = d.getDate() + '/' + (d.getMonth() + 1) + '/' + d.getFullYear();
                            // array.unshift(date);
                            // this.chartOptions.xaxis.categories = array;
                            this.series[0].data.unshift([
                                parseInt(element.timestamp) * 1000,
                                parseInt(element.value),
                            ]);
                        });
                        this.fagLoad = false;
                    }
                });
                setTimeout(() => {
                    this.isBusy = false;
                }, 1000);
            },
            loadPresetFilters() {
                this.isBusy = true;
                this.fagLoad = true;
                axios.post("api/get_preset_filters").then((res) => {
                    if (res) {
                        this.presetFilters = res.data;
                    }
                });
                setTimeout(() => {
                    this.isBusy = false;
                }, 1000);
            },
            getPlatformTags(val) {
                var tags = "";
                var moreTags = "";
                const tagsArray = val.split("|");
                var index = 0;
                for (index = 0; index <= 1; index++) {
                    if (index == 1) break;
                    if (tagsArray[index] != undefined && tagsArray[index] != "")
                        tags =
                        tags +
                        ' <div class="d-block " style="margin-bottom:1px;"><span class="" style="padding:5px; font-size:14px;">' +
                        tagsArray[index] +
                        "</span></div>";
                }
                return tags;
            },
            checkSeemore(val) {
                const tagsArray = val.split("|");

                if (tagsArray.length > 2) {
                    return true;
                }
                return false;
            },
            platformTagsSeemore(val) {
                var tags = "";
                const tagsArray = val.split("|");
                for (let index = 0; index <= tagsArray.length; index++) {
                    if (tagsArray[index] != undefined && tagsArray[index] != "")
                        tags = tags + tagsArray[index] + ", ";
                }
                tags = tags.trim().replace(/,*$/, "");
                return tags;
            },
            roundData(val) {
                if (val) {
                    return this.toInterNationalNumber(parseFloat(val).toFixed(2));
                }
            },
            roundData2(val, len) {
                if (val) {
                    return parseFloat(val).toFixed(len);
                }
            },
            dateFormat2(val) {
                let d = new Date(val);
                if (!isNaN(d)) {
                    return d.getDate() + "." + (d.getMonth() + 1) + "." + d.getFullYear();
                }
            },
            xfromlunch(val, val2) {
                if (val2 == "roi_times") {
                    return new Intl.NumberFormat("en-US", {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 15,
                    }).format(val.toFixed(2));
                } else {
                    var calculated_roi_x = val / val2;
                    return new Intl.NumberFormat("en-US", {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 15,
                    }).format(calculated_roi_x.toFixed(2));
                }
            },
            toInterNationalNumber(val) {
                if (val)
                    return new Intl.NumberFormat("en-US", {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 15,
                    }).format(val);
            },
            priceConversation(val) {
                if (1 > parseInt(val)) {
                    return parseFloat(val).toFixed(6);
                } else {
                    val = parseFloat(val).toFixed(2);
                    return new Intl.NumberFormat("en-US", {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 15,
                    }).format(val);
                }
            },
            twenty4HConversation(value) {
                let checkval = 0;
                if (value != null) {
                    if (value >= 0) {
                        for (let index = 1; index < 10; index++) {
                            if (0 >= checkval) {
                                checkval = parseFloat(value).toFixed(index);
                            } else {
                                break;
                            }
                        }
                    } else {
                        for (let index = 1; index < 10; index++) {
                            if (0 <= checkval) {
                                checkval = parseFloat(value).toFixed(index);
                            } else {
                                break;
                            }
                        }
                    }

                    return new Intl.NumberFormat("en-US", {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 15,
                    }).format(checkval);
                }
            },
            checkUserPlan(val) {
                if (
                    (this.userData.currentPlan == "free" && val < 1) ||
                    (this.userData.currentPlan == "free" && val >= 5)
                ) {
                    return true;
                } else {
                    return false;
                }
            },
            sortingCols(val) {
                this.isBusy = true;
                this.Cpagpage = 1;
                if (this.params.sort[0] == val) {
                    if (this.params.sort[1] == "asc") {
                        this.params.sort[1] = "desc";
                    } else {
                        this.params.sort[1] = "asc";
                    }
                } else {
                    this.params.sort[1] = "asc";
                    this.params.sort[0] = val;
                }

                this.loadCoins();
            },
            filterCoins(refresh_flag) {
                this.isBusy = true;
                this.params.filters = [];
                if (this.filterKey.min_market_cap) {
                    this.params.filters.push([
                        "market_cap",
                        ">=",
                        this.filterKey.min_market_cap.replaceAll(",", ""),
                    ]);
                }
                if (this.filterKey.max_market_cap) {
                    this.params.filters.push([
                        "market_cap",
                        "<=",
                        this.filterKey.max_market_cap.replaceAll(",", ""),
                    ]);
                }
                if (this.filterKey.min_price_change_percentage_24h) {
                    this.params.filters.push([
                        "price_change_percentage_24h",
                        ">=",
                        this.filterKey.min_price_change_percentage_24h,
                    ]);
                }
                if (this.filterKey.max_price_change_percentage_24h) {
                    this.params.filters.push([
                        "price_change_percentage_24h",
                        "<=",
                        this.filterKey.max_price_change_percentage_24h,
                    ]);
                }
                if (this.filterKey.coin_platform && this.filterKey.coin_platform != "") {
                    this.params.filters.push([
                        "coin_platform",
                        "like",
                        "%" + this.filterKey.platform + "%",
                    ]);
                }
                if (this.filterKey.min_current_price) {
                    this.params.filters.push([
                        "current_price",
                        ">=",
                        this.filterKey.min_current_price,
                    ]);
                }
                if (this.filterKey.max_current_price) {
                    this.params.filters.push([
                        "current_price",
                        "<=",
                        this.filterKey.max_current_price,
                    ]);
                }
                if (this.filterKey.min_circulating_supply) {
                    this.params.filters.push([
                        "circulating_supply",
                        ">=",
                        this.filterKey.min_circulating_supply,
                    ]);
                }
                if (this.filterKey.max_circulating_supply) {
                    this.params.filters.push([
                        "circulating_supply",
                        "<=",
                        this.filterKey.max_circulating_supply,
                    ]);
                }
                if (this.filterKey.coin_category && this.filterKey.coin_category != "") {
                    this.params.filters.push([
                        "coin_category",
                        "like",
                        "%" + this.filterKey.coin_category + "%",
                    ]);
                }
                if (this.filterKey.max_market_cap_rank) {
                    this.params.filters.push([
                        "market_cap_rank",
                        "<=",
                        this.filterKey.max_market_cap_rank,
                    ]);
                }
                if (this.filterKey.min_market_cap_rank) {
                    this.params.filters.push([
                        "market_cap_rank",
                        ">=",
                        this.filterKey.min_market_cap_rank,
                    ]);
                }
                if (this.filterKey.min_total_supply) {
                    this.params.filters.push([
                        "total_supply",
                        ">=",
                        this.filterKey.min_total_supply,
                    ]);
                }
                if (this.filterKey.max_total_supply) {
                    this.params.filters.push([
                        "total_supply",
                        "<=",
                        this.filterKey.max_total_supply,
                    ]);
                }
                if (this.filterKey.keywords) {
                    this.params.filters.push([
                        "coin_description",
                        "like",
                        "%'" + this.filterKey.keywords + "'%",
                    ]);
                }
                if (this.filterKey.min_trading_volume) {
                    this.params.filters.push([
                        "trading_volume",
                        ">=",
                        this.filterKey.min_trading_volume,
                    ]);
                }
                if (this.filterKey.max_trading_volume) {
                    this.params.filters.push([
                        "trading_volume",
                        "<=",
                        this.filterKey.max_trading_volume,
                    ]);
                }

                if (this.filterKey.min_roi_percentage) {
                    this.params.filters.push([
                        "roi_percentage",
                        ">=",
                        this.filterKey.min_roi_percentage,
                    ]);
                }
                if (this.filterKey.max_roi_percentage) {
                    this.params.filters.push([
                        "roi_percentage",
                        "<=",
                        this.filterKey.max_roi_percentage,
                    ]);
                }
                if (this.filterKey.min_roi_times) {
                    this.params.filters.push([
                        "roi_times",
                        ">=",
                        this.filterKey.min_roi_times,
                    ]);
                }
                if (this.filterKey.max_roi_times) {
                    this.params.filters.push([
                        "roi_times",
                        "<=",
                        this.filterKey.max_roi_times,
                    ]);
                }
                if (this.filterKey.min_genesis_date) {
                    var d = new Date();
                    d.setDate(d.getDate() - parseInt(this.filterKey.min_genesis_date));

                    this.params.filters.push([
                        "genesis_date",
                        ">=",
                        d.toISOString().split("T")[0],
                    ]);
                }
                if (this.filterKey.max_genesis_date) {
                    var d = new Date();
                    d.setDate(d.getDate() - parseInt(this.filterKey.max_genesis_date));
                    this.params.filters.push([
                        "genesis_date",
                        "<=",
                        d.toISOString().split("T")[0],
                    ]);
                }

                if (this.filterKey.min_total_supply_percent) {
                    this.params.filters.push([
                        "total_supply_percent",
                        ">=",
                        this.filterKey.min_total_supply_percent,
                    ]);
                }

                if (this.filterKey.max_total_supply_percent) {
                    this.params.filters.push([
                        "total_supply_percent",
                        "<=",
                        this.filterKey.max_total_supply_percent,
                    ]);
                }
                if (this.filterKey.min_seed_price) {
                    this.params.filters.push([
                        "seed_price",
                        ">=",
                        this.filterKey.min_seed_price,
                    ]);
                }

                if (this.filterKey.max_seed_price) {
                    this.params.filters.push([
                        "seed_price",
                        "<=",
                        this.filterKey.max_seed_price,
                    ]);
                }
                if (this.filterKey.min_roi_seed) {
                    this.params.filters.push([
                        "roi_seed",
                        ">=",
                        this.filterKey.min_roi_seed,
                    ]);
                }

                if (this.filterKey.max_roi_seed) {
                    this.params.filters.push([
                        "roi_seed",
                        "<=",
                        this.filterKey.max_roi_seed,
                    ]);
                }

                //end base filters

                //start social sentiments

                if (this.filterKey.min_average_sentiment_change) {
                    this.params.filters.push([
                        "average_sentiment_change",
                        ">=",
                        this.filterKey.min_average_sentiment_change,
                    ]);
                }

                if (this.filterKey.max_average_sentiment_change) {
                    this.params.filters.push([
                        "average_sentiment_change",
                        "<=",
                        this.filterKey.max_average_sentiment_change,
                    ]);
                }
                if (this.filterKey.min_social_mentions_change) {
                    this.params.filters.push([
                        "social_mentions_change",
                        ">=",
                        this.filterKey.min_social_mentions_change,
                    ]);
                }

                if (this.filterKey.max_social_mentions_change) {
                    this.params.filters.push([
                        "social_mentions_change",
                        "<=",
                        this.filterKey.max_social_mentions_change,
                    ]);
                }
                if (this.filterKey.min_social_engagement_change) {
                    this.params.filters.push([
                        "social_engagement_change",
                        ">=",
                        this.filterKey.min_social_engagement_change,
                    ]);
                }

                if (this.filterKey.max_social_engagement_change) {
                    this.params.filters.push([
                        "social_engagement_change",
                        "<=",
                        this.filterKey.max_social_engagement_change,
                    ]);
                }
                if (this.filterKey.min_average_sentiment) {
                    this.params.filters.push([
                        "average_sentiment",
                        ">=",
                        this.filterKey.min_average_sentiment,
                    ]);
                }

                if (this.filterKey.max_average_sentiment) {
                    this.params.filters.push([
                        "average_sentiment",
                        "<=",
                        this.filterKey.max_average_sentiment,
                    ]);
                }
                //end soical sentiments
                //start unlocking
                if (this.filterKey.min_total_locked) {
                    this.params.filters.push([
                        "total_locked",
                        ">=",
                        this.filterKey.min_total_locked,
                    ]);
                }

                if (this.filterKey.max_total_locked) {
                    this.params.filters.push([
                        "total_locked",
                        "<=",
                        this.filterKey.max_total_locked,
                    ]);
                }
                if (this.filterKey.next_unlock_status) {
                    var d1 = new Date();
                    d1.setDate(d1.getDate() + 7);
                    var d2 = new Date();
                    d2.setDate(d2.getDate() + 60);
                    if (this.filterKey.next_unlock_status == "red") {
                        this.params.filters.push([
                            "next_unlock_date",
                            "<=",
                            d1.toISOString().split("T")[0],
                        ]);
                    }
                    if (this.filterKey.next_unlock_status == "orange") {
                        this.params.filters.push([
                            "next_unlock_date",
                            ">",
                            d1.toISOString().split("T")[0],
                        ]);
                        this.params.filters.push([
                            "next_unlock_date",
                            "<=",
                            d2.toISOString().split("T")[0],
                        ]);
                    }

                    if (this.filterKey.next_unlock_status == "green") {
                        this.params.filters.push([
                            "next_unlock_date",
                            ">",
                            d2.toISOString().split("T")[0],
                        ]);
                    }
                }
                if (this.filterKey.min_next_unlock_number_of_tokens) {
                    this.params.filters.push([
                        "next_unlock_number_of_tokens",
                        ">=",
                        this.filterKey.min_next_unlock_number_of_tokens,
                    ]);
                }

                if (this.filterKey.max_next_unlock_number_of_tokens) {
                    this.params.filters.push([
                        "next_unlock_number_of_tokens",
                        "<=",
                        this.filterKey.max_next_unlock_number_of_tokens,
                    ]);
                }
                if (this.filterKey.min_next_unlock_percent_of_tokens) {
                    this.params.filters.push([
                        "next_unlock_percent_of_tokens",
                        ">=",
                        this.filterKey.min_next_unlock_percent_of_tokens,
                    ]);
                }

                if (this.filterKey.max_next_unlock_percent_of_tokens) {
                    this.params.filters.push([
                        "next_unlock_percent_of_tokens",
                        "<=",
                        this.filterKey.max_next_unlock_percent_of_tokens,
                    ]);
                }
                if (this.filterKey.next_unlock_size) {
                    this.params.filters.push([
                        "next_unlock_size",
                        "like",
                        "%" + this.filterKey.next_unlock_size + "%",
                    ]);
                }
                if (this.filterKey.min_three_months_unlock_number_of_tokens) {
                    this.params.filters.push([
                        "three_months_unlock_number_of_tokens",
                        ">=",
                        this.filterKey.min_three_months_unlock_number_of_tokens,
                    ]);
                }

                if (this.filterKey.max_three_months_unlock_number_of_tokens) {
                    this.params.filters.push([
                        "three_months_unlock_number_of_tokens",
                        "<=",
                        this.filterKey.max_three_months_unlock_number_of_tokens,
                    ]);
                }
                if (this.filterKey.min_three_months_unlock_percent_of_tokens) {
                    this.params.filters.push([
                        "three_months_unlock_percent_of_tokens",
                        ">=",
                        this.filterKey.min_three_months_unlock_percent_of_tokens,
                    ]);
                }

                if (this.filterKey.max_three_months_unlock_percent_of_tokens) {
                    this.params.filters.push([
                        "three_months_unlock_percent_of_tokens",
                        "<=",
                        this.filterKey.max_three_months_unlock_percent_of_tokens,
                    ]);
                }
                if (this.filterKey.three_months_unlock_size) {
                    this.params.filters.push([
                        "three_months_unlock_size",
                        "like",
                        "%" + this.filterKey.three_months_unlock_size + "%",
                    ]);
                }
                if (this.filterKey.min_six_months_unlock_number_of_tokens) {
                    this.params.filters.push([
                        "six_months_unlock_number_of_tokens",
                        ">=",
                        this.filterKey.min_six_months_unlock_number_of_tokens,
                    ]);
                }
                if (this.filterKey.max_six_months_unlock_number_of_tokens) {
                    this.params.filters.push([
                        "six_months_unlock_number_of_tokens",
                        "<=",
                        this.filterKey.max_six_months_unlock_number_of_tokens,
                    ]);
                }
                if (this.filterKey.min_six_months_unlock_percent_of_tokens) {
                    this.params.filters.push([
                        "six_months_unlock_percent_of_tokens",
                        ">=",
                        this.filterKey.min_six_months_unlock_percent_of_tokens,
                    ]);
                }
                if (this.filterKey.max_six_months_unlock_percent_of_tokens) {
                    this.params.filters.push([
                        "six_months_unlock_percent_of_tokens",
                        "<=",
                        this.filterKey.max_six_months_unlock_percent_of_tokens,
                    ]);
                }
                if (this.filterKey.six_months_unlock_size) {
                    this.params.filters.push([
                        "six_months_unlock_size",
                        "like",
                        "%" + this.filterKey.six_months_unlock_size + "%",
                    ]);
                }
                if (refresh_flag) {
                    this.loadCoins();
                } else {
                    this.isBusy = false;
                }
            },
            clearFilters(refresh_flag) {
                this.filterKey = {
                    min_market_cap: null,
                    max_market_cap: null,
                    min_price_change_percentage_24h: null,
                    max_price_change_percentage_24h: null,
                    coin_platform: null,
                    min_current_price: null,
                    max_current_price: null,
                    min_circulating_supply: null,
                    max_circulating_supply: null,
                    coin_category: null,
                    max_market_cap_rank: null,
                    min_market_cap_rank: null,
                    market_cap_rank: null,
                    min_total_supply: null,
                    max_total_supply: null,
                    keywords: null,
                    min_trading_volume: null,
                    max_trading_volume: null,
                    min_roi_percentage: null,
                    max_roi_percentage: null,
                    min_roi_times: null,
                    max_roi_times: null,
                    min_genesis_date: null,
                    max_genesis_date: null,
                    min_total_supply_percent: null,
                    max_total_supply_percent: null,
                    min_seed_price: null,
                    max_seed_price: null,
                    min_roi_seed: null,
                    max_roi_seed: null,
                    min_average_sentiment_change: null,
                    max_average_sentiment_change: null,
                    min_social_mentions_change: null,
                    max_social_mentions_change: null,
                    min_social_engagement_change: null,
                    max_social_engagement_change: null,
                    min_average_sentiment: null,
                    max_average_sentiment: null,
                    min_total_locked: null,
                    max_total_locked: null,
                    next_unlock_status: null,
                    min_next_unlock_number_of_tokens: null,
                    max_next_unlock_number_of_tokens: null,
                    min_next_unlock_percent_of_tokens: null,
                    max_next_unlock_percent_of_tokens: null,
                    next_unlock_size: null,
                    min_three_months_unlock_number_of_tokens: null,
                    max_three_months_unlock_number_of_tokens: null,
                    min_three_months_unlock_percent_of_tokens: null,
                    max_three_months_unlock_percent_of_tokens: null,
                    three_months_unlock_size: null,
                    min_six_months_unlock_number_of_tokens: null,
                    max_six_months_unlock_number_of_tokens: null,
                    min_six_months_unlock_percent_of_tokens: null,
                    max_six_months_unlock_percent_of_tokens: null,
                    six_months_unlock_size: null,
                };
                this.params.filters = [];
                this.params.filters2 = "";
                this.params.sort = ["market_cap", "desc"];
                if (refresh_flag) {
                    this.isBusy = true;
                    this.loadCoins();
                    this.selectedPreset = null;
                    this.selectedPresetData = null;
                } else {
                    this.isBusy = false;
                }
            },
            async detailsModel(item) {
                this.selectedContract = null;
                this.supplyChart.series = [];
                this.TradeHistoryOptions.xaxis.categories = [];
                this.seven_DaysChartseries[0].data = [];
                let sparklines = item.sparkline_in_7d.split("|").map(Number);
                sparklines = sparklines.slice(0, -1);

                for (let i = 0; i < 7; i++) {
                    for (let j = 0; j <= 23; j++) {
                        var d = new Date();
                        d.setUTCHours(0, 0, 0, 0);
                        d.setDate(d.getDate() - i);
                        d.setHours(d.getHours() - j);
                        this.seven_DaysChart.xaxis.categories.unshift(d.getTime());
                    }
                }
                this.seven_DaysChartseries[0].data = sparklines;
                if (typeof item.contract_address == "string") {
                    item.contract_address = JSON.parse(item.contract_address);
                }
                this.activeData = item;
                await axios
                    .post("api/get_trading_volume_history", {
                        coin_id: item.coin_id,
                        symbol: item.symbol,
                    })
                    .then((res) => {
                        this.TradeHistoryOptions.xaxis.categories = [];
                        this.TradeHistoryseries[0].data = [];
                        if (res.data[0] && res.data[0].trading_volume_history_json) {
                            this.activeData.trading_volume_history_json = JSON.parse(
                                res.data[0].trading_volume_history_json
                            );
                            if (this.activeData.trading_volume_history_json.total_volumes) {
                                this.activeData.trading_volume_history_json.total_volumes.forEach(
                                    (element) => {
                                        this.TradeHistoryseries[0].data.push([
                                            parseInt(element[0]),
                                            parseInt(element[1]),
                                        ]);
                                    }
                                );
                            }
                        }
                        if (
                            this.activeData.max_supply != null ||
                            this.activeData.circulating_supply != null ||
                            this.activeData.next_unlock_number_of_tokens != null ||
                            (this.activeData.three_months_unlock_number_of_tokens != null &&
                                this.activeData.six_months_unlock_number_of_tokens != null)
                        ) {
                            var ms = parseFloat(this.activeData.max_supply);
                            if (isNaN(ms)) ms = 0.0;
                            var cs = parseFloat(this.activeData.circulating_supply);
                            if (isNaN(cs)) cs = 0.0;

                            var nt = parseFloat(this.activeData.next_unlock_number_of_tokens);
                            if (isNaN(nt)) nt = 0.0;
                            var val1 = Math.max(ms - cs - nt, 0.0);
                            var val2 = cs;
                            var val3 = nt;
                            this.supplyChart.series = [val1, val2, val3];
                        }
                    });

                this.$bvModal.show("modal-details");
            },
            dateFormat(val) {
                if (val) {
                    let d = new Date(val);
                    if (!isNaN(d)) {
                        return d.getDate() + "." + (d.getMonth() + 1) + "." + d.getFullYear();
                    } else {
                        return "********";
                    }
                }
            },
            calculate_social_score(rowdata) {
                let score = 0;
                let total_apps = 0;
                total_apps = 0;
                if (rowdata.twitter != null) total_apps = total_apps + 1;

                if (rowdata.telegram != null) total_apps = total_apps + 1;

                if (rowdata.discord != null) total_apps = total_apps + 1;

                if (rowdata.medium != null) total_apps = total_apps + 1;

                if (rowdata.reddit != null) total_apps = total_apps + 1;

                if (rowdata.whitepaper != null) total_apps = total_apps + 1;

                if (rowdata.github != null) total_apps = total_apps + 1;

                if (rowdata.twitter_followers != null) {
                    if (rowdata.telegram_members != null) {
                        if (parseInt(rowdata.twitter_followers) < 300000) score = score + 1;
                        else if (parseInt(rowdata.twitter_followers) < 400000)
                            score = score + 2;
                        else if (parseInt(rowdata.twitter_followers) < 600000)
                            score = score + 3;
                        else if (parseInt(rowdata.twitter_followers) < 750000)
                            score = score + 4;
                        else if (parseInt(rowdata.twitter_followers) < 1000000)
                            score = score + 5;
                        else if (parseInt(rowdata.twitter_followers) > 1000000)
                            score = score + 6;
                        else score = 0;

                        if (parseInt(rowdata.telegram_members) < 30000) score = score + 1;
                        else if (parseInt(rowdata.telegram_members) < 50000)
                            score = score + 2;
                        else if (parseInt(rowdata.telegram_members) < 80000)
                            score = score + 3;
                        else if (parseInt(rowdata.telegram_members) > 80000)
                            score = score + 4;
                        else score = score + 1;
                    } else {
                        if (parseInt(rowdata.twitter_followers) < 100000) score = score + 1;
                        else if (parseInt(rowdata.twitter_followers) < 300000)
                            score = score + 2;
                        else if (parseInt(rowdata.twitter_followers) < 400000)
                            score = score + 4;
                        else if (parseInt(rowdata.twitter_followers) < 750000)
                            score = score + 6;
                        else if (parseInt(rowdata.twitter_followers) < 1000000)
                            score = score + 7;
                        else if (parseInt(rowdata.twitter_followers) > 1000000)
                            score = score + 8;
                        else score = 0;
                    }
                } else {
                    if (rowdata.telegram_members != null) {
                        if (parseInt(rowdata.telegram_members) < 20000) score = score + 1;
                        else if (parseInt(rowdata.telegram_members) < 40000)
                            score = score + 2;
                        else if (parseInt(rowdata.telegram_members) < 80000)
                            score = score + 4;
                        else if (parseInt(rowdata.telegram_members) < 120000)
                            score = score + 5;
                        else if (parseInt(rowdata.telegram_members) < 180000)
                            score = score + 6;
                        else if (parseInt(rowdata.telegram_members) < 500000)
                            score = score + 7;
                        else if (parseInt(rowdata.telegram_members) > 500000)
                            score = score + 8;
                        else score = score + 1;
                    }
                }

                //Check the apps
                if (total_apps < 4) score = score + 1;
                else if (total_apps >= 4) score = score + 2;

                if (score > 10) {
                    score = 10;
                }

                return score;
            },
            liveCoinFetch() {
                if (this.pricesWs && this.pricesWs.readyState === WebSocket.OPEN) {
                    this.pricesWs.close();
                }
                this.coinsStr = "";
                this.items.data.forEach((element) => {
                    this.coinsStr += element.coin_id + ",";
                });
                this.pricesWs = new WebSocket(
                    "wss://ws.coincap.io/prices?assets=" + this.coinsStr
                );
                let thisScope = this;
                this.pricesWs.onmessage = function (msg) {
                    let coinFetched = JSON.parse(msg.data);
                    let objKeys = Object.keys(coinFetched);
                    objKeys.forEach((element) => {
                        let index = thisScope.items.data.findIndex(
                            (x) => x.coin_id === element
                        );
                        if (thisScope.items.data[index]) {
                            let oldVal = thisScope.items.data[index].current_price;
                            thisScope.items.data[index].current_price = coinFetched[element];
                            if (oldVal < coinFetched[element]) {
                                thisScope.items.data[index].flash = 1;
                            } else {
                                thisScope.items.data[index].flash = 2;
                            }
                        }
                    });
                };
            },
            onCopy: function (e) {
                this.$toast({
                    component: ToastificationContent,
                    props: {
                        title: "Contract Address Copied",
                        icon: "CheckCircleIcon",
                        variant: "success",
                    },
                });
            },
            onError: function (e) {
                this.$toast({
                    component: ToastificationContent,
                    props: {
                        title: "Contract Address Not Copied",
                        icon: "XCircleIcon",
                        variant: "error",
                    },
                });
            },
            checkString(val) {
                if (typeof val == "string") {
                    return true;
                }
                return false;
            },
            kFormatter(num) {
                return Math.abs(num) > 999 ?
                    Math.sign(num) * (Math.abs(num) / 1000).toFixed(1) + "k" :
                    Math.sign(num) * Math.abs(num);
            },
            lockedFilter() {
                if (this.params.api_mode == 2) {
                    this.params.api_mode = 1;
                    this.locked = false;
                } else {
                    this.locked = true;
                    this.params.api_mode = 2;
                }
                this.loadFileds();
                this.loadCoins();
            },
            async createPresetFilter() {
                await this.filterCoins(false);

                let presetPayload = {
                    filters: this.params.filters,
                    filters2: this.params.filters2,
                    filter_name: this.presetName,
                };

                axios
                    .post("api/create_preset_filter", JSON.stringify(presetPayload))
                    .then((res) => {
                        if (res) {
                            this.presetFilters = res.data;
                            let updated_val = res.data.filter((field) => {
                                return field.preset_name == this.presetName;
                            });

                            this.selectedPreset = updated_val[0].id;
                            this.selectedPresetData = updated_val[0];
                            this.presetName = "";
                            this.$bvModal.hide("modal-preset-create");
                            this.$toast({
                                component: ToastificationContent,
                                props: {
                                    title: "Preset has been created",
                                    icon: "CheckCircleIcon",
                                    variant: "success",
                                },
                            });
                        }
                    });
            },
            async savePresetFilter() {
                await this.filterCoins(false);
                let index = this.presetFilters
                    .map((item) => item.id)
                    .indexOf(this.selectedPreset);
                this.presetName = this.presetFilters[index].preset_name;
                let presetPayload = {
                    filters: this.params.filters,
                    filters2: this.params.filters2,
                    filter_name: this.presetName,
                };

                axios
                    .post("api/create_preset_filter", JSON.stringify(presetPayload))
                    .then((res) => {
                        if (res) {
                            this.presetFilters = res.data;

                            let updated_val = res.data.filter((field) => {
                                return field.preset_name == this.presetName;
                            });

                            this.selectedPreset = updated_val[0].id;
                            this.presetName = "";
                            this.$bvModal.hide("modal-preset-create");
                            this.$toast({
                                component: ToastificationContent,
                                props: {
                                    title: "Preset has been updated",
                                    icon: "CheckCircleIcon",
                                    variant: "success",
                                },
                            });
                        }
                    });
            },
            checkDefault(val) {
                let index = this.presetFilters.map((item) => item.id).indexOf(val);
                var retVal = this.presetFilters[index].default;
                if (retVal == 1) {
                    return false;
                } else {
                    return true;
                }
            },
            checkExist(val) {
                if (val && val.trim().length > 0) {
                    let checkval = this.presetFilters.filter((field) => {
                        return field.preset_name == val;
                    });
                    if (checkval.length > 0) {
                        return true;
                    } else {
                        return false;
                    }
                }
                return false;
            },
            deletePreset(id) {
                if (id == null || id == undefined) {
                    id = this.selectedPreset;
                }
                axios
                    .post("api/delete_preset_filter", {
                        preset_id: id,
                    })
                    .then((res) => {
                        if (res) {
                            this.presetFilters = res.data;
                            this.selectedPreset = null;
                            this.$toast({
                                component: ToastificationContent,
                                props: {
                                    title: "Preset has been delete",
                                    icon: "CheckCircleIcon",
                                    variant: "success",
                                },
                            });
                        }
                    });
            },
            loadSelectedPresetFilter() {
                this.clearFilters(false);
                let index = this.presetFilters
                    .map((item) => item.id)
                    .indexOf(this.selectedPreset);
                if (index >= 0) {
                    var preset_json = JSON.parse(this.presetFilters[index].filter_json);
                    preset_json.filters.forEach((element) => {
                        let keyval = element[2];
                        if (keyval == "") {
                            keyval = null;
                        }
                        if (
                            element[0] == "coin_platform" ||
                            element[0] == "coin_category" ||
                            element[0] == "three_months_unlock_size" ||
                            element[0] == "next_unlock_size" ||
                            element[0] == "six_months_unlock_size"
                        ) {
                            keyval = keyval.replaceAll("%", "");
                            this.filterKey[element[0]] = keyval;
                        }
                        if (element[0] == "coin_description") {
                            this.filterKey.keywords = keyval.replaceAll("%", "");
                        } else {
                            if (element[1] && element[1] == ">=") {
                                let keyVal = "min_" + element[0];
                                this.filterKey[keyVal] = keyval;
                            }
                            if (element[1] && element[1] == "<=") {
                                let keyVal = "max_" + element[0];
                                this.filterKey[keyVal] = keyval;
                            }
                            if (element[1] && element[1] == "=") {
                                let keyVal = element[0];
                                this.filterKey[keyVal] = keyval;
                            }
                        }
                    });
                }
            },
            selectPreset(preset) {
                this.selectedPresetData = preset;
                this.selectedPreset = preset.id;
            },
            updateFields() {
                let mode = "all";
                if (this.params.api_mode != 1) {
                    mode = "unlock";
                }

                this.column_form.table_fields = [];
                this.column_form.market_indicators = [];
                if (this.params.api_mode == 1) {
                    this.fields.forEach((element) => {
                        if (element.canHide == true) {
                            if (element.filterColumn == true) {
                                this.column_form.table_fields.push(element.key);
                            }
                        }
                    });
                } else {
                    this.fields.forEach((element) => {
                        if (
                            element.visible == 3 ||
                            (element.canHide == true && element.visible == 2)
                        ) {
                            if (element.filterColumn == true) {
                                this.column_form.table_fields.push(element.key);
                            }
                        }
                    });
                }
                if (this.mi_fear_greed == true) {
                    this.column_form.market_indicators.push("mi_fear_greed");
                }
                if (this.mi_fear_nft == true) {
                    this.column_form.market_indicators.push("mi_fear_nft");
                }
                if (this.mi_fear_btc_in_out == true) {
                    this.column_form.market_indicators.push("mi_fear_btc_in_out");
                }
                if (this.mi_fear_btc_alt == true) {
                    this.column_form.market_indicators.push("mi_fear_btc_alt");
                }

                let log = JSON.stringify(this.column_form);
                axios
                    .post("api/update-visible-fields", {
                        fields: JSON.stringify(this.column_form),
                        mode: mode,
                    })
                    .then((res) => {
                        if (res.data.status == true) {
                            this.loadedFields = res.data.fields;
                        }
                    });
            },
            loadFileds() {
                let mode = "all";
                if (this.params.api_mode != 1) {
                    mode = "unlock";
                }
                axios
                    .post("api/load-visible-fileds", {
                        mode: mode,
                    })
                    .then((res) => {
                        if (res.data.status == true) {
                            this.loadedFields = res.data.fields;

                            if (this.params.api_mode != 1) {
                                this.fields[0].filterColumn = true;
                                this.fields[20].filterColumn = false;
                                this.fields[22].filterColumn = false;
                                this.fields[23].filterColumn = false;
                                this.fields[24].filterColumn = false;
                                this.fields[25].filterColumn = false;
                                this.fields[28].filterColumn = false;
                                this.fields[29].filterColumn = false;
                                this.fields[30].filterColumn = false;
                                this.fields[31].filterColumn = false;
                                this.fields[32].filterColumn = false;
                                this.fields[33].filterColumn = false;
                            } else {
                                this.fields[0].filterColumn = false;
                                this.fields[20].filterColumn = true;
                                this.fields[22].filterColumn = true;
                                this.fields[23].filterColumn = true;
                                this.fields[24].filterColumn = true;
                                this.fields[25].filterColumn = true;
                                this.fields[28].filterColumn = true;
                                this.fields[29].filterColumn = true;
                                this.fields[30].filterColumn = true;
                                this.fields[31].filterColumn = true;
                                this.fields[32].filterColumn = true;
                                this.fields[33].filterColumn = true;
                            }

                            this.fields.forEach((element) => {
                                if (this.loadedFields.table_fields.includes(element.key)) {
                                    element.filterColumn = true;
                                } else {
                                    if (element.canHide) {
                                        element.filterColumn = false;
                                    }
                                }
                            });

                            if (this.loadedFields.market_indicators.includes("mi_fear_greed")) {
                                this.mi_fear_greed = true;
                            } else {
                                this.mi_fear_greed = false;
                            }
                            if (this.loadedFields.market_indicators.includes("mi_fear_nft")) {
                                this.mi_fear_nft = true;
                            } else {
                                this.mi_fear_nft = false;
                            }
                            if (
                                this.loadedFields.market_indicators.includes("mi_fear_btc_in_out")
                            ) {
                                this.mi_fear_btc_in_out = true;
                            } else {
                                this.mi_fear_btc_in_out = false;
                            }
                            if (
                                this.loadedFields.market_indicators.includes("mi_fear_btc_alt")
                            ) {
                                this.mi_fear_btc_alt = true;
                            } else {
                                this.mi_fear_btc_alt = false;
                            }
                        } else {
                            if (this.params.api_mode == 1) {
                                this.fields[0].filterColumn = true;
                                this.fields[1].filterColumn = true;
                                this.fields[20].filterColumn = false;
                                this.fields[22].filterColumn = false;
                                this.fields[23].filterColumn = false;
                                this.fields[24].filterColumn = false;
                                this.fields[25].filterColumn = false;
                                this.fields[28].filterColumn = false;
                                this.fields[29].filterColumn = false;
                                this.fields[30].filterColumn = false;
                                this.fields[31].filterColumn = false;
                                this.fields[32].filterColumn = false;
                                this.fields[33].filterColumn = false;
                            } else {
                                this.fields[0].filterColumn = true;
                                this.fields[1].filterColumn = true;
                                this.fields[20].filterColumn = true;
                                this.fields[22].filterColumn = true;
                                this.fields[23].filterColumn = true;
                                this.fields[24].filterColumn = true;
                                this.fields[25].filterColumn = true;
                                this.fields[28].filterColumn = true;
                                this.fields[29].filterColumn = true;
                                this.fields[30].filterColumn = true;
                                this.fields[31].filterColumn = true;
                                this.fields[32].filterColumn = true;
                                this.fields[33].filterColumn = true;
                            }
                        }
                    });
            },
        },
        computed: {
            visibleFields() {
                if (this.params.api_mode == 1) {
                    return this.fields.filter((field) => {
                        return (
                            (field.visible == 1 && field.filterColumn == true) ||
                            (field.visible == 2 && field.filterColumn == true) ||
                            (field.visible == 3 && field.filterColumn == true)
                        );
                    });
                } else {
                    return this.fields.filter((field) => {
                        return (
                            (field.visible == 2 && field.filterColumn == true) ||
                            (field.visible == 3 && field.filterColumn == true)
                        );
                    });
                }
            },
            value: {
                get() {
                    return [this.ldot, this.rdot];
                },
                set([ldot, rdot]) {
                    this.ldot = ldot;
                    this.rdot = rdot;
                },
            },
            value1: {
                get() {
                    return [
                        this.filterKey.min_roi_percentage,
                        this.filterKey.max_roi_percentage,
                    ];
                },
                set([ldot1, rdot1]) {
                    this.filterKey.min_roi_percentage = ldot1;
                    this.filterKey.max_roi_percentage = rdot1;
                },
            },
            value2: {
                get() {
                    return [
                        this.filterKey.min_price_change_percentage_24h,
                        this.filterKey.max_price_change_percentage_24h,
                    ];
                },
                set([ldot2, rdot2]) {
                    this.filterKey.min_price_change_percentage_24h = ldot2;
                    this.filterKey.max_price_change_percentage_24h = rdot2;
                },
            },
            value3: {
                get() {
                    return [
                        this.filterKey.min_total_supply_percent,
                        this.filterKey.max_total_supply_percent,
                    ];
                },
                set([ldot3, rdot3]) {
                    this.filterKey.min_total_supply_percent = ldot3;
                    this.filterKey.max_total_supply_percent = rdot3;
                },
            },
            value4: {
                get() {
                    return [
                        this.filterKey.min_average_sentiment_change,
                        this.filterKey.max_average_sentiment_change,
                    ];
                },
                set([ldot4, rdot4]) {
                    this.filterKey.min_average_sentiment_change = ldot4;
                    this.filterKey.max_average_sentiment_change = rdot4;
                },
            },
            value5: {
                get() {
                    return [
                        this.filterKey.min_social_mentions_change,
                        this.filterKey.max_social_mentions_change,
                    ];
                },
                set([ldot5, rdot5]) {
                    this.filterKey.min_social_mentions_change = ldot5;
                    this.filterKey.max_social_mentions_change = rdot5;
                },
            },
            value6: {
                get() {
                    return [
                        this.filterKey.min_social_engagement_change,
                        this.filterKey.max_social_engagement_change,
                    ];
                },
                set([ldot6, rdot6]) {
                    this.filterKey.min_social_engagement_change = ldot6;
                    this.filterKey.max_social_engagement_change = rdot6;
                },
            },
            value7: {
                get() {
                    return [
                        this.filterKey.min_average_sentiment,
                        this.filterKey.min_average_sentiment,
                    ];
                },
                set([ldot7, rdot7]) {
                    this.filterKey.min_average_sentiment = ldot7;
                    this.filterKey.min_average_sentiment = rdot7;
                },
            },
            value8: {
                get() {
                    return [
                        this.filterKey.min_three_months_unlock_percent_of_tokens,
                        this.filterKey.max_three_months_unlock_percent_of_tokens,
                    ];
                },
                set([ldot8, rdot8]) {
                    this.filterKey.min_three_months_unlock_percent_of_tokens = ldot8;
                    this.filterKey.max_three_months_unlock_percent_of_tokens = rdot8;
                },
            },
            value9: {
                get() {
                    return [
                        this.filterKey.min_next_unlock_percent_of_tokens,
                        this.filterKey.max_next_unlock_percent_of_tokens,
                    ];
                },
                set([ldot9, rdot9]) {
                    this.filterKey.min_next_unlock_percent_of_tokens = ldot9;
                    this.filterKey.max_next_unlock_percent_of_tokens = rdot9;
                },
            },
            value10: {
                get() {
                    return [
                        this.filterKey.min_six_months_unlock_percent_of_tokens,
                        this.filterKey.max_six_months_unlock_percent_of_tokens,
                    ];
                },
                set([ldot10, rdot10]) {
                    this.filterKey.min_six_months_unlock_percent_of_tokens = ldot10;
                    this.filterKey.max_six_months_unlock_percent_of_tokens = rdot10;
                },
            },
            presetFiltersapp1() {
                return this.presetFilters.filter((filter) => {
                    return filter.default == 1;
                });
            },
            presetFiltersapp2() {
                return this.presetFilters.filter((filter) => {
                    return filter.default != 1;
                });
            },

            direction() {
                if (store.state.appConfig.isRTL) {
                    // eslint-disable-next-line vue/no-side-effects-in-computed-properties
                    this.dir = "rtl";
                    return this.dir;
                }
                // eslint-disable-next-line vue/no-side-effects-in-computed-properties
                this.dir = "ltr";
                return this.dir;
            },
        },
        mounted() {
            // this.loadFileds();
            // this.loadCoins();
            // this.loadFag();
            // this.loadPresetFilters();
            this.isBusy = false
        },
        created() {
            this.userData = getUserData();
        },
        watch: {
            // Cpagpage: function (newVal, oldVal) {
            //   if (oldVal && newVal) {
            //     this.loadCoins();
            //   }
            // },
            // "params.filters2": function (newVal, oldVal) {
            //   if (
            //     (oldVal != newVal && newVal.trim().length == 0) ||
            //     newVal.trim().length >= 3
            //   ) {
            //     this.Cpagpage = 1;
            //     this.loadCoins();
            //   }
            // },
            // loadedData: function (n, o) {
            //   if (this.loadedData == true) {
            //     this.liveCoinFetch();
            //   }
            // },
            // selectedPreset: function (n, o) {
            //   this.loadSelectedPresetFilter();
            // },
            // "params.perpage": function (n, o) {
            //   this.Cpagpage = 1;
            //   this.loadCoins();
            // },
        },

        updated() {
            var meter_array = document.querySelectorAll("g path:not(:first-child)");
            for (let index = 0; index < meter_array.length; index++) {
                var element = meter_array[index];
                let path_array = element.getAttribute("d").split(" ");
                if (document.getElementById("marker_" + index) != null) {
                    document.getElementById("marker_" + index).style.background = "#b6e7b6";
                    document.getElementById("marker_" + index).style.boxShadow =
                        "0px 0px 7px 3.5px #0f0";
                    if (Number(path_array[9]) > 100) {
                        document.getElementById("marker_" + index).style.left =
                            Number(path_array[9]) - 6 + "px";
                        document.getElementById("marker_" + index).style.top =
                            Number(path_array[10]) - 4 + "px";
                    } else {
                        document.getElementById("marker_" + index).style.left =
                            Number(path_array[9]) - 6 + "px";
                        document.getElementById("marker_" + index).style.top =
                            Number(path_array[10]) + "px";
                    }
                }
            }
        },
    };

</script>
<style lang="scss">
    @import "~@resources/scss/vue/libs/vue-slider.scss";

</style>
<style>
    .model-desc {
        color: #757094 !important;
    }

    .model-desc a {
        color: #757094 !important;
    }

    #dashboard .nameWidth {
        width: 55px !important;
    }

    #dashboard .full {
        width: 100%;
    }

    #dashboard .customBadge {
        font-size: 11px;
        padding: 2px;
        border-radius: 5px;
    }

    #dashboard .b-table-1 {
        overflow-y: auto !important;
        max-height: 56vh;
    }

    #dashboard .b-table-1 tr {
        height: 60px;
    }

    #dashboard .b-table-1:hover {
        overflow-x: scroll !important;
    }

    #dashboard td {
        text-align: center;
    }

    .b-tabs {
        justify-content: left !important;
    }


    #dashboard .b-table-1::-webkit-scrollbar {
        height: 2px;
    }

    #dashboard .b-table-1:hover::-webkit-scrollbar {
        height: 8px;
    }

    #dashboard .b-table-1::-webkit-scrollbar-corner {
        background: rgba(0, 0, 0, 0);
    }

    #dashboard .b-table-1::-webkit-scrollbar-thumb {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(233, 229, 229, 0.3);
        background-color: #676565;
    }

    #dashboard .inner-text {
        height: 100%;
        width: 100%;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #dashboard table td {
        padding-left: 4px !important;
        padding-right: 4px !important;
        font-family: "Poppins-Light";
        font-weight: 300;
    }

    #dashboard table th {
        padding-left: 18px !important;
        padding-right: 15px !important;
        font-size: 12px;
        font-weight: 300;
        font-family: "Poppins";
    }

    #dashboard .b-avatar {
        width: 30px;
        height: 30px;
        margin: auto;
    }

    #modal-details___BV_modal_title_ {
        width: 100%;
    }

    @media only screen and (max-width: 500px) {
        .min-block {
            display: block !important;
        }
    }

    @media only screen and (max-width: 992px) {
        .max-block {
            display: block !important;
        }
    }

    .sparlineChat svg {
        height: 100%;
        width: 100%;
    }

    .soicalLable {
        font-family: "Poppins-Light";
        font-style: normal;
        font-weight: 500;
        font-size: 10px;
        opacity: 0.8;
        margin: auto;
    }

    .blurry-text {
        text-shadow: 0 0 32px white;
        color: transparent;
    }

    .popover {
        border-radius: 50px;
    }

    .popover-body {
        background: linear-gradient(172deg,
                rgba(39, 179, 62, 0.3) 10.11%,
                rgba(0, 0, 0, 0) 20.06%),
            rgba(9, 9, 9, 0.725);
        border-radius: 20px;
    }

    .popover .arrow {
        color: gray;
    }

    .blurry-text {
        text-shadow: 0px -2px 5px #d13e3e;
    }

    .rank_slot {
        top: 36px;
        right: 189px;
        z-index: 999;
    }

    .apexcharts-tooltip {
        background: #f3f3f3;
        color: #78909c;
    }

    .greenFlash {
        color: #6bbe84;
    }

    .redFlash {
        color: #ea5455;
    }

    .marginx1 {
        margin: 0 8px 0 8px;
    }

    .margin16_b {
        margin-bottom: 16px;
    }

    .feerGreen {
        font-family: "Poppins-Light";
        font-style: normal;
        font-weight: 600;
        font-size: 35px;
        text-align: center;
        color: #6bd863;
    }

    .feerSmallGreen {
        font-family: "Poppins-Light";
        font-style: normal;
        text-align: center;
        color: #6bd863;
        font-size: 20px;
    }

    thead tr th {
        font-family: "Poppins-Light";
        font-style: normal;
        font-weight: 300;
        font-size: 12px;
    }

    tbody tr {
        font-family: "Poppins-Light";
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        background: linear-gradient(172deg,
                rgba(43, 255, 77, 0.3) 3.11%,
                rgba(0, 0, 0, 0) 20.06%),
            rgba(255, 255, 255, 0.07);
        position: relative;
    }

    [class*="collapse-"] .collapse-title {
        font-family: "Poppins";
        font-style: normal;
        font-weight: 400;
        font-size: 16px;
        opacity: 0.7;
    }

    /* tbody tr:before {
        content: "";
        z-index: 3;
        position: absolute;
        top: -1px;
        left: 10px;
        background: linear-gradient(90deg, rgba(35,34,40, 0) 0%, rgba(35,34,40, 1) 100%);
        width: 100%;
        height: 2px;
   
    } */

    tbody tr:has(td:not(:first-child)) {
        box-shadow: inset 1px 2px 1px 0px rgb(82, 243, 109);
    }

    table {
        border-collapse: separate;
        border-spacing: 0 15px !important;
    }

    td {
        border: solid 0px #000000;
        padding: 15px;
    }

    tr td:first-child {
        border-top-left-radius: 50em;
        border-bottom-left-radius: 50em;
    }

    tr td:last-child {
        border-top-right-radius: 50em;
        border-bottom-right-radius: 50em;
    }

    #pagination button span {
        background-color: transparent !important;
    }

    .greenGradient {
        margin-right: 10px;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-radius: 20px;
        background: linear-gradient(169deg,
                rgba(43, 255, 77, 0.3) 3.11%,
                rgba(0, 0, 0, 0) 50.06%),
            rgba(255, 255, 255, 0.07);
    }

    .margin20 {
        margin: 10px;
        font-family: "Poppins-Light";
        font-style: normal;
        font-weight: 400;
        font-size: 16px !important;
    }

    .cunningBtn>button {
        color: white !important;
        padding: 0px !important;
    }

    .cunningBtn>ul {
        min-width: 500px !important;
        /* border:1px solid rgba(43, 255, 77, 1); */
        border-radius: 10px;
    }

    .cunningBtn .dropdown-menu {
        max-height: 2000px;
    }

    .cunningDrop .dropdown-menu.show {
        max-height: 275px !important;
    }

    .dropdown-menu {
        border-radius: 20px;
        max-height: 500px;
        overflow: auto;
    }

    /* .card {
        padding: 0px;
    }

    .card-body{
        padding: 0px;
    } */

    #dropdown-left1__BV_toggle_ {
        padding: 0px !important;
    }

    #dropdown-left1__BV_toggle_:hover {
        background: none;
    }

    .cunningDrop>ul {
        background: none;
    }

    .cunningDrop>form {
        padding: 7px 30px 10px 0px;
    }

    .graph_tab {
        font-size: 10px;
    }

    .graph_tab a {
        padding: inherit !important;
        margin-right: 1rem;
        padding-bottom: 3px !important;
    }

    g path:not(:first-child) {
        filter: transparent;
    }

    .socialText {
        font-family: "Poppins-Light";
        font-style: normal;
        font-weight: 400;
        font-size: 16px;
    }

    .socialText2 {
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
        font-family: "Poppins-Light";
        font-style: normal;
        font-weight: 400;
        font-size: 20px;
    }

    .apexcharts-menu-open {
        background: black;
    }

    .modal-content {
        border-radius: 30px;
    }

    .modal-header {
        border-radius: 30px;
    }

    .modal-body {
        border-radius: 30px;
    }

    body.dark-layout .modal-content div ul li.cunningDrop {
        background: #0a070e !important;
        padding-right: 15px;
    }

    body .modal-content div ul li.cunningDrop {
        background: rgb(248, 248, 248);
    }

    body.dark-layout .modal-content div ul:has(li.cunningDrop) {
        padding: 0px;
    }

    .oneToFive .vue-slider-rail {
        height: 15px !important;
        background: url(/images/static/slider_5.png) !important;
        background-color: transparent !important;
        background-size: cover !important;
    }

    .oneToFive .vue-slider-process {
        top: 3px !important;
        left: 0%;
        width: 100%;
        transition-property: width, left;
        transition-duration: 0.5s;
    }

    .text-success-green {
        color: #6bbe84;
    }

    #modal-preset-create___BV_modal_body_ {
        background: linear-gradient(146.03deg,
                rgba(43, 255, 77, 1) -102%,
                rgb(44, 43, 49) 21.77%),
            white !important;
    }

    #modal-preset-create___BV_modal_content_ {
        padding: 1px;
        border-radius: 30px;
        background: linear-gradient(146.03deg,
                rgba(0, 255, 0, 1) 7%,
                rgba(255, 255, 255, 0) 50%) !important;
    }

    #modal-details___BV_modal_content_ {
        max-height: 90vh !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
    }

    body.dark-layout .graph_tab-1 ul {
        justify-content: normal !important;
        margin-left: 87px !important;
    }

    .poppins-font {
        font-family: "Poppins-Light";
    }

    .chart-desc,
    .chart-desc a {
        color: gray !important;
    }

    .dark-layout .chart-desc,
    .dark-layout .chart-desc a {
        color: white !important;
    }

    .socialText2 {
        height: 33px;
    }

    .soicalLable.darkWhiteText.lableText {
        height: 32px;
    }

    .preset-button-style {
        background-color: #333237;
        padding: 10px !important;
        border-radius: 22px;
    }

    .preset-dropdown {
        width: 88%;
        background-color: #333237;
    }

    .preset-dropdown ul {
        top: -58px !important;
        width: 100%;
    }

    .dark-layout .preset-form form {
        background-color: #333237 !important;
    }

    .socialData .innerCard card-body {
        padding: 5px;
    }

    .socialData .innerCard .radius_gradient {
        max-width: 140px;
    }

    #modal-details .modal-dialog {
        max-width: 900px !important;
    }

    .soicalLable-2 {
        font-size: 15px;
        height: 30px;
    }

    .cunningDrop2 {
        border-radius: 20px !important;
    }

    .cunningDrop2 button {
        border-radius: 21px;
        background: linear-gradient(142deg,
                rgba(43, 255, 77, 0.3) 3.11%,
                rgba(0, 0, 0, 0) 20.06%),
            rgba(255, 255, 255, 0.07);
        box-shadow: inset 1px 1px 1px 0px rgb(52 215 80);
        border-radius: 20px;
    }

    .cunningDrop2 button .preset-button-style {
        background-color: transparent !important;
    }

    .cunningDrop2 .preset-form form {
        border-radius: 21px;
        background: linear-gradient(142deg,
                rgba(43, 255, 77, 0.3) 3.11%,
                rgba(0, 0, 0, 0) 20.06%),
            rgba(255, 255, 255, 0.07) !important;
        box-shadow: inset 1px 1px 1px 0px rgb(52 215 80);
        border-radius: 20px;
    }

    /* modal-preset-create___BV_modal_content_ */

    /* .oneToFive .vue-slider-dot{
        width: 14px;
        height: 14px;
        transform: translate(-50%, -50%);
        top: 80% !important;
        left: 0%;
        transition: left 0.5s ease 0s;
    } */
    body.dark-layout ul.nav-tabs {
        justify-content: left !important;

    }

    .nav-tabs li {
        justify-content: left !important;

    }

    #insideTabs .nav-tabs li {
        justify-content: center !important;

    }

    #insideTabs>ul.nav-tabs {
        justify-content: center !important;

    }

</style>
