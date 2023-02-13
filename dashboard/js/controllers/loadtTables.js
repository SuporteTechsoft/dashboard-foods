import { ProdutosMesa } from '../api/produtosMesa.js'


// TODO: Fetch before load data tables
const calcTotal = async element => {
  let total = 0
  Object.values(element)[0].forEach(element => {
    total = total + parseFloat(element.vltotal)
  })
  return total.toFixed(2)
}

// ? Default layout from card insert
const table = async props => {
  let total = "000,00"

  if (props.status != 'L') {
    let element = await ProdutosMesa({ mesa: props.mesa })
    total = await calcTotal(element)
  }
  console.log(total)

  return `
<div class="card" id="${props.mesa}">
<div class="separator">
  <div class="number">${props.mesa.padStart(3, '0')}</div>
  <div class="status">${props.status == 'L' ? 'Livre' : 'Ocupado'}</div>
</div>
<div class="separator">
  <div class="name">${props.nome != 'Livre' && props.nome != 'Ocupado' ? props.nome : 'CONSUMIDOR'}</div>
  <div class="bill">
    <span>R$</span>
    <h1>${total}</h1>
  </div>
</div>
</div>
`
}

export const loadTables = async props => {
  document.getElementById('tables').innerHTML = ``
  Object.values(props)[0].forEach(async element => {
    document.getElementById('tables').insertAdjacentHTML('beforeEnd', `${await table(element)}`)
  })
}
