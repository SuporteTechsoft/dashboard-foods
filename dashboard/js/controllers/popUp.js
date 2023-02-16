import { ProdutosMesa } from '../api/produtosMesa.js'

const getId = event => {
  let obj = event.target
  if (obj.id != 'tables') {
    if (obj.id == '') {
      let id = ''
      while (id == '') {
        id = obj.parentElement.id
        obj = obj.parentElement
      }
    }
    return obj.id
  }
  return false
}

const getSalesman = (dataTable, sellers) => {
  let mainSeller = 'Balcao'
  let sellerId = dataTable[0]
  if (sellerId.id != 0) {
    mainSeller = sellers.find(seller => seller.id == sellerId.codvend).nome
  }
  return mainSeller
}

const popUpModal = async (table, items, sellers) => {
  {
    /* <td>${item.codigo.padStart(4, '0')} - ${item.descricao}</td> */
  }
  return `
    <div id="modal-table">
      <div id="pop-up">
        <div class="number">
          <h3>Mesa: ${table.mesa.padStart(3, '0')}</h3>
        </div>
        <div class="items">
          <h3>Itens</h3>
          <div class="list">
            <div class="table-items">
              <div class="head-table">
                <div class="row">
                  <div class="cell">Produtos</div>
                  <div class="cell">Quantidade</div>
                  <div class="cell">Valor</div>
                </div>
              </div>
              <div class="body-table">
                ${items
                  .map(
                    item => `
                  <div class="row">
                    <div class="cell">${item.descricao}</div>
                    <div class="cell">${item.quantidade.padStart(3, '0')}</div>
                    <div class="cell">
                      <div class="value-item">
                        <h5 class="coin">R$</h5>
                        <h4 class="value">${item.vltotal}</h4>
                      </div>
                    </div>
                  </div>
                  `
                  )
                  .join('')}
              </div>
            </div>
          </div>
        </div>
        <div class="totais">
          <div class="calc">
            <div class="discount">
              <h4 class="label">Total Desconto</h4>
              <div class="value-item">
                <h5 class="coin">R$</h5>
                <h4 class="value">${table.desconto}</h4>
              </div>
            </div>
            <div class="products">
              <h4 class="label">Total Produtos</h4>
              <div class="value-item">
                <h5 class="coin">R$</h5>
                <h4 class="value">${table.total}</h4>
              </div>
            </div>
          </div>
          <hr />
          <div class="total">
            <h4 class="label">Total</h4>
            <div class="value-item">
              <h5 class="coin">R$</h5>
              <h4 class="value">${table.total}</h4>
            </div>
          </div>
        </div>
        <hr />
        <div class="salesman">
          <h3 class="label">vendedor</h3>
          <h3 class="name">${getSalesman(items, sellers)}</h3>
        </div>
      </div>
    </div>
  `
}

export const openPopUp = async (event, tables, sellers) => {
  let id = getId(event)
  if (id) {
    // console.log(id)
    let table = tables.find(e => e.uuid === id)
    // console.log(table)
    if (table.status != 'L') {
      let items = await ProdutosMesa({ mesa: table.mesa })
      document.body.insertAdjacentHTML('afterBegin', `${await popUpModal(table, items, sellers)}`)
      document.getElementById('modal-table').addEventListener('click', e => closePopUp(e))
    }
  }
}

export const closePopUp = event => {
  let id = event.target.id
  if (id == 'modal-table') document.getElementById('modal-table').remove()
}
