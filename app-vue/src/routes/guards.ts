import { useMeStore } from '../store/me';

export const redirectIfNotAuthenticated = (_to: any, _from: any, next: any) => {
  const meStore = useMeStore();

  if (!meStore.isLoggedIn) {
    next({ name: 'login' })
  } else {
    next();
  }
}

export const redirectIfAuthenticated = (_to: any, _from: any, next: any) => {
  const meStore = useMeStore()

  if (meStore.isLoggedIn) {
    next({ name: 'home' })
  } else {
    next()
  }
}

export const checkIfTokenExists = (to: any, _from: any, next: any) => {
  if (!to.query?.token) {
    next({name: 'login'})
  } else {
    next();
  }
}