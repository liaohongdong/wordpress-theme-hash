import UploadComponent from './UploadComponent.jsx'

export default function Children({ tabInfo, formData, handleChange }) {
  const { item, key: pKey } = tabInfo
  const renderFormItem = cfg => {
    const { key, type, default: defVal, options = [], title } = cfg
    const currentVal = formData[key] ?? defVal
    switch (type) {
      case 'radio':
        return (
          <Radio.Group value={currentVal} onChange={e => handleChange(pKey, key, e.target.value)}>
            <Space wrap>
              {options.map(opt => (
                <Radio key={opt.value} value={opt.value}>
                  {opt.label}
                </Radio>
              ))}
            </Space>
          </Radio.Group>
        )
      case 'text':
        return <Input value={currentVal} onChange={e => handleChange(pKey, key, e.target.value)} placeholder={`请输入${title}`} style={{ width: 300 }} />
      case 'textarea':
        return <TextArea rows={4} value={currentVal} onChange={e => handleChange(pKey, key, e.target.value)} placeholder={`请输入${title}`} style={{ width: '100%' }} />
      case 'editor':
        return <TextArea rows={6} value={currentVal} onChange={e => handleChange(pKey, key, e.target.value)} placeholder={`请编辑${title}`} style={{ width: '100%' }} />
      case 'upload':
        // item={item} onUploadSuccess={url => handleChange(item.key, url)}
        return <UploadComponent item={cfg} onUploadSuccess={e => handleChange(pKey, key, e)} />
      case 'desc':
        return <Paragraph.Text type="secondary">{defVal}</Paragraph.Text>
      // return <></>
      default:
        return <></>
    }
  }

  return (
    <Form layout="vertical">
      {item.map(e => (
        <Form.Item key={e.key} label={e.title} help={e.desc || ''} className="tw:flex">
          {renderFormItem(e)}
        </Form.Item>
      ))}
    </Form>
  )
}

// import TabCompontent from './TabComponent'

// const Children = (props) => {
//   const { item, key } = props;
//   // const key = Object.keys(item)[0];
//   let content = <></>;
//   switch (props.key) {
//     case 'global_set':
//       content = <TabCompontent item={item} _key={key} />
//       break;
//     // case 'basic_set':
//     //   content = <TabCompontent item={item} _key={key} data={item.basic_set} />
//     //   break;
//     // case 'third_set':
//     //   content = <TabCompontent item={item} _key={key} data={item.third_set} />
//     //   break;
//     // case 'company_layout_set':
//     //   content = <TabCompontent item={item} _key={key} data={item.company_layout_set} />
//     //   break;
//     // case 'cms_layout_set':
//     //   content = <TabCompontent item={item} _key={key} data={item.cms_layout_set} />
//     //   break;
//     // case 'seo_set':
//     //   content = <TabCompontent item={item} _key={key} data={item.seo_set} />
//     //   break;
//     // case 'smtp_set':
//     //   content = <TabCompontent item={item} _key={key} data={item.smtp_set} />
//     //   break;
//     // case 'anti_brush_set':
//     //   content = <TabCompontent item={item} _key={key} data={item.anti_brush_set} />
//     //   break;
//     // case 'ad_set':
//     //   content = <TabCompontent item={item} _key={key} data={item.ad_set} />
//     //   break;
//   }
//   return content
// }
// export default Children
