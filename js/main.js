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
            testsActive: [],
            testsAvailable: [],
            testResults: [],
            refreshTime: 5000,
        },
        mounted() {

            if (position[0] == 'admin') {

                if (position[1] == 'options') {
                    this.api.get('mintfit/v1/options/').then((response) => {
                        console.log(response)
                        this.testsActive = response.data['tests_active']
                        this.testsAvailable = response.data['tests_available']
                        this.clientId = response.data['client_id']
                        this.clientSecret = response.data['client_secret']
                    })
                }

                if (position[1] == 'viewResults') {
                    this.api.get('mintfit/v1/test/all?all_users=true').then(response => {
                        this.testResults = response.data
                    })
                }
            }

        },
        methods: {
            log: function(message) {
                console.log(message)
                return message
            },
            saveOptions: function(clientData) {

                this.api.post('mintfit/v1/options/', clientData).then((response) => {

                    // Reload tests with increasing timeout, if they are not available
                    let refreshTests = () => {
                        this.api.get('mintfit/v1/options/').then(response => {
                            if (response.testsAvailable.length > 0) {
                                this.testsAvailable = response['tests_available']
                                this.testsActive = response['tests_active']
                            } else {
                                setTimeout(refreshTests, this.refreshTime)
                            }
                        })
                        this.refreshTime *= 2;
                    }

                    this.clientId = clientData.clientId
                    this.clientSecret = clientData.clientSecret

                    if (this.testsAvailable.length > 0) {
                        this.testsActive = clientData.testsActive
                    } else {
                        refreshTests()
                    }

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