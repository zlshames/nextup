<template>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <h3 style="text-align: center;">{{ username }}</h3>
        <h5 style="text-align: center;">{{ email }}</h5>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <h3 style="text-align: center;">Your Events</h3>
        <div v-for="event in events" class="panel panel-default">
          <div class="panel-heading">{{ event.name }}</div>
          <div class="panel-body">
            <p>Start Date: {{ event.start }}</p>
            <p>Start Date: {{ (event.finish) ? event.finish : 'N/A' }}</p>
          </div>
				</div>
      </div>
    </div>
  </div>
</template>

<script>
import storage from '../utils/Storage'
import request from 'superagent'

export default {
  data: function () {
    return {
      username: '',
      email: '',
      events: []
    }
  },
  mounted() {
    console.log('User component mounted.')

    // Check if api_token is available
    const username = storage.getItem('username')
    const email = storage.getItem('email')

    if (username !== null && email !== null) {
      this.username = username
      this.email = email
    }

    // Send HTTP request
    request
      .get(`/api/v1/users/${ username }/events`)
      .set('Authorization', storage.getItem('api_token'))
      .then((success) => {
        this.events = success.body.response
      })
      .catch((error) => {
        console.log(error)
    })
  }
}
</script>
