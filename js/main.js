import Vue from 'vuejs';
import Axios from 'axios'
import AdminChangeOptions from './admin-change-options.vue';
import AdminViewResults from './admin-view-results.vue';
import {
    templateSettings
} from 'lodash';

document.addEventListener('DOMContentLoaded', function() {

    window.app = new Vue({
        el: '.mitfit-app',
        components: {
            'admin-change-options': AdminChangeOptions,
            'admin-view-results': AdminViewResults
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
            testResults: [],
            testsAvailable: ['math1', 'physics']
        },
        mounted() {
            this.api.get('mintfit/v1/options/').then((response) => {
                this.tests = response.data['tests']
                this.clientId = response.data['client_id']
                this.clientSecret = response.data['client_secret']
            })
            this.api.get('mintfit/v1/test/all?all_users=true').then(response => {
                console.log(response)
                this.testResults = response.data
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

            },
            deleteEntry: function(entry) {
                this.api.delete(`mintfit/v1/entry/${entry.id}`).then(response => {
                    Vue.set(entry, 'trash', true)
                })
            }
        }

    })

})