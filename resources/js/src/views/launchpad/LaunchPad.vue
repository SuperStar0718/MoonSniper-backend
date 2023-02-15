<template>
    <div class="launchpad">
        <div>
            <div>
                <div id="alerts">
                    <div class="darkWhiteText" style="font-family: 'Poppins';
        font-style: normal;
        font-weight: 600;
        font-size: 24px;
        margin-top: 26px;
        margin-bottom: 26px;
        text-align: center;
        ">
                        Launchpad
                    </div>
                </div>
            </div>
            <div class="body-content-overlay" />
            <!-- search bar and table -->
            <div class="cardBack" style="">
                <div class="searchbar ">
                    <b-row>
                        <b-col cols="8" md="6" xl="6">
                            <b-form-group>
                                <b-input-group class="input-group-merge">
                                    <b-form-input v-model="params.filters2" placeholder="Search"
                                        class="search-product searchdark" style="border-radius: 20px;" />
                                    <b-input-group-append style="z-index: 999;">
                                        <i v-if="params.filters2 != null && params.filters2.trim() != ''"
                                            @click="params.filters2 = ''" class="fa-solid fa-xmark cursor-pointer"
                                            style="font-size: 16px; position: relative;   right: 32px;
                              margin: auto;"></i>
                                    </b-input-group-append>
                                </b-input-group>
                            </b-form-group>

                        </b-col>
                        <b-col cols="4" md="2" xl="4">
                        </b-col>
                        <b-col cols="12" md="4" xl="2">
                            <div class="d-flex jusctify-content-between float-right">
                                <div class="ml-1" style="padding:5px; color:white;">
                                    <b-dropdown size="lg" variant="flat-dark"
                                        style="padding:0px !important; color: white !important;" class="cunningBtn"
                                        id="dropdown-left" no-caret dropright>
                                        <template #button-content>
                                            <feather-icon icon="SlidersIcon" size="20"
                                                class=" text-black cursor-pointer darkWhiteText"
                                                style="color:#28c76f;rotate:-90deg" />
                                        </template>
                                        <b-dropdown-form href="#" class="dropdown-mine">
                                            <div style="font-family: 'Poppins-Light';
                                              font-style: normal;
                                              font-weight: 500;
                                              font-size: 18px;margin-bottom: 20px; margin-top: 20px;"
                                                class="text-center darkWhiteText">
                                                Customise your Launchpad
                                            </div>
                                            <hr style="margin:0px !important;">
                                            <template>
                                                <div class="accordion" role="tablist">
                                                    <app-collapse accordion>
                                                        <app-collapse-item :isVisible="true" title="Market Filters">
                                                            <b-row>
                                                                <!-- <b-col md="6" xl="6">
                                                                    <div class="margin20">
                                                                        <b-form-checkbox @change="updateFields"
                                                                            v-model="fields[1].filterColumn"
                                                                            name="cursor-pointer some-checkboxs">
                                                                            Icon
                                                                        </b-form-checkbox>
                                                                    </div>

                                                                </b-col> -->
                                                                <b-col md="6" xl="6">
                                                                    <div class="margin20">
                                                                        <b-form-checkbox @change="updateFields"
                                                                            name="cursor-pointer some-checkboxs1"
                                                                            v-model="fields[1].filterColumn">
                                                                            Launchpad
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </b-col>
                                                                <b-col md="6" xl="6">
                                                                    <div class="margin20">

                                                                        <b-form-checkbox @change="updateFields"
                                                                            v-model="fields[2].filterColumn"
                                                                            name="cursor-pointer some-checkboxs2">
                                                                            Project
                                                                        </b-form-checkbox>

                                                                    </div>
                                                                </b-col>
                                                                <!-- <b-col md="6" xl="6">
                                                              <div class="margin20">

                                                                  <b-form-checkbox @change="updateFields"
                                                                      v-model="fields[1].filterColumn"
                                                                      name="cursor-pointer some-checkboxs2">
                                                                      Name
                                                                  </b-form-checkbox>

                                                              </div>
                                                          </b-col> -->
                                                                <b-col md="6" xl="6">
                                                                    <div class="margin20">
                                                                        <div class="">
                                                                            <b-form-checkbox @change="updateFields"
                                                                                v-model="fields[3].filterColumn"
                                                                                name="cursor-pointer some-checkboxs3">

                                                                                Category
                                                                            </b-form-checkbox>
                                                                        </div>
                                                                    </div>
                                                                </b-col>

                                                                <b-col md="6" xl="6">
                                                                    <div class="margin20">
                                                                        <div class="">
                                                                            <b-form-checkbox @change="updateFields"
                                                                                v-model="fields[4].filterColumn"
                                                                                name="cursor-pointer some-checkboxs3">

                                                                                Market cap
                                                                            </b-form-checkbox>
                                                                        </div>
                                                                    </div>
                                                                </b-col>
                                                                <b-col md="6" xl="6">
                                                                    <div class="margin20">
                                                                        <div class="">
                                                                            <b-form-checkbox @change="updateFields"
                                                                                v-model="fields[5].filterColumn"
                                                                                name="cursor-pointer some-checkboxs3">
                                                                                Thicker
                                                                            </b-form-checkbox>
                                                                        </div>
                                                                    </div>
                                                                </b-col>
                                                                <b-col md="6" xl="6">
                                                                    <div class="margin20">
                                                                        <div class="">
                                                                            <b-form-checkbox @change="updateFields"
                                                                                v-model="fields[6].filterColumn"
                                                                                name="cursor-pointer some-checkboxs3">
                                                                                Launch time
                                                                            </b-form-checkbox>
                                                                        </div>
                                                                    </div>
                                                                </b-col>
                                                                <b-col md="6" xl="6">
                                                                    <div class="margin20">
                                                                        <div class="">
                                                                            <b-form-checkbox @change="updateFields"
                                                                                v-model="fields[7].filterColumn"
                                                                                name="cursor-pointer some-checkboxs4">
                                                                                First unlock time
                                                                            </b-form-checkbox>
                                                                        </div>
                                                                    </div>
                                                                </b-col>
                                                                <!-- <b-col md="6" xl="6"> NotAvail
                                                              <div class="margin20">
                                                                  <div class="">
                                                                      <b-form-checkbox @change="updateFields"  v-model="fields[2].filterColumn" name="cursor-pointer some-checkboxs5" >
                                                                          Circulating Supply %
                                                                      </b-form-checkbox>
                                                                  </div>
                                                              </div>
                                                          </b-col> -->
                                                                <b-col md="6" xl="6">
                                                                    <div class="margin20">
                                                                        <div class="">
                                                                            <b-form-checkbox @change="updateFields"
                                                                                v-model="fields[8].filterColumn"
                                                                                name="cursor-pointer some-checkboxs6">
                                                                                Network
                                                                            </b-form-checkbox>
                                                                        </div>
                                                                    </div>
                                                                </b-col>
                                                                <b-col md="6" xl="6">
                                                                    <div class="margin20">
                                                                        <div class="">
                                                                            <b-form-checkbox @change="updateFields"
                                                                                v-model="fields[9].filterColumn"
                                                                                name="cursor-pointer some-checkboxs7">
                                                                                Ido public number
                                                                            </b-form-checkbox>
                                                                        </div>
                                                                    </div>
                                                                </b-col>
                                                                <b-col md="6" xl="6">
                                                                    <div class="margin20">
                                                                        <div class="">
                                                                            <b-form-checkbox @change="updateFields"
                                                                                v-model="fields[10].filterColumn"
                                                                                name="cursor-pointer some-checkboxs8">
                                                                                Telegram
                                                                            </b-form-checkbox>
                                                                        </div>
                                                                    </div>
                                                                </b-col>
                                                                <b-col md="6" xl="6">
                                                                    <div class="margin20">
                                                                        <div class="">
                                                                            <b-form-checkbox @change="updateFields"
                                                                                v-model="fields[11].filterColumn"
                                                                                name="cursor-pointer some-checkboxs9">
                                                                                Website
                                                                            </b-form-checkbox>
                                                                        </div>
                                                                    </div>
                                                                </b-col>
                                                                <!-- <b-col md="6" xl="6">
                                                              <div class="margin20">
                                                                  <div class="">
                                                                      <b-form-checkbox @change="updateFields"  v-model="fields[2].filterColumn" name="cursor-pointer some-checkboxs10" >
                                                                          
                                                                          Network
                                                                      </b-form-checkbox>
                                                                  </div>
                                                              </div>
                                                          </b-col> -->
                                                                <b-col md="6" xl="6">
                                                                    <div class="margin20">
                                                                        <div class="">
                                                                            <b-form-checkbox @change="updateFields"
                                                                                v-model="fields[12].filterColumn"
                                                                                name="cursor-pointer some-checkboxs11">

                                                                                Twitter
                                                                            </b-form-checkbox>
                                                                        </div>
                                                                    </div>
                                                                </b-col>

                                                                <b-col md="6" xl="6">
                                                                    <div class="margin20">
                                                                        <div class="">
                                                                            <b-form-checkbox @change="updateFields"
                                                                                v-model="fields[13].filterColumn"
                                                                                name="cursor-pointer some-checkboxs13">
                                                                                Tokenomies
                                                                            </b-form-checkbox>
                                                                        </div>
                                                                    </div>
                                                                </b-col>
                                                                <b-col md="6" xl="6">
                                                                    <div class="margin20">
                                                                        <div class="">
                                                                            <b-form-checkbox @change="updateFields"
                                                                                v-model="fields[14].filterColumn"
                                                                                name="cursor-pointer some-checkboxs13">
                                                                                Contract
                                                                            </b-form-checkbox>
                                                                        </div>
                                                                    </div>
                                                                </b-col>

                                                            </b-row>
                                                        </app-collapse-item>


                                                    </app-collapse>

                                                </div>

                                            </template>
                                        </b-dropdown-form>

                                    </b-dropdown>

                                </div>


                            </div>
                        </b-col>
                    </b-row>

                </div>
                <div id="ctable" style="position: relative;">

                    <div class="opacityGradient" style="position: absolute;right: 4px; top: 0px;height: 100%;width: 61px;z-index: 3;
                      background: linear-gradient(90deg, rgba(248,248,248, 0) 0%, rgba(248,248,248, 1) 100%);">

                    </div>
                    <b-overlay :show="!loadedLaunches" rounded="sm">
                        <div>
                            <div>
                                <b-table :no-border-collapse="true" tbody-tr-class="cursor-pointer  box rounded-pill"
                                    class="b-table-2" :fields="visibleFields" :show-empty="showEmpty" :busy="isBusy"
                                    :empty-text="emptyText" style=" white-space: nowrap;" responsive
                                    :items="launchList.data">
                                    <template #thead-top="d">
                                        <draggable tag="b-tr" v-model="visibleFields">
                                            <b-th v-for="(field, i) in visibleFields" :key="i"
                                                class="draggable text-center draggable-columns" style="">
                                                <div class="text-nowrap cursor-pointer text-center" style=""
                                                    @click="sortingCols(field.key)">
                                                    <div :title="field.title" v-if="field.label"
                                                        class="d-flex justify-content-center text-capitalize">
                                                        <span> {{ field.label }} </span>
                                                        <span class="my-auto d-inline">
                                                            <feather-icon icon="TriangleIcon" size="8"
                                                                style="rotate:180deg;margin-left: 5px; margin-top: -9px; "
                                                                :class="{'text-danger':params.sort[1] =='asc'&& params.sort[0] ==field.key}" />
                                                        </span>
                                                    </div>
                                                </div>
                                            </b-th>
                                        </draggable>

                                    </template>
                                    <template #cell(icon)="data">
                                        <div class="d-flex justify-content-start ml-2">
                                            <div style="" class="my-auto">
                                                <b-avatar class="text-center mr-1" :src="'storage/launchpad/icons/'+data.value" />
                                            </div>
                                        </div>
                                    </template>

                                </b-table>
                            </div>

                        </div>
                    </b-overlay>

                </div>
                <div class="p">
                    <b-row>

                        <!-- Pagination -->
                        <b-col cols="12"
                            class="d-flex align-items-center justify-content-center justify-content-around">
                            <div>
                                <span class="" v-if="loadedLaunches"> Showing {{ launchList.from }} to
                                    {{ launchList.to }} of
                                    {{ launchList.total }}</span>
                            </div>
                            <b-pagination id="pagination" v-model="CpageNum" :total-rows="launchList.total"
                                :per-page="launchList.per_page" first-number last-number class="mb-0 mt-1 mt-sm-0"
                                prev-class="prev-item" next-class="next-item"
                                style="background-color:transaprent !important;">
                                <template #prev-text style="background-color:transaprent !important;">
                                    <feather-icon icon="ChevronLeftIcon" size="18"
                                        style="background-color:transaprent !important;" />
                                </template>
                                <template #next-text style="background-color:transaprent !important;">
                                    <feather-icon icon="ChevronRightIcon" size="18"
                                        style="background-color:transaprent !important;" />
                                </template>
                            </b-pagination>
                            <div>
                                <span>
                                    <select v-model="CpageNum" v-if="loadedLaunches">
                                        <option v-for="(item,index) in launchList.last_page" :key="index">
                                            {{ index+1 }}
                                        </option>
                                    </select>
                                </span>
                            </div>
                        </b-col>

                    </b-row>
                </div>
            </div>

        </div>

    </div>
