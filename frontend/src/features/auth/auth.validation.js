function isEmail(value) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)
}

export function validateLogin(values) {
  const errors = {}

  if (!values.email.trim()) {
    errors.email = 'Email is required.'
  } else if (!isEmail(values.email)) {
    errors.email = 'Please enter a valid email address.'
  }

  if (!values.password) {
    errors.password = 'Password is required.'
  }

  return errors
}

export function validateRegister(values) {
  const errors = {}

  if (!values.name.trim()) {
    errors.name = 'Full name is required.'
  }

  if (!values.email.trim()) {
    errors.email = 'Email is required.'
  } else if (!isEmail(values.email)) {
    errors.email = 'Please enter a valid email address.'
  }

  if (!values.phone.trim()) {
    errors.phone = 'Phone number is required.'
  } else if (values.phone.trim().length < 8) {
    errors.phone = 'Phone number must be at least 8 characters.'
  }

  if (!values.password) {
    errors.password = 'Password is required.'
  } else if (values.password.length < 4) {
    errors.password = 'Password must be at least 4 characters.'
  }

  if (!values.confirmPassword) {
    errors.confirmPassword = 'Please confirm your password.'
  } else if (values.confirmPassword !== values.password) {
    errors.confirmPassword = 'Passwords do not match.'
  }

  if (!values.acceptTerms) {
    errors.acceptTerms = 'You must accept the terms to continue.'
  }

  return errors
}
