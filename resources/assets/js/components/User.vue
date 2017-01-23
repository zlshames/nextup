<template>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <h3 style="text-align: center;">{{ username }}</h3>
        <h5 style="text-align: center;">{{ email }}</h5>
      </div>
    </div>
  </div>
</template>

<script>
import storage from '../utils/Storage'

export default {
  data: function () {
    return {
      username: '',
      email: ''
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
  }
}
</script>
