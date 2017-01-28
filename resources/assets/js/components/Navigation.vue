<template>
  <nav class="navbar navbar-default navbar-static-top">
    <div class="container">
      <div class="navbar-header">

          <!-- Collapsed Hamburger -->
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
          <span class="sr-only">Toggle Navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

        <!-- Branding Image -->
        <a class="navbar-brand" href="/">
          Next Up
        </a>
      </div>

      <div class="collapse navbar-collapse" id="app-navbar-collapse">
        <!-- Left Side Of Navbar -->
        <ul class="nav navbar-nav">
            <li><a href="/categories">Categories</a></li>
        </ul>

        <!-- Right Side Of Navbar -->
        <ul v-if="!loggedIn" class="nav navbar-nav navbar-right">
          <!-- Authentication Links -->
          <li><a href="/login">Login</a></li>
          <li><a href="/register">Register</a></li>
        </ul>

        <ul v-if="loggedIn" class="nav navbar-nav navbar-right">
          <!-- Authenticated Links -->
          <li v-if="username == 'zlshames'"><a href="/create-category">Create Category</a></li>
          <li><a href="/create-event">Create Event</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              {{ username }}
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="/user">My Account</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#" @click="logout">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import storage from '../utils/Storage'

export default {
  data: function () {
    return {
      loggedIn: false,
      username: '',
      email: ''
    }
  },
  created() {
    console.log('Navigation component mounted.')

    // Check if api_token is available
    const token = storage.getItem('api_token')
    const username = storage.getItem('username')
    const email = storage.getItem('email')

    if (token !== null && username !== null && email !== null) {
      this.loggedIn = true
      this.username = username
      this.email = email
    }
  },
  methods: {
    logout() {
      storage.removeItem('api_token')

      location.href = '/'
    }
  }
}
</script>
