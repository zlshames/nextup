<template>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Login</div>
          <div class="panel-body">
						<div v-if="errors.main !== null" class="alert alert-danger">
							<strong>Error!</strong> {{ errors.main }}
						</div>

            <form class="form-horizontal" novalidate v-on:submit.prevent="submitForm">
              <div v-bind:class="['form-group', (errors.email !== null) ? 'has-error' : '']">
                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                <div class="col-md-6">
                  <input id="email" type="email" class="form-control" v-model="email" required autofocus>

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

              <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                  <button type="submit" class="btn btn-primary">
                    Login
                  </button>

                  <a class="btn btn-link" href="/password/reset">
                    Forgot Your Password?
                  </a>
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
					email: null,
					password: null
				},
				email: '',
				password: ''
			}
		},
    mounted() {
      console.log('Login component mounted.')
    },
    methods: {
			submitForm() {
				let hasError = false;

				// Clear errors
				this.errors.main = null
				this.errors.email = null
				this.errors.password = null

				// Validation
				if (this.email == '' || this.email.length < 6 || this.email.indexOf('@') < 0) {
					this.errors.email = 'Please enter a valid email'
					hasError = true
				}

				if (this.password == '' || this.password.length < 6) {
					this.errors.password = 'Password must be at least 6 characters.'
					hasError = true
				}

				// Check hasError so all errors are shown
				if (hasError) {
					return;
				}

				// Send HTTP request
        request
          .post('/api/auth/signin')
          .send({
            email: this.email,
            password: this.password
          })
          .then((sucess) => {
            location.href = '/'
          })
          .catch((error) => {
            this.errors.main = error.response.body.error
        })
			}
    }
  }
</script>
