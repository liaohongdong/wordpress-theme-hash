import TabCompontent from './TabComponent'

const Children = (props) => {
  const { item } = props;
  const key = Object.keys(item)[0];
  let content = <></>;
  switch (key) {
    case 'global_set':
      content = <TabCompontent item={item} data={item.global_set} />
      break;
    case 'basic_set':
      content = <TabCompontent item={item} data={item.basic_set} />
      break;
    case 'third_set':
      content = <TabCompontent item={item} data={item.third_set} />
      break;
    case 'company_layout_set':
      content = <TabCompontent item={item} data={item.company_layout_set} />
      break;
    case 'cms_layout_set':
      content = <TabCompontent item={item} data={item.cms_layout_set} />
      break;
    case 'seo_set':
      content = <TabCompontent item={item} data={item.seo_set} />
      break;
    case 'smtp_set':
      content = <TabCompontent item={item} data={item.smtp_set} />
      break;
    case 'anti_brush_set':
      content = <TabCompontent item={item} data={item.anti_brush_set} />
      break;
    case 'ad_set':
      content = <TabCompontent item={item} data={item.ad_set} />
      break;
  }
  return content
}
export default Children
