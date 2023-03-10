import React from 'react';
import './App.css';

import LoginPage from './LoginPage';
import OrganizationsPage from './OrganizationsPage';

class App extends React.Component {

  anonymousContent = () => {
    return <LoginPage />;
  }

  authContent = () => {
    return <OrganizationsPage />;
  }

  render() {
    return (
      <div className="App container">
        {getCookie('accessToken') ? this.authContent() : this.anonymousContent()}
      </div>
    );
  }
}

export default App;

export const getCookie = (cname) => {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) === ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) === 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

export const setCookie = (cname, cvalue, exdays) => {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
