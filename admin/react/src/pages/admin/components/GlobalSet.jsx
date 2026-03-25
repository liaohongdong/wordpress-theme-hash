import { Input, List, Radio, Divider, Typography } from 'antd'

const GlobalSet = (props) => {
  const { item } = props;
  const { global_set } = item;
  const { item: _item } = global_set;
  const dom = <>
    <List
      bordered
      dataSource={_item}
      renderItem={(item) => (
        <List.Item
          style={{
            display: 'flex',
            flexDirection: 'column',
            alignItems: 'start',
          }}>
          <div className='tw:text-lg tw:font-bold'>
            <Typography.Text level={5}>{item.title}</Typography.Text>
          </div>
          {['radio'].includes(item.type) && (
            <Radio.Group
              value={item.default}
              options={
                item.options.map(option => ({
                  value: option.key,
                  label: option.value
                }))
              }
            />
          )}
          <div>
            <Typography.Text level={5}
              style={{
                fontSize: '12px',
                color: '#6b7280',
              }}>{item.desc}</Typography.Text>
          </div>
        </List.Item>
      )}
    />
  </>

  // return <>GlobalSet {JSON.stringify(item)}</>
  return dom
}
export default GlobalSet
