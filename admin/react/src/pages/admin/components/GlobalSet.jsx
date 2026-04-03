import { UploadOutlined } from '@ant-design/icons';
import { Input, List, Radio, Divider, Typography, message, Upload, Button } from 'antd';
import { genSuffPathByUploadFile } from '@/utils';
import {
  S3Client,
  PutObjectCommand,
  GetObjectCommand,
  ListObjectsV2Command,
  ListBucketsCommand,
} from "@aws-sdk/client-s3";

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
                  // action: 'https://a3f2441ab2dcc5a7eb4c789098210e27.r2.cloudflarestorage.com/',
                  // data: formData,
                  showUploadList: false,
                  beforeUpload: (file) => {
                    // return Promise.reject(new Error('上传失败'));
                    // return false;
                    return true;
                  },
                  customRequest: async (options) => {
                    const { file, onProgress, onSuccess, onError } = options;
                    console.log(options, 444444, file)
                    const suffPath = genSuffPathByUploadFile(file);
                    // console.log(file, 444, suffPath);
                    try {
                      const s3Client = new S3Client({
                        region: "auto",
                        endpoint: "https://a3f2441ab2dcc5a7eb4c789098210e27.r2.cloudflarestorage.com",
                        credentials: {
                          accessKeyId: "3e66e7963eb4e385b710b31a0de9a4e1",
                          secretAccessKey: "83d80ebccf090a708b6989e45b4eb3d5dfaf0f1a10984929b40e5f17502ddc7e"
                        },
                        // signer: { sign: async (req) => req },
                        forcePathStyle: true,
                        disableHostPrefix: true,
                      });
                      // const put = new PutObjectCommand({
                      //   Bucket: "wordpress",
                      //   Key: 'hh.txt',
                      //   Body: '1122334',
                      //   ContentType: file.type,
                      // });
                      // console.log(s3Client, 70, put);
                      // await s3Client.send(put);
                      // console.log(await s3Client.send(new ListBucketsCommand({})));
                      message.success('上传成功');
                      onSuccess({ url: suffPath }); // 通知组件上传完成
                    } catch (error) {
                      message.error('上传失败');
                      onError(error);
                    }
                  },
                  onChange: (info) => {
                    if (info.file.status === 'done') {
                      console.log("上传完成", info.file.response);
                    } else if (info.file.status === 'error') {
                      console.log("上传失败", info.file.error);
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
