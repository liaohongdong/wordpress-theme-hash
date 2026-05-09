import { UploadOutlined } from '@ant-design/icons'
import { genSuffPathByUploadFile } from '@/utils'
import request from '@/utils/request'
import axios from 'axios'
import qs from 'qs'
import { useRef } from 'react'
import { message } from 'antd'

import TabContext from './TabContext'

const UploadComponent = ({ item, onUploadSuccess }) => {
  const { setSpinning } = useContext(TabContext);
  const uploadRef = useRef(null);
  const uploadProps = {
    name: 'file',
    openFileDialogOnClick: false,
    showUploadList: false,
    beforeUpload: file => {
      let LIMIT_WIDTH = item.width // 最大宽度
      let LIMIT_HEIGHT = item.height // 最大高度
      let LIMIT_SIZE = item.size * 1024 * 1024 // 2MB
      // if (!item?.allow?.some(type => file.type.includes(type))) {
      //   message.error(`请上传${item.allow.join('、')}格式的文件`);
      //   return Promise.reject(false);
      // }
      // if (file.size > LIMIT_SIZE) {
      //   message.error(`文件大小不能超过 ${item.size}MB`);
      //   return Promise.reject(false);
      // }
      // return new Promise((resolve, reject) => {
      //   // const img = new Image();
      //   // img.src = URL.createObjectURL(file);
      //   // img.onload = () => {
      //   //   const { width, height } = img;
      //   //   // if (width !== LIMIT_WIDTH && height !== LIMIT_HEIGHT) {
      //   //   //   message.error(`图片尺寸必须为： ${LIMIT_WIDTH}×${LIMIT_HEIGHT}尺寸！当前：${width}×${height}`);
      //   //   //   reject(false); // 拦截上传
      //   //   //   return;
      //   //   // }
      //   //   resolve(true);
      //   // }
      //   // img.onerror = () => {
      //   //   message.error("图片加载失败，请重新上传");
      //   //   reject(false);
      //   // };
      //   resolve(true)
      // })
      // return Promise.reject(new Error('上传失败'));
      // return false;
      return true
    },
    customRequest: async options => {
      const { file, onSuccess, onError } = options
      const suffPath = genSuffPathByUploadFile(file)
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
        setSpinning(true);
        const res = await request.post(
          __params.ajax_url,
          qs.stringify({
            action: 'r2_upload',
            nonce: __params.ajaxNonce,
            suffPath
          })
        )
        setSpinning(false);
        // const uploadRes = await fetch(res.data.upload_url, {
        //   method: 'PUT',
        //   body: file,
        //   headers: { 'Content-Type': file.type }
        // })
        setSpinning(true);
        const uploadRes = await axios({
          method: 'PUT',
          url: res.data.upload_url,
          data: file,
          headers: { 'Content-Type': file.type }
        })
        setSpinning(false);
        console.log(uploadRes, 181);
        // if (uploadRes.ok) {
        if (uploadRes.status === 200) {
          message.destroy()
          onSuccess({ url: __params.custom_domain + suffPath }, file) // 通知组件上传完成
        } else {
          message.error('上传失败')
          onError('请检查上传路径')
        }
      } catch (error) {
        message.error('上传失败')
        onError(error)
      }
    },
    onChange: info => {
      console.log('onChange =', info)
      if (info.file.status === 'done') {
        onUploadSuccess(info.file.response?.url)
        message.destroy()
        message.success('上传成功')
      }
      if (info.file.status === 'error') {
        message.error('上传失败')
      }
    }
  }
  return (
    <>
      <style>{`.ant-upload-select { width: 100% !important; }`}</style>
      <Upload {...uploadProps} ref={uploadRef} className="tw:!w-[30%]">
        <div className="tw:flex tw:items-center tw:gap-2">
          <Input value={item.default} className="tw:w-full" />
          <Button icon={<UploadOutlined />} onClick={() => uploadRef.current.nativeElement?.querySelector('input[type="file"]')?.click()} />
        </div>
      </Upload>
    </>
  )
}

export default UploadComponent