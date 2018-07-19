var axios = require('axios');

var axiosInstance = axios.create({
  baseURL: 'http://back.loc/api',
  /* other custom settings */
});

module.exports = axiosInstance;