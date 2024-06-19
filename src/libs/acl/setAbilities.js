import ability from "./ability";

export function setAbilities(access_map) {
    
    if (access_map && access_map.length) {
        const ability_arr = [{
            action: "read",
            subject: "home"
        }];
        for (let i = 0; i < access_map.length; i++) {
            const map = access_map[i];

            if (map.create) {
                ability_arr.push({
                    action: "create",
                    subject: map.module_name
                })
            }

            if (map.read) {
                ability_arr.push({
                    action: "read",
                    subject: map.module_name
                })
            }

            if (map.update) {
                ability_arr.push({
                    action: "update",
                    subject: map.module_name
                })
            }

            if (map.delete) {
                ability_arr.push({
                    action: "delete",
                    subject: map.module_name
                })
            }
        }
        localStorage.setItem("userData", JSON.stringify(ability_arr))
        ability.update(ability_arr);
    }
}