import React from 'react';
import axios from 'axios';

import { setCookie } from './App';

class LoginPage extends React.Component {

  state = {
    email: '',
    pass: '',
  };

  submit = async () => {
    const { email, pass } = this.state;

    try {
      const resp = await axios({
        method: 'post',
        url: 'http://web.badm_test.loc.com/api/login',
        headers: { 'Content-Type': 'application/json' },
        data: {
          email: email,
          password: pass,
        }
      });

      if (resp.data.success) {
        setCookie('accessToken', resp.data.data, 30);
        location.reload();
      }
      else {
        // @todo wrong credentials msg
      }
    }
    catch (error) {
      // 
    }
  }

  render() {
    return (
      <div className="row mt-5">
        <div className="col-12 email form-floating mb-3">
          <input
            type="email"
            className="form-control"
            id="email"
            placeholder="Email address"
            value={this.state.email}
            onChange={e => this.setState({ email: e.target.value })} />
          <label
            htmlFor="email">Email address</label>
        </div>
        <div className="col-12 pass form-floating mb-3">
          <input
            type="password"
            className="form-control"
            id="pass"
            placeholder="Password"
            value={this.state.pass}
            onChange={e => this.setState({ pass: e.target.value })} />
          <label
            htmlFor="pass">Password</label>
        </div>
        <div className="col-12 action d-grid">
          <button
            className="btn btn-lg form-control position-relative"
            onClick={this.submit}
            type="button">
              Login
            </button>
        </div>
      </div>
    );
  }
}

export default LoginPage;