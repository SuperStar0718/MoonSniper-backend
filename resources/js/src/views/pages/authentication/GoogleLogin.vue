<template>
    <div class="mx-2">
        <b-button @click="AuthProvider" variant="google" href="javascript:void(0)">
          <Strong>Google</Strong>
        </b-button>
    </div>
</template>
<script>
    import VuexyLogo from '@core/layouts/components/Logo.vue'
import axios from '@axios'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {
        BButton,
    } from 'bootstrap-vue'
        import router from '@/router'
    export default ({
        components: {
            BButton,

        },
        methods: {
            async AuthProvider() {
                const newWindow = openWindow('', 'login')
                await axios.get('http://localhost:8000/auth/google/redirect').then(res => {
                    this.url = res.data.url;

                });

                newWindow.location.href = this.url
            },
            onMessage(e) {
                if (e.origin !== window.origin || !e.data.token) {
                    return
                }
                localStorage.setItem('userData', JSON.stringify(e.data.userData));
                localStorage.setItem('accessToken', e.data.token);
                console.log(e.data.userData);
                this.$toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                        title: `Welcome ${e.data.userData.fullName || e.data.userData.username}`,
                        icon: 'CoffeeIcon',
                        variant: 'success',
                        text: `You have successfully logged in as ${e.data.userData.role}. Now you can start to explore!`,
                    },
                })
                 window.location.href = '/'

            }
        },
        mounted() {
            window.addEventListener('message', this.onMessage, false)
        },
        beforeDestroy() {
            window.removeEventListener('message', this.onMessage)
        },
    })
    function openWindow(url, title, options = {}) {
        if (typeof url === 'object') {
            options = url
            url = ''
        }
        options = {
            url,
            title,
            width: 600,
            height: 720,
            ...options
        }
        const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screen.left
        const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screen.top
        const width = window.innerWidth || document.documentElement.clientWidth || window.screen.width
        const height = window.innerHeight || document.documentElement.clientHeight || window.screen.height
        options.left = ((width / 2) - (options.width / 2)) + dualScreenLeft
        options.top = ((height / 2) - (options.height / 2)) + dualScreenTop
        const optionsStr = Object.keys(options).reduce((acc, key) => {
            acc.push(`${key}=${options[key]}`)
            return acc
        }, []).join(',')
        const newWindow = window.open(url, title, optionsStr)
        if (window.focus) {
            newWindow.focus()
        }
        return newWindow
    }
</script>
