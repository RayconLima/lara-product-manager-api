import { Directive, DirectiveBinding } from "vue";
import { userHasPermission } from "../utils/helpers";

export const can: Directive = {
    mounted(el: HTMLElement, binding: DirectiveBinding) {
        if (!userHasPermission(binding.value)) {
            el.style.display = 'none'
        }
    },
}