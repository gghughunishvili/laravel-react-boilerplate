import React, { Component } from 'react'
import { Link, NavLink } from 'react-router-dom'

export default class Master extends Component {
  render() {
    return (
      <div>
        <div className="header">
          <nav className="navbar navbar-expand-lg navbar-dark bg-primary">
            <Link to="/" className="navbar-brand">App</Link>
            <button
              className="navbar-toggler"
              type="button"
              data-toggle="collapse"
              data-target="#navbarColor01"
              aria-controls="navbarColor01"
              aria-expanded="true"
              aria-label="Toggle navigation">
                <span className="navbar-toggler-icon"></span>
            </button>

            <div className="collapse navbar-collapse" id="navbarColor01">
              <ul className="navbar-nav mr-auto">
                <NavLink exact to="/" className="nav-link">Home <span className="sr-only">(current)</span></NavLink>
                <NavLink to="/about" className="nav-link">About</NavLink>
                <NavLink to="/contact" className="nav-link">Contact</NavLink>
                <NavLink to="/register" className="nav-link">Register</NavLink>
                <NavLink to="/login" className="nav-link">Login</NavLink>
              </ul>
            </div>
          </nav>
        </div>
        <div className="content">
          {this.props.children}
        </div>
        <div className="footer">
          <h2>Footer Mate</h2>
        </div>
      </div>
    )
  }
}
