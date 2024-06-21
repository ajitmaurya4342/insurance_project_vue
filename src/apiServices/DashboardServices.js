import Api from "./Api";

export const GetAllUsers = async (payload) =>
  Api().post(`/GetUserList.php`, payload);

export const addEditUsers = async (payload) =>
  Api().post(`/addEditUser.php`, payload);

export const GetAllAgent = async (payload) =>
  Api().post(`/GetAgentList.php`, payload);

export const addEditAgent = async (payload) =>
  Api().post(`/addEditAgent.php`, payload);

export const GetAllPayment = async (payload) =>
  Api().post(`/GetPaymentList.php`, payload);

export const addEditPayment = async (payload) =>
  Api().post(`/addEditPayment.php`, payload);
