import Vue from 'vuejs';
import Axios from 'axios'
import AdminChangeOptions from './admin-change-options.vue';
import {
    templateSettings
} from 'lodash';

document.addEventListener('DOMContentLoaded', function() {

    window.app = new Vue({
        el: '.mitfit-app',
        components: {
            'admin-change-options': AdminChangeOptions,
        },
        data: {
            api: Axios.create({
                baseURL: localURLs.rest,
                headers: {
                    'content-type': 'application/json',
                    'X-WP-Nonce': nonce
                },
            }),
            clientId: "",
            clientSecret: "",
            tests: [],
            testsAvailable: ['math1', 'physics', 'test']
        },
        mounted() {
            this.api.get('mintfit/v1/options/').then((response) => {
                this.tests = response.data['tests']
                this.clientId = response.data['client_id']
                this.clientSecret = response.data['client_secret']
            })
        },
        methods: {
            log: function(message) {
                console.log(message)
                return message
            },
            saveOptions: function(clientData) {
                console.log(clientData)
                this.api.post('mintfit/v1/options/', clientData).then((response) => {

                    this.clientId = clientData.clientId
                    this.clientSecret = clientData.clientSecret
                    this.tests = clientData.tests
                })

            }
        }

    })

})