<template>
    <b-nav-item-dropdown class="dropdown-notification mr-25 dropdown-notify"  menu-class="dropdown-menu-media" right>

        <template #button-content>
            <feather-icon :badge="unreadCount()" badge-classes="bg-danger" class="text-body" icon="BellIcon"
                size="21" />
        </template>

        <!-- Header -->
        <li class="dropdown-menu-header">
            <div class="dropdown-header d-flex">
                <h4 class="notification-title mb-0 mr-auto">
                    Notifications
                </h4>
                <b-badge pill variant="">
                    {{ unreadCount() }} New
                </b-badge>
            </div>
        </li>

        <!-- Notifications -->


        <!-- Account Notification -->
        <span v-if="loaded">
            <b-link v-for="(notification,index) in notifications" :key="index">
                <b-media>

                    <p class="media-heading" @click="markAsRead(notification.id,index,notification.read_at)">
                        <span class="h5 " :class="[notification.read_at == null ? 'text-success-green':'text-success-green-2']" style="">{{ coinName(notification.data)}}
                            Alert!</span><br />
                        <span :class="[notification.read_at == null ? 'font-weight-bolder text-white':'text-muted']">
                            {{ notification.note }}
                        </span><br />
                        <small class="text-muted" style="font-size: 10px;">--{{ notify_date(notification.show_date) }}</small>
                    </p>
                </b-media>
            </b-link>
        </span>
        <div class="text-center m-auto" v-else>
            Loading...
        </div>

        <!-- System Notification Toggler -->


        <!-- Cart Footer -->
        <!-- <li class="dropdown-menu-footer">
            <b-button v-ripple.400="'rgba(255, 255, 255, 0.15)'" variant="" block>Read all notifications</b-button>
        </li> -->
    </b-nav-item-dropdown>
</template>

<script>
    import {
        BNavItemDropdown,
        BBadge,
        BMedia,
        BLink,
        BAvatar,
        BButton,
        BFormCheckbox,
    } from 'bootstrap-vue'
    import VuePerfectScrollbar from 'vue-perfect-scrollbar'
    import Ripple from 'vue-ripple-directive'
    import axios from '@axios';
    export default {
        components: {
            BNavItemDropdown,
            BBadge,
            BMedia,
            BLink,
            BAvatar,
            VuePerfectScrollbar,
            BButton,
            BFormCheckbox,
        },
        directives: {
            Ripple,
        },

        data() {
            return {
                notifications: [],
                loaded: false
            }
        },
        methods: {
            loadNotifications() {
                this.loaded = false;
                axios.get('api/user-notifications')
                    .then(res => {
                        if (res.data.status) {
                            this.notifications = res.data.notifications;
                            this.loaded = true;

                        }
                    })
            },
            coinName(data) {
                let ndata = JSON.parse(data);

                return ndata.coin_name;
            },
            markAsRead(id, index, read_at) {
                if (read_at == null) {
                    axios.post('api/read-notification', {
                            id: id
                        })
                        .then(res => {
                            if (res.data.status) {
                                this.notifications[index].read_at = Date.now();
                            }
                        })

                }
            },
            unreadCount() {
                let unreadCountElements = [];
                unreadCountElements = this.notifications.filter((element) => {
                    return element.read_at == null;
                });
                return unreadCountElements.length;
            },
            notify_date(dateTime) {
                  let date = new Date(dateTime),
                    day = date.getDate(),
                    month = date.getMonth(),
                    year = date.getFullYear(),
                    months = ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct',
                        'Nov', 'Dec'
                    ],
                    h = date.getHours(),
                    m = date.getMinutes();
                let ampm = h >= 12 ? 'PM' : 'AM';
                h = h % 12;
                h = h ? h : 12; // the hour '0' should be '12'
                m = m < 10 ? '0' + m : m;
                if (h < 10) {
                    h = '0' + h;
                }
                if (day < 10) {
                    day = '0' + day;
                }
                //    if(m <10)
                //    {
                //     m = '0'+m;
                //    }

                return months[month] + ' ' + day + ', ' + year + ', ' + h + ':' + m + ' ' + ampm;
            }
        },
        mounted() {
            this.loadNotifications();
        },
        computed: {

        },

        setup() {
            /* eslint-disable global-require */


            const perfectScrollbarSettings = {
                maxScrollbarLength: 60,
                wheelPropagation: false,
            }

            return {
                perfectScrollbarSettings,
            }
        },
    }

</script>

<style>
    .header-div.nav-link.dropdown-toggle {
        position: absolute !important;
        right: 0 !important;
    }

    .header-div.dropdown-menu-header {}

    .header-div .dropdown-menu.dropdown-menu-media {
        box-shadow: inset 1px 1px 1px 0px rgb(52 215 80);
        background-color: #333237 !important;
        width: 311px !important;

    }

    .header-div .media-heading {
        padding: 5px;
        background-color: transparent;
        border-radius: 9px;
        border: solid 1px #4d4d4d;
        border-left: none;
        border-right: none;
        margin:0 !important;
        padding-left: 10px;
    }

    .text-success-green {
        color: #6BD863;
    }

    .header-div li::marker {
        content: none !important;
    }

    .header-div .b-nav-dropdown .dropdown-toggle::after {
        background-image: none !important;
    }
    .text-success-green-2 {
      color: #97c194;
  }
  .dropdown-notify{
    position: absolute;
    top: 6px;
    right: -3px;
  }
   .AppExtensionMode .dropdown-notify{
        position: absolute !important;
        top: 9px !important;
        right: -5px !important;
    }
</style>
