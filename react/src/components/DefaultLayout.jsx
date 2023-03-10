import React from 'react'
import { useEffect } from 'react'
import { Link, Navigate, Outlet } from 'react-router-dom'
import axiosClient from '../axios-client'
import { useStateContext } from '../contexts/ContextProvider'

export default function DefaultLayout() {


  const {user, token, setUser, setToken, notification } = useStateContext()
  if(!token){
    return <Navigate to="/login" />
  }


  /* Per recuperare le info dell'user quanto il componente viene montato viene fatta una chiamata a user */
  useEffect(() => {
    axiosClient.get('/user').then(({data}) => {
        setUser(data);
    })
  }, [])



  const onLogout = (ev) => {
    ev.preventDefault();

    axiosClient.post('logout').then(()=> {
        setUser({});
        setToken(null);
    })
  }


  return (
    <div id="defaultLayout">
      <aside>
        <Link to="/dashboard">Dashboard</Link>
        <Link to="/users">Users</Link>
      </aside>
      <div className="content">
        <header>
          <div>
            Header
          </div>
          <div>
            {user.name}
            <a href="#" onClick={onLogout} className='btn-logout'>Logout</a>
          </div>
        </header>
        <main>
          <Outlet />
        </main>
      </div>
        {notification && <div className="notification">{notification}</div>}
    </div>
  )
}
