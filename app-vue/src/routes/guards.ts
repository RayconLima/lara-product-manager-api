import { VITE_APP_USER_EMAIL_ADMIN } from '../config';
import { useMeStore } from '../store/me';
import router from './';

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

export const checkPermission = async (to:any, _from: any, next:any) => {
  const meStore           = useMeStore();
  const permission        = to.meta.can;
  const emailSuperAdmin   = VITE_APP_USER_EMAIL_ADMIN;

  if (permission) {
    const isAllowed = meStore.user?.permissions.some((data: any) => data.name === permission);
    if (isAllowed || emailSuperAdmin === meStore.user?.email) {
      next();
    } else {
      router.push({
        name: 'error403',
        params: {
          title: 'Erro 403',
          message: 'Acesso negado.',
          code: 403
        }
      });
    }
  } else {
    next();
  }
};

export const checkRole = async (to:any, _from: any, next:any) => {
  const meStore     = useMeStore();
  const role        = to.meta.role;

  if (role) {
    const isAllowed = meStore.user?.roles.some((data: any) => data.name === role);
    if (isAllowed) {
      next();
    } else {
      router.push({
        name: 'error403',
        params: {
          title: 'Erro 403',
          message: 'Acesso negado.',
          code: 403
        }
      });
    }
  } else {
    next();
  }
};