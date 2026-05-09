import { tasksReducer } from '@/utils'

import UploadComponent from './UploadComponent'

const GlobalSet = props => {
  console.log(props, 666);
  
  const initialTasks = props.data.item || []

  const [tasks, dispatch] = useReducer(tasksReducer, initialTasks)
  const handleChange = (key, value) => {
    const target = tasks.find(i => i.key === key)
    if (target) {
      dispatch({
        type: 'changed',
        payload: { ...target, default: value }
      })
    }
  }
  const dom = (
    <>
      <List
        bordered
        dataSource={tasks}
        renderItem={item => (
          <List.Item
            style={{
              display: 'flex',
              flexDirection: 'column',
              alignItems: 'start'
            }}
          >
            <div className="tw:text-lg tw:font-bold">
              <Typography.Text level={5}>{item.title}</Typography.Text>
            </div>

            {item.type === 'radio' && (
              <Radio.Group value={item.default} onChange={e => handleChange(item.key, e.target.value)} options={item.options.map(option => ({ value: option.value, label: option.label }))} />
            )}

            {item.type === 'text' && <Input value={item.default} className="tw:!w-[30%]" onChange={e => handleChange(item.key, e.target.value)} />}

            {item.type === 'upload' && <UploadComponent item={item} onUploadSuccess={url => handleChange(item.key, url)} />}

            <div>
              <Typography.Text level={5} style={{ fontSize: '12px', color: '#6b7280' }}>
                {item.desc}
              </Typography.Text>
            </div>
          </List.Item>
        )}
      />
    </>
  )
  return dom
}

export default GlobalSet
