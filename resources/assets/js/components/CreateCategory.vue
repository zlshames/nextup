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

              <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                  <button type="submit" class="btn btn-primary">
                    Create Category
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
					name: null
				},
				name: ''
			}
		},
    created() {
      // Redirect to login if no api_token found
      if (storage.getItem('api_token') == null) {
        location.href = '/login'
      }

      console.log('Create Category component mounted.')
    },
    methods: {
			submitForm() {
				let hasError = false;

				// Clear errors
				this.errors.main = null
				this.errors.name = null

				// Validation
				if (this.name == '' || this.name.length < 3) {
					this.errors.name = 'Category must be at least 3 characters.'
					hasError = true
				}

				// Check hasError so all errors are shown
				if (hasError) {
					return;
				}

				// Send HTTP request
        request
          .post('/api/v1/categories')
          .set('Authorization', storage.getItem('api_token'))
          .send({
            name: this.name
          })
          .then((success) => {
            location.href = '/create-category'
          })
          .catch((error) => {
            console.log(error.response)
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
        } else {
          this.errors.main = 'An unknown error occured.'
        }
      }
    }
  }
</script>
