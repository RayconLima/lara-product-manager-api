import { useMeStore } from "../../store/me";

interface iPermission {
    name: string
}
export const userHasPermission = (permissionName: string): Boolean => {
    const useStore = useMeStore();
    const user = useStore.user;
    // if (user.isAdmin) return true
    let hasPermission = false;
    user?.permissions.map((permission: iPermission) => {
      if (permission.name === permissionName) {
        hasPermission = true;
      }
    });
  
    return hasPermission;
  }