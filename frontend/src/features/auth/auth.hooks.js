import { useState } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { useNavigate } from 'react-router-dom'
import {
  clearAuthError,
  login,
  logout,
  register,
  selectAuth,
} from './auth.store'
import { validateLogin, validateRegister } from './auth.validation'

function getFieldError(serverErrors, fieldName) {
  const value = serverErrors?.[fieldName]

  if (Array.isArray(value)) {
    return value[0]
  }

  return value ?? ''
}

export function useAuth() {
  const dispatch = useDispatch()
  const auth = useSelector(selectAuth)

  return {
    ...auth,
    clearError: () => dispatch(clearAuthError()),
    logout: () => dispatch(logout()),
  }
}

export function useLoginForm() {
  const dispatch = useDispatch()
  const navigate = useNavigate()
  const { status, error, validationErrors } = useSelector(selectAuth)
  const [values, setValues] = useState({
    email: '',
    password: '',
  })
  const [clientErrors, setClientErrors] = useState({})

  function updateField(event) {
    const { name, value } = event.target

    setValues((current) => ({
      ...current,
      [name]: value,
    }))
  }

  async function handleSubmit(event) {
    event.preventDefault()
    const nextErrors = validateLogin(values)
    setClientErrors(nextErrors)

    if (Object.keys(nextErrors).length > 0) {
      return
    }

    const result = await dispatch(login(values))

    if (login.fulfilled.match(result)) {
      navigate('/')
    }
  }

  return {
    values,
    isSubmitting: status === 'loading',
    formError: error,
    fieldErrors: {
      email: clientErrors.email || getFieldError(validationErrors, 'email'),
      password: clientErrors.password || getFieldError(validationErrors, 'password'),
    },
    updateField,
    handleSubmit,
    clearError: () => dispatch(clearAuthError()),
  }
}

export function useRegisterForm() {
  const dispatch = useDispatch()
  const navigate = useNavigate()
  const { status, error, validationErrors } = useSelector(selectAuth)
  const [values, setValues] = useState({
    name: '',
    email: '',
    phone: '',
    password: '',
    confirmPassword: '',
    acceptTerms: false,
  })
  const [clientErrors, setClientErrors] = useState({})

  function updateField(event) {
    const { name, type, checked, value } = event.target

    setValues((current) => ({
      ...current,
      [name]: type === 'checkbox' ? checked : value,
    }))
  }

  async function handleSubmit(event) {
    event.preventDefault()
    const nextErrors = validateRegister(values)
    setClientErrors(nextErrors)

    if (Object.keys(nextErrors).length > 0) {
      return
    }

    const payload = {
      name: values.name.trim(),
      email: values.email.trim(),
      phone: values.phone.trim(),
      password: values.password,
    }

    const result = await dispatch(register(payload))

    if (register.fulfilled.match(result)) {
      navigate('/')
    }
  }

  return {
    values,
    isSubmitting: status === 'loading',
    formError: error,
    fieldErrors: {
      name: clientErrors.name || getFieldError(validationErrors, 'name'),
      email: clientErrors.email || getFieldError(validationErrors, 'email'),
      phone: clientErrors.phone || getFieldError(validationErrors, 'phone'),
      password: clientErrors.password || getFieldError(validationErrors, 'password'),
      confirmPassword:
        clientErrors.confirmPassword || getFieldError(validationErrors, 'confirmPassword'),
      acceptTerms: clientErrors.acceptTerms,
    },
    updateField,
    handleSubmit,
    clearError: () => dispatch(clearAuthError()),
  }
}
