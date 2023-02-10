export const itsAlive = async props => {

  let req = props
  let url = `http://${window.location.host}/food/get_itsalive.php`

  if (!!req) {
    // ? expected empresa as boolean param
    url = `${url}?${Object.keys(req)[0]}=${Object.values(req)[0]}`
  }
  
  const res = await fetch(url)
  const data = await res.json()
  console.log(url)
  console.log(data)
  return data
}
