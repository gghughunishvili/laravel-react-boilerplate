import React, { Component } from 'react'

import Master from './layouts/Master'

class Register extends Component {
  render() {
    return (
      <Master>
        <div id="auth">
          <div className="wrapper">
              <div className="login">
                  <h1>Register</h1>
                  <form method="post">
                      <input type="text" name="name" placeholder="Full Name" required="required" />
                      <input type="email" name="email" placeholder="Email" required="required" />
                      <input type="password" name="password" placeholder="Password" required="required" />
                      <button type="submit" className="btn btn-primary btn-block btn-large">Let me register</button>
                  </form>
              </div>
          </div>
        </div>
      </Master>
    )
  }
}

export default Register
