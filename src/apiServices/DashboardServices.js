import Api from "./Api";

export const GetAllUsers = async (payload) =>
  Api().post(`/GetUserList.php`, payload);

export const addEditUsers = async (payload) =>
  Api().post(`/addEditUser.php`, payload);

export const GetAllAgent = async (payload) =>
  Api().post(`/GetAgentList.php`, payload);

export const addEditAgent = async (payload) =>
  Api().post(`/addEditAgent.php`, payload);
