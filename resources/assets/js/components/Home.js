import React, { Component } from 'react'
import Master from './layouts/Master'

class Home extends Component {
  render() {
    return (
      <Master>
        <div className="container">
          I am a test home element in master Layout
        </div>
      </Master>
    )
  }
}

export default Home
