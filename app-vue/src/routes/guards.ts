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
  const meStore = useMeStore();
  const permission = to.meta.can;

  if (permission) {
    const isAllowed = meStore.user?.permissions.some((data: any) => data.name === permission);
    console.log(isAllowed)
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

// export const checkPermission = async (to:any, from:any, next:any) => {
//   const meStore     = useMeStore();
//   const permission  = to.meta.can;

//   if (permission) {
//     const isAllowed = meStore.user?.permissions.some((data: any) => console.log(data.name === permission));
//     if (isAllowed) {
//       next();
//     } else {
//       redirectIfNotAuthenticated(to, from, next);
//     }
//   } else {
//     next();
//   }
// };