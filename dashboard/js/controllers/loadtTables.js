const table = props => `
<div class="card" id="${props.mesa}">
<div class="separator">
  <div class="number">${props.mesa.padStart(3, '0')}</div>
  <div class="status">${props.status == 'L' ? 'Livre' : 'Ocupado'}</div>
</div>
<div class="separator">
  <div class="name">${props.nome != 'Livre' && props.nome != 'Ocupado' ? props.nome : '-'}</div>
  <div class="bill">
    <span>R$</span>
    <h1>${props.pago.padStart(6, '0').replace('.', ',')}</h1>
  </div>
</div>
</div>
`

export const loadTables = props => {
  document.getElementById('tables').innerHTML = ``
  Object.values(props)[0].forEach(element => {
    // console.log(element)
    document.getElementById('tables').insertAdjacentHTML('afterBegin', `${table(element)}`)
  });
}