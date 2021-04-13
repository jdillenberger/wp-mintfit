<template>
  <form @keypress.enter.prevent="saveForm()" >
    
    <h1>MINTFIT API Options</h1>
    
    <h2>Client Configuration</h2>
    <p>Please add your client-id and your client-secret.</p>
    <p>
      <label class="textbox-label" for="input-client-id">Client Id:</label>
      <input id="input-client-id" type="text" v-model="$data._clientId" required>
    </p>

    <p>
      <label class="textbox-label" for="input-client-secret">Client Secret:</label>
      <input id="input-client-secret" type="text" v-model="$data._clientSecret" required>
    </p>

    <h2>Test configuration</h2>
    <p>Which of the following tests do you want to synchronize?</p>
    <p v-for="test in testsAvailable" :key="test">
      <input  :id="'check-' + test" type="checkbox" :value="test" v-model="$data._tests[test]" />
      <label :for="'check-' + test">{{ test }}</label>
    </p>

    <button type="button" :disabled="!formFilledOut || !changed"  @click="saveForm()" class="button action">Save Configuration</button>

  </form>
</template>

<script>
import Vue from 'vuejs';

export default {
  name: 'admin-change-options',
  props: {
    tests: Array,
    testsAvailable: Array,
    clientId: String,
    clientSecret: String
  },
  emits: ['saveOptions'],
  data: function() {
    return {
      _tests: {},
      _clientId: "",
      _clientSecret: ""
    }
  },
  watch: {
      clientId: function(newValue, oldValue) {
        this.$data._clientId = this.clientId
      },
      clientSecret: function(newValue, oldValue) {
        this.$data._clientSecret = this.clientSecret
      },
      tests: function(newValue, oldValue) {
        this.testsAvailable.forEach(availableTest => {
          Vue.set(this.$data._tests, availableTest, this.tests.includes(availableTest))
        });
      },
  },
  computed: {
      changed: function() {
        let changedClientId = this.$data._clientId !== this.clientId
        let changedClientSecret = this.$data._clientSecret !== this.clientSecret

        let changedTests = false

        for (let test of this.testsAvailable) {
          if (this.$data._tests[test] !== this.tests.includes(test)) {
            changedTests = true
          }
        }

        return changedClientId || changedClientSecret || changedTests
      },
      formFilledOut: function() {
        let hasClientId = String( this.$data._clientId ).trim() != ''
        let hasClientSecret = String( this.$data._clientSecret ).trim() != ''
        console.log(hasClientId && hasClientSecret) 
        return hasClientId && hasClientSecret
      }
  },
  methods: {
      changeTest: function(){

      },
      saveForm: function() {
        this.$emit('saveoptions', {
          clientId: this.$data._clientId,
          clientSecret: this.$data._clientSecret,
          tests: this.testsAvailable.filter(test => {
            return this.$data._tests[test]
          })
        })

      }
  }
  
}
</script>

<style>
  .textbox-label {
    width: 7rem;
    display: inline-block;
  }
</style>
