require('./bootstrap');
import React, { Component } from 'react'
import { render } from 'react-dom'
import { BrowserRouter as Router, Route, Link } from 'react-router-dom'

import Home from './components/Home'
import About from './components/About'
import Contact from './components/Contact'

render(
  (
    <Router>
      <div>
        <Route exact path="/" component={Home}/>
        <Route path="/about" component={About}/>
        <Route path="/contact" component={Contact}/>
      </div>
    </Router>
  ),
  document.getElementById('app')
)
