export const Categorias = async () => {
  const res = await fetch('http://127.0.0.1/food/get_categorias.php')
  const data = await res.json()
  return data
}