import './App.css'
import './style.scss'
import React from 'react'
import { App, Button, Space, DatePicker, version, Tabs } from 'antd'
import Children from './components/Children'

const onChange = key => {
  console.log(key, 8);
};

const _App = () => {
  console.log(window, 998123, window.__params, window.$);
  const items = [];
  if (window.__params?.admin_options?.tab_options && window.__params.admin_options.tab_options?.length) {
    window.__params.admin_options.tab_options.forEach(e => {
      console.log(e, 11);
      const key = Object.keys(e)[0];
      items.push({
        key: key,
        label: e[key].title,
        children: <Children item={e}/>,
      })
    })
    
  }
  return (
    <App className="wrapper">
      {/* <h1 className="tw:text-[50px]! tw:font-bold tw:underline">antd version: {version}</h1> */}
      <Tabs defaultActiveKey="1" items={items} onChange={onChange} />
    </App>
  )
}

export default _App
