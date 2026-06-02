import './App.css'
import './style.scss'
import qs from 'qs'
import request from '@/utils/request'
import TabContext from './components/TabContext'
import Children from './components/Children'

message.config({
  top: 100,
  duration: 2,
  maxCount: 3,
  rtl: true,
  prefixCls: 'my-message'
})

const onChange = key => {
  console.log('切换标签', key)
}

const _App = () => {
  const [spinning, setSpinning] = useState(false)
  const [tabOptions, setTabOptions] = useState([]) // 只存配置，不存组件
  const [formData, setFormData] = useState({})

  const handleChange = (pKey, fieldKey, val) => {
    setFormData(prev => ({
      ...prev,
      // [fieldKey]: `${pKey}___${val}`,
      [fieldKey]: val
    }))
  }

  useEffect(() => {
    const tabs = window.__params?.admin_options?.tab_options || []
    setTabOptions(tabs)
  }, [])

  return (
    <App className="wrapper">
      {JSON.stringify(formData)} 25
      <TabContext.Provider value={{ spinning, setSpinning, tabOptions, setTabOptions, formData, setFormData, handleChange }}>
        <div className="tabs-spin-wrap">
          <Spin spinning={spinning}>
            <Tabs defaultActiveKey="global_set">
              {tabOptions.map(tab => (
                <Tabs.TabPane key={tab.key} tab={tab.title}>
                  <Children tabInfo={tab} formData={formData} handleChange={handleChange} />
                </Tabs.TabPane>
              ))}
            </Tabs>
          </Spin>
        </div>

        <Flex gap="small" wrap style={{ 'margin-top': '12px' }}>
          <Button onClick={() => setFormData({})}>重置</Button>
          <Button type="primary" onClick={() => save(formData, setSpinning)}>
            保存
          </Button>
        </Flex>
      </TabContext.Provider>
    </App>
  )
}

const save = async (item, fn) => {
  console.log(item, 888);
  
  fn(true)
  try {
    const res = await request.post(
      __params.ajax_url,
      qs.stringify({
        action: 'admin_save',
        nonce: __params.admin_save,
        item
      })
    )
    if (res.success) {
      message.success('保存成功')
    } else {
      message.error(res.message || '保存失败')
    }
  } catch (err) {
    message.error('请求异常')
    console.error(err)
  } finally {
    fn(false)
  }
}
export default _App