</template>
<script>
    import axios from '../../../axiosInt'
    import draggable from 'vuedraggable'
    import AppCollapse from '@core/components/app-collapse/AppCollapse.vue'
    import AppCollapseItem from '@core/components/app-collapse/AppCollapseItem.vue'
    import {
        BTh,
        BTr,
        BIconGripHorizontal,
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
        BInputGroupPrepend,
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
        BProgress,
        BAppCollapse
    } from 'bootstrap-vue';
    import fieldsData from './fields'
    import Ripple from 'vue-ripple-directive'

    export default {
        data() {
            return {
                fields: fieldsData,
                launchList: [],
                loadedLaunches: false,
                params: {
                    filters: [],
                    filters2: "",
                    sort: ["market_cap", "asc"],
                    perpage: 10,
                },
                isBusy: true,
                showEmpty: false,
                emptyText: 'There are no records to show',
                column_form: {
                    table_fields: [],
                },
                CpageNum: 1,
                loadedFields: {}
            }
        },
        directives: {
            'b-modal': VBModal,
            'b-toggle': VBToggle,
            'b-popover': VBPopover,
            'b-tooltip': VBPopover,
            Ripple,

        },
        components: {
            BTh,
            BTr,
            BIconGripHorizontal,
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
            BInputGroupPrepend,
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
            BProgress,
            AppCollapseItem,
            AppCollapse,
            draggable
        },
        methods: {
            LoadList() {
                this.isBusy = true;
                this.showEmpty = false;

                axios.post('/api/launchpad-list?page=' + this.CpageNum, JSON.stringify(this.params))
                    .then(res => {
                        console.log(res.data);
                        if (res.data.status == true) {
                            this.launchList = res.data.LaunchList;
                            this.loadedLaunches = true;
                            this.isBusy = false;
                            this.showEmpty = true;
                        }
                    });
            },
            sortingCols(val) {
                this.isBusy = true;
                this.CpageNum = 1;
                if (this.params.sort[0] == val) {
                    if (this.params.sort[1] == 'asc') {
                        this.params.sort[1] = 'desc'
                    } else {
                        this.params.sort[1] = 'asc'
                    }
                } else {
                    this.params.sort[1] = 'asc';
                    this.params.sort[0] = val
                }



                this.LoadList(false);
            },
            updateFields() {
            let mode = 'Launchpad';
                this.column_form.table_fields = [];
                this.fields.forEach(element => {
                    if (element.canHide == true) {
                        if (element.filterColumn == true) {
                            this.column_form.table_fields.push(element.key)
                        }
                    }

                });
                axios.post('api/update-visible-fields', {
                    fields: JSON.stringify(this.column_form),
                    mode: mode
                }).then(res => {
                    if (res.data.status == true) {
                        this.loadedFields = res.data.fields
                    }
                })
            },
            loadFileds() {
                let mode = 'Launchpad';
                axios.post('api/load-visible-fileds', {
                    mode: mode,
                    orderMode: 'launchpadOrder'
                }).then(res => {
                    if (res.data.status == true) {
                        this.loadedFields = res.data.fields;

                        this.fields.forEach(element => {
                            element.index = false;
                        });
                        this.fields.forEach(element => {
                            if (this.loadedFields.table_fields.includes(element.key)) {
                                element.filterColumn = true;
                            } else {
                                if (element.canHide) {
                                    element.filterColumn = false;
                                }
                            }
                        });
                    } else {
                        this.fields.forEach(element => {
                            element.index = true;
                        });
                    }
                    if (res.data.orderColumns) {
                        let orderedItems = JSON.parse(res.data.orderColumns['columns']);

                        this.fields.forEach(element => {
                            element.index = orderedItems[0][element.key];
                        });
                    }
                })
            },
            updateDraggedFields(evt) {
                let keyArray = [];
                var obj = {};
                evt.forEach(element => {
                    obj[element.key] = element.index;
                });
                keyArray.push(obj)
                axios.post('api/update-column-order', {
                        keyArray: keyArray,
                        mode: 'launchpadOrder'

                    })
                    .then(res => {})
            },
        },
        mounted() {
            this.loadFileds();
            this.LoadList();
        },
        computed: {
            visibleFields: {
                get() {
                    let itemList;
                    itemList = this.fields.filter(field => {
                        return field.visible == 1 && field.filterColumn == true
                    })
                    return itemList.filter(field => field.index >= 0)
                        .sort((a, b) => a.index - b.index);
                },
                set(newValue) {
                    let k = 0;
                    for (let j = 0; j < this.fields.length; j++) {
                        let index = newValue.findIndex((item) => {
                            return item.key == this.fields[j].key;
                        });
                        if (index >= 0) {
                            this.fields[j].index = index;
                        } else {
                            this.fields[j].index = newValue.length + k;
                            k++;
                        }
                    }
                    console.log(this.fields);
                    this.updateDraggedFields(this.fields);

                }
            },
        },
        watch: {
            'CpageNum': function (newVal, oldVal) {
                if (oldVal && newVal) {
                    this.LoadList(false)
                }
            },
            'params.filters2': function (newVal, oldVal) {
                if (oldVal != newVal && newVal.trim().length == 0 || newVal.trim().length >= 3) {
                    this.Cpagpage = 1;
                    this.LoadList(false)
                }
            },
        }
    }

