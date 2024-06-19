import Vue from "vue";
import axios from "axios";
import { TokenService } from "./storageService";

var loader = null;

export default function Api() {
  console.log({
    baseURL: process.env.VUE_APP_BASEURL,
  });
  const instance = axios.create({
    baseURL: process.env.VUE_APP_BASEURL,
  });

  const AUTH_TOKEN = TokenService.getToken();

  if (AUTH_TOKEN) {
    instance.defaults.headers.common["authorization"] = `${AUTH_TOKEN}`;
  }

  instance.defaults.headers.common["Access-Control-Allow-Origin"] = "*";
  instance.interceptors.request.use((req) => {
    if (!req.url.includes("master/new-notifications")) {
      if (!loader) loader = Vue.$loading.show();
    }
    return req;
  });

  instance.interceptors.response.use(
    function (response) {
      if (loader) {
        loader.hide();
        loader = null;
      }
      return response;
    },
    function (error) {
      if (loader) {
        loader.hide();
        loader = null;
      }

      if (!error["response"]) {
        showErrorMessage(
          "Your authorization token is invalid or expired ",
          error
        );
        // if (window.location.pathname !== '/') window.location.replace("/")
        return Promise.reject(error);
      } else if (error.response.status == 403) {
        TokenService.removeToken();
        showErrorMessage("Your authorization token is invalid or expired");
        if (window.location.pathname !== "/") window.location.replace("/");
      } else if (error.response.status == 401) {
        TokenService.removeToken();
        if (window.location.pathname !== "/") window.location.replace("/");
      }
      return Promise.reject(error.response);
    }
  );

  const showErrorMessage = (message) => {
    console.log("Error ", message);
    // Show Some Notification
  };

  return instance;
}
