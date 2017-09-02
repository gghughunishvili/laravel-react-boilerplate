require('./bootstrap');
import React, { Component } from 'react'
import { render } from 'react-dom'

class Welcome extends Component {
  render() {
    return (
        <div className="container">
            <h1 className="center">Hello</h1>
        </div>
    )
  }
}

render(<Welcome />, document.getElementById('example'))
