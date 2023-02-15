import { itsAlive } from './api/itsAlive.js'
import { Vendedores } from './api/vendedores.js'
import { Produtos } from './api/produtos.js'
import { Categorias } from './api/categorias.js'
import { ProdutosMesa } from './api/produtosMesa.js'
import { Mesa } from './api/mesa.js'

import { loadTables } from './controllers/loadTableList.js'
import { loadBusiness } from './controllers/loadBusiness.js'
import { openPopUp } from './controllers/popUp.js'

// * Test Start
// await Mesa({status: 'O', mesa: 1 })
// await Mesa()
// await itsAlive({ empresa: true })
// await itsAlive()
// await Vendedores()
// // await Produtos()
// await Produtos({ grupo: 2 })
// await Categorias()
// await ProdutosMesa()
// await ProdutosMesa({ mesa: 1 })
// ! Test End

// let data = await Mesa()
// let data = await Mesa({status: 'O' })

await loadBusiness()
let dataTables = await loadTables()
let sellers = await Vendedores()

// * Start page
document.getElementById('tables').addEventListener('click', async e => await openPopUp(e, dataTables, sellers))
// openPopUp()
