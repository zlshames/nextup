<template>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Create Event</div>
          <div class="panel-body">
            <div v-if="errors.main !== null" class="alert alert-danger">
							<strong>Error!</strong> {{ errors.main }}
						</div>

            <form class="form-horizontal" novalidate v-on:submit.prevent="submitForm">
              <div v-bind:class="['form-group', (errors.name !== null) ? 'has-error' : '']">
                <label for="name" class="col-md-4 control-label">Name</label>

                <div class="col-md-6">
                  <input id="name" type="text" class="form-control" v-model="name" required autofocus>

									<span v-if="errors.name !== null" class="help-block">
					        	<strong>{{ errors.name }}</strong>
					     		</span>
								</div>
              </div>

              <div v-bind:class="['form-group', (errors.start !== null) ? 'has-error' : '']">
                <label for="start" class="col-md-4 control-label">Start Date</label>
                <div class="col-md-6">
                  <input id="start" type="text" class="form-control" v-model="start" required>

									<span v-if="errors.start !== null" class="help-block">
					        	<strong>{{ errors.start }}</strong>
					     		</span>
								</div>
              </div>

              <div v-bind:class="['form-group', (errors.end !== null) ? 'has-error' : '']">
                <label for="end" class="col-md-4 control-label">End Date</label> (Optional)
                <div class="col-md-6">
                  <input id="end" type="text" class="form-control" v-model="end" required>

									<span v-if="errors.end !== null" class="help-block">
					        	<strong>{{ errors.end }}</strong>
					     		</span>
								</div>
              </div>

              <div v-bind:class="['form-group', (errors.category !== null) ? 'has-error' : '']">
                <label for="category" class="col-md-4 control-label">Category</label>
                <div class="col-md-6">
                  <input id="category" type="text" class="form-control" v-model="category" required>

									<span v-if="errors.category !== null" class="help-block">
					        	<strong>{{ errors.category }}</strong>
					     		</span>
								</div>
              </div>

              <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                  <button type="submit" class="btn btn-primary">
                    Create Event
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
	import request from 'superagent'
  import storage from '../utils/Storage'

	export default {
		data: function () {
			return {
				errors: {
					main: null,
					name: null,
					start: null,
          end: null,
          category: null
				},
				name: '',
				start: '',
        end: '',
        category: ''
			}
		},
    created() {
      // Redirect to login if no api_token found
      if (storage.getItem('api_token') == null) {
        location.href = '/login'
      }

      console.log('Create Event component mounted.')
    },
    methods: {
			submitForm() {
				let hasError = false;

				// Clear errors
				this.errors.main = null
				this.errors.name = null
				this.errors.start = null
        this.errors.end = null
        this.errors.category = null

				// Validation
				if (this.name == '' || this.name.length < 6) {
					this.errors.name = 'Name must be at least 6 characters.'
					hasError = true
				}

				if (this.start == '') {
					this.errors.start = 'Please enter a start date.'
					hasError = true
				}

        if (this.category == '') {
					this.errors.category = 'Please select a category.'
					hasError = true
				}

				// Check hasError so all errors are shown
				if (hasError) {
					return;
				}

				// Send HTTP request
        request
          .post('/api/v1/events')
          .set('Authorization', storage.getItem('api_token'))
          .send({
            name: this.name,
            start: this.start,
            finish: this.end,
            category_id: this.category
          })
          .then((success) => {
            location.href = '/'
          })
          .catch((error) => {
            this.handleErrors(error);           
        })
			},
      handleErrors(error) {
        // Handle status errors
        if (!error.response.body.success) {
          if (error.status == 403) {
            this.errors.main = 'You must be authenticated to create an event.'
          }
        }

        // Handle form errors
        if (error.response.body.errors) {
          const errors = error.response.body.errors

          this.errors.name = (errors.name) ? errors.name[0] : null
          this.errors.start = (errors.start) ? errors.start[0] : null
          this.errors.end = (errors.end) ? errors.end[0] : null
          this.errors.category = (errors.category_id) ? errors.category_id[0] : null
        } else {
          this.errors.main = 'An unknown error occured.'
        }
      }
    }
  }
</script>
