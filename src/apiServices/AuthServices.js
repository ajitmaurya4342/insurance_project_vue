import Api from "./Api";

export const Login = async (payload) => Api().post(`/admin/login`, payload);
