export const Mesa = async props => {
  var req = props
  let url = `http://localhost/food/get_mesa.php` 
  if (req?.mesa && req?.status) {
    props = `${url}?mesa=${req.mesa}&status=${req.status}`
  } else {
    if (req?.mesa || req?.status) {
      req?.mesa ? (props = `${url}?mesa=${req.mesa}`) : (props = `${url}?status=${req.status}`)
    } else {
      props = '${url}'
    }
  }
  
  const res = await fetch(props)
  const data = await res.json()
  console.log(data)
  return data
}
