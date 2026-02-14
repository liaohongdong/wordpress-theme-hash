import './App.css'
import './style.scss'
import React from 'react'
import { Button, Space, DatePicker, version } from 'antd'

const xx = () => {
  alert(11)
}

const App = () => {
  console.log(window, 998123, window.__params, window.$);
  return (
    <div className="content">
      <p>Start building amazing things with Rsbuild.</p>
      <h1 className="tw:text-[50px]! tw:font-bold tw:underline">antd version: {version}</h1>
      <Space>
        <DatePicker />
        <Button type="primary" onClick={xx}>Primary Button</Button>
      </Space>
    </div>
  )
}

export default App
