export const Mesa = async props => {
  let req = props
  let url = `http://${window.location.host}/food/get_mesa.php`

  if (!!req) {
    let i = 0
    for (const key in req) {
      // ? Expected mesa or status as param
      // * mesa as number
      // * status as 'O' or 'L'
      url = !i ? `${url}?${key}=${req[key]}` : `${url}&${key}=${req[key]}`
      ++i
    }
  }

  const res = await fetch(url)
  const data = await res.json()
  // console.log(url)
  // console.log(data.mesa)
  return data.mesa
}
