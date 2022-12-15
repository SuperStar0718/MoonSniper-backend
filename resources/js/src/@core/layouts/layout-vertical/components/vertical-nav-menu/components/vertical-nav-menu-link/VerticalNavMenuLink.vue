<template>
    <li v-if="canViewVerticalNavMenuLink(item)" class="nav-item" :class="{
      'active': isActive,
      'disabled': item.disabled
    }">
        <b-link v-bind="linkProps" class="d-flex align-items-center" v-if="item.title && item.title == 'Dashboard'" @click="emittReload">
            <feather-icon  :icon="item.icon || 'CircleIcon'" />
            <span class="menu-title text-truncate">{{ t(item.title) }}</span>
            <b-badge v-if="item.tag" pill :variant="item.tagVariant || 'primary'" class="mr-1 ml-auto">
                {{ item.tag }}
            </b-badge>
        </b-link>
        <b-link v-else v-bind="linkProps" class="d-flex align-items-center">
            <div v-if="item.title && item.title == 'Profit Calculator'" style="margin-right: 15px; margin-top: -1px;">
                <img src='/images/static/calculator.png' alt="calc">
            </div>
            <feather-icon v-else :icon="item.icon || 'CircleIcon'" />
            <span class="menu-title text-truncate">{{ t(item.title) }}</span>
            <b-badge v-if="item.tag" pill :variant="item.tagVariant || 'primary'" class="mr-1 ml-auto">
                {{ item.tag }}
            </b-badge>
        </b-link>
    </li>
</template>

<script>
    import {
        useUtils as useAclUtils
    } from '@core/libs/acl'
    import {
        BLink,
        BBadge
    } from 'bootstrap-vue'
    import {
        useUtils as useI18nUtils
    } from '@core/libs/i18n'
    import useVerticalNavMenuLink from './useVerticalNavMenuLink'
    import mixinVerticalNavMenuLink from './mixinVerticalNavMenuLink'

    export default {
      data()
      {
        return{
          timestamp:1,
        }
      },  
        components: {
            BLink,
            BBadge,
        },
        methods:{
          emittReload()
          {
            var domain = window.location.href;
            if (domain.includes("dashboard")) {
              this.$emitter.emit('refreshEvent', {time: 'Refresh'})
            }
            // this.timestamp = Math.floor((Math.random() * 10) + 1);
          }
        },
        mixins: [mixinVerticalNavMenuLink],
        props: {
            item: {
                type: Object,
                required: true,
            },
        },
        setup(props) {
            const {
                isActive,
                linkProps,
                updateIsActive
            } = useVerticalNavMenuLink(props.item)
            const {
                t
            } = useI18nUtils()
            const {
                canViewVerticalNavMenuLink
            } = useAclUtils()

            return {
                isActive,
                linkProps,
                updateIsActive,

                // ACL
                canViewVerticalNavMenuLink,

                // i18n
                t,
            }
        },


    }

</script>
