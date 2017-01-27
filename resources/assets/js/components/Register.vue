<template>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Register</div>
          <div class="panel-body">
            <div v-if="errors.main !== null" class="alert alert-danger">
							<strong>Error!</strong> {{ errors.main }}
						</div>

            <form class="form-horizontal" novalidate v-on:submit.prevent="submitForm">
              <div v-bind:class="['form-group', (errors.username !== null) ? 'has-error' : '']">
                <label for="username" class="col-md-4 control-label">Username</label>

                <div class="col-md-6">
                  <input id="username" type="text" class="form-control" v-model="username" required autofocus>

                  <span v-if="errors.username !== null" class="help-block">
					        	<strong>{{ errors.username }}</strong>
					     		</span>
                </div>
              </div>

              <div v-bind:class="['form-group', (errors.email !== null) ? 'has-error' : '']">
                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                <div class="col-md-6">
                  <input id="email" type="email" class="form-control" v-model="email" required>

                  <span v-if="errors.email !== null" class="help-block">
					        	<strong>{{ errors.email }}</strong>
					     		</span>
                </div>
              </div>

              <div v-bind:class="['form-group', (errors.password !== null) ? 'has-error' : '']">
                <label for="password" class="col-md-4 control-label">Password</label>

                <div class="col-md-6">
                  <input id="password" type="password" class="form-control" v-model="password" required>

                  <span v-if="errors.password !== null" class="help-block">
					        	<strong>{{ errors.password }}</strong>
					     		</span>
                </div>
              </div>

              <div v-bind:class="['form-group', (errors.confirmation !== null) ? 'has-error' : '']">
                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                <div class="col-md-6">
                  <input id="password-confirm" type="password" class="form-control" v-model="confirmation" required>

                  <span v-if="errors.confirmation !== null" class="help-block">
					        	<strong>{{ errors.confirmation }}</strong>
					     		</span>
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                  <button type="submit" class="btn btn-primary">
                    Register
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

	export default {
		data: function () {
			return {
				errors: {
					main: null,
          username: null,
					email: null,
					password: null,
          confirmation: null
				},
        username: '',
				email: '',
				password: '',
        confirmation: ''
			}
		},
    mounted() {
      console.log('Register component mounted.')
    },
    methods: {
			submitForm() {
				let hasError = false;

				// Clear errors
				this.errors.main = null
        this.errors.username = null
				this.errors.email = null
				this.errors.password = null
        this.errors.confirmation = null

				// Validation
				if (this.email == '' || this.email.length < 6 || this.email.indexOf('@') < 0) {
					this.errors.email = 'Please enter a valid email'
					hasError = true
				}

        if (this.username == '' || this.username.length < 3) {
					this.errors.username = 'Username must be at least 3 characters.'
					hasError = true
				}

				if (this.password == '' || this.password.length < 6) {
					this.errors.password = 'Password must be at least 6 characters.'
					hasError = true
				}

        if (this.confirmation !== this.password) {
					this.errors.confirmation = 'Confirmation does not match password.'
					hasError = true
				}

				// Check hasError so all errors are shown
				if (hasError) {
					return;
				}

				// Send HTTP request
        request
          .post('/api/auth/signup')
          .send({
            username: this.username,
            email: this.email,
            password: this.password,
            password_confirmation: this.confirmation
          })
          .then((success) => {
            location.href = '/login'
          })
          .catch((error) => {
            this.handleErrors(error)
        })
			},
      handleErrors(error) {
        // Handle status errors
        if (!error.response.body.success) {
          if (error.status == 403) {
            this.errors.main = 'You are forbidden to do this.'
          }
        }

        // Handle form errors
        if (error.response.body.errors) {
          const errors = error.response.body.errors

          this.errors.username = (errors.username) ? errors.username[0] : null
          this.errors.email = (errors.email) ? errors.email[0] : null
          this.errors.password = (errors.password) ? errors.password[0] : null
        } else {
          this.errors.main = 'An unknown error occured.'
        }
      }
    }
  }
</script>
