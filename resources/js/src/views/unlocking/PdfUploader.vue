<template>
    <b-card title="Upload PDF">
        <validation-observer ref="uploadPDF" #default="{invalid}">
            <b-form @submit.prevent="uploadPDF">
                <b-row>
                    <b-col cols="12">
                        <template>
                            <div>
                                <!-- Styled -->
                                <validation-provider #default="{ errors }" name="PDF" rules="" vid="pdf">
                                    <b-form-file v-model="pdfFile" ref="pdffile" accept="application/pdf"
                                        placeholder="Choose a file or drop it here..."
                                        drop-placeholder="Drop file here..." />
                                    <b-form-invalid-feedback>
                                        {{ errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>
                            </div>
                            <b-card-text class="my-1">
                                Selected file: <strong>{{ pdfFile ? pdfFile.name : '' }}</strong>
                            </b-card-text>
                        </template>

                    </b-col>
                </b-row>
                <b-row class="mt-2">
                    <b-col>
                        <b-button variant="primary" class="mb-1 mb-sm-0 mr-0 mr-sm-1" type="submit"
                            :disabled="sendForm || invalid" :block="$store.getters['app/currentBreakPoint'] === 'xs'">
                            Upload
                            <b-spinner v-if="sendForm" small  label="Small Spinner" />
                        </b-button>
                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>
    </b-card>
</template>

<script>
    import {
        BRow,
        BCol,
        BCard,
        BForm,
        BButton,
        BFormInvalidFeedback,
        BCardText,
        BSpinner
    } from 'bootstrap-vue'
    import {
        BFormFile
    } from 'bootstrap-vue'
    import {
        pdf,
        required
    } from '@validations'
    import {
        ValidationProvider,
        ValidationObserver
    } from 'vee-validate'
    import axios from '@axios'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    export default {
        components: {
            BRow,
            BCol,
            BFormFile,
            BCard,
            BForm,
            ValidationProvider,
            ValidationObserver,
            BButton,
            BFormInvalidFeedback,
            BCardText,
            BSpinner
        },
        data() {
            return {
                pdfFile: null,
                sendForm: false,
                pdf,
                required
            }
        },
        methods: {
            uploadPDF() {
                if(this.$refs.pdffile.files[0])
                {
                    this.$refs.uploadPDF.validate().then(success => {
                    if (success) {
                        this.sendForm = true;
                        this.pdfFile = this.$refs.pdffile.files[0];
                        let formData = new FormData();
                        formData.append('pdfFile', this.pdfFile);
                        axios.post('api/upload-pdf', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }).then(res => {
                            if (res.data.status == 'success') {
                                this.$toast({
                                    component: ToastificationContent,
                                    props: {
                                        title: 'PDF has been upload, Start parsing the EDL and updating the db...',
                                        variant: 'success',
                                        icon: 'CheckCircleIcon',
                                    },
                                })

                                //Start parsing the data and updating db:
                                axios.post('api/parse-pdf', res.data).then(res => {
                                    if (res.data.status == 'success') {
                                        this.$toast({
                                            component: ToastificationContent,
                                            props: {
                                                title: 'PDF Parsed and data updated successfully!',
                                                variant: 'success',
                                                icon: 'CheckCircleIcon',
                                            },
                                        })
                                        this.pdfFile = null;
                                    } else {
                                        this.$toast({
                                            component: ToastificationContent,
                                            props: {
                                                title: 'Something went wrong',
                                                variant: 'error',
                                                icon: 'CheckCircleIcon',
                                            },
                                        })
                                    }
                                })


                                //End updating data
                                this.pdfFile = null;
                            } else {
                                this.$toast({
                                    component: ToastificationContent,
                                    props: {
                                        title: 'Something went wrong',
                                        variant: 'error',
                                        icon: 'CheckCircleIcon',
                                    },
                                })
                            }
                        })
                        setTimeout(() => {
                            this.sendForm = false;
                        }, 1000);
                    }

                })

                }
                  }
        }
    }

</script>

<style lang="scss">
    @import '~@resources/scss/vue/libs/vue-autosuggest.scss';

</style>
