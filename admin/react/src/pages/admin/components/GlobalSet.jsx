import { UploadOutlined } from '@ant-design/icons';
import { Input, List, Radio, Divider, Typography, message, Upload, Button } from 'antd'

import { genSuffPathByUploadFile } from '@/utils'

const GlobalSet = props => {
  const { item } = props
  const { global_set } = item
  const { item: _item } = global_set
  // 斐波那契数列
  const dom = (
    <>
      <List
        bordered
        dataSource={_item}
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
            {(() => {
              if (item.type === 'radio') {
                return <Radio.Group
                  value={item.default}
                  options={item.options.map(option => ({
                    value: option.key,
                    label: option.value
                  }))}
                />
              } else if (item.type === 'text') {
                return <Input value={item.default} className='tw:!w-[30%]' />
              } else if (item.type === 'upload') {
                const formData = new FormData();
                formData.append('file', item.default);
                const props = {
                  name: 'file',
                  action: 'https://a3f2441ab2dcc5a7eb4c789098210e27.r2.cloudflarestorage.com/',
                  data: formData,
                  showUploadList: false,
                  beforeUpload: (file) => {
                    const suffPath = genSuffPathByUploadFile(file);
                    console.log(file, 444, suffPath);
                    // return true;
                    return Promise.reject(new Error('上传失败'));
                  },
                  onChange: (info) => {
                    console.log(info, 404040)
                    if (info.file.status === 'done') {
                      console.log(info.file.response)
                    }
                  },
                }
                return <>
                  {/* :global(.ant-upload-select) { */}
                  <style>{`
                    .ant-upload-select {
                      width: 100% !important;
                    }
                  `}</style>
                  <Upload {...props} className='tw:w-full'>
                    <div className="tw:flex tw:items-center tw:gap-2">
                      <Input value={item.default} className='tw:!w-[30%]' />
                      <Button icon={<UploadOutlined />}></Button>
                    </div>
                  </Upload>
                </>;
              }
              return null;
            })()}
            <div>
              <Typography.Text
                level={5}
                style={{
                  fontSize: '12px',
                  color: '#6b7280'
                }}
              >
                {item.desc}
              </Typography.Text>
            </div>
          </List.Item>
        )}
      />
    </>
  )

  // return <>GlobalSet {JSON.stringify(item)}</>
  return dom
}
export default GlobalSet
