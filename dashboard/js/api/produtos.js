export const Produtos = async props => {

  let req = props
  let url = `http://${window.location.host}/food/get_produtos.php`

  if (!!req) {
    // ? Expected grupo as param
    // * grupo as code numbero
    url = `${url}?${Object.keys(req)[0]}=${Object.values(req)[0]}`
  }

  const res = await fetch(url)
  const data = await res.json()
  console.log(url)
  console.log(data)
  return data
}
