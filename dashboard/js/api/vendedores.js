export const Vendedores = async () => {

  let url = `http://${window.location.host}/food/get_vendedores.php`

  let res = await fetch(url)
  let data = await res.json()
  console.log(url)
  console.log({...data})
  return {...data }
}
