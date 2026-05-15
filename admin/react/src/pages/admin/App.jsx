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
  console.log(key, 8)
}

const _App = () => {
  const [spinning, setSpinning] = useState(false)
  const [options, setOptions] = useState([])
  const [items, setItems] = useState([])
  // const _tmp = []
  useEffect(() => {
    const tabOptions = window.__params?.admin_options?.tab_options;
    if (!tabOptions?.length) return;
    setOptions([...tabOptions]);
    const newItems = tabOptions.map((e) => {
      const key = Object.keys(e)[0];
      return {
        key: key,
        label: e[key].title,
        children: <Children item={e} />,
      };
    });
    setItems(newItems);
  }, [])
  console.log(items, 35)

  return (
    <App className="wrapper">
      {JSON.stringify(items)}
      <TabContext.Provider value={{ spinning, setSpinning }}>
        {/* <h1 className="tw:text-[50px]! tw:font-bold tw:underline">antd version: {version}</h1> */}
        {/* <Spin spinning={spinning}>
          <Tabs defaultActiveKey="1" items={items} onChange={onChange} />
          <Flex gap="small" wrap style={{ 'margin-top': '12px' }}>
            <Button onClick={() => {}}>重置</Button>
            <Button type="primary" onClick={() => save(items, setSpinning)}>
              保存
            </Button>
          </Flex>
        </Spin> */}
      </TabContext.Provider>
    </App>
  )
}

const save = async (item, fn) => {
  fn(true)
  try {
    console.log(item, 55)

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
