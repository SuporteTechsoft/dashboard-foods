import { itsAlive } from './api/itsAlive.js'
import { Vendedores } from './api/vendedores.js'
import { Produtos } from './api/produtos.js'
import { Categorias } from './api/categorias.js'
import { ProdutosMesa } from './api/produtosMesa.js'
import { loadTables } from './controllers/loadTableList.js'
import { Mesa } from './api/mesa.js'

// * Test Start
// await Mesa({status: 'O', mesa: 1 })
// await Mesa()
// await itsAlive({ empresa: true })
// await itsAlive()
// await Vendedores()
// await Produtos()
// await Produtos({ grupo: 2 })
// await Categorias()
// await ProdutosMesa()
// await ProdutosMesa({ mesa: 1 })
// ! Test End

// let data = await Mesa()
// let data = await Mesa({status: 'O' })
await loadTables()