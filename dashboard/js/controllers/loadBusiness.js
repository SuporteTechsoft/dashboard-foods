import { itsAlive } from '../api/itsAlive.js'

export const loadBusiness = async () => {
  let business = await itsAlive({ empresa: true })
  let element = document.getElementById("business").childNodes[1]

  element.textContent = business.empresa
}
