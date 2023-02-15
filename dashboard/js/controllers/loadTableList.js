import { Mesa } from '../api/mesa.js'
import { ProdutosMesa } from '../api/produtosMesa.js'
import { Vendedores } from '../api/vendedores.js'
import { UUID } from '../functions/UUID.js'


const getTotal = element => {

  let total = 0
  element.forEach(element => {
    total = total + parseFloat(element.vltotal)
  })

  return total.toFixed(2).replace('.', ',')
}

const fetchAllData = async () => {
  // * Fecth all data tables
  let loadMesa = await Mesa()

  return await Promise.all(
    loadMesa.map(async element => {
      // Element {mesa: '1', nome: 'Ocupado', status: 'O', pago: '0.00', desconto: '0.00' }
      element.status != 'L' ? (element.total = getTotal(await ProdutosMesa({ mesa: element.mesa }))) : (element.total = '000,00')
      element.uuid = UUID()

      return element
    })
  )

}

// ? Default layout from card insert
const cardTable = props => {
  return `
<div class="card ${props.status != 'L' ? 'occupied' : ''}" id="${props.uuid}">
<div class="separator">
  <div class="number">${props.mesa.padStart(3, '0')}</div>
  <div class="status ${props.status == 'L' ? 'free' : 'occupied'}">${props.status == 'L' ? 'Livre' : 'Ocupado'}</div>
</div>
<div class="separator">
  <div class="name">${props.nome != 'Livre' && props.nome != 'Ocupado' ? props.nome : 'CONSUMIDOR'}</div>
  <div class="bill">
    <span>R$</span>
    <h1>${props.total}</h1>
  </div>
</div>
</div>
`
}

export const loadTables = async () => {
  document.getElementById('tables').innerHTML = ``
  let tables = await fetchAllData()
  tables.forEach(table => {
    document.getElementById('tables').insertAdjacentHTML('beforeEnd', `${cardTable(table)}`)
  })
  return tables
}
