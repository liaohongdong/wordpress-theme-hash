import { UploadOutlined } from '@ant-design/icons';
import { Input, List, Radio, Divider, Typography, message, Upload, Button } from 'antd';
import { genSuffPathByUploadFile } from '@/utils';
import request from '@/utils/request';
import axios from 'axios';
import qs from 'qs';

// import {
//   S3Client,
//   PutObjectCommand,
//   GetObjectCommand,
//   ListObjectsV2Command,
//   ListBucketsCommand,
// } from "@aws-sdk/client-s3";

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
                    const { file, onSuccess, onError } = options;
                    const suffPath = genSuffPathByUploadFile(file);
                    console.log(file, 64);
                    try {
                      // const formData = new FormData();
                      // formData.append('action', 'r2_upload');
                      // formData.append('nonce', __params.ajaxNonce);
                      // formData.append('file', file);
                      // formData.append('suffPath', suffPath);
                      // await request.post(__params.ajax_url, formData, {
                      //   headers: {
                      //     'Content-Type': 'multipart/form-data'
                      //   }
                      // })
                      // 后端上传
                      // await request.post(__params.ajax_url, {
                      //   action: 'r2_upload',
                      //   nonce: __params.ajaxNonce,
                      //   file,
                      //   suffPath,
                      // }, {
                      //   headers: {
                      //     'Content-Type': 'multipart/form-data'
                      //   }
                      // })
                      // $.ajax({
                      //   url: __params.ajax_url,
                      //   method: 'POST',
                      //   dataType: 'json',
                      //   data: {
                      //     action: 'r2_upload',
                      //     nonce: __params.ajaxNonce,
                      //     input: '哈哈哈gaga',
                      //   }
                      // })
                      // 前端上传
                      const res = await request.post(
                        __params.ajax_url,
                        qs.stringify({
                          action: 'r2_upload',
                          nonce: __params.ajaxNonce,
                          suffPath,
                        }),
                      );
                      // const uploadRes = await fetch(res.data.upload_url, {
                      //   method: 'PUT',
                      //   body: file,
                      //   headers: { 'Content-Type': file.type }
                      // })
                      const uploadRes = await axios({
                        method: 'PUT',
                        url: res.data.upload_url,
                        data: file,
                        headers: { 'Content-Type': file.type }
                      })
                      // if (uploadRes.ok) {
                      if (uploadRes.status === 200) {
                        message.success('上传成功');
                        onSuccess({ url: suffPath }); // 通知组件上传完成
                      } else {
                        message.error('上传失败');
                        onError('请检查上传路径');
                      }
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
