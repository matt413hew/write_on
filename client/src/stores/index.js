import { createPinia } from "pinia";
import { createPersistedStatePlugin } from "pinia-plugin-persistedstate-2";
import { useMainStore } from "./mainStore";
// import { useUserStore } from "@/stores/user";
// import { usePermissionStore } from "@/stores/permission";
// import { useRoleStore } from "@/stores/role";
import { EncryptStorage } from "encrypt-storage";

const pinia = createPinia();

    let persistedStateOptions = {};
    const salt = "Hello-Tinapa";

    const prefix = "01001101011000010111010001110100";

    const ls = new EncryptStorage(salt, {
        stateManagementUse: true,
    });
    persistedStateOptions = {
        storage: {
      getItem: (key) => {
         let data = ls.getItem(key)?.replace(/^\s+|\s+$/gm, "") ?? "";
        if (data == "") return "[]";
        return data;
      },
      setItem: (key, value) => ls.setItem(key, value),
      removeItem: (key) => ls.removeItem(key),
        },
    };

pinia.use(createPersistedStatePlugin(persistedStateOptions));

export {
  pinia,
  useMainStore,
};