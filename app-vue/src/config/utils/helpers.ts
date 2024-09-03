import { useMeStore } from "../../store/me";

interface iPermission {
    name: string
}
export const userHasPermission = (permissionName: string): Boolean => {
  const useStore  = useMeStore();
  const user      = useStore.user;
  if (user?.roles?.[0]) return true
  let hasPermission = false;
  user?.permissions.map((permission: iPermission) => {
    if (permission.name === permissionName) {
      hasPermission = true;
    }
  });

  return hasPermission;
}

export const formatMoney = (value: number): String => {
  const options: Intl.NumberFormatOptions = {
    style: 'currency',
    currency: 'BRL',
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  };

  const formatter = new Intl.NumberFormat('pt-BR', options);
  return formatter.format(value);
}

export const customformatDate = (dataISO: string): string => {
  const data = new Date(dataISO);

  const dia = data.getDate().toString().padStart(2, '0');
  const mes = (data.getMonth() + 1).toString().padStart(2, '0');
  const ano = data.getFullYear();   


  const dateFormated = `${dia}/${mes}/${ano}`;
  return dateFormated;
}