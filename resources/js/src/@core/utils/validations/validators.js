import axios from "@axios"
import { async } from "q"
export const validatorPositive = value => {
    if (value >= 0) {
        return true
    }
    return false
}

export const validatorPassword = password => {
    /* eslint-disable no-useless-escape */
    const regExp = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%&*()]).{8,}/
    /* eslint-enable no-useless-escape */
    const validPassword = regExp.test(password)
    return validPassword
}

export const validatorCreditCard = creditnum => {
    /* eslint-disable no-useless-escape */
    const cRegExp = /^(?:3[47][0-9]{13})$/
    /* eslint-enable no-useless-escape */
    const validCreditCard = cRegExp.test(creditnum)
    return validCreditCard
}

export const validatorUrlValidator = val => {
    if (val === undefined || val === null || val.length === 0) {
        return true
    }
    /* eslint-disable no-useless-escape */
    const re = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/
    /* eslint-enable no-useless-escape */
    return re.test(val)
}
export const validatorUniqueEmail = async val => {
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(val))
  {
    
    const {
        data
    } = await axios.post('api/validateemail', {
        email: val
    })
    if (data.status == true) {
        return true
    } else {
        return false;
    }
    const re = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/
    /* eslint-enable no-useless-escape */
    return re.test(val)
  }
}

export const validatorUniqueUserName = async val => {
    
  const {
      data
  } = await axios.post('api/validateusername', {
      username: val
  })
  if (data.status == true) {
      return true
  } else {
      return false;
  }
}
export const validatorUniqueUserName2 = async (val,id) => {
  const {
      data
  } = await axios.post('api/validateusernameonupdate', {
      username: val,
      id:id[0]
  })
  if (data.status == true) {
      return true
  } else {
      return false;
  }
}
export const validatorUniqueEmail2 = async (val,id) => {
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(val))
  {
const {
    data
} = await axios.post('api/validateemailonupdate', {
    email: val,
    id:id[0]
})
if (data.status == true) {
    return true
} else {
    return false;
}
  }
}
export const maxValValidator = async(val,max)=>{
    if (val === undefined || val === null) return true

    return val.length <= max || `More than ${max} characters are not allowed`
}