export const Protutos = async props => {
  props = props?.grupo
    ? `http://127.0.0.1/food/get_produtos.php?grupo=${props.grupo}`
    : 'http://127.0.0.1/food/get_produtos.php'
  const res = await fetch(props)
  const data = await res.json()
  return data
}
