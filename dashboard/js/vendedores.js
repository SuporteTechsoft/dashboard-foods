export const Vendedores = async () => {
  const res = await fetch('http://127.0.0.1/food/get_vendedores.php')
  const data = await res.json()
  return { ...data }
}
