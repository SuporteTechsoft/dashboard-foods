import { itsAlive } from './api/itsAlive.js'
import { Vendedores } from './api/vendedores.js'
import { Produtos } from './api/produtos.js'
import { Categorias } from './api/categorias.js'
import { ProdutosMesa } from './api/produtosMesa.js'
import { loadTables } from './controllers/loadtTables.js'
import { Mesa } from './api/mesa.js'

// * Test Start
// await Mesa({ mesa: 1, status: 'O' })
// await Mesa()
// await itsAlive({ empresa: true })
// await itsAlive()
// console.log(...data?.mesa)
// await Vendedores()
// await Produtos()
// await Produtos({ grupo: 2 })
// await Categorias()
// await ProdutosMesa()
// await ProdutosMesa({ mesa: 1 })
// ! Test End

/**
 * desconto: "0.00"
 * mesa: "1"
 * mesaprinc: "0"
 * nome: "Ocupado"
 * pago: "0.00"
 * status: "O"
 */

let data = await Mesa()

loadTables(data)