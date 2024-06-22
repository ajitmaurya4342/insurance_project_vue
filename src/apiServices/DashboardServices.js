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

export const GetAllInsuranceType = async (payload) =>
  Api().post(`/GetInsuranceTypeList.php`, payload);

export const addEditInsuranceType = async (payload) =>
  Api().post(`/addEditInsuranceType.php`, payload);

export const GetAllFuelType = async (payload) =>
  Api().post(`/GetFuelTypeList.php`, payload);

export const addEditFuelType = async (payload) =>
  Api().post(`/addEditFuelType.php`, payload);

export const GetAllBank = async (payload) =>
  Api().post(`/GetBankList.php`, payload);

export const addEditBank = async (payload) =>
  Api().post(`/addEditBank.php`, payload);

export const GetAllCustomer = async (payload) =>
  Api().post(`/GetCustomerList.php`, payload);

export const addEditCustomer = async (payload) =>
  Api().post(`/addEditCustomer.php`, payload);

export const addEditInsurancePolicy = async (payload) =>
  Api().post(`/addEditInsurancePolicy.php`, payload);

export const GetInsurancePolicyList = async (payload) =>
  Api().post(`/GetInsurancePolicyList.php`, payload);

export const addEditSetting = async (payload) =>
  Api().post(`/addEditSetting.php`, payload);

export const GetSetting = async (payload) =>
  Api().post(`/GetSetting.php`, payload);
