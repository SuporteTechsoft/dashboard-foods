export const ProdutosMesa = async props => {

  let req = props
  let url = `http://${window.location.host}/food/get_produtosmesa.php`

  // ? Expected mesa as number and diferent than 0
  if (!!req) {
    url = !!Object.values(req)[0] ? `${url}?${Object.keys(req)[0]}=${Object.values(req)[0]}` : `${url}?mesa=9999`
  } else {
    url = `${url}?mesa=9999`
  }
  
  const res = await fetch(url)
  const data = await res.json()
  console.log(url)
  console.log(data)
  return data
}