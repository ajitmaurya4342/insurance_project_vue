import Api from "./Api";

export const GenerateQrCode = async (payload) =>
  Api().post(`/admin/addEditUsers`, payload);

export const GetAllUsers = async (payload) =>
  Api().post(`/GetUserList.php`, payload);

export const GetUserQrDetails = async (params) =>
  Api().get(`/admin/getUserList/${params.unique_code_generate}`);
