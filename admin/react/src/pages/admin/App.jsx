import './App.css'
import './style.scss'
// import React from 'react'
// import { App, Tabs, message } from 'antd'
import TabContext from './components/TabContext';
import Children from './components/Children'

message.config({
  top      : 100,
  duration : 2,
  maxCount : 3,
  rtl      : true,
  prefixCls: 'my-message',
});

const onChange = key => {
  console.log(key, 8);
};

const _App = () => {
  // console.log(window, 998123, window.__params, window.$);
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
  const [spinning, setSpinning] = useState(false);
  return (
    <App className="wrapper">
      <TabContext.Provider value={{ spinning, setSpinning }}>
        {/* <h1 className="tw:text-[50px]! tw:font-bold tw:underline">antd version: {version}</h1> */}
        <Spin spinning={spinning}>
          <Tabs defaultActiveKey="1" items={items} onChange={onChange} />
        </Spin>
      </TabContext.Provider>
    </App>
  )
}

export default _App
