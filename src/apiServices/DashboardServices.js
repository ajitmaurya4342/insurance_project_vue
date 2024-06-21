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

export const GetAllVehicleType = async (payload) =>
  Api().post(`/GetVehicleTypeList.php`, payload);

export const addEditVehicleType = async (payload) =>
  Api().post(`/addEditVehicleType.php`, payload);

export const GetAllCompanyType = async (payload) =>
  Api().post(`/GetCompanyTypeList.php`, payload);

export const addEditCompanyType = async (payload) =>
  Api().post(`/addEditCompanyType.php`, payload);

export const GetAllFPType = async (payload) =>
  Api().post(`/GetFPTypeList.php`, payload);

export const addEditFPType = async (payload) =>
  Api().post(`/addEditFPType.php`, payload);
