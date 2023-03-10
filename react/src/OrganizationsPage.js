import React from 'react';
import axios from 'axios';
import { getCookie } from './App';

class OrganizationsPage extends React.Component {

  state = {
    list: null,

    // Organization form.
    name: '',
    description: '',
  };

  componentDidMount = async () => {
    try {
      const resp = await axios({
        method: 'get',
        url: 'http://web.badm_test.loc.com/api/organizations',
        headers: { 'Content-Type': 'application/json', Authorization: 'Bearer ' + getCookie('accessToken'), },
        params: {
        }
      });

      if (resp.data.success) {
        this.setState({ list: resp.data.data });
      }
      else {
        // @todo
      }
    }
    catch (error) {
      // 
    }
  }

  filterOnChange = async (status) => {
    try {
      const resp = await axios({
        method: 'get',
        url: 'http://web.badm_test.loc.com/api/organizations',
        headers: { 'Content-Type': 'application/json', Authorization: 'Bearer ' + getCookie('accessToken'), },
        params: {
          status
        }
      });

      if (resp.data.success) {
        this.setState({ list: resp.data.data });
      }
      else {
        // @todo
      }
    }
    catch (error) {
      // 
    }
  }

  submit = async () => {
    const { name, description } = this.state;

    try {
      const resp = await axios({
        method: 'post',
        url: 'http://web.badm_test.loc.com/api/organizations',
        headers: { 'Content-Type': 'application/json', Authorization: 'Bearer ' + getCookie('accessToken'), },
        data: {
          name,
          description,
        }
      });

      if (resp.data.success) {
        await this.componentDidMount();
      }
      else {
        // @todo
      }
    }
    catch (error) {
      // 
    }
  }
  
  render() {
    return (
      <div className="row mt-5">
        <div className="col-12 mb-3">
            <div>
            <select onChange={e => this.filterOnChange(e.target.value)}>
              <option value="all">All</option>
              <option value="trial">Trial</option>
              <option value="subbed">Subbed</option>
            </select>
            </div>
            <ul>
              {this.state.list && this.state.list.map(({ name }) => <li>{name}</li>)}
            </ul>
            <div className="row mt-5">
              <div className="col-12 name form-floating mb-3">
                <input
                  type="text"
                  className="form-control"
                  id="name"
                  placeholder="Organization name"
                  value={this.state.name}
                  onChange={e => this.setState({ name: e.target.value })} />
                <label
                  htmlFor="name">Organization name</label>
              </div>
              <div className="col-12 description form-floating mb-3">
                <input
                  type="text"
                  className="form-control"
                  id="description"
                  placeholder="Description"
                  value={this.state.description}
                  onChange={e => this.setState({ description: e.target.value })} />
                <label
                  htmlFor="description">Description</label>
              </div>
              <div className="col-12 action d-grid">
                <button
                  className="btn btn-lg form-control position-relative"
                  onClick={this.submit}
                  type="button">
                    Save Organization
                  </button>
              </div>
            </div>
        </div>
      </div>
    );
  }
}

export default OrganizationsPage;
