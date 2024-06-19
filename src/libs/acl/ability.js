import { Ability } from '@casl/ability'
import { initialAbility } from './config'

const ability = JSON.parse(localStorage.getItem('abilities'))
const existingAbility = ability ? ability : null

export default new Ability(existingAbility || initialAbility)