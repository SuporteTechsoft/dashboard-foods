export const itsAlive = async props => {
  var props = props?.status
    ? `http://127.0.0.1/food/get_itsalive.php?empresa=${props.status}`
    : 'http://127.0.0.1/food/get_itsalive.php'
  // console.log(props)
  const res = await fetch(props)
  const data = await res.json()

  return data
}
