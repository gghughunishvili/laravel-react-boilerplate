import React, { Component } from 'react'

import Master from './layouts/Master'

class Login extends Component {
  render() {
    return (
      <Master>
        <div id="auth">
          <div className="wrapper">
              <div className="login">
                  <h1>Login</h1>
                  <form method="post">
                      <input type="text" name="username" placeholder="Username" required="required" />
                      <input type="password" name="password" placeholder="Password" required="required" />
                      <button type="submit" className="btn btn-primary btn-block btn-large custom-btn">Let me in</button>
                  </form>
              </div>
          </div>
          </div>
      </Master>
    )
  }
}

export default Login
