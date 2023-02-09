import { itsAlive } from './itsAlive.js'
import { Vendedores } from './vendedores.js'
import { Protutos } from './produtos.js'
import { Categorias } from './categorias.js'
import { Mesa } from './mesa.js'

// let data = await Protutos({grupo:1})
// console.log(...data?.produtos)

// data = await Vendedores()
// console.log(...data.vendedores)

// console.log(await itsAlive())

// console.log(await Categorias())
await Mesa({ mesa: 1, status: 'O' })
await Mesa()
// console.log(...data?.mesa)

// console.log("teste")

/**
 * desconto: "0.00"
 * mesa: "1"
 * mesaprinc: "0"
 * nome: "Ocupado"
 * pago: "0.00"
 * status: "O"
 */                                                                                
// document.getElementById('tables').innerHTML = `
// <div class="card" id="${}">
// <div class="separator">
//   <div class="number">${}</div>
//   <div class="status">Livre</div>
// </div>
// <div class="separator">
//   <div class="name">-</div>
//   <div class="bill">
//     <span>R$</span>
//     <h1>0000,00</h1>
//   </div>
// </div>
// </div>
// `
