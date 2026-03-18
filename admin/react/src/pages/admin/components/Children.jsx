import GlobalSet from './GlobalSet'
import BasicSet from './BasicSet'
import ThirdSet from './ThirdSet'
import CompanyLayoutSet from './CompanyLayoutSet'
import CmsLayoutSet from './CmsLayoutSet'
import SeoSet from './SeoSet'
import SmtpSet from './SmtpSet'
import AntiBrushSet from './AntiBrushSet'
import AdSet from './AdSet'

const Children = (props) => {
  const { item } = props;
  const key = Object.keys(item)[0];
  let content = <></>;
  switch (key) {
    case 'global_set':
      content = <GlobalSet item={item} />
      break;
    case 'basic_set':
      content = <BasicSet item={item} />
      break;
    case 'third_set':
      content = <ThirdSet item={item} />
      break;
    case 'company_layout_set':
      content = <CompanyLayoutSet item={item} />
      break;
    case 'cms_layout_set':
      content = <CmsLayoutSet item={item} />
      break;
    case 'seo_set':
      content = <SeoSet item={item} />
      break;
    case 'smtp_set':
      content = <SmtpSet item={item} />
      break;
    case 'anti_brush_set':
      content = <AntiBrushSet item={item} />
      break;
    case 'ad_set':
      content = <AdSet item={item} />
      break;
  }

  return content
}
export default Children