</script>
<style>
    td {
        overflow: hidden;
    }

    #launchpad .b-table-1 {
        overflow-y: auto !important;
        max-height: 56vh;

    }

    #launchpad .b-table-1.fullscreen {
        overflow-y: auto !important;
        max-height: 71vh;

    }

    #launchpad .b-table-1 tr {
        height: 30px;
    }

    .AppExtensionMode #launchpad .b-table-1 tbody tr {
        height: 45px;
    }

    .AppExtensionMode #launchpad .b-table-1 thead tr {
        height: 34px;
    }

    #launchpad .b-table-1:hover {
        overflow-x: scroll !important;
    }

    .AppExtensionMode .searchbar {
        margin-top: 0.5rem;
    }

    #launchpad td {
        text-align: center;
    }

    #launchpad .b-table-1::-webkit-scrollbar {
        height: 2px;

    }

    #launchpad .b-table-1:hover::-webkit-scrollbar {
        width: 8px;
        height: 8px;
        cursor: pointer;
    }



    #ctable .b-overlay-wrap.position-relative:hover {
        margin-right: -4px;

    }

    #launchpad .b-table-1::-webkit-scrollbar-corner {
        background: rgba(0, 0, 0, 0);
        z-index: 999;
    }

    #launchpad .b-table-1::-webkit-scrollbar-thumb {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(255, 255, 255, 0.3);
        background-color: #ffffff;

    }

    #launchpad .inner-text {
        height: 100%;
        width: 100%;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }


    #launchpad table td {
        padding-left: 4px !important;
        padding-right: 4px !important;
        font-family: 'Poppins-Light';
        font-weight: 300;

    }

    #launchpad table th {
        padding-left: 18px !important;
        padding-right: 15px !important;
        font-size: 12px;
        font-weight: 300;
        font-family: 'Poppins';
    }

    #launchpad .b-avatar {
        width: 30px;
        height: 30px;
        margin: auto;
    }

    #modal-details___BV_modal_title_ {
        width: 100%;
    }


    thead tr th {
        font-family: 'Poppins-Light';
        font-style: normal;
        font-weight: 300;
        font-size: 12px;
    }

    tbody tr {
        font-family: 'Poppins-Light';
        font-style: normal;
        font-weight: 400;
        font-size: 15px;
        /* background: linear-gradient(172deg, rgba(43, 255, 77, 0.3) 3.11%, rgba(0, 0, 0, 0) 20.06%), rgba(255, 255, 255, 0.07); */
        background: linear-gradient(163deg, rgba(43, 255, 76, 0.3) 1.11%, rgba(0, 0, 0, 0) 6.06%), rgba(255, 255, 255, 0.07);
        position: relative;
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


    .AppExtensionMode table {
        border-spacing: 0 4px !important;
    }

    table {
        border-collapse: separate;
        border-spacing: 0 7px !important;
    }

    td {
        border: solid 0px #000000;
        padding: 15px;
    }

    tr td:first-child {
        border-top-left-radius: 50em;
        border-bottom-left-radius: 50em;
    }

    #launchpad .table td {
        padding: 0.72rem 2rem;
        border-top: 2px solid #ebe9f1;
        padding: 2px 0;
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
        background: linear-gradient(169deg, rgba(43, 255, 77, 0.3) 3.11%, rgba(0, 0, 0, 0) 50.06%), rgba(255, 255, 255, 0.07);
    }

    .margin20 {
        margin: 10px;
        font-family: 'Poppins-Light';
        font-style: normal;
        font-weight: 400;
        font-size: 16px !important;
    }




    .whitepaper-card .card-body {
        padding-left: 0.5rem !important;
        padding-right: 0.5rem !important;
    }

    .AppExtensionMode #launchpad .b-table-1 {
        overflow-y: auto !important;
        margin: 0;
        max-height: 58vh;

    }



    #launchpad .b-table-1 thead tr {
        height: 30px;
    }

    .AppExtensionMode .HeaderTopBar {
        margin-bottom: -2px !important;
    }


    .table>tbody>tr>td {
        max-width: 300px;
    }

    body.AppExtensionMode {
        line-height: 1.2;
    }

    .AppExtensionMode .extn-flex {
        display: flex;
    }

    .AppExtensionMode .extn-symb {
        float: left;
        max-width: 100px;
        width: 100px;
        opacity: 0.8;
        margin: auto;
    }

    .AppExtensionMode .extn-name {
        display: flex;
        float: left;
        max-width: 100px;
        margin-right: 5px;
        font-weight: 600;
        margin-top: auto;
        margin-bottom: auto;
    }

    .AppExtensionMode tbody tr {
        font-size: 14px;
    }

    .AppExtensionMode #launchpad table td:nth-child(1) {
        padding: 0.22rem 0rem !important;
    }

    .AppExtensionMode #launchpad table td {
        padding: 0.22rem 2rem !important;
    }



    body.dark-layout #launchpad table th {
        background: #232228 !important;
        color: white;
    }






    thead tr:nth-child(2) {
        display: none !important;
    }

    .cardBack {
        padding: 1px 16px;
        box-shadow: 0px 0px 20px rgba(19, 20, 37, 0.5);
        backdrop-filter: blur(7.5px);
        border-radius: 30px;
    }

    .searchbar {
        margin-top: 1rem;
    }

    .search-product::placeholder {
        color: rgb(186, 183, 183) !important;
        opacity: 1 !important;
        /* Firefox */
    }

    .search-product:-ms-input-placeholder {
        /* Internet Explorer 10-11 */
        color: rgb(186, 183, 183) !important;
    }

    .search-product::-ms-input-placeholder {
        /* Microsoft Edge */
        color: rgb(186, 183, 183) !important;
    }

    .margin20 {
        margin: 10px;
        font-family: 'Poppins-Light';
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

</style>
