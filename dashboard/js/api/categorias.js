export const Categorias = async () => {

  let url = `http://${window.location.host}/food/get_categorias.php`
  

  const res = await fetch(url)
  const data = await res.json()
  console.log(url)
  console.log(data)
  return data
}