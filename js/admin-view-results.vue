<template>
  <div>
      <div v-if="selectedTestResult==undefined">
      <h1>MINTFIT User Results</h1>
      <wp-list-table 
        :columns="{
            'id': {
                label: 'Id'
            },
            'user_login': {
                label: 'User'
            },
            'test_slug': {
                label: 'Test'
            },
            'score': {
                label: 'Score'
            },
            'max_score': {
                label: 'Max Score',
            }
        }"
        :rows="activeTestResults"
        action-column="id"
        :actions="[{
            key: 'view',
            label: 'View'
        },{
            key: 'delete',
            label: 'Delete'
        }]"
        :show-cb="true"
        :total-items="activeTestResults.length"
        :bulk-actions="[ {
            key: 'delete',
            label: 'Delete'
        }]"
        @action:click="performAction"
        @bulk:click="performBulkAction"

      />
      </div>
      <div v-if="selectedTestResult!=undefined">
          <h1>MINTFIT View Result</h1>
          <div class="result-entry-wrapper">
            <p>
                <span class="label">Id:</span>
                <span class="value">{{ selectedTestResult.id }}</span>
            </p>
            <p>
                <span class="label">User:</span>
                <span class="value">{{ selectedTestResult.user_login }}</span>
            </p>
            <p>
                <span class="label">Test:</span>
                <span class="value">{{ selectedTestResult.test_slug }}</span>
            </p>
            <p>
                <span class="label">Begin:</span>
                <span class="value">{{ selectedTestResult.start_time }}</span>
            </p>
            <p>
                <span class="label">End:</span>
                <span class="value">{{ selectedTestResult.end_time }}</span>
            </p>
            <p>
                <span class="label">Min Score:</span>
                <span class="value"> 0 </span>
            </p>
            <p>
                <span class="label">Max Score:</span>
                <span class="value">{{ selectedTestResult.max_score }}</span>
            </p>
            <p>
                <span class="label">User Score:</span>
                <span class="value">{{ selectedTestResult.score }}</span>
            </p>
            <p>
                <span class="label">Finished:</span>
                <span class="value">{{ selectedTestResult.finished ? 'Yes' : 'No' }}</span>
            </p>
            </div>

            <button @click="exitViewSingle()" class="button action">Go back</button>



      </div>
  </div>
</template>

<script>
import Vue from 'vuejs';
import ListTable from 'vue-wp-list-table';


export default {
  name: 'admin-view-results',
  components: {
      'wp-list-table': ListTable
  },
  props: {
      testResults: Array
  },
  data: function(){
      return {
          selectedTestResult: undefined,
      }
  },
  computed: {
      activeTestResults: function(){
          if (!Array.isArray( this.testResults)) return [];

          return this.testResults.filter(testResult => {
              return !testResult.trash
          })
      },
      inactiveTestResults: function(){
          if (!Array.isArray( this.testResults)) return [];

          return this.testResults.filter(testResult => {
              return testResult.trash
          })
      },
  },
  methods: {
      performAction: function(action, row){
          if (action == 'view') {
              this.selectedTestResult = row
          }

          if (action == 'delete') {
              this.$emit('deleteenty', row)
          }
      },
      performBulkAction: function(action, rowIds){

        let rows = this.testResults.filter(testResult => {
            return rowIds.includes( testResult.id )
        })

        for (let row of rows){
            this.performAction(action, row)
        }
          
      },
      exitViewSingle: function(){
          this.selectedTestResult = undefined
      }
  }
}
</script>

<style>
    h1 {
        margin-bottom: 0.5rem;
    }

    .result-entry-wrapper {
        background-color: white;
        padding: 1rem;
        border: thin solid #cccccc;
        margin-bottom: 1rem;
    }

    .label {
        font-weight: 700;
        display: inline-block;
        width: 8rem;
    }
</style>
