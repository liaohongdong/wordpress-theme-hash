import './App.css'
import React from 'react'
import { Button, Space, DatePicker, version } from 'antd'

const xx = () => {
  alert(11)
}

const App = () => {
  return (
    <div className="content">
      <p>Start building amazing things with Rsbuild.</p>
      <h1>antd version: {version}</h1>
      <Space>
        <DatePicker />
        <Button type="primary" onClick={xx}>Primary Button</Button>
      </Space>
    </div>
  )
}

export default App
