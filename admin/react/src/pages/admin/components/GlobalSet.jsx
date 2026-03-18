import { Input } from 'antd'

const GlobalSet = (props) => {
  const { item } = props;
  const { global_set } = item;
  const { item: _item } = global_set;
  console.log(item, 555, global_set, _item);
  
  return <>GlobalSet {JSON.stringify(item)}</>
}
export default GlobalSet
